<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\Licnese_type;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class DriverController extends Controller
{
    public function __construct()
    {
        // Check if user is employee - restrict create, edit, delete operations
        $this->middleware(function ($request, $next) {
            if (Auth::check() && Auth::user()->hasRole('employee')) {
                // Allow only index and show for employees
                $allowedRoutes = ['driver.index', 'driver.show', 'driver-list'];
                $currentRoute = $request->route()->getName();
                
                if (!in_array($currentRoute, $allowedRoutes) && !str_contains($currentRoute, 'show') && !str_contains($currentRoute, 'view')) {
                    return redirect()->back()->with('error', 'You do not have permission to perform this action.');
                }
            }
            return $next($request);
        })->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $departments = Department::all();
        $units = Unit::all();
        $employees = Employee::all();
        $drivers = Driver::latest()->get();

    return view('admin.dashboard.driver.index', compact('departments', 'units', 'employees', 'drivers'));
    }

    public function create(Request $request)
    {
          
         $units = Unit::orderBy('id','DESC')->get();
         $departments = Department::orderBy('id','DESC')->get();

         $units = Unit::orderBy('id','DESC')->get();
         $employees = Employee::orderBy('id','DESC')->get();
         // Load license types from table to populate dropdown
         $licenseTypes = Licnese_type::orderBy('type_name')->get();
        return view('admin.dashboard.driver.create',compact('departments','units','employees','licenseTypes'));


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $driver = Driver::with(['unit', 'department', 'licenseType', 'employee'])->findOrFail($id);
        return view('admin.dashboard.driver.show', compact('driver'));
    }

    public function store(Request $request)
{  
    
    


    // ✅ Validation
    $validated = $request->validate([
        'unit_id'            => 'required|exists:units,id',
        'department_id'      => 'required|exists:departments,id',
        'employee_id'        => 'nullable|exists:employees,id',
        // 'employee_nid'       => 'required',
        'driver_name'        => 'required|string|max:255',
        'license_number'     => 'required|string|max:255|unique:drivers,license_number',
        'license_type_id'    => 'nullable|exists:licnese_types,id',
        'license_issue_date' => 'nullable|date',
        'joining_date'       => 'nullable|date',
        'date_of_birth'      => 'nullable|date',
        'nid'                => 'nullable|string|max:50',
        'mobile'             => 'nullable|string|max:20',
        'present_address'    => 'nullable|string|max:500',
        'permanent_address'  => 'nullable|string|max:500',
        'working_time_slot'  => 'nullable|string|max:50',
        'leave_status'       => 'nullable|boolean',
        'photograph'         => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
    ]);

 
    // ✅ Handle File Upload
    if ($request->hasFile('photograph')) {
        $file = $request->file('photograph');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/drivers'), $filename);
        $validated['photograph'] = 'uploads/drivers/'.$filename;
    }

    // ✅ Assign Created By (optional)
    $validated['created_by'] = auth()->id() ?? 1; // Change as needed

    // If a license_type_id was provided, map the readable name into the drivers.license_type column
    if (!empty($validated['license_type_id'])) {
        $lt = Licnese_type::find($validated['license_type_id']);
        if ($lt) {
            $validated['license_type'] = $lt->type_name;
        }
    }

// dd($validated);

// ✅ Save Driver
    $driver = \App\Models\Driver::create($validated);

    // ✅ Return JSON for AJAX
    return response()->json([
        'status'  => 'success',
        'message' => 'Driver added successfully!',
        'driver'  => $driver,
    ]);
}
  // edit view (separate page)
    public function edit($id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return redirect()->route('drivers.index')->with('danger','Driver not found');
        }
        $units = Unit::orderBy('unit_name')->get();
        $departments = Department::orderBy('department_name')->get();
        $licenseTypes = Licnese_type::orderBy('type_name')->get();
        $employees = Employee::orderBy('name')->get();

        return view('admin.dashboard.driver.edit', compact('driver','units','departments','licenseTypes','employees'));
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $validated = $request->validate([
            'unit_id'            => 'required|exists:units,id',
            'department_id'      => 'required|exists:departments,id',
            'employee_id'        => 'nullable|exists:employees,id',
            'driver_name'        => 'required|string|max:255',
            'license_number'     => 'required|string|max:255|unique:drivers,license_number,' . $driver->id,
            'license_type_id'    => 'nullable|exists:licnese_types,id',
            'license_issue_date' => 'nullable|date',
            'joining_date'       => 'nullable|date',
            'date_of_birth'      => 'nullable|date',
            'nid'                => 'nullable|string|max:50',
            'mobile'             => 'nullable|string|max:20',
            'present_address'    => 'nullable|string|max:500',
            'permanent_address'  => 'nullable|string|max:500',
            'working_time_slot'  => 'nullable|string|max:50',
            'leave_status'       => 'nullable|boolean',
            'photograph'         => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        if ($request->hasFile('photograph')) {
            // Delete old photo if exists
            if ($driver->photograph && file_exists(public_path($driver->photograph))) {
                @unlink(public_path($driver->photograph));
            }
            $file = $request->file('photograph');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/drivers'), $filename);
            $validated['photograph'] = 'uploads/drivers/'.$filename;
        }

        $validated['updated_by'] = auth()->id() ?? 1;

        if (!empty($validated['license_type_id'])) {
            $lt = Licnese_type::find($validated['license_type_id']);
            if ($lt) {
                $validated['license_type'] = $lt->type_name;
            }
        }

        $driver->update($validated);

        return response()->json(['status' => 'success', 'message' => 'Driver updated successfully!']);
    }

    public function getEmployeeDetails($id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            return response()->json([
                'driver_name' => $employee->name,
                'mobile' => $employee->phone ?? '',
                'present_address' => $employee->present_address ?? '',
                'permanent_address' => $employee->permanent_address ?? '',
                'nid' => $employee->nid ?? '',
                'joining_date' => (!empty($employee->join_date) && ($employee->join_date instanceof \Carbon\Carbon)) ? $employee->join_date->format('Y-m-d') : ($employee->join_date ?? ''),
                'date_of_birth' => $employee->date_of_birth ?? '',
            ]);
        }
        return response()->json(['error' => 'Not found'], 404);
    }

    /**
     * Return HTML <option> list of departments for a given unit (used by driver create JS)
     */
    public function getDepartmentsByUnit(Request $request)
    {
        $unit_id = $request->get('unit_id');
        if (!$unit_id) {
            return response()->json(['department_list' => []]);
        }

        $departments = Department::where('unit_id', $unit_id)->orderBy('department_name')->get(['id', 'department_name']);

        return response()->json(['department_list' => $departments]);
    }

    /**
     * Return employee info by employee_nid (used by driver create JS)
     */


   public function data()
{
    if (request()->ajax()) {

        $drivers = Driver::with([
            'unit:id,unit_name',
            'department:id,department_name',
            'licenseType:id,type_name',
            'employee:id,employee_code,name'
        ])
        ->select([
            'id',
            'unit_id',
            'department_id',
            'driver_name',
            'license_number',
            'nid',
            'employee_id',
            'license_type_id',       // If this is an ID, rename column to license_type_id
            'license_issue_date',
            'date_of_birth',
            'joining_date',
            'present_address',
            'permanent_address',
            'mobile',
            'working_time_slot',
            'leave_status',
            'photograph'
        ])
        ->latest();

        return DataTables::of($drivers)
            ->addIndexColumn()

            // Show Unit Name
            ->addColumn('unit_name', function($row){
                return $row->unit->unit_name ?? '-';
            })

            // Show Department Name
            ->addColumn('department_name', function($row){
                return $row->department->department_name ?? '-';
            })

            // Show License Type Name
            ->addColumn('license_type_name', function($row){
                return $row->licenseType->type_name ?? '-';
            })

            // Show Employee Code
            ->addColumn('employee_code', function($row){
                return $row->employee->employee_code ?? '-';
            })

            // Show Driver Photo
            ->addColumn('photo', function($row){
                if ($row->photograph) {
                    $url = asset('public/' . $row->photograph);
                    return '<img src="'. $url .'" width="40" height="40" class="rounded-circle" />';
                }
                return '<span class="badge bg-secondary">No Photo</span>';
            })

            // Clean Mobile Field
            ->editColumn('mobile', function($row){
                return $row->mobile ?? '-';
            })

            // Joining Date format
            ->editColumn('joining_date', function($row){
                return $row->joining_date ? date('d M, Y', strtotime($row->joining_date)) : '-';
            })

            // Action buttons
            ->addColumn('action', function($row){
                $editUrl = route('drivers.edit', $row->id);
                $viewUrl = route('drivers.show', $row->id);
                
                // Check if user has driver-manage permission (edit/delete)
                if (auth()->user()->can('driver-manage')) {
                    $btn  = '<a href="'. e($editUrl) .'" class="btn btn-sm btn-primary me-1">';
                    $btn .= '<i class="fa fa-edit"></i></a>';

                    $btn .= '<button class="btn btn-sm btn-danger deleteUser" data-did="'. $row->id .'">';
                    $btn .= '<i class="fa fa-minus-circle"></i></button>';
                } elseif (auth()->user()->can('driver-list-view')) {
                    // User with driver-list-view permission can only view
                    $btn  = '<a href="'. e($viewUrl) .'" class="btn btn-sm btn-info me-1">';
                    $btn .= '<i class="fa fa-eye"></i></a>';
                } else {
                    $btn = '';
                }

                return $btn;
            })

            ->rawColumns(['photo', 'action'])
            ->make(true);
    }
}

    public function getEmployeeInfo(Request $request)
    {
        $id = $request->get('employee_id');
        if (!$id) {
            return response()->json(['error' => 'Missing parameter'], 400);
        }

        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['error' => 'Not found'], 404);
        }

        return response()->json([
            'name' => $employee->name,
            'mobile' => $employee->phone ?? '',
            'present_address' => $employee->present_address ?? '',
            'permanent_address' => $employee->permanent_address ?? '',
            'employee_code' => $employee->employee_code ?? '',
            'joining_date' => (!empty($employee->join_date) && ($employee->join_date instanceof \Carbon\Carbon)) ? $employee->join_date->format('Y-m-d') : ($employee->join_date ?? ''),
            // Employee model may not have date_of_birth; include if present
            'date_of_birth' => $employee->date_of_birth ?? '',
            'nid' => $employee->nid ?? '',
        ]);
    }

    public function getByVehicle($vehicleId)
    {
        // Get the vehicle and find its associated driver via driver_id
        $vehicle = Vehicle::find($vehicleId);
        
        if ($vehicle && $vehicle->driver_id) {
            $drivers = Driver::where('id', $vehicle->driver_id)->get();
        } else {
            $drivers = collect();
        }

        return response()->json([
            'status' => 'success',
            'drivers' => $drivers
        ]);
    }

    /**
     * Get driver by authenticated user
     */
    private function getDriverByUser()
    {
        $user = auth()->user();
        
        // Try to find driver by employee_id linking to employee which links to user
        $employee = \App\Models\Employee::where('email', $user->email)->first();
        
        if ($employee) {
            $driver = Driver::where('employee_id', $employee->id)->first();
            if ($driver) {
                return $driver;
            }
        }
        
        // Try to find driver by mobile number matching user's phone
        $driver = Driver::where('mobile', $user->phone)->first();
        if ($driver) {
            return $driver;
        }
        
        // Try to find driver by name matching user's name
        $driver = Driver::where('driver_name', $user->name)->first();
        if ($driver) {
            return $driver;
        }
        
        return null;
    }

    // ============================================================================
    // DRIVER PORTAL METHODS
    // ============================================================================

    /**
     * Driver Dashboard - shows assigned trips and schedule
     */
    public function driverDashboard()
    {
        $driver = $this->getDriverByUser();
        $todayTrips = collect();
        $upcomingTrips = collect();
        $recentTrips = collect();
        $assignedTrips = collect();
        
        if (!$driver) {
            return view('admin.dashboard.driver.dashboard', compact('driver', 'todayTrips', 'upcomingTrips', 'recentTrips', 'assignedTrips'));
        }
        
        // Get assigned trips for today
        $todayTrips = \App\Models\Requisition::where('driver_id', $driver->id)
            ->whereDate('travel_date', today())
            ->whereIn('transport_status', ['Approved', 'Pending'])
            ->with(['vehicle', 'employee'])
            ->get();
        
        // Upcoming trips
        $upcomingTrips = \App\Models\Requisition::where('driver_id', $driver->id)
            ->whereDate('travel_date', '>', today())
            ->where('transport_status', 'Approved')
            ->with(['vehicle', 'employee'])
            ->orderBy('travel_date', 'asc')
            ->take(5)
            ->get();
        
        // Recent completed trips
        $recentTrips = \App\Models\Requisition::where('driver_id', $driver->id)
            ->where('status', 'Completed')
            ->with(['vehicle', 'employee'])
            ->orderBy('travel_date', 'desc')
            ->take(5)
            ->get();
        
        // Get all assigned trips (for dashboard display)
        $assignedTrips = \App\Models\Requisition::where('driver_id', $driver->id)
            ->whereDate('travel_date', today())
            ->whereIn('transport_status', ['Approved', 'Pending'])
            ->with(['vehicle', 'employee'])
            ->get();
        
        return view('admin.dashboard.driver.dashboard', compact('driver', 'todayTrips', 'upcomingTrips', 'recentTrips', 'assignedTrips'));
    }

    /**
     * Driver Schedule - shows all assigned trips in a calendar/list view
     */
    public function driverSchedule()
    {
        $driver = $this->getDriverByUser();
        $schedules = collect(); // Initialize empty collection
        
        if (!$driver) {
            return view('admin.dashboard.driver.schedule', compact('driver', 'schedules'));
        }
        
        // Get all assigned trips
        $schedules = \App\Models\Requisition::where('driver_id', $driver->id)
            ->whereDate('travel_date', '>=', today())
            ->whereIn('transport_status', ['Approved', 'Pending'])
            ->with(['vehicle', 'employee'])
            ->orderBy('travel_date', 'asc')
            ->get();
        
        return view('admin.dashboard.driver.schedule', compact('driver', 'schedules'));
    }

    /**
     * Driver Trips - list all trips for the driver
     */
    public function driverTrips()
    {
        $driver = $this->getDriverByUser();
        $trips = collect();
        
        if (!$driver) {
            return view('admin.dashboard.driver.trips', compact('driver', 'trips'));
        }
        
        $trips = \App\Models\Requisition::where('driver_id', $driver->id)
            ->with(['vehicle', 'employee'])
            ->orderBy('travel_date', 'desc')
            ->paginate(10);
        
        return view('admin.dashboard.driver.trips', compact('driver', 'trips'));
    }

    /**
     * Driver Trip Status - shows trip status update form
     */
    public function driverTripStatus($id = null)
    {
        $driver = $this->getDriverByUser();
        $activeTrips = collect();
        $trip = null;
        
        if (!$driver) {
            return view('admin.dashboard.driver.trip-status', compact('driver', 'activeTrips', 'trip'));
        }
        
        if ($id) {
            $trip = \App\Models\Requisition::where('id', $id)
                ->where('driver_id', $driver->id)
                ->with(['vehicle', 'employee'])
                ->first();
            
            if (!$trip) {
                return redirect()->route('driver.trip.status')->with('error', 'Trip not found.');
            }
            
            return view('admin.dashboard.driver.trip-status', compact('driver', 'trip'));
        }
        
        // Get pending trips for status update (trips that haven't been started/completed yet)
        $activeTrips = \App\Models\Requisition::where('driver_id', $driver->id)
            ->whereIn('transport_status', ['Approved', 'Pending'])
            ->whereNotIn('status', ['Completed'])
            ->with(['vehicle', 'employee'])
            ->get();
        
        return view('admin.dashboard.driver.trip-status', compact('driver', 'activeTrips'));
    }

    /**
     * Start a trip
     */
    public function startTrip($id)
    {
        $driver = $this->getDriverByUser();
        
        $trip = \App\Models\Requisition::where('id', $id)
            ->where('driver_id', $driver->id)
            ->first();
        
        if (!$trip) {
            return response()->json(['error' => 'Trip not found.'], 404);
        }
        
        $trip->transport_status = 'In Transit';
        $trip->save();
        
        return response()->json(['success' => true, 'message' => 'Trip started successfully.']);
    }

    /**
     * Finish a trip
     */
    public function finishTrip($id)
    {
        $driver = $this->getDriverByUser();
        
        $trip = \App\Models\Requisition::where('id', $id)
            ->where('driver_id', $driver->id)
            ->first();
        
        if (!$trip) {
            return response()->json(['error' => 'Trip not found.'], 404);
        }
        
        $trip->transport_status = 'Trip Completed';
        $trip->save();
        
        return response()->json(['success' => true, 'message' => 'Trip finished successfully.']);
    }

    /**
     * End a trip (final completion)
     */
    public function endTrip($id)
    {
        $driver = $this->getDriverByUser();
        
        $trip = \App\Models\Requisition::where('id', $id)
            ->where('driver_id', $driver->id)
            ->first();
        
        if (!$trip) {
            return response()->json(['error' => 'Trip not found.'], 404);
        }
        
        $trip->status = 'Completed';
        $trip->save();
        
        return response()->json(['success' => true, 'message' => 'Trip ended successfully.']);
    }

    /**
     * Driver Fuel Log - shows fuel consumption log form
     */
    public function driverFuelLog()
    {
        $driver = $this->getDriverByUser();
        $fuelLogs = collect();
        $vehicles = collect();
        
        if (!$driver) {
            return view('admin.dashboard.driver.fuel-log', compact('driver', 'fuelLogs', 'vehicles'));
        }
        
        // Get fuel logs for this driver
        $fuelLogs = \App\Models\FuelLog::where('driver_id', $driver->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get vehicles assigned to driver
        $vehicles = Vehicle::where('driver_id', $driver->id)->get();
        
        return view('admin.dashboard.driver.fuel-log', compact('driver', 'fuelLogs', 'vehicles'));
    }

    /**
     * Store fuel log entry
     */
    public function storeFuelLog(Request $request)
    {
        $driver = $this->getDriverByUser();
        
        if (!$driver) {
            return response()->json(['error' => 'Driver profile not found.'], 404);
        }
        
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'fuel_date' => 'required|date',
            'fuel_quantity' => 'required|numeric|min:0',
            'fuel_cost' => 'required|numeric|min:0',
            'fuel_station' => 'nullable|string|max:255',
            'odometer_reading' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:500',
        ]);
        
        $validated['driver_id'] = $driver->id;
        $validated['created_by'] = auth()->id();
        
        \App\Models\FuelLog::create($validated);
        
        return response()->json(['success' => true, 'message' => 'Fuel log added successfully.']);
    }

    /**
     * Driver Availability - update availability status
     */
    public function driverAvailability()
    {
        $driver = $this->getDriverByUser();
        
        if (!$driver) {
            return view('admin.dashboard.driver.availability', compact('driver'));
        }
        
        return view('admin.dashboard.driver.availability', compact('driver'));
    }

    /**
     * Update driver availability
     */
    public function updateAvailability(Request $request)
    {
        $driver = $this->getDriverByUser();
        
        if (!$driver) {
            return response()->json(['error' => 'Driver profile not found.'], 404);
        }
        
        $validated = $request->validate([
            'availability_status' => 'required|in:available,on_leave,unavailable',
            'availability_notes' => 'nullable|string|max:500',
            'available_from' => 'nullable|date|required_if:availability_status,on_leave',
            'available_until' => 'nullable|date|required_if:availability_status,on_leave',
        ]);
        
        $driver->availability_status = $validated['availability_status'];
        $driver->availability_notes = $validated['availability_notes'] ?? null;
        $driver->available_from = $validated['available_from'] ?? null;
        $driver->available_until = $validated['available_until'] ?? null;
        $driver->save();
        
        return response()->json(['success' => true, 'message' => 'Availability updated successfully.']);
    }

    /**
     * Driver Vehicle - show assigned vehicle details
     */
    public function driverVehicle()
    {
        $driver = $this->getDriverByUser();
        $vehicle = null;
        $maintenanceRecords = collect();
        
        if (!$driver) {
            return view('admin.dashboard.driver.vehicle', compact('driver', 'vehicle', 'maintenanceRecords'));
        }
        
        // Get assigned vehicle
        $vehicle = Vehicle::where('driver_id', $driver->id)->first();
        
        // Get recent maintenance records for the vehicle
        $maintenanceRecords = \App\Models\MaintenanceRequisition::where('vehicle_id', $vehicle->id ?? 0)
            ->where('status', 'Approved')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.dashboard.driver.vehicle', compact('driver', 'vehicle', 'maintenanceRecords'));
    }
}
