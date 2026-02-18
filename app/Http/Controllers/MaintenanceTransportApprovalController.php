<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequisition;
use App\Models\MaintenanceVendor;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\MaintenanceApproved;

class MaintenanceTransportApprovalController extends Controller
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
     * List all maintenance requisitions pending transport approval.
     */
    public function index()
    {
        return view('admin.dashboard.maintenance_transport_approvals.index');
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

        return view('admin.dashboard.maintenance_transport_approvals.show', compact('requisition', 'vendors'));
    }

    /**
     * AJAX: DataTable for maintenance transport approvals.
     */
    public function ajax(Request $request)
    {
        $query = MaintenanceRequisition::with(['vehicle', 'employee', 'maintenanceType'])
            ->where('department_status', 'Approved')
            ->where(function($q) {
                $q->where('status', 'Pending Transport Approval')
                  ->orWhere('transport_status', 'Pending');
            });

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
                return '<span class="badge bg-info">Pending Transport Approval</span>';
            })
            ->addColumn('action', function($r) {
                return view('admin.dashboard.maintenance_transport_approvals.partials.action_btn', compact('r'))->render();
            })
            ->rawColumns(['priority', 'status_badge', 'action'])
            ->make(true);
    }

    /**
     * Approve maintenance requisition (Transport Head approval).
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

        // Check if department has approved first
        if ($requisition->department_status !== 'Approved') {
            return response()->json(['status' => 'error', 'message' => 'This requisition must be approved by Department Head first.'], 422);
        }

        if (!in_array($requisition->status, ['Pending Transport Approval', 'Pending'])) {
            return response()->json(['status' => 'error', 'message' => 'This requisition is not pending transport approval.'], 422);
        }

        // Update transport approval status
        $requisition->transport_status = 'Approved';
        $requisition->transport_approved_by = Auth::id();
        $requisition->transport_approved_at = now();
        $requisition->transport_remarks = $request->remarks ?? null;
        
        // Final approval
        $requisition->status = 'Approved';
        $requisition->approved_by = Auth::id();
        $requisition->approved_at = now();
        $requisition->save();

        // Send email notification to Department Head and Requester
        try {
            $this->emailService->sendMaintenanceTransportApproved($requisition);
            Log::info('Maintenance transport approval email sent for requisition: ' . $requisition->requisition_no);
        } catch (\Exception $e) {
            Log::error('Failed to send maintenance transport approval email: ' . $e->getMessage());
        }

        // Send push notification to requester and department heads
        $notificationUsers = collect();

        // Get requester if they have a user account
        if ($requisition->employee && $requisition->employee->user) {
            $notificationUsers = $notificationUsers->push($requisition->employee->user);
        }

        // Also notify Department Head, Super Admin, Admin
        $departmentUsers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['Department Head', 'Manager', 'Super Admin', 'Admin']);
            })
            ->where('id', '!=', Auth::id())
            ->get();

        $notificationUsers = $notificationUsers->merge($departmentUsers);

        // Send notifications
        if ($notificationUsers->isNotEmpty()) {
            Notification::send($notificationUsers, new MaintenanceApproved($requisition));
            Log::info('Maintenance transport approval push notification sent');
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance requisition approved successfully!'
        ]);
    }

    /**
     * Reject maintenance requisition (Transport Head rejection).
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

        if ($requisition->department_status !== 'Approved') {
            return response()->json(['status' => 'error', 'message' => 'This requisition cannot be rejected at transport level.'], 422);
        }

        // Update transport rejection status
        $requisition->transport_status = 'Rejected';
        $requisition->transport_approved_by = Auth::id();
        $requisition->transport_approved_at = now();
        $requisition->transport_remarks = $request->remarks;
        
        // Set overall status to rejected
        $requisition->status = 'Rejected';
        $requisition->save();

        // Send notification to requester
        if ($requisition->employee && $requisition->employee->user) {
            $requisition->employee->user->notify(new MaintenanceApproved($requisition));
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Maintenance requisition rejected by Transport.'
        ]);
    }
}
