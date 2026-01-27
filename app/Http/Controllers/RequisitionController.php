<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Requisition;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\RequisitionStatusChangedMail;
use Illuminate\Support\Facades\Mail;
use App\Notifications\RequisitionCreated;
use App\Notifications\TestPushNotification;
use App\Events\RequisitionStatusUpdated;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
class RequisitionController extends Controller
{
   
     public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $query = Requisition::with(['employee', 'department', 'vehicle']);
    
    // Apply filters
    if ($request->filled('requisition_number')) {
        $query->where('requisition_number', 'like', '%' . $request->requisition_number . '%');
    }
    
    if ($request->filled('employee_name')) {
        $query->whereHas('employee', function($q) use ($request) {
            $q->where('name', 'like', '%' . $request->employee_name . '%');
        });
    }
    
    if ($request->filled('department_id')) {
        $query->where('department_id', $request->department_id);
    }
    
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    if ($request->filled('priority')) {
        $query->where('priority', $request->priority);
    }
    
    if ($request->filled('start_date')) {
        $query->whereDate('travel_date', '>=', $request->start_date);
    }
    
    if ($request->filled('end_date')) {
        $query->whereDate('travel_date', '<=', $request->end_date);
    }
    
    $perPage = $request->get('per_page', 10);
    $requisitions = $query->latest()->paginate($perPage);
    
    // For AJAX requests
    if ($request->ajax()) {
        return response()->json([
            'html' => view('admin.dashboard.requisition.table', compact('requisitions'))->render(),
            'pagination' => view('admin.dashboard.requisition.pagination', compact('requisitions'))->render(),
            'stats' => [
                'total' => Requisition::count(),
                'pending' => Requisition::where('status', 0)->count(),
                'approved' => Requisition::where('status', 1)->count(),
                'rejected' => Requisition::where('status', 2)->count(),
            ]
        ]);
    }
    
    $departments = Department::all();
    $stats = [
        'total' => Requisition::count(),
        'pending' => Requisition::where('status', 0)->count(),
        'approved' => Requisition::where('status', 1)->count(),
        'rejected' => Requisition::where('status', 2)->count(),
    ];
    
    return view('admin.dashboard.requisition.index', compact('requisitions', 'departments', 'stats'));
}


