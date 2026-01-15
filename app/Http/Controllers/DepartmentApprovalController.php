<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\Department;
use App\Models\Unit;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class DepartmentApprovalController extends Controller
{
    /**
     * List all pending requisitions for this department.
     */
    public function index()
    {
        // $requisitions = Requisition::with(['requestedBy', 'department', 'unit'])
        //     ->where('status', 'Pending')
        //     ->orderBy('created_at', 'desc')
        //     ->get();

            $departments = Department::select('id','department_name')->get();
            $units = Unit::select('id','unit_name')->get();
            $users = User::select('id','name')->get();

        // return view('department.approvals.index', compact('departments','units','users'));

        return view('admin.dashboard.approvals.department.index', compact('departments','units','users'));
    }

    public function ajax(Request $request)
    {
        $query = Requisition::with(['requestedBy','department','unit'])
            ->select('requisitions.*');

        // Filters
        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }
        if ($request->filled('requested_by')) {
            $query->where('requested_by', $request->requested_by);
        }
        if ($request->filled('status')) {
            $query->where(function($q) use($request){
                $q->where('department_status', $request->status)
                  ->orWhere('transport_status', $request->status);
            });
        }
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        }

        // Search customization: highlight requisition_number on server-side? we will send the string and allow client highlight
        return Datatables::eloquent($query)
            ->editColumn('requisition_number', function($r){
                return $r->requisition_number;
            })
            ->addColumn('requested_by', function($r){
                return $r->requestedBy->name ?? 'N/A';
            })
            ->addColumn('department', function($r){
                return $r->department->department_name ?? '-';
            })
            ->addColumn('unit', function($r){
                return $r->unit->unit_name ?? '-';
            })
            ->addColumn('department_status_badge', function($r){
                return $r->department_status;
            })
            ->addColumn('transport_status_badge', function($r){
                return $r->transport_status;
            })
            ->addColumn('action', function($r){
                return view('admin.dashboard.approvals.department.partials.action_btn', compact('r'))->render();
            })
            ->editColumn('created_at', function($r){
                return $r->created_at->format('d M Y');
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    /**
     * Show a single requisition for review.
     */

    public function show($id) {
    $requisition = Requisition::with(['requestedBy','department','unit'])->findOrFail($id);
    return view('admin.dashboard.approvals.department.show', compact('requisition'));
}

public function approve(Request $request, $id) {
    $req = Requisition::findOrFail($id);
    $req->department_status = 'approved';
    // $req->remarks = $request->remarks;
    $req->save();
    return response()->json(['message'=>'Requisition approved successfully!']);
}

public function reject(Request $request, $id) {
    $req = Requisition::findOrFail($id);
    $req->status = 'rejected';
    $req->remarks = $request->remarks;
    $req->save();
    return response()->json(['message'=>'Requisition rejected successfully!']);
}

    // public function show($id)
    // {
    //     $requisition = Requisition::with([
    //         'requestedBy',
    //         'department',
    //         'unit',
    //     ])->findOrFail($id);


    //     return view('admin.dashboard.approvals.department.modal', compact('requisition'));

    // }

    // /**
    //  * Approve the requisition.
    //  */
    // public function approve(Request $request, $id)
    // {
    //     $requisition = Requisition::findOrFail($id);

    //     $requisition->department_status = 'Approved';
    //     $requisition->department_remarks = $request->remarks;
    //     $requisition->department_approved_at = now();
    //     $requisition->save();

    //     // TODO: Add notification (Email/SMS)
    //     // event(new RequisitionDepartmentApproved($requisition));

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Requisition approved successfully.'
    //     ]);
    // }

    // /**
    //  * Reject the requisition.
    //  */
    // public function reject(Request $request, $id)
    // {
    //     $requisition = Requisition::findOrFail($id);

    //     $request->validate([
    //         'remarks' => 'required'
    //     ]);

    //     $requisition->department_status = 'Rejected';
    //     $requisition->department_remarks = $request->remarks;
    //     $requisition->save();

    //     // TODO: Add notification
    //     // event(new RequisitionDepartmentRejected($requisition));

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Requisition rejected successfully.'
    //     ]);
    // }
}
