<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class DepartmentApprovalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // This permission is defined in your PermissionSeeder
        $this->middleware('permission:department-approval-view');
    }

    /**
     * Display a listing of the requisitions pending department approval.
     * The view will be populated by an AJAX call to the 'ajax' method.
     */
    public function index()
    {
        // Assuming the view exists at this path
        return view('admin.dashboard.approvals.department.index');
    }

    /**
     * Display the specified requisition for approval.
     */
    public function show($id)
    {
        $requisition = Requisition::with(['requestedBy', 'department', 'unit', 'passengers.employee'])->findOrFail($id);

        // Security check: Dept Head can only see their department's requisitions
        $user = Auth::user();
        if ($user->hasRole('Department Head') && $requisition->department_id != $user->department_id) {
            abort(403, 'You are not authorized to view this requisition.');
        }

        // Assuming the view exists at this path
        return view('admin.dashboard.approvals.department.show', compact('requisition'));
    }

    /**
     * Approve the specified requisition and move it to the next stage.
     */
    public function approve(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id);
        $user = Auth::user();

        // Security check
        if ($user->hasRole('Department Head') && $requisition->department_id != $user->department_id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        if ($requisition->status !== 'Pending Department Approval') {
            return response()->json(['status' => 'error', 'message' => 'Requisition is not in a state to be approved by the department.'], 422);
        }

        $requisition->update([
            'status' => 'Pending Transport Approval',
            'department_approved_at' => now(),
            'department_approved_by' => $user->id,
            'department_remarks' => $request->remarks,
        ]);

        // TODO: Optionally, notify Transport Managers
        // $transportManagers = User::role('Transport')->get();
        // if ($transportManagers->isNotEmpty()) {
        //     Notification::send($transportManagers, new YourNotificationForTransport($requisition));
        // }

        return response()->json(['status' => 'success', 'message' => 'Requisition approved and forwarded to the Transport department.']);
    }

    /**
     * Reject the specified requisition.
     */
    public function reject(Request $request, $id)
    {
        $request->validate(['remarks' => 'required|string|max:500']);
        $requisition = Requisition::findOrFail($id);
        $user = Auth::user();

        // Security check
        if ($user->hasRole('Department Head') && $requisition->department_id != $user->department_id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        if ($requisition->status !== 'Pending Department Approval') {
            return response()->json(['status' => 'error', 'message' => 'Requisition is not in a state to be rejected by the department.'], 422);
        }

        $requisition->update([
            'status' => 'Rejected by Department',
            'department_approved_at' => now(), // This is more like 'processed_at'
            'department_approved_by' => $user->id,
            'department_remarks' => $request->remarks,
        ]);

        // TODO: Optionally, notify the original requester
        // if ($requisition->requestedBy->user) {
        //    Notification::send($requisition->requestedBy->user, new YourRejectionNotification($requisition));
        // }

        return response()->json(['status' => 'success', 'message' => 'Requisition has been rejected.']);
    }

    /**
     * Provide data for the department approval DataTable.
     */
    public function ajax(Request $request)
    {
        $user = Auth::user();
        $query = Requisition::with(['requestedBy', 'department'])
            ->where('status', 'Pending Department Approval');

        // Department head should only see requisitions from their own department.
        // Super Admin/Admin can see all.
        if ($user->hasRole('Department Head')) {
            // Assuming the User model has a 'department_id'
            $query->where('department_id', $user->department_id);
        }

        return \DataTables::eloquent($query)
            ->addColumn('requested_by', function ($r) {
                return $r->requestedBy->name ?? '-';
            })
            ->addColumn('department', function ($r) {
                return $r->department->department_name ?? '-';
            })
            ->addColumn('travel_date', function ($r) {
                return $r->travel_date ? date('d M, Y', strtotime($r->travel_date)) : '-';
            })
            ->addColumn('status_badge', function ($r) {
                return '<span class="badge bg-warning">' . $r->status . '</span>';
            })
            ->addColumn('action', function ($r) {
                $viewUrl = route('department.approvals.show', $r->id);
                return '<a href="' . $viewUrl . '" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>';
            })
            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }
}