// EXPORT EXCEL
    public function exportExcel()
    {
        return Excel::download(new RequisitionExport, 'requisitions.xlsx');
    }

    // EXPORT PDF
    public function exportPDF()
    {
        $requisitions = Requisition::with(['requestedBy','vehicle','driver'])->get();

        $pdf = PDF::loadView('admin.dashboard.requisition.pdf', compact('requisitions'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('requisitions.pdf');
    }

   public function create()
{

        $vehicles = Vehicle::where('status', 1)->get();
        $drivers  = Driver::where('status', 1)->get();
        $employees = Employee::all();
        $vehicleTypes = VehicleType::all();

    return view('admin.dashboard.requisition.create', [
        'action'      => route('requisitions.store'),
        'method'      => 'POST',
        'units' => Unit::all(),
        'requisition' => new Requisition(),
        'vehicles'    => $vehicles,
        'employees'    => $employees,
        'drivers'     => $drivers
    ]);


 
        // return view('admin.dashboard.requisition.create', compact('employees', 'vehicleTypes'));
}


public function validateAjax(Request $request)
{
    $validator = Validator::make($request->all(), [
        'requested_by'   => 'required|exists:employees,id',
        'vehicle_id'     => 'nullable|exists:vehicles,id',
        'from_location'  => 'required|string|max:255',
        'to_location'    => 'required|string|max:255',
        'travel_date'    => 'required|date',
        'purpose'        => 'nullable|string|max:500',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Validation passed'
    ]);
}


  public function store(Request $request)
{

    // dd($request->vehicle_id);
    // Complete validation for ALL form fields
    $validator = Validator::make($request->all(), [
        'employee_id' => 'required|exists:employees,id',
        'vehicle_type' => 'required|exists:vehicle_types,id',
        // 'driver_id' => 'required|exists:drivers,id',    
        'requisition_date' => 'required|date', // Add this if it's in your form
        'from_location' => 'required|string|max:255',
        'to_location' => 'required|string|max:255',
        'travel_date' => 'required|date',
        // 'return_date' => 'required|date|after_or_equal:travel_date',
        'number_of_passenger' => 'required|integer|min:1', // Add this if it's in your form
        'purpose' => 'required|string|max:500', // Changed from nullable to required
        'passengers.*.employee_id' => 'required|exists:employees,id',
    ], [
        'employee_id.required' => 'Please select an employee',
        'vehicle_type.required' => 'Please select a vehicle Type',
        'driver_id.required' => 'Please select a driver',
        'requisition_date.required' => 'Requisition date is required',
        'from_location.required' => 'From location is required',
        'to_location.required' => 'To location is required',
        'travel_date.required' => 'Travel date is required',
        'purpose.required' => 'Purpose is required',
        'number_of_passenger.required' => 'Number of passengers is required',
        'passengers.*.employee_id.exists' => 'Selected passenger is invalid',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'validation_error',
            'errors' => $validator->errors()
        ], 422);
    }




     // 🔵 AUTO GENERATE UNIQUE REQUISITION NUMBER
       $last = Requisition::orderBy('id', 'DESC')->first();

            if ($last && preg_match('/(\d+)/', $last->requisition_number, $matches)) {
                $number = (int)$matches[1] + 1;
            } else {
                $number = 1;
            }

            $requisition_number = 'REQ-' . str_pad($number, 5, '0', STR_PAD_LEFT);


    
    DB::beginTransaction();
    try {
        $requisition = Requisition::create([
            'requested_by' => $request->employee_id,
            'company_id' => auth()->user()->company_id,
            'vehicle_id' => $request->vehicle_id ?? null,
            'department_id' => $request->department_id,
            'unit_id'       => $request->unit_id,
            'vehicle_type' => $request->vehicle_type ?? null,
            'driver_id' => $request->driver_id ?? null,
            'requisition_number' => $requisition_number,
            'from_location' => $request->from_location,
            'to_location' => $request->to_location,
            'requisition_date' => $request->requisition_date,
            'number_of_passenger' => $request->number_of_passenger,
            'travel_date' => $request->travel_date,
            'return_date' => $request->return_date,
            'purpose' => $request->purpose,
            'created_by' => auth()->id() ?? 1,
        ]);

        // Add passengers if any
        if (!empty($request->passengers)) {
            foreach ($request->passengers as $passenger) {
                if (!empty($passenger['employee_id'])) {
                    \App\Models\RequisitionPassenger::create([
                        'requisition_id' => $requisition->id,
                        'employee_id' => $passenger['employee_id'],
                        'created_by' => auth()->id() ?? 1,
                    ]);
                }
            }
        }





        DB::commit();
        
//   $users = User::whereHas('roles', function ($q) {
//         $q->whereIn('name', ['Super Admin', 'Demo Role']);
//     })
//     ->whereHas('pushSubscriptions')
//     ->get();

// Notification::send($users, new TestPushNotification($requisition));
// $user = User::find(1);
// $user->notify(new TestPushNotification($requisition));




// Get users with specific roles AND push subscriptions
$users = User::whereHas('roles', function ($q) {
        $q->whereIn('name', ['Super Admin', 'Demo Role']);
    })
    // ->whereHas('pushSubscriptions')
    ->get();
    // dd($users);

// Log the users we found
Log::info('Push notification target users count: ' . $users->count());
foreach ($users as $user) {
    Log::info('User ID: ' . $user->id . ', Email: ' . $user->email);
}

// Send notification to these users
if ($users->isNotEmpty()) {
    Notification::send($users, new RequisitionCreated($requisition));
} else {
    Log::warning('No users found with roles and push subscriptions.');
}

// Also try sending directly to Super Admin (ID 1)
$user = User::find(1);
if ($user) {
    $user->notify(new RequisitionCreated($requisition));
    Log::info('Direct notification sent to User ID 1.');
} else {
    Log::warning('User ID 1 not found.');
}

    // event(new RequisitionCreated($requisition));

        return response()->json([
            'status' => 'success',
            'message' => 'Requisition created successfully!',
            'redirect_url' => route('requisitions.index'),
            'users_found' => $users->pluck('id'),
             'direct_user' => $user ? $user->id : null,
        ], 200);
        

    } catch (\Throwable $e) {
        DB::rollBack();
        \Log::error('Requisition store error: '.$e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Server error while saving requisition: ' . $e->getMessage()
        ], 500);
    }
}

     /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $requisition = Requisition::with(['requestedBy', 'vehicle', 'driver', 'unit', 'passengers.employee'])
                                  ->findOrFail($id);

        return view('admin.dashboard.requisition.show', compact('requisition'));
        
    }

    /**
     * Edit form.
     */
   public function edit($id)
    {
        $requisition = Requisition::with(['employee', 'department', 'vehicle', 'driver', 'passengers.employee'])->findOrFail($id);
        

        // return dd($requisition);
        $employees = Employee::all();
        $vehicleTypes = VehicleType::where('status', 1)->get();
        $drivers = Driver::all();
        $units = Unit::all();
        $departments = Department::all();
        $vehicles = Vehicle::where('status', 1)->get();
        
        return view('admin.dashboard.requisition.edit', compact(
            'requisition', 'employees', 'vehicleTypes', 'drivers', 'units', 'departments', 'vehicles'
        ));


    }

    /**
     * Update requisition.
     */
    public function update(Request $request, $id)
{
    try {

        $requisition = Requisition::findOrFail($id);

        // Validation
        $validator = Validator::make($request->all(), [
            'employee_id'           => 'required|exists:employees,id',
            'vehicle_id'            => 'nullable|exists:vehicles,id',
            // 'driver_id'             => 'required|exists:drivers,id',
            'requisition_date'      => 'required|date',
            'from_location'         => 'required|string',
            'to_location'           => 'required|string',
            'travel_date'           => 'required|date',
            'number_of_passenger'   => 'required|integer|min:1',
            'purpose'               => 'required|string',
            // 'status'                => 'required|string',

            'passengers'            => 'sometimes|array',
            'passengers.*.employee_id' => 'required|exists:employees,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'validation_error',
                'errors' => $validator->errors()
            ], 422);
        }

        // -------------------------------
        // 🔵 Update each field manually
        // -------------------------------
        $requisition->requested_by        = $request->employee_id;
        $requisition->department_id       = $request->department_id;
        $requisition->unit_id             = $request->unit_id;
        $requisition->vehicle_id          = $request->vehicle_id ?? null;
        $requisition->driver_id           = $request->driver_id;
        $requisition->requisition_date    = $request->requisition_date;
        $requisition->from_location       = $request->from_location;
        $requisition->to_location         = $request->to_location;
        $requisition->travel_date         = $request->travel_date;
        $requisition->number_of_passenger = $request->number_of_passenger;
        $requisition->purpose             = $request->purpose;
        $requisition->status              = 'Pending';
        $requisition->created_by          = auth()->id() ?? 1;
        // Do not update the requisition number
        $requisition->save();

        // -------------------------------
        // 🔵 Update Passengers
        // -------------------------------
        if ($request->has('passengers')) {

            // Remove old
            $requisition->passengers()->delete();

            // Insert new passengers
            foreach ($request->passengers as $passengerData) {
                $requisition->passengers()->create([
                    'employee_id' => $passengerData['employee_id'],
                     'created_by'  => auth()->id() ?? 1, // fallback for testing
                ]);
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Requisition updated successfully!',
            'redirect_url' => route('requisitions.index')
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status'  => 'error',
            'message' => 'Error updating requisition: ' . $e->getMessage()
        ], 500);
    }
}


    /**
     * Delete requisition.
     */
    public function destroy($id)
    {
        $requisition = Requisition::findOrFail($id);
        $requisition->delete();

        return redirect()->route('requisitions.index')
                         ->with('success', 'Requisition deleted successfully!');
    }
 public function getEmployeeDetails($id)
    {
        $emp = Employee::find($id);

        if (!$emp) {
            return response()->json(['status' => 'error', 'message' => 'Employee not found']);
        }

        return response()->json([
            'status' => 'success',
            'employee' => [
                'department' => $emp->department_name,
                'unit'       => $emp->unit_name,
                'designation'=> $emp->designation,
            ]
        ]);
    }


