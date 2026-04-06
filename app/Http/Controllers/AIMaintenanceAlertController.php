<?php

namespace App\Http\Controllers;

use App\Models\AIMaintenanceAlert;
use App\Models\Vehicle;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\Notifications\MaintenanceAlert;

class AIMaintenanceAlertController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
        $this->middleware('auth');
    }

    /**
     * Display AI Maintenance Alerts list
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getAlertsDataTable($request);
        }

        return view('admin.ai-maintenance-alerts.index', [
            'statuses' => AIMaintenanceAlert::getStatuses(),
            'priorities' => AIMaintenanceAlert::getPriorities(),
            'alertTypes' => AIMaintenanceAlert::getAlertTypes(),
        ]);
    }

    /**
     * Get alerts for DataTable
     */
    private function getAlertsDataTable(Request $request)
    {
        $query = AIMaintenanceAlert::with(['vehicle', 'createdBy'])
            ->select('ai_maintenance_alerts.*');

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        // Filter by alert type
        if ($request->alert_type) {
            $query->where('alert_type', $request->alert_type);
        }

        // Filter by vehicle
        if ($request->vehicle) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('registration_number', 'like', "%{$request->vehicle}%")
                  ->orWhere('vehicle_name', 'like', "%{$request->vehicle}%");
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('vehicle', function ($row) {
                return $row->vehicle->registration_number ?? '-';
            })
            ->addColumn('alert_type', function ($row) {
                return AIMaintenanceAlert::getAlertTypes()[$row->alert_type] ?? $row->alert_type;
            })
            ->addColumn('priority', function ($row) {
                $color = $row->getPriorityBadgeColor();
                return '<span class="badge bg-' . $color . '">' . ucfirst($row->priority) . '</span>';
            })
            ->addColumn('status', function ($row) {
                $color = $row->getStatusBadgeColor();
                return '<span class="badge bg-' . $color . '">' . ucfirst(str_replace('_', ' ', $row->status)) . '</span>';
            })
            ->addColumn('urgency_level', function ($row) {
                $percentage = ($row->urgency_level / 5) * 100;
                return '<div class="progress" style="height: 20px;"><div class="progress-bar" style="width: ' . $percentage . '%">' . $row->urgency_level . '/5</div></div>';
            })
            ->addColumn('estimated_cost', function ($row) {
                return $row->estimated_cost ? '$' . number_format($row->estimated_cost, 2) : 'N/A';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('M d, Y H:i');
            })
            ->addColumn('actions', function ($row) {
                $actions = '<a href="' . route('ai-maintenance-alerts.show', $row->id) . '" class="btn btn-sm btn-info" title="View Details"><i class="fas fa-eye"></i></a> ';
                $actions .= '<a href="' . route('ai-maintenance-alerts.edit', $row->id) . '" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a> ';
                
                if ($row->status !== 'completed') {
                    $actions .= '<button class="btn btn-sm btn-success" onclick="markAsCompleted(' . $row->id . ')" title="Mark as Completed"><i class="fas fa-check"></i></button> ';
                }
                
                $actions .= '<button class="btn btn-sm btn-danger" onclick="deleteAlert(' . $row->id . ')" title="Delete"><i class="fas fa-trash"></i></button>';
                
                return $actions;
            })
            ->rawColumns(['priority', 'status', 'urgency_level', 'actions'])
            ->make(true);
    }

    /**
     * Show single alert details
     */
    public function show($id)
    {
        $alert = AIMaintenanceAlert::with(['vehicle', 'createdBy'])->findOrFail($id);
        
        return view('admin.ai-maintenance-alerts.show', [
            'alert' => $alert,
            'statuses' => AIMaintenanceAlert::getStatuses(),
            'priorities' => AIMaintenanceAlert::getPriorities(),
        ]);
    }

    /**
     * Show edit form
     */
    public function edit($id)
    {
        $alert = AIMaintenanceAlert::findOrFail($id);
        
        return view('admin.ai-maintenance-alerts.edit', [
            'alert' => $alert,
            'statuses' => AIMaintenanceAlert::getStatuses(),
            'priorities' => AIMaintenanceAlert::getPriorities(),
            'alertTypes' => AIMaintenanceAlert::getAlertTypes(),
        ]);
    }

    /**
     * Update alert
     */
    public function update(Request $request, $id)
    {
        $alert = AIMaintenanceAlert::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:pending,acknowledged,scheduled,completed,dismissed',
            'priority' => 'required|in:low,medium,high,critical',
            'recommendation' => 'required|string',
            'estimated_cost' => 'nullable|numeric|min:0',
            'urgency_level' => 'required|integer|min:1|max:5',
            'notes' => 'nullable|string',
            'scheduled_date' => 'nullable|date',
        ]);

        $alert->update($validated);

        return redirect()->route('ai-maintenance-alerts.show', $alert->id)
            ->with('success', 'Alert updated successfully');
    }

    /**
     * Show generate form
     */
    public function generateForm()
    {
        $vehicles = Vehicle::orderBy('vehicle_name')->get();
        return view('admin.ai-maintenance-alerts.generate', compact('vehicles'));
    }

    /**
     * Generate new AI alert for a vehicle
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);
        
        // Prepare vehicle data for AI analysis
        $vehicleData = [
            'registration_number' => $vehicle->registration_number,
            'make_model' => $vehicle->make_model,
            'age' => $vehicle->age,
            'mileage' => $vehicle->current_mileage ?? 0,
            'last_service' => $vehicle->last_service_date,
            'service_interval' => $vehicle->service_interval ?? 5000,
            'recent_issues' => $vehicle->recent_issues ?? 'None',
            'monthly_mileage' => $this->calculateMonthlyMileage($vehicle),
        ];

        // Get AI analysis
        $result = $this->aiService->generateMaintenanceAlert($vehicleData);

        if (!$result['success']) {
            return back()->withErrors(['error' => $result['message'] ?? 'Failed to generate alert']);
        }

        // Create alert from AI analysis
        $analysis = $result['analysis'];
        
        $alert = AIMaintenanceAlert::create([
            'vehicle_id' => $vehicle->id,
            'created_by' => Auth::id(),
            'alert_type' => $analysis['alert_type'] ?? 'other',
            'priority' => $analysis['priority'] ?? 'medium',
            'recommendation' => $analysis['recommendation'] ?? '',
            'estimated_cost' => $analysis['estimated_cost'] ?? null,
            'urgency_level' => $analysis['urgency_level'] ?? 1,
            'ai_analysis' => $analysis,
            'status' => 'pending',
        ]);

        // Notify relevant users
        $this->notifyMaintenanceTeam($alert);

        return redirect()->route('ai-maintenance-alerts.show', $alert->id)
            ->with('success', 'AI Maintenance Alert generated successfully');
    }

    /**
     * Mark alert as completed
     */
    public function markAsCompleted($id)
    {
        $alert = AIMaintenanceAlert::findOrFail($id);
        $alert->update(['status' => 'completed']);

        return back()->with('success', 'Alert marked as completed');
    }

    /**
     * Delete alert
     */
    public function destroy($id)
    {
        $alert = AIMaintenanceAlert::findOrFail($id);
        $alert->delete();

        return back()->with('success', 'Alert deleted successfully');
    }

    /**
     * Get alerts dashboard data
     */
    public function dashboard()
    {
        $data = [
            'total_alerts' => AIMaintenanceAlert::count(),
            'pending_alerts' => AIMaintenanceAlert::pending()->count(),
            'critical_alerts' => AIMaintenanceAlert::critical()->count(),
            'high_priority_alerts' => AIMaintenanceAlert::highPriority()->count(),
            'alerts_by_type' => AIMaintenanceAlert::selectRaw('alert_type, COUNT(*) as count')
                ->groupBy('alert_type')
                ->get(),
            'recent_alerts' => AIMaintenanceAlert::with(['vehicle', 'createdBy'])
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('admin.ai-maintenance-alerts.dashboard', $data);
    }

    /**
     * Get stats for AJAX
     */
    public function stats()
    {
        return response()->json([
            'total' => AIMaintenanceAlert::count(),
            'pending' => AIMaintenanceAlert::pending()->count(),
            'critical' => AIMaintenanceAlert::critical()->count(),
            'completed' => AIMaintenanceAlert::where('status', 'completed')->count(),
        ]);
    }

    /**
     * Calculate monthly mileage
     */
    private function calculateMonthlyMileage($vehicle)
    {
        // This is a simplified calculation; adjust based on your actual data
        $currentMileage = $vehicle->current_mileage ?? 0;
        $purchaseDate = $vehicle->purchase_date;
        
        if (!$purchaseDate) {
            return 0;
        }

        $monthsOwned = now()->diffInMonths($purchaseDate);
        
        if ($monthsOwned === 0) {
            return $currentMileage;
        }

        return round($currentMileage / $monthsOwned, 2);
    }

    /**
     * Notify maintenance team of new alert
     */
    private function notifyMaintenanceTeam($alert)
    {
        try {
            // Get maintenance managers or supervisors
            $maintenanceUsers = \App\Models\User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['Maintenance Manager', 'Transport Admin', 'Admin']);
            })->get();

            foreach ($maintenanceUsers as $user) {
                $user->notify(new MaintenanceAlert($alert));
            }
        } catch (\Exception $e) {
            Log::error('Failed to notify maintenance team: ' . $e->getMessage());
        }
    }
}
