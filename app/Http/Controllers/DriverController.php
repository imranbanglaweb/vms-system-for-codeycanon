<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Department;
use App\Models\Unit;
use App\Models\Employee;
use App\Models\Licnese_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\Facades\DataTables;
class DriverController extends Controller
{
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

    public function store(Request $request)
{  
    
    


    // ✅ Validation
    $validated = $request->validate([
        'unit_id'            => 'required|exists:units,id',
        'department_id'      => 'required|exists:departments,id',
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
            'licenseType:id,type_name'
        ])
        ->select([
            'id',
            'unit_id',
            'department_id',
            'driver_name',
            'license_number',
            'nid',
            'employee_nid',
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

            // Show Driver Photo
            ->addColumn('photo', function($row){
                if ($row->photograph) {
                    $url = asset('uploads/drivers/' . $row->photograph);
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

                $btn  = '<a href="'. e($editUrl) .'" class="btn btn-sm btn-primary me-1">';
                $btn .= '<i class="fa fa-edit"></i></a>';

                $btn .= '<button class="btn btn-sm btn-danger deleteUser" data-did="'. $row->id .'">';
                $btn .= '<i class="fa fa-minus-circle"></i></button>';

                return $btn;
            })

            ->rawColumns(['photo', 'action'])
            ->make(true);
    }
}

    public function getEmployeeInfo(Request $request)
    {
        $employee_code = $request->get('employee_code');
        if (!$employee_code) {
            return response()->json(['error' => 'Missing parameter'], 400);
        }

        $employee = Employee::where('employee_code', $employee_code)->first();
        if (!$employee) {
            // try fallback by employee_code if employee_nid not present
            $employee = Employee::where('employee_code', $employee_code)->first();
        }

        if (!$employee && is_numeric($employee_code)) {
            // last-resort: try by numeric id
            $employee = Employee::find((int)$employee_code);
        }

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
}
