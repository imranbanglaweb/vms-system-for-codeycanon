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
use Illuminate\Support\Facades\DB;

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
        
        // Return JSON for API requests (mobile app)
        if (request()->expectsJson() || request()->is('api/*')) {
            if (!$driver) {
                return response()->json([
                    'driver' => null,
                    'todayTrips' => [],
                    'upcomingTrips' => [],
                    'recentTrips' => [],
                    'assignedTrips' => [],
                    'activeTrip' => null,
                    'pendingTripsCount' => 0,
                    'activeTripsCount' => 0,
                    'completedTripsCount' => 0,
                ]);
            }
            
            $todayTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
                ->whereDate('travel_date', today())
                ->whereIn('transport_status', ['Approved', 'Pending', 'In Transit'])
                ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
                ->get()
                ->map(fn($t) => $this->transformTrip($t));
            
            $upcomingTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
                ->whereDate('travel_date', '>', today())
                ->where('transport_status', 'Approved')
                ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
                ->orderBy('travel_date', 'asc')
                ->take(5)
                ->get()
                ->map(fn($t) => $this->transformTrip($t));
            
            $recentTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
                ->where('status', 'Completed')
                ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
                ->orderBy('travel_date', 'desc')
                ->take(5)
                ->get()
                ->map(fn($t) => $this->transformTrip($t));
            
            $assignedTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
                ->where(function($query) {
                    $query->where(function($q) {
                        $q->whereDate('travel_date', today())
                          ->whereIn('transport_status', ['Approved', 'Pending', 'In Transit']);
                    })->orWhere(function($q) {
                        $q->where('transport_status', 'In Transit');
                    });
                })
                ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
                ->orderBy('travel_date', 'asc')
                ->get()
                ->map(fn($t) => $this->transformTrip($t));
            
            $activeTrip = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
                ->where('transport_status', 'In Transit')
                ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
                ->first();
            
            $pendingTripsCount = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
                ->whereIn('transport_status', ['Pending', 'Approved'])
                ->whereDate('travel_date', '>=', today())
                ->count();
            
            $activeTripsCount = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
                ->where('transport_status', 'In Transit')
                ->count();
            
            $completedTripsCount = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
                ->where('status', 'Completed')
                ->whereDate('travel_date', today())
                ->count();
            
            return response()->json([
                'driver' => $driver ? [
                    'id' => $driver->id,
                    'driverName' => $driver->driver_name,
                    'licenseNumber' => $driver->license_number,
                    'licenseType' => $driver->license_type,
                    'mobile' => $driver->mobile,
                    'availabilityStatus' => $driver->availability_status,
                ] : null,
                'todayTrips' => $todayTrips,
                'upcomingTrips' => $upcomingTrips,
                'recentTrips' => $recentTrips,
                'assignedTrips' => $assignedTrips,
                'activeTrip' => $activeTrip ? $this->transformTrip($activeTrip) : null,
                'pendingTripsCount' => $pendingTripsCount,
                'activeTripsCount' => $activeTripsCount,
                'completedTripsCount' => $completedTripsCount,
            ]);
        }
        
        // Web view response
        $todayTrips = collect();
        $upcomingTrips = collect();
        $recentTrips = collect();
        $assignedTrips = collect();
        $activeTrip = null;
        
        if (!$driver) {
            return view('admin.dashboard.driver.dashboard', compact('driver', 'todayTrips', 'upcomingTrips', 'recentTrips', 'assignedTrips', 'activeTrip'));
        }
        
        // Get all pending trips for the driver (for the stats - all pending, not just today)
        $pendingTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
            ->whereIn('transport_status', ['Pending', 'Approved'])
            ->whereDate('travel_date', '>=', today())
            ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
            ->get();
        
        // Get active/In Transit trip for the driver
        $activeTrip = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
            ->where('transport_status', 'In Transit')
            ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
            ->first();
        
        // Get today's trips (all statuses including In Transit)
        $todayTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
            ->whereDate('travel_date', today())
            ->whereIn('transport_status', ['Approved', 'Pending', 'In Transit'])
            ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
            ->get();
        
        // Upcoming trips
        $upcomingTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
            ->whereDate('travel_date', '>', today())
            ->where('transport_status', 'Approved')
            ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
            ->orderBy('travel_date', 'asc')
            ->take(5)
            ->get();
        
        // Recent completed trips
        $recentTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
            ->where('status', 'Completed')
            ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
            ->orderBy('travel_date', 'desc')
            ->take(5)
            ->get();
        
        // Get all assigned trips - active (In Transit) OR today's pending/approved
        $assignedTrips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
            ->where(function($query) {
                $query->where(function($q) {
                    $q->whereDate('travel_date', today())
                      ->whereIn('transport_status', ['Approved', 'Pending', 'In Transit']);
                })->orWhere(function($q) {
                    $q->where('transport_status', 'In Transit');
                });
            })
            ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
            ->orderBy('travel_date', 'asc')
            ->get();
        
        return view('admin.dashboard.driver.dashboard', compact('driver', 'todayTrips', 'upcomingTrips', 'recentTrips', 'assignedTrips', 'activeTrip'));
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
        $schedules = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
            ->whereDate('travel_date', '>=', today())
            ->whereIn('transport_status', ['Approved', 'Pending'])
            ->with(['vehicle', 'requestedBy', 'assignedVehicle', 'passengers'])
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
       
    //   dd($trips);
        
        if (!$driver) {
            return view('admin.dashboard.driver.trips', compact('driver', 'trips'));
             
        }
        
        $trips = \App\Models\Requisition::where('assigned_driver_id', $driver->id)
            ->with(['vehicle', 'employee', 'requestedBy', 'assignedVehicle', 'passengers'])
            ->orderBy('travel_date', 'desc')
            ->paginate(10);
        //   dd($trips);
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
                ->where(function($query) use ($driver) {
                    $query->where('driver_id', $driver->id)
                          ->orWhere('assigned_driver_id', $driver->id);
                })
                ->with(['vehicle', 'employee'])
                ->first();
            
            if (!$trip) {
                return redirect()->route('driver.trip.status')->with('error', 'Trip not found.');
            }
            
            return view('admin.dashboard.driver.trip-status', compact('driver', 'trip'));
        }
        
        // Get pending/in-progress trips for status update (trips that haven't been completed yet)
        // Include both driver_id and assigned_driver_id for compatibility
        $activeTrips = \App\Models\Requisition::where(function($query) use ($driver) {
                $query->where('driver_id', $driver->id)
                      ->orWhere('assigned_driver_id', $driver->id);
            })
            ->whereIn('transport_status', ['Approved', 'Pending', 'In Transit'])
            ->whereNotIn('status', ['Completed'])
            ->with(['vehicle', 'employee', 'assignedVehicle'])
            ->orderBy('travel_date', 'desc')
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
            ->where(function($query) use ($driver) {
                $query->where('driver_id', $driver->id)
                      ->orWhere('assigned_driver_id', $driver->id);
            })
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
            ->where(function($query) use ($driver) {
                $query->where('driver_id', $driver->id)
                      ->orWhere('assigned_driver_id', $driver->id);
            })
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
            ->where(function($query) use ($driver) {
                $query->where('driver_id', $driver->id)
                      ->orWhere('assigned_driver_id', $driver->id);
            })
            ->first();
        
        if (!$trip) {
            return response()->json(['error' => 'Trip not found.'], 404);
        }
        
        $trip->transport_status = 'Completed';
        $trip->status = 'Completed';
        $trip->save();
        
        return response()->json(['success' => true, 'message' => 'Trip completed successfully!']);
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
     * Get previous fuel data for a vehicle (for auto-calculation)
     */
    public function getVehicleFuelData(Request $request)
    {
        $driver = $this->getDriverByUser();
        $vehicleId = $request->get('vehicle_id');
        
        if (!$driver || !$vehicleId) {
            return response()->json(['data' => null]);
        }
        
        // Get last fuel entry for this vehicle
        $lastEntry = \App\Models\FuelLog::where('vehicle_id', $vehicleId)
            ->orderBy('fuel_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Get entry before last (for mileage calculation)
        $previousEntry = null;
        if ($lastEntry) {
            $previousEntry = \App\Models\FuelLog::where('vehicle_id', $vehicleId)
                ->where('id', '!=', $lastEntry->id)
                ->orderBy('fuel_date', 'desc')
                ->first();
        }
        
        $data = [
            'last_odometer' => $lastEntry ? floatval($lastEntry->odometer_reading) : null,
            'last_fuel_date' => $lastEntry ? $lastEntry->fuel_date->format('Y-m-d') : null,
            'last_quantity' => $lastEntry ? floatval($lastEntry->quantity) : null,
            'last_cost' => $lastEntry ? floatval($lastEntry->cost) : null,
            'last_cost_per_liter' => ($lastEntry && $lastEntry->quantity > 0) 
                ? round($lastEntry->cost / $lastEntry->quantity, 2) 
                : null,
            'distance_traveled' => ($lastEntry && $previousEntry) 
                ? round($lastEntry->odometer_reading - $previousEntry->odometer_reading, 2) 
                : null,
            'mileage' => ($lastEntry && $previousEntry && $lastEntry->quantity > 0)
                ? round(($lastEntry->odometer_reading - $previousEntry->odometer_reading) / $lastEntry->quantity, 2)
                : null,
        ];
        
        return response()->json(['data' => $data]);
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
            'fuel_quantity' => 'required|numeric|min:0|max:500',
            'fuel_cost' => 'required|numeric|min:0',
            'fuel_type' => 'required|string|max:50',
            'fuel_station' => 'required|string|max:255',
            'receipt_image' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'odometer_reading' => 'required|numeric|min:0|max:9999999',
            'notes' => 'nullable|string|max:500',
        ]);
        
        // === SMART VALIDATION ===
        
        // 1. Check odometer (allow if clearly wrong data or new entry)
        $lastEntry = \App\Models\FuelLog::where('vehicle_id', $validated['vehicle_id'])
            ->orderBy('fuel_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->first();
        
        // Skip strict odometer check if previous value is unrealistic (> 500k km)
        if ($lastEntry && floatval($lastEntry->odometer_reading) > 500000) {
            // Previous entry has unrealistic odometer, warn but allow
            $warnings[] = 'Note: Previous odometer (' . $lastEntry->odometer_reading . ' km) seems very high. Verify if correct.';
        } elseif ($lastEntry && floatval($validated['odometer_reading']) < floatval($lastEntry->odometer_reading)) {
            // Allow lower if within 1000km (might be data correction)
            $diff = floatval($lastEntry->odometer_reading) - floatval($validated['odometer_reading']);
            if ($diff > 1000) {
                return response()->json([
                    'error' => 'Odometer reading must be greater than previous entry (' . $lastEntry->odometer_reading . ' km)',
                    'field' => 'odometer_reading'
                ], 422);
            } else {
                $warnings[] = 'Note: Odometer is lower than previous entry by ' . $diff . ' km.';
            }
        }

        // 2. Check for duplicate entry (same date + vehicle)
        $duplicateCheck = \App\Models\FuelLog::where('vehicle_id', $validated['vehicle_id'])
            ->where('fuel_date', $validated['fuel_date'])
            ->first();
        
        if ($duplicateCheck) {
            return response()->json([
                'error' => 'Fuel entry already exists for this vehicle on the selected date',
                'field' => 'fuel_date'
            ], 422);
        }

        // 3. Calculate mileage and warn if unrealistic
        $previousEntry = null;
        $warnings = [];
        if ($lastEntry) {
            $previousEntry = \App\Models\FuelLog::where('vehicle_id', $validated['vehicle_id'])
                ->where('id', '!=', $lastEntry->id)
                ->orderBy('fuel_date', 'desc')
                ->first();
            
            if ($previousEntry && $validated['fuel_quantity'] > 0) {
                $distance = floatval($lastEntry->odometer_reading) - floatval($previousEntry->odometer_reading);
                $mileage = round($distance / $validated['fuel_quantity'], 2);
                
                // Warn if mileage is too low (< 5 km/L) or too high (> 25 km/L)
                if ($mileage < 5) {
                    $warnings[] = 'Warning: Mileage (' . $mileage . ' km/L) is very low. This may indicate fuel theft or leakage.';
                } elseif ($mileage > 25) {
                    $warnings[] = 'Warning: Mileage (' . $mileage . ' km/L) is unusually high. Please verify odometer reading.';
                }
            }
        }
        
        // === FUEL THEFT DETECTION ===
        
        // 4. Too frequent fueling alert (within 24 hours of last entry)
        if ($lastEntry) {
            $hoursSinceLastEntry = now()->diffInHours($lastEntry->created_at);
            if ($hoursSinceLastEntry < 24) {
                $warnings[] = 'Alert: Very recent fueling (' . $hoursSinceLastEntry . ' hours ago). Why refueling so soon?';
            }
        }
        
        // 5. Overfueling alert (more than 100L - unusual for normal driving)
        if (floatval($validated['fuel_quantity']) > 100) {
            $warnings[] = 'Alert: Large fuel quantity (' . $validated['fuel_quantity'] . 'L). Please verify.';
        }
        
        // 6. Odometer anomaly (large jump > 500km since last entry - possible tampering)
        if ($lastEntry) {
            $odometerJump = floatval($validated['odometer_reading']) - floatval($lastEntry->odometer_reading);
            if ($odometerJump > 500) {
                $warnings[] = 'Alert: Large odometer jump (' . $odometerJump . ' km). Please verify the reading.';
            }
        }
        
        // Handle receipt image upload
        $receiptPath = null;
        if ($request->hasFile('receipt_image')) {
            $file = $request->file('receipt_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/fuel-receipts'), $filename);
            $receiptPath = 'uploads/fuel-receipts/' . $filename;
        }
        
        // Map field names to match database columns
        $fuelLogData = [
            'driver_id' => $driver->id,
            'vehicle_id' => $validated['vehicle_id'],
            'fuel_date' => $validated['fuel_date'],
            'fuel_type' => $validated['fuel_type'] ?? 'Petrol',
            'quantity' => $validated['fuel_quantity'],
            'cost' => $validated['fuel_cost'],
            'location' => $validated['fuel_station'] ?? null,
            'receipt_image' => $receiptPath,
            'odometer_reading' => $validated['odometer_reading'],
            'notes' => $validated['notes'] ?? null,
            'created_by' => auth()->id(),
        ];
        
        \App\Models\FuelLog::create($fuelLogData);
        
        return response()->json([
            'success' => true, 
            'message' => 'Fuel log added successfully.',
            'warnings' => $warnings ?? []
        ]);
    }

    /**
     * Fuel History - Admin view all fuel logs
     */
    public function fuelHistory()
    {
        $fuelLogs = \App\Models\FuelLog::with(['driver', 'vehicle'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        $drivers = \App\Models\Driver::where('status', 1)->orderBy('driver_name')->get();
        $vehicles = Vehicle::where('status', 1)->orderBy('vehicle_name')->get();
        
        return view('admin.dashboard.driver.fuel-history', compact('fuelLogs', 'drivers', 'vehicles'));
    }

    /**
     * Fuel Purchase Log - Admin view all fuel purchases
     */
    public function fuelPurchaseLog()
    {
        $fuelLogs = \App\Models\FuelLog::with(['driver', 'vehicle'])
            ->orderBy('fuel_date', 'desc')
            ->paginate(20);
        
        $totalCost = \App\Models\FuelLog::sum('cost');
        $totalLiters = \App\Models\FuelLog::sum('quantity');
        
        return view('admin.dashboard.driver.fuel-purchase-log', compact('fuelLogs', 'totalCost', 'totalLiters'));
    }

    /**
     * Monthly Fuel Summary
     */
    public function fuelMonthlySummary()
    {
        $monthlyData = \App\Models\FuelLog::select(
            DB::raw('MONTH(fuel_date) as month'),
            DB::raw('SUM(quantity) as total_liters'),
            DB::raw('SUM(cost) as total_cost')
        )
        ->groupBy('month')
        ->orderBy('month', 'DESC')
        ->get();
        
        return view('admin.dashboard.driver.fuel-monthly-summary', compact('monthlyData'));
    }

    /**
     * Vehicle Fuel Efficiency
     */
    public function fuelEfficiency()
    {
        $vehicles = Vehicle::where('status', 1)->orderBy('vehicle_name')->get();
        
        return view('admin.dashboard.driver.fuel-efficiency', compact('vehicles'));
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
        
        // JSON response for API
        if (request()->expectsJson() || request()->is('api/*')) {
            if (!$driver) {
                return response()->json(['vehicle' => null]);
            }
            
            $vehicle = Vehicle::where('driver_id', $driver->id)->first();
            
            if (!$vehicle) {
                return response()->json(['vehicle' => null]);
            }
            
            return response()->json([
                'vehicle' => [
                    'id' => $vehicle->id,
                    'vehicle_name' => $vehicle->vehicle_name,
                    'vehicle_number' => $vehicle->vehicle_number,
                    'vehicle_type' => $vehicle->vehicle_type,
                    'brand' => $vehicle->brand,
                    'model' => $vehicle->model,
                    'color' => $vehicle->color,
                    'seating_capacity' => $vehicle->seating_capacity,
                    'status' => $vehicle->status,
                ]
            ]);
        }
        
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

    /**
     * Driver Profile API - returns JSON for mobile app
     */
    public function driverProfile()
    {
        try {
            // Check if user is authenticated
            if (!auth()->check()) {
                return response()->json([
                    'id' => 0,
                    'driver_name' => 'Guest User',
                    'license_number' => null,
                    'license_type' => null,
                    'mobile' => null,
                    'nid' => null,
                    'present_address' => null,
                    'permanent_address' => null,
                    'photograph' => null,
                    'availability_status' => 'available',
                    'availability_notes' => null,
                    'available_from' => null,
                    'available_until' => null,
                ]);
            }
            
            $driver = $this->getDriverByUser();
            
            if (!$driver) {
                // Return from authenticated user
                $user = auth()->user();
                return response()->json([
                    'id' => 0,
                    'driver_name' => $user->name,
                    'license_number' => null,
                    'license_type' => null,
                    'mobile' => $user->cell_phone,
                    'nid' => null,
                    'present_address' => null,
                    'permanent_address' => null,
                    'photograph' => null,
                    'availability_status' => 'available',
                    'availability_notes' => null,
                    'available_from' => null,
                    'available_until' => null,
                ]);
            }
            
            return response()->json([
                'id' => $driver->id,
                'driver_name' => $driver->driver_name,
                'license_number' => $driver->license_number,
                'license_type' => $driver->license_type,
                'mobile' => $driver->mobile,
                'nid' => $driver->nid,
                'present_address' => $driver->present_address,
                'permanent_address' => $driver->permanent_address,
                'photograph' => $driver->photograph,
                'availability_status' => $driver->availability_status,
                'availability_notes' => $driver->availability_notes,
                'available_from' => $driver->available_from,
                'available_until' => $driver->available_until,
            ]);
        } catch (\Exception $e) {
            // Return a valid response even on error
            return response()->json([
                'id' => 0,
                'driver_name' => 'Unknown',
                'license_number' => null,
                'license_type' => null,
                'mobile' => null,
                'nid' => null,
                'present_address' => null,
                'permanent_address' => null,
                'photograph' => null,
                'availability_status' => 'available',
                'availability_notes' => null,
                'available_from' => null,
                'available_until' => null,
            ]);
        }
    }
}
