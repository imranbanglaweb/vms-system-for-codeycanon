<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Services\EmailService;
use Illuminate\Http\Request;

class RequisitionApprovalController extends Controller
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

    // public function approve(Request $request, $id)
    // {
    //     $req = Requisition::findOrFail($id);
    //     $user = auth()->user();

    //     switch ($user->role) {

    //         case 'dept_head':
    //             if ($req->status != 'Pending') return response()->json(["error" => "Already processed"]);
    //             $req->status = 'Dept_Approved';
    //             break;

    //         case 'transport_admin':
    //             if ($req->status != 'Dept_Approved') return response()->json(["error" => "Not department-approved"]);
    //             $req->status = 'Transport_Approved';
    //             break;

    //         case 'gm':
    //             if ($req->status != 'Transport_Approved') return response()->json(["error" => "Not transport-approved"]);
    //             $req->status = 'GM_Approved';
    //             break;

    //         case 'super_admin':
    //             $req->status = 'Completed';
    //             break;

    //         default:
    //             return response()->json(["error" => "You are not allowed to approve"]);
    //     }

    //     $req->save();

    //     return response()->json(["success" => true]);
    // }



    // public function reject(Request $request, $id)
    // {
    //     $req = Requisition::findOrFail($id);
    //     $req->status = 'Rejected';
    //     $req->save();

    //     return response()->json(["success" => true]);
    // }



  // Department approval by department head
    public function deptApprove(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id);
        $oldStatus = $requisition->status;

        $requisition->update([
            'approved_by_department' => auth()->id(),
            'department_approved_at' => now(),
            'status' => 'Pending Transport Approval'
        ]);

        // Send email notification to transport admin
        $this->emailService->sendDepartmentApproved($requisition);

        // Notify transport admin(s) - implement logic to find transport admins
        $transportAdmins = \App\Models\User::where('role','transport_admin')->get();
        foreach ($transportAdmins as $admin) {
            $admin->notify(new \App\Notifications\RequisitionStatusNotification($requisition, 'Pending Transport Approval'));
        }

        return response()->json(['status'=>'success','message'=>'Department approved']);
    }

    public function deptReject(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id);
        $requisition->update([
            'approved_by_department' => auth()->id(),
            'department_approved_at' => now(),
            'status' => 'Rejected'
        ]);

        // Notify requester
        $user = $requisition->requester->user ?? null;
        if ($user) {
            $user->notify(new \App\Notifications\RequisitionStatusNotification($requisition, 'Rejected by Department'));
        }

        return response()->json(['status'=>'success','message'=>'Department rejected']);
    }

    // Transport admin approval (assign vehicle & driver)
    public function transportApprove(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id);

        // Try to find vehicle and driver automatically if not provided
        $vehicle = \App\Models\Vehicle::available()->where('type', $requisition->vehicle_type)->first();
        $driver = \App\Models\Driver::available()->first();

        if (!$vehicle || !$driver) {
            return response()->json(['status'=>'error','message'=>'No available vehicle or driver'], 422);
        }

        // Assign, update statuses
        $requisition->update([
            'vehicle_id' => $vehicle->id,
            'driver_id' => $driver->id,
            'transport_admin_id' => auth()->id(),
            'transport_approved_at' => now(),
            'status' => 'Approved'
        ]);

        $vehicle->update(['status' => 'Assigned']);
        $driver->update(['status' => 'Assigned']);

        // Send email notification to requester, driver, and transport head
        $this->emailService->sendTransportApproved($requisition);

        // Notify requester
        $user = $requisition->requester->user ?? null;
        if ($user) {
            $user->notify(new \App\Notifications\RequisitionStatusNotification($requisition, 'Approved'));
        }

        return response()->json(['status'=>'success','message'=>'Transport approved and vehicle/driver assigned']);
    }

    public function transportReject(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id);
        $requisition->update([
            'transport_admin_id' => auth()->id(),
            'transport_approved_at' => now(),
            'status' => 'Rejected by Transport'
        ]);

        // Notify requester
        $user = $requisition->requester->user ?? null;
        if ($user) {
            $user->notify(new \App\Notifications\RequisitionStatusNotification($requisition, 'Rejected by Transport'));
        }

        return response()->json(['status'=>'success','message'=>'Transport rejected']);
    }



}