public function updateWorkflow(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:1,2,3,4,5',
        'remarks' => 'nullable|string|max:1000',
    ]);

    $requisition = Requisition::findOrFail($id);

    // Role-based allowed transitions (example)
    $user = Auth::user();
    $newStatus = (int)$request->status;
    $oldStatus = (int)$requisition->status;

    // Example policy:
    // - employee cannot change status (except create)
    // - transport can move Requested(1) -> TransportReview(2) OR TransportReview(2) -> Pending/Approved? customize
    // - admin can Approve(3) or Reject(4) or Complete(5)
    if ($user->role === 'employee') {
        abort(403, 'Access Denied');
    }

    if ($user->role === 'transport') {
        // allow only transitions to 2 (review) or to 5 (completed) depending on your rules
        $allowed = [2];
        if (!in_array($newStatus, $allowed)) {
            abort(403, 'Transport role not allowed to set this status.');
        }
    }

    if ($user->role === 'admin') {
        // admin allowed any
    }

    // Update
    $requisition->update([
        'status' => $newStatus,
        'updated_by' => $user->id,
    ]);

    // Log
    WorkflowLog::create([
        'requisition_id' => $requisition->id,
        'changed_by' => $user->id,
        'old_status' => $oldStatus,
        'new_status' => $newStatus,
        'remarks' => $request->remarks,
    ]);

    // Dispatch event for email
    event(new RequisitionStatusChanged($requisition, $oldStatus, $newStatus, $request->remarks));

    return back()->with('success', 'Workflow updated.');
}
public function updateStatus(Request $request, $id)
{
    // $req = Requisition::findOrFail($id);
    // $req->update([
    //     'status' => $request->status,
    //     'updated_by' => auth()->id()
    // ]);

    // return response()->json(['success' => true]);


     $req = Requisition::findOrFail($id);

    $old = $req->status;
    $new = $request->status;

    // Update status
    $req->update([
        'status' => $new
    ]);

    // Insert log
    WorkflowLog::create([
        'requisition_id' => $req->id,
        'changed_by' => auth()->id(),
        'action' => $new == 'Approved' ? 'APPROVED' : 'REJECTED',
        'old_status' => $old,
        'new_status' => $new,
        'remarks' => $request->comment ?? null
    ]);


    // SEND EMAIL TO EMPLOYEE
Mail::to($req->requestedBy->email)
    ->send(new RequisitionStatusChangedMail($req, $newStatus, $request->comment ?? null));

// OPTIONAL: SEND EMAIL TO ADMIN  
Mail::to('admin@company.com')
    ->send(new RequisitionStatusChangedMail($req, $newStatus));

    return response()->json(['success' => true]);
}





