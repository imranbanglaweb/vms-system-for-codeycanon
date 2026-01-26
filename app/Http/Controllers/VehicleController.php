<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Unit;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Notification;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use \DateTime;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportExport;
use App\Exports\ExportLandinventory;
Use \Carbon\Carbon;
Use Redirect;
use App\Models\Department;
use App\Models\Driver;
use App\Models\Vendor;
use App\Models\VehicleType;
use App\Models\RtaOffice;

class VehicleController extends Controller
{
 public function index(Request $request)
{
    // Check if it's an AJAX request for DataTables
     if ($request->ajax()) {
        $vehicles = Vehicle::with(['department', 'driver', 'vehicleType', 'vendor'])->latest();

        return datatables()->of($vehicles)
            ->addIndexColumn() // Adds DT_RowIndex
            ->addColumn('department', function($row){
                return $row->department ? $row->department->department_name : '-';
            })
            ->addColumn('driver', function($row){
                return $row->driver ? $row->driver->driver_name : '-';
            })
            ->addColumn('vehicle_type', function($row){
                return $row->vehicleType ? $row->vehicleType->name : '-';
            })
            ->addColumn('vendor', function($row){
                return $row->vendor ? $row->vendor->name : '-';
            })
            ->addColumn('status', function($row){
                return $row->status == 1 
                    ? '<span class="badge bg-success">Active</span>'
                    : '<span class="badge bg-danger">Inactive</span>';
            })
            ->addColumn('action', function($row){
                $editUrl = route('vehicles.edit', $row->id);

                $deleteBtn = '<button class="btn btn-danger btn-sm deleteVehicleBtn" data-id="'. $row->id .'">
                                <i class="fa fa-trash"></i>
                              </button>';

                $editBtn = '<a href="'. $editUrl .'" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>';

                return $editBtn . ' ' . $deleteBtn;
            })
            ->rawColumns(['status', 'action']) // allow HTML in status and action
            ->make(true);
    }

    // If normal page request
    return view('admin.dashboard.vehicles.index');
}
     protected function dropdownData()
    {
        // Use pluck to get id => name arrays
        $departments  = Department::pluck('department_name', 'id');
        $drivers      = Driver::pluck('driver_name', 'id');
        $vendors      = Vendor::pluck('name', 'id');
        $vehicleTypes = VehicleType::pluck('name', 'id');
        // $rtaOffices   = RtaOffice::pluck('name', 'id');

        // static ownership options
        $ownerships = [
            'Owned' => 'Owned',
            'Rented' => 'Rented',
            'Leased'  => 'Leased',
        ];

        return compact('departments', 'drivers', 'vendors', 'vehicleTypes', 'ownerships');
    }

    public function create()
    {
        //   $departments = Department::pluck('department_name', 'id');
        // $drivers = Driver::pluck('driver_name', 'id');
        // // $vendors = Vendor::pluck('vendor_name', 'id');
        // $vehicleTypes = VehicleType::pluck('name', 'id');
        // // $rtaOffices = RtaOffice::pluck('name', 'id');
        // $ownerships = ['Company' => 'Company', 'Private' => 'Private', 'Leased' => 'Leased'];

        // // return view('admin.vehicles.form', compact(
        // //     'departments', 'drivers', 'vendors', 'vehicleTypes', 'rtaOffices', 'ownerships'
        // // ));
        // return view('admin.dashboard.vehicles.create', compact(
        //     'departments', 'drivers', 'vehicleTypes', 'ownerships'
        // ));


  $data = $this->dropdownData();
        // pass all dropdowns to view
        return view('admin.dashboard.vehicles.form', $data);
        
    }

     public function store(Request $request)
    {
        $request->validate([
            'vehicle_name' => 'required|string|max:100',
            'department_id' => 'required|exists:departments,id',
            'registration_date' => 'required|date',
            'license_plate' => 'required|string|unique:vehicles,license_plate',
            'alert_cell_number' => 'required|string',
            'ownership' => 'required',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'driver_id' => 'required|exists:drivers,id',
            'vendor_id' => 'required|exists:vendors,id',
            'seat_capacity' => 'required|integer|min:1',
        ]);


        $company = auth()->user()->company;
        
        if ($company && $company->subscription && $company->subscription->plan) {
            $limit = $company->subscription->plan->max_vehicles;
            if ($limit && $company->vehicles()->count() >= $limit) {
                abort(403, 'Vehicle limit reached. Upgrade plan.');
            }
        }

        // Auto generate vehicle number
        $last = Vehicle::orderBy('id', 'desc')->first();
        $number = $last ? $last->id + 1 : 1;
        $vehicle_number = 'V-' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $vehicle = Vehicle::create(array_merge($request->all(), [
            'created_by' => Auth::id(),
            'vehicle_number' => $vehicle_number,
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Vehicle created successfully'
        ]);
    }

    // public function edit(Vehicle $vehicle)
    // {
    //     return view('admin.dashboard.vehicles.edit', compact('vehicle'));
    // }
    public function edit(Vehicle $vehicle)
    {
           $ownerships = [
            'Owned' => 'Owned',
            'Rented' => 'Rented',
            'Leased'  => 'Leased',
        ];
        return view('admin.dashboard.vehicles.edit', [
            'vehicle'       => $vehicle,
            'departments'   => Department::pluck('department_name', 'id'),
            'vehicleTypes'  => VehicleType::pluck('name', 'id'),
            'drivers'       => Driver::pluck('driver_name', 'id'),
            'vendors'       => Vendor::pluck('name', 'id'),
            'ownerships'       => $ownerships,
        ]);
    }


    
    public function update(Request $request, Vehicle $vehicle)
        {
            $validated = $request->validate([
                'vehicle_name'        => 'required|string|max:255',
                'department_id'       => 'required|exists:departments,id',
                'registration_date'   => 'required|date',
                'license_plate'       => 'required|string|max:50|unique:vehicles,license_plate,' . $vehicle->id,
                'alert_cell_number'   => 'required|string|max:20',
                'ownership'           => 'required',
                'vehicle_type_id'     => 'required|exists:vehicle_types,id',
                'driver_id'           => 'required|exists:drivers,id',
                'vendor_id'           => 'required|exists:vendors,id',
                'seat_capacity'       => 'required|integer|min:1',
            ]);

            $validated['updated_by'] = Auth::id();

            $vehicle->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Vehicle updated successfully',
            ]);
        }


    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted successfully!');
    }
}
