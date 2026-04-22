<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Requisition;
use App\Models\Unit;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class DepartmentApprovalController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->middleware('auth');
        // This permission is defined in your PermissionSeeder
        $this->middleware('permission:department-approval-view');
        $this->emailService = $emailService;
    }

    /**
     * Display a listing of the requisitions pending department approval.
     * The view will be populated by an AJAX call to the 'ajax' method.
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'pending');
        $departments = Department::all();
        $units = Unit::all();
        $users = User::all();

        return view('admin.dashboard.approvals.department.index', compact('departments', 'units', 'users', 'type'));
    }

    /**
     * Display the current user's pending approvals.
     */
    public function myApprovals(Request $request)
    {
        $type = 'my';
        $departments = Department::all();
        $units = Unit::all();
        $users = User::all();

        return view('admin.dashboard.approvals.department.index', compact('departments', 'units', 'users', 'type'));
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

        // Debug logging
        \Log::info('Approve attempt - Requisition ID: '.$requisition->id.', Status: ['.$requisition->department_status.']');

        if (! in_array($requisition->department_status, ['Pending', null])) {
            return response()->json(['status' => 'error', 'message' => 'Requisition is not in a state to be approved by the department. Current status: '.$requisition->department_status], 422);
        }

        $requisition->update([
            'status' => 'Approved',
            'department_status' => 'Approved',
            'transport_status' => 'Pending',
            'department_approved_at' => now(),
            'department_approved_by' => $user->id,
            'department_remarks' => $request->remarks,
        ]);

        // Send email notification via queue (async)
        try {
            $this->emailService->sendDepartmentApproved($requisition);
            Log::info('Department approval email queued for requisition: '.$requisition->requisition_number);
        } catch (\Exception $e) {
            Log::error('Failed to send department approval email: '.$e->getMessage());
        }

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

        if (! in_array($requisition->department_status, ['Pending', null])) {
            return response()->json(['status' => 'error', 'message' => 'Requisition is not in a state to be rejected by the department.'], 422);
        }

        $requisition->update([
            'status' => 'Rejected by Department',
            'department_status' => 'Rejected',
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
        $type = $request->get('type', 'pending');

        // Build query based on type
        $query = Requisition::with(['requestedBy', 'department', 'unit']);

        // Filter by type
        switch ($type) {
            case 'pending':
                $query->where('department_status', 'Pending');
                break;
            case 'approved':
                $query->where('department_status', 'Approved');
                break;
            case 'rejected':
                $query->where('department_status', 'Rejected');
                break;
            case 'my':
                $query->where('department_status', 'Pending')
                    ->where('department_id', $user->department_id);
                break;
            default:
                $query->whereIn('department_status', ['Pending', 'Approved']);
        }

        // Department Head can only see their department's requisitions
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
            $query->where(function ($q) use ($search) {
                $q->where('requisition_number', 'like', "%$search%");
            });
        }

        return \DataTables::eloquent($query)
            ->addColumn('requested_by', function ($r) {
                // Eager load check - if relationship not loaded, try to get from the model
                if ($r->relationLoaded('requestedBy') && $r->requestedBy) {
                    return $r->requestedBy->name;
                }
                // Fallback: try to get employee directly
                $employee = \App\Models\Employee::find($r->requested_by);

                return $employee ? $employee->name : '-';
            })
            ->addColumn('department', function ($r) {
                if ($r->relationLoaded('department') && $r->department) {
                    return $r->department->department_name;
                }
                $dept = \App\Models\Department::find($r->department_id);

                return $dept ? $dept->department_name : '-';
            })
            ->addColumn('unit', function ($r) {
                if ($r->relationLoaded('unit') && $r->unit) {
                    return $r->unit->unit_name;
                }
                $unit = \App\Models\Unit::find($r->unit_id);

                return $unit ? $unit->unit_name : '-';
            })

            ->addColumn('department_status_badge', function ($r) {
                return $r->department_status;
            })

            ->addColumn('transport_status_badge', function ($r) {
                return $r->transport_status ?? 'Pending';
            })
            ->addColumn('action', function ($r) {
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
