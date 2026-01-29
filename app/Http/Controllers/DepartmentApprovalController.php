<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\User;
use App\Models\Department;
use App\Models\Unit;
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
        $departments = Department::all();
        $units = Unit::all();
        $users = User::all();

        // Assuming the view exists at this path
        return view('admin.dashboard.approvals.department.index', compact('departments', 'units', 'users'));
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

        if ($requisition->department_status !== 'Pending') {
            return response()->json(['status' => 'error', 'message' => 'Requisition is not in a state to be approved by the department.'], 422);
        }

        $requisition->update([
            'department_status' => 'Approved',
            'transport_status' => 'Pending',
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

    $query = Requisition::with(['requestedBy', 'department', 'unit'])
        ->whereIn('department_status', ['Pending', 'Approved']);

    if ($user->hasRole('Department Head')) {
        $query->where('department_id', $user->department_id);
    }

    // Filters
    if ($request->department_id) {
        $query->where('department_id', $request->department_id);
    }
    if ($request->unit_id) {
        $query->where('unit_id', $request->unit_id);
    }
    if ($request->requested_by) {
        $query->where('requested_by', $request->requested_by);
    }
    if ($request->status) {
        $query->where('status', $request->status);
    }
    if ($request->date_from) {
        $query->whereDate('created_at', '>=', $request->date_from);
    }
    if ($request->date_to) {
        $query->whereDate('created_at', '<=', $request->date_to);
    }
    if ($request->search_text) {
        $search = $request->search_text;
        $query->where(function($q) use ($search) {
            $q->where('requisition_number', 'like', "%$search%");
        });
    }

    return \DataTables::eloquent($query)

        ->addColumn('requested_by', fn($r) => $r->requestedBy->name ?? '-')
        ->addColumn('department', fn($r) => $r->department->department_name ?? '-')
        ->addColumn('unit', fn($r) => $r->unit->unit_name ?? '-')

        ->addColumn('department_status_badge', function ($r) {
            return $r->department_status;
        })

        ->addColumn('transport_status_badge', function ($r) {
            return $r->transport_status ?? 'Pending';
        })
         ->addColumn('action', function($r){
            // Only show Review button if department_status is Pending
            if ($r->department_status === 'Pending') {
                $url = route('department.approvals.show', $r->id);
                return '<a href="'.$url.'" class="btn btn-sm btn-primary">
                            <i class="fa fa-eye me-1"></i> Review
                        </a>';
            }
            return '<span class="text-muted">Approved</span>';
        })

        ->rawColumns(['action'])
        ->make(true);
    }


}