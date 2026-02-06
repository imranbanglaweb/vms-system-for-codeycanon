<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\TripSheet;
use App\Models\Department;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use App\Notifications\TransportApproved;

class TransportApprovalController extends Controller
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
     * List all department-approved requisitions.
     */
    public function index()
    {
        $departments = Department::all();
        $users = User::all();
        return view('admin.dashboard.approvals.transport.index', compact('departments', 'users'));
    }

    /**
     * Show approval screen.
     */
    public function show($id)
    {
        $requisition = Requisition::with(['requestedBy', 'department', 'unit', 'passengers', 'assignedVehicle', 'assignedDriver'])
            ->findOrFail($id);

        $vehicles = Vehicle::where('status', '1')->get();
        $drivers = Driver::where('status', '1')->get();

        return view('admin.dashboard.approvals.transport.show', compact('requisition', 'vehicles', 'drivers'));
    }

    // /**
    //  * Assign vehicle and driver.
    //  */
    // public function assignVehicleDriver(Request $request, $id)
    // {
    //     $request->validate([
    //         'assigned_vehicle_id' => 'required|exists:vehicles,id',
    //         'assigned_driver_id' => 'required|exists:drivers,id',
    //     ]);

    //     $req = Requisition::findOrFail($id);

    //     $req->assigned_vehicle_id = $request->vehicle_id;
    //     $req->assigned_driver_id = $request->driver_id;
    //     $req->transport_status = 'Assigned';
    //     $req->save();

    //     // TODO: Send notification to employee
    //     // event(new RequisitionAssigned($req));

    //     return response()->json([
    //         'status' => 'success',
    //         'message' => 'Vehicle & Driver assigned successfully!'
    //     ]);
    // }



     public function assignVehicleDriver(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'assigned_vehicle_id' => 'required|exists:vehicles,id',
            'assigned_driver_id'  => 'required|exists:drivers,id',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=>'validation_error','errors'=>$validator->errors()], 422);
        }

        $requisition = Requisition::findOrFail($id);
        $vehicle = Vehicle::findOrFail($request->assigned_vehicle_id);
        $driver  = Driver::findOrFail($request->assigned_driver_id);

        // Conflict check: same travel_date (you can enhance to time ranges)
        $travelDate = $requisition->travel_date ? date('Y-m-d', strtotime($requisition->travel_date)) : null;

        // vehicle conflict: any other requisition assigned/approved with same vehicle on same date
        $vehicleConflict = Requisition::where('assigned_vehicle_id', $vehicle->id)
            ->whereIn('transport_status',['Assigned','Approved'])
            ->whereDate('travel_date', $travelDate)
            ->where('id','!=', $requisition->id)
            ->exists();

        if ($vehicleConflict) {
            return response()->json(['status'=>'error','message'=>'Selected vehicle is already assigned for the same date.'], 422);
        }

        // dd($vehicleConflict);
        // driver conflict
        $driverConflict = Requisition::where('assigned_driver_id', $driver->id)
            ->whereIn('transport_status',['Assigned','Approved'])
            ->whereDate('travel_date', $travelDate)
            ->where('id','!=', $requisition->id)
            ->exists();

        if ($driverConflict) {
            return response()->json(['status'=>'error','message'=>'Selected driver is already assigned for the same date.'], 422);
        }

        // assign
        $requisition->assigned_vehicle_id = $vehicle->id;
        $requisition->assigned_driver_id  = $driver->id;
        $requisition->transport_status    = 'Assigned';
        $requisition->transport_remarks   = $request->remarks ?? null;
        $requisition->transport_admin_id = Auth::id();
        $requisition->save();

        // Optionally update vehicle/driver status to Assigned
        $vehicle->update(['availability_status' => 'Assigned']);
        $driver->update(['availability_status' => 'Assigned']);

        // TODO: Notify requester + driver if needed

        return response()->json(['status'=>'success','message'=>'Vehicle & driver assigned successfully.']);
    }
    /**
     * Approve final transport.
     */
    
    public function approve(Request $request, $id)
    {
        $requisition = Requisition::findOrFail($id);

        if (empty($requisition->assigned_vehicle_id) || empty($requisition->assigned_driver_id)) {
            return response()->json(['status'=>'error','message'=>'Assign vehicle and driver before final approval.'], 422);
        }

        $oldStatus = $requisition->transport_status;
        
        $requisition->transport_status = 'Approved';
        $requisition->transport_approved_at = now();
        $requisition->transport_admin_id = Auth::id();
        $requisition->transport_remarks = $request->remarks ?? $requisition->transport_remarks;
        $requisition->status = 'Approved';
        $requisition->save();

        // Send email notification to requester, driver, and transport head
        try {
            $this->emailService->sendTransportApproved($requisition);
            Log::info('Transport approval email sent for requisition: ' . $requisition->requisition_number);
        } catch (\Exception $e) {
            Log::error('Failed to send transport approval email: ' . $e->getMessage());
        }

        // Send push notification to requester and driver
        $notificationUsers = collect();
        
        // Get requester if they have a user account (linked via employee_id)
        $requesterUser = User::where('employee_id', $requisition->requested_by)->first();
        if ($requesterUser) {
            $notificationUsers = $notificationUsers->push($requesterUser);
        }
        
        // Get driver if they have a user account
        if ($requisition->assignedDriver) {
            $driverUser = User::where('employee_id', $requisition->assignedDriver->employee_id ?? null)->first();
            if ($driverUser && !$notificationUsers->contains('id', $driverUser->id)) {
                $notificationUsers = $notificationUsers->push($driverUser);
            }
        }
        
        // Also notify Transport Head, Transport Managers, Super Admin, Admin
        $transportUsers = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['Transport_Head', 'Transport', 'Super Admin', 'Admin']);
            })
            ->where('id', '!=', Auth::id())
            ->get();
            
        $notificationUsers = $notificationUsers->merge($transportUsers);
        
        // Log the users we found
        Log::info('Transport approval push notification target users count: ' . $notificationUsers->count());
        foreach ($notificationUsers as $notificationUser) {
            Log::info('User ID: ' . $notificationUser->id . ', Email: ' . $notificationUser->email);
        }
        
        // Send notification to these users
        if ($notificationUsers->isNotEmpty()) {
            Notification::send($notificationUsers, new TransportApproved($requisition));
            Log::info('Transport approval push notification sent');
        } else {
            Log::warning('No users found for transport approval push notification.');
        }

        //  // Update vehicle status
        $vehicle = Vehicle::find($requisition->assigned_vehicle_id);
        $vehicle->availability_status = 'busy';  // ENUM value
        $vehicle->save();

        // // Update driver status
        $driver = Driver::find($requisition->assigned_driver_id);
        $driver->availability_status = 'busy';   // ENUM value
        $driver->save();


        // dd($requisition->assigned_vehicle_id);

         // CREATE TRIP SHEET
    $trip = TripSheet::create([
        'trip_number' => 'TS-' . str_pad(TripSheet::max('id') + 1, 5, '0', STR_PAD_LEFT),
        'requisition_id' => $requisition->id,
        'vehicle_id' => $requisition->assigned_vehicle_id,
        'driver_id' => $requisition->assigned_driver_id,
        'start_date' => $requisition->travel_date,
        'trip_start_time' => $request->start_time,
        'start_meter' => $request->start_meter,
        'start_location' => $requisition->from_location,
        'status' => 'in_progress'
    ]);

        return response()->json(['status'=>'success','message'=>'Requisition approved and scheduled.']);
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['remarks'=>'required|string']);
        $requisition = Requisition::findOrFail($id);

        $requisition->transport_status = 'Rejected';
        $requisition->transport_remarks = $request->remarks;
        $requisition->transport_approved_at = now();
        $requisition->transport_approved_by = Auth::id();
        $requisition->status = 'Rejected by Transport';
        $requisition->save();

        // Optionally free vehicle/driver if previously assigned
        if ($requisition->assigned_vehicle_id) {
            Vehicle::find($requisition->assigned_vehicle_id)?->update(['status'=>'Available']);
        }
        if ($requisition->assigned_driver_id) {
            Driver::find($requisition->assigned_driver_id)?->update(['status'=>'Available']);
        }

        return response()->json(['status'=>'success','message'=>'Requisition rejected by transport.']);
    }


    public function availability($id)
    {
    // load vehicle status list
    $vehicles = Vehicle::select('id','availability_status')->get()->map(function($v){
        return ['id' => $v->id, 'availability_status' => $v->availability_status];
    });

    $drivers = Driver::select('id','availability_status')->get()->map(function($d){
        return ['id' => $d->id, 'availability_status' => $d->availability_status];
    });

    // optional: return any currently assigned vehicle/driver info for this requisition
    $requisition = Requisition::with(['assignedVehicle','assignedDriver'])->find($id);
    $assignedInfo = null;
    if ($requisition) {
        $assignedInfo = [
            'vehicle_id' => $requisition->assigned_vehicle_id,
            'vehicle_name' => optional($requisition->assignedVehicle)->vehicle_name,
            'driver_id' => $requisition->assigned_driver_id,
            'driver_name' => optional($requisition->assignedDriver)->driver_name,
        ];
    }

    return response()->json([
        'vehicles' => $vehicles,
        'drivers'  => $drivers,
        'assigned_info' => $assignedInfo
    ]);
    }

    /**
     * Get available drivers for a specific vehicle
     * Used for auto-loading drivers when vehicle is selected
     */
    public function getDriversForVehicle($requisitionId, $vehicleId)
    {
        $travelDate = null;
        
        if ($requisitionId) {
            $requisition = Requisition::find($requisitionId);
            $travelDate = $requisition->travel_date ? date('Y-m-d', strtotime($requisition->travel_date)) : null;
        }
        
        // Get drivers available for this vehicle on the travel date
        // First get all active drivers
        $drivers = Driver::where('status', '1')->get();
        
        $availableDrivers = $drivers->filter(function($driver) use ($travelDate, $requisitionId) {
            // Check if driver is assigned to another requisition on the same date
            $conflict = Requisition::where('assigned_driver_id', $driver->id)
                ->whereIn('transport_status', ['Assigned', 'Approved'])
                ->whereDate('travel_date', $travelDate)
                ->where('id', '!=', $requisitionId)
                ->exists();
            
            return !$conflict;
        })->map(function($driver) {
            $isAvailable = strtolower($driver->availability_status) !== 'assigned';
            return [
                'id' => $driver->id,
                'driver_name' => $driver->driver_name,
                'phone' => $driver->phone,
                'availability_status' => $driver->availability_status,
                'is_available' => $isAvailable,
                'status_label' => $isAvailable ? 'Available' : 'Busy',
                'status_class' => $isAvailable ? 'success' : 'danger'
            ];
        });
        
        return response()->json([
            'drivers' => $availableDrivers,
            'travel_date' => $travelDate
        ]);
    }

    /**
     * AJAX: DataTable for transport approvals
     */
    public function ajax(Request $request)
    {
        // Only show requisitions that have been approved by department
        $query = Requisition::with(['requestedBy', 'department'])
            ->where('department_status', 'Approved')
            ->where(function($q) {
                $q->where('status', 'Pending Transport Approval')
                  ->orWhereIn('transport_status', ['Assigned', 'Pending', 'Approved']);
            });

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }
        if ($request->filled('status')) {
            $query->where('transport_status', $request->status);
        }
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        }
        if ($request->filled('search_text')) {
            $query->where(function($q) use($request){
                $q->where('requisition_number', 'like', '%'.$request->search_text.'%');
            });
        }

        return \DataTables::eloquent($query)
            ->addColumn('requested_by', function($r){
                return $r->requestedBy->name ?? '-';
            })
            ->addColumn('department', function($r){
                return $r->department->department_name ?? '-';
            })
            ->addColumn('department_approved_at', function($r){
                return $r->department_approved_at ? date('d M, Y', strtotime($r->department_approved_at)) : '-';
            })
            ->addColumn('status_badge', function($r){
                $status = $r->transport_status;
                $class = $status === 'Pending' ? 'warning' : ($status === 'Assigned' ? 'info' : ($status === 'Approved' ? 'success' : 'secondary'));
                return '<span class="badge bg-' . $class . '">' . $status . '</span>';
            })
            ->addColumn('action', function($r){
                // Only show Process button if transport_status is Pending or Assigned
                if (in_array($r->transport_status, ['Pending', 'Assigned'])) {
                    return view('admin.dashboard.approvals.transport.partials.action_btn', compact('r'))->render();
                }
                return '<span class="text-muted">Completed</span>';
            })
            ->rawColumns(['status_badge','action'])
            ->make(true);
    }
}