public function transportApprove($id)
{
    $req = Requisition::findOrFail($id);

    if ($req->status != 2) {
        return response()->json(['status' => 'error', 'message' => 'Invalid workflow step']);
    }

    $req->status = 4; // Transport Office Approved
    $req->save();

    RequisitionLogHistory::create([
    'requisition_id' => $req->id,
    'user_id' => auth()->id(),
    'action' => 'Transport Approved'
]);


    return response()->json(['status' => 'success']);
}

public function transportReject($id)
{
    $req = Requisition::findOrFail($id);

    if ($req->status != 2) {
        return response()->json(['status' => 'error', 'message' => 'Invalid workflow step']);
    }

    $req->status = 5; // Transport Office Rejected
    $req->save();

    RequisitionLogHistory::create([
    'requisition_id' => $req->id,
    'user_id' => auth()->id(),
    'action' => 'Transport Rejected',
    'note' => $request->note ?? null
]);

    return response()->json(['status' => 'success']);
}


public function adminApprove($id)
{
    $req = Requisition::findOrFail($id);

    if ($req->status != 4) {
        return response()->json(['status' => 'error', 'message' => 'Invalid workflow step']);
    }

    $req->status = 6; // Final Approval
    $req->save();

    RequisitionLogHistory::create([
    'requisition_id' => $req->id,
    'user_id' => auth()->id(),
    'action' => 'Admin Final Approved'
]);

$requisition->update([
        'approved_by_department' => auth()->id(),
        'department_approved_at' => now(),
        'status' => 'Pending Transport Approval'
    ]);

sendNotification(
    $requisition->created_by,
    "Requisition Approved",
    "Your requisition request #{$requisition->id} has been approved.",
    "success",
    route('admin.requisition.show', $requisition->id)
);



    return response()->json(['status' => 'success']);
}

