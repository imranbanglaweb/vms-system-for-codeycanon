<?php

namespace App\Http\Controllers;

use App\Models\AIReport;
use App\Models\MaintenanceRequisition;
use App\Models\FuelLog;
use App\Models\DriverPerformance;
use App\Models\Vehicle;
use App\Services\AIService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class AIReportController extends Controller
{
    protected $aiService;

    public function __construct(AIService $aiService)
    {
        $this->aiService = $aiService;
        $this->middleware('auth');
    }

    /**
     * Display AI Reports list
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getReportsDataTable($request);
        }

        return view('admin.ai-reports.index', [
            'reportTypes' => AIReport::getReportTypes(),
            'statuses' => AIReport::getStatuses(),
        ]);
    }

    /**
     * Get reports for DataTable
     */
    private function getReportsDataTable(Request $request)
    {
        $query = AIReport::with(['createdBy'])
            ->select('ai_reports.*');

        // Filter by report type
        if ($request->report_type) {
            $query->where('report_type', $request->report_type);
        }

        // Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('report_type', function ($row) {
                return AIReport::getReportTypes()[$row->report_type] ?? $row->report_type;
            })
            ->addColumn('status', function ($row) {
                $color = $row->getStatusBadgeColor();
                return '<span class="badge bg-' . $color . '">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('period', function ($row) {
                if ($row->report_period_from && $row->report_period_to) {
                    return $row->report_period_from->format('M d, Y') . ' - ' . $row->report_period_to->format('M d, Y');
                }
                return '-';
            })
            ->addColumn('created_by', function ($row) {
                return $row->createdBy->name ?? '-';
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('M d, Y H:i');
            })
            ->addColumn('actions', function ($row) {
                $actions = '<a href="' . route('ai-reports.show', $row->id) . '" class="btn btn-sm btn-info" title="View Details"><i class="fas fa-eye"></i></a> ';
                
                if ($row->isReady()) {
                    $actions .= '<a href="' . route('ai-reports.download', $row->id) . '" class="btn btn-sm btn-success" title="Download"><i class="fas fa-download"></i></a> ';
                }
                
                $actions .= '<button class="btn btn-sm btn-danger" onclick="deleteReport(' . $row->id . ')" title="Delete"><i class="fas fa-trash"></i></button>';
                
                return $actions;
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    /**
     * Show create report form
     */
    public function create()
    {
        return view('admin.ai-reports.create', [
            'reportTypes' => AIReport::getReportTypes(),
        ]);
    }

    /**
     * Store and generate new report
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report_type' => 'required|in:maintenance,fuel_efficiency,driver_performance,fleet_health,cost_analysis,custom',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'report_period_from' => 'required|date',
            'report_period_to' => 'required|date|after_or_equal:report_period_from',
        ]);

        // Create report record
        $report = AIReport::create([
            'created_by' => Auth::id(),
            'report_type' => $validated['report_type'],
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => AIReport::STATUS_GENERATING,
            'report_period_from' => $validated['report_period_from'],
            'report_period_to' => $validated['report_period_to'],
            'filter_criteria' => $request->filters ?? [],
        ]);

        // Generate report asynchronously or immediately based on data size
        try {
            $this->generateReportData($report);
        } catch (\Exception $e) {
            Log::error('Report generation error: ' . $e->getMessage());
            $report->update([
                'status' => AIReport::STATUS_FAILED,
                'error_message' => $e->getMessage(),
            ]);
        }

        return redirect()->route('ai-reports.show', $report->id)
            ->with('success', 'Report is being generated. This may take a few moments.');
    }

    /**
     * Show single report details
     */
    public function show($id)
    {
        $report = AIReport::findOrFail($id);
        
        return view('admin.ai-reports.show', [
            'report' => $report,
        ]);
    }

    /**
     * Download report as PDF or Excel
     */
    public function download($id, $format = 'pdf')
    {
        $report = AIReport::findOrFail($id);

        if (!$report->isReady()) {
            return back()->withErrors(['error' => 'Report is not ready for download']);
        }

        if ($format === 'pdf' && file_exists($report->file_path)) {
            return response()->download($report->file_path, $report->title . '.pdf');
        }

        return back()->withErrors(['error' => 'Report file not found']);
    }

    /**
     * Delete report
     */
    public function destroy($id)
    {
        $report = AIReport::findOrFail($id);
        
        // Delete file if exists
        if ($report->file_path && file_exists($report->file_path)) {
            unlink($report->file_path);
        }
        
        $report->delete();

        return back()->with('success', 'Report deleted successfully');
    }

    /**
     * Generate report data based on type
     */
    private function generateReportData($report)
    {
        $data = [];

        switch ($report->report_type) {
            case AIReport::TYPE_MAINTENANCE:
                $data = $this->getMaintenanceData($report);
                break;
            case AIReport::TYPE_FUEL_EFFICIENCY:
                $data = $this->getFuelEfficiencyData($report);
                break;
            case AIReport::TYPE_DRIVER_PERFORMANCE:
                $data = $this->getDriverPerformanceData($report);
                break;
            case AIReport::TYPE_FLEET_HEALTH:
                $data = $this->getFleetHealthData($report);
                break;
            case AIReport::TYPE_COST_ANALYSIS:
                $data = $this->getCostAnalysisData($report);
                break;
        }

        // Store raw data
        $report->update(['raw_data' => $data, 'total_records' => count($data)]);

        // Get AI analysis
        $aiResult = $this->aiService->generateReportAnalysis($data, $report->report_type);

        if ($aiResult['success']) {
            $report->update([
                'ai_summary' => $aiResult['analysis']['summary'] ?? null,
                'ai_findings' => $aiResult['analysis']['key_findings'] ?? null,
                'ai_recommendations' => $aiResult['analysis']['recommendations'] ?? null,
                'ai_analysis' => $aiResult['analysis'] ?? null,
                'status' => AIReport::STATUS_COMPLETED,
            ]);

            // Generate PDF (you may use a package like DOMPDF)
            $this->generatePDF($report);
        } else {
            $report->update([
                'status' => AIReport::STATUS_FAILED,
                'error_message' => $aiResult['message'] ?? 'Unknown error',
            ]);
        }
    }

    /**
     * Get maintenance report data
     */
    private function getMaintenanceData($report)
    {
        return MaintenanceRequisition::whereBetween('created_at', [
            $report->report_period_from,
            $report->report_period_to,
        ])
            ->with(['vehicle', 'employee'])
            ->get()
            ->map(function ($item) {
                return [
                    'vehicle' => $item->vehicle->registration_number ?? '-',
                    'type' => $item->type ?? '-',
                    'status' => $item->status,
                    'cost' => $item->estimated_cost ?? 0,
                    'date' => $item->created_at,
                ];
            })
            ->toArray();
    }

    /**
     * Get fuel efficiency data
     */
    private function getFuelEfficiencyData($report)
    {
        return FuelLog::whereBetween('created_at', [
            $report->report_period_from,
            $report->report_period_to,
        ])
            ->with(['vehicle', 'driver'])
            ->get()
            ->map(function ($item) {
                return [
                    'vehicle' => $item->vehicle->registration_number ?? '-',
                    'driver' => $item->driver->name ?? '-',
                    'quantity' => $item->quantity,
                    'cost' => $item->cost,
                    'mileage' => $item->mileage ?? 0,
                    'efficiency' => $item->mileage ? ($item->quantity / $item->mileage) : 0,
                    'date' => $item->created_at,
                ];
            })
            ->toArray();
    }

    /**
     * Get driver performance data
     */
    private function getDriverPerformanceData($report)
    {
        // This assumes you have a driver performance tracking system
        $vehicles = Vehicle::all();
        
        $data = [];
        foreach ($vehicles as $vehicle) {
            $trips = $vehicle->tripSheets()
                ->whereBetween('created_at', [$report->report_period_from, $report->report_period_to])
                ->get();
            
            $data[] = [
                'vehicle' => $vehicle->registration_number,
                'trips' => $trips->count(),
                'total_distance' => $trips->sum('total_distance') ?? 0,
                'fuel_used' => $trips->sum('fuel_consumed') ?? 0,
            ];
        }
        
        return $data;
    }

    /**
     * Get fleet health data
     */
    private function getFleetHealthData($report)
    {
        $vehicles = Vehicle::all();
        
        return $vehicles->map(function ($vehicle) {
            return [
                'vehicle' => $vehicle->registration_number,
                'make_model' => $vehicle->make_model,
                'status' => $vehicle->status ?? 'active',
                'mileage' => $vehicle->current_mileage ?? 0,
                'last_service' => $vehicle->last_service_date,
                'age' => $vehicle->age ?? 0,
            ];
        })->toArray();
    }

    /**
     * Get cost analysis data
     */
    private function getCostAnalysisData($report)
    {
        $maintenance = MaintenanceRequisition::whereBetween('created_at', [
            $report->report_period_from,
            $report->report_period_to,
        ])->get();

        $fuel = FuelLog::whereBetween('created_at', [
            $report->report_period_from,
            $report->report_period_to,
        ])->get();

        return [
            'maintenance_cost' => $maintenance->sum('estimated_cost') ?? 0,
            'fuel_cost' => $fuel->sum('cost') ?? 0,
            'total_cost' => ($maintenance->sum('estimated_cost') ?? 0) + ($fuel->sum('cost') ?? 0),
            'maintenance_count' => $maintenance->count(),
            'fuel_entries' => $fuel->count(),
        ];
    }

    /**
     * Generate PDF report
     */
    private function generatePDF($report)
    {
        try {
            // You would implement PDF generation here using DOMPDF or similar
            // For now, we'll just set a placeholder file path
            $fileName = 'report_' . $report->id . '_' . now()->timestamp . '.pdf';
            $filePath = storage_path('app/public/reports/' . $fileName);
            
            // Create directory if it doesn't exist
            if (!is_dir(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            // TODO: Generate actual PDF using DOMPDF or similar package
            // Temporary: just create an empty file
            touch($filePath);

            $report->update(['file_path' => $filePath]);
        } catch (\Exception $e) {
            Log::error('PDF generation error: ' . $e->getMessage());
        }
    }

    /**
     * Get reports dashboard data
     */
    public function dashboard()
    {
        $data = [
            'total_reports' => AIReport::count(),
            'completed_reports' => AIReport::completed()->count(),
            'generating_reports' => AIReport::generating()->count(),
            'failed_reports' => AIReport::failed()->count(),
            'reports_by_type' => AIReport::selectRaw('report_type, COUNT(*) as count')
                ->groupBy('report_type')
                ->get(),
            'recent_reports' => AIReport::with(['createdBy'])
                ->recent()
                ->take(10)
                ->get(),
        ];

        return view('admin.ai-reports.dashboard', $data);
    }

    /**
     * Get stats for AJAX
     */
    public function stats()
    {
        return response()->json([
            'total' => AIReport::count(),
            'completed' => AIReport::completed()->count(),
            'generating' => AIReport::generating()->count(),
            'failed' => AIReport::failed()->count(),
        ]);
    }
}
