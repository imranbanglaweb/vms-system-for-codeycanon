<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequisition;
use App\Models\Vehicle;
use App\Models\MaintenanceVendor;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\MaintenanceApproved;

class MaintenanceApprovalController extends Controller
{
    /**
     * @var EmailService
     */
    protected $emailService;

    /**
     * Create a new controller instance.
     *
     * @param EmailService $emailService
     * @return void
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * List all pending maintenance approvals.
     */
    public function index()
    {
        return view('admin.dashboard.maintenance_approvals.index');
    }

    /**
     * Show approval screen for a specific requisition.
     */
    public function show($id)
    {
        $requisition = MaintenanceRequisition::with([
            'vehicle',
            'employee',
            'vehicle.vehicleType',
            'items.category',
            'maintenanceType',
            'vendor'
        ])->findOrFail($id);

        $vendors = MaintenanceVendor::all();

        return view('admin.dashboard.maintenance_approvals.show', compact('requisition', 'vendors'));
    }

    /**
     * AJAX: DataTable for maintenance approvals.
     */
    public function ajax(Request $request)
    {
        $query = MaintenanceRequisition::with(['vehicle', 'employee', 'maintenanceType'])
            ->where('status', 'Pending Approval');

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('type')) {
            $query->where('requisition_type', $request->type);
        }

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        }

        if ($request->filled('search_text')) {
            $query->where(function($q) use($request) {
                $q->where('requisition_no', 'like', '%' . $request->search_text . '%')
                  ->orWhere('service_title', 'like', '%' . $request->search_text . '%');
            });
        }

        return \DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('vehicle', function($r) {
                return $r->vehicle->vehicle_name ?? '-';
            })
            ->addColumn('employee', function($r) {
                return $r->employee->name ?? '-';
            })
            ->addColumn('type', function($r) {
                return ucfirst($r->requisition_type);
            })
            ->addColumn('priority', function($r) {
                $colors = ['Low' => 'success', 'Medium' => 'warning', 'High' => 'danger', 'Urgent' => 'dark'];
                return '<span class="badge bg-' . ($colors[$r->priority] ?? 'secondary') . '">' . $r->priority . '</span>';
            })
            ->addColumn('total_cost', function($r) {
                return '$' . number_format($r->total_cost ?? 0, 2);
            })
            ->addColumn('status_badge', function($r) {
                return '<span class="badge bg-warning">Pending Approval</span>';
            })
            ->addColumn('action', function($r) {
                return view('admin.dashboard.maintenance_approvals.partials.action_btn', compact('r'))->render();
            })
            ->rawColumns(['priority', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Approve maintenance requisition (Department Head approval)
     */
    public function approve(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'remarks' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'validation_error', 'errors' => $validator->errors()], 422);
        }

        $requisition = MaintenanceRequisition::findOrFail($id);

        if ($requisition->status !== 'Pending Approval') {
            return response()->json(['status' => 'error', 'message' => 'This requisition is not pending approval.'], 422);
        }

        // Update department approval status
        $requisition->department_status = 'Approved';
        $requisition->department_approved_by = Auth::id();
        $requisition->department_approved_at = now();
        $requisition->department_remarks = $request->remarks ?? null;
        
        // Set status to pending transport approval
        $requisition->status = 'Pending Transport Approval';
        $requisition->save();

        // Send email notification to Transport Head
        try {
            $this->emailService->sendMaintenanceDepartmentApproved($requisition);
            Log::info('Maintenance department approval email sent to transport head for requisition: ' . $requisition->requisition_no);
        } catch (\Exception $e) {
            Log::error('Failed to send maintenance department approval email: ' . $e->getMessage());
        }

        // Send push notification to requester and transport heads
        $notificationUsers = collect();

        // Get requester if they have a user account
        if ($requisition->employee && $requisition->employee->user) {
            $notificationUsers = $notificationUsers->push($requisition->employee->user);
        }

        // Also notify Transport Head, Super Admin, Admin
        $transportUsers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['Transport', 'Super Admin', 'Admin']);
            })
            ->where('id', '!=', Auth::id())
            ->get();

        $notificationUsers = $notificationUsers->merge($transportUsers);

        // Send notifications
        if ($notificationUsers->isNotEmpty()) {
            Notification::send($notificationUsers, new MaintenanceApproved($requisition));
            Log::info('Maintenance department approval push notification sent');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance requisition approved and sent to Transport Head!'
        ]);
    }

    /**
     * Reject maintenance requisition.
     */
    public function reject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'remarks' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'validation_error', 'errors' => $validator->errors()], 422);
        }

        $requisition = MaintenanceRequisition::findOrFail($id);

        if (!in_array($requisition->status, ['Pending Approval', 'Pending'])) {
            return response()->json(['status' => 'error', 'message' => 'This requisition cannot be rejected.'], 422);
        }

        $requisition->status = 'Rejected';
        $requisition->approved_by = Auth::id();
        $requisition->approved_at = now();
        $requisition->approval_remarks = $request->remarks;
        $requisition->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance requisition rejected.'
        ]);
    }

    /**
     * Submit for approval (change from Pending to Pending Approval).
     */
    public function submit(Request $request, $id)
    {
        $requisition = MaintenanceRequisition::findOrFail($id);

        if ($requisition->status !== 'Pending') {
            return response()->json(['status' => 'error', 'message' => 'Only pending requisitions can be submitted for approval.'], 422);
        }

        $requisition->status = 'Pending Approval';
        $requisition->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Requisition submitted for approval.'
        ]);
    }

    /**
     * Get approved requisitions for completion.
     */
    public function approved(Request $request)
    {
        if ($request->ajax()) {
            $query = MaintenanceRequisition::with(['vehicle', 'employee', 'maintenanceType'])
                ->where('status', 'Approved');

            if ($request->filled('search_text')) {
                $query->where(function($q) use($request) {
                    $q->where('requisition_no', 'like', '%' . $request->search_text . '%')
                      ->orWhere('service_title', 'like', '%' . $request->search_text . '%');
                });
            }

            return \DataTables::eloquent($query)
                ->addIndexColumn()
                ->addColumn('vehicle', function($r) {
                    return $r->vehicle->vehicle_name ?? '-';
                })
                ->addColumn('employee', function($r) {
                    return $r->employee->name ?? '-';
                })
                ->addColumn('total_cost', function($r) {
                    return '$' . number_format($r->total_cost ?? 0, 2);
                })
                ->addColumn('approved_at', function($r) {
                    return $r->approved_at ? date('d M, Y H:i', strtotime($r->approved_at)) : '-';
                })
                ->addColumn('status_badge', function($r) {
                    return '<span class="badge bg-success">Approved</span>';
                })
                ->addColumn('action', function($r) {
                    return '<a href="' . route("maintenance_approvals.show", $r->id) . '" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>';
                })
                ->rawColumns(['status_badge', 'action'])
                ->make(true);
        }

        return view('admin.dashboard.maintenance_approvals.approved');
    }

    /**
     * Mark requisition as completed.
     */
    public function complete(Request $request, $id)
    {
        $requisition = MaintenanceRequisition::findOrFail($id);

        if ($requisition->status !== 'Approved') {
            return response()->json(['status' => 'error', 'message' => 'Only approved requisitions can be marked as completed.'], 422);
        }

        $requisition->status = 'Completed';
        $requisition->save();

        // Update vehicle availability if needed
        // You can add logic here to update vehicle status

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance requisition marked as completed.'
        ]);
    }
}