public function adminReject($id)
{
    $req = Requisition::findOrFail($id);

    if ($req->status != 4) {
        return response()->json(['status' => 'error', 'message' => 'Invalid workflow step']);
    }

    $req->status = 7; // Final Rejection
    $req->save();

    RequisitionLogHistory::create([
        'requisition_id' => $req->id,
        'user_id' => auth()->id(),
        'action' => 'Admin Final Rejected',
        'note' => $request->note ?? null
    ]);

     $requisition->update([
        'approved_by_department' => auth()->id(),
        'department_approved_at' => now(),
        'status' => 'Rejected'
    ]);

sendNotification(
    $requisition->created_by,
    "Requisition Rejected",
    "Your requisition request #{$requisition->id} was rejected.",
    "danger",
    route('admin.requisition.show', $requisition->id)
);

    return response()->json(['status' => 'success']);
}




public function downloadPDF($id)
{
    $requisition = Requisition::with([
        'employee',
        'department', 
        'unit',
        'vehicle',
        'driver',
        'passengers.employee.department',
        'passengers.employee.unit',
        'approvedBy',
        'rejectedBy'
    ])->findOrFail($id);

    $pdf = PDF::loadView('admin.dashboard.requisition.pdf', compact('requisition'));
    
    return $pdf->download("requisition-{$requisition->requisition_number}.pdf");
}

  

   



    public function getVehiclesByCapacity(Request $request)
    {
         Validator::make($request->all(), [
            'passenger_count' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'A valid passenger count is required.',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $passengerCount = $request->input('passenger_count');   
            
            // Assuming the 'vehicles' table has a 'capacity' column
             $vehicles = Vehicle::where('capacity', '>=', $passengerCount)
                                 ->where('status', 1)
                                 ->orderBy('capacity', 'asc')
                                 ->get();

            if ($vehicles->isEmpty()) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'No vehicles found for the specified passenger count.'
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'vehicles' => $vehicles
            ]);

        } catch (\Exception $e) {
            \Log::error('Vehicle suggestion error: ' . $e->getMessage());   
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred while fetching vehicle suggestions.'
            ], 500);
        }
    }

    public function getDriversByVehicle($vehicleId)
    {
        // Get the vehicle and find its associated driver via driver_id
        $vehicle = Vehicle::find($vehicleId);
        
        if ($vehicle && $vehicle->driver_id) {
            $drivers = Driver::where('id', $vehicle->driver_id)
                ->where('status', 1)
                ->get();
        } else {
            $drivers = collect();
        }

        return response()->json([
            'status' => 'success',
            'drivers' => $drivers
        ]);
    }

    
    }
