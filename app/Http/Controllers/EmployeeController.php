<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Unit;
use App\Models\Location;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // If this is an AJAX request from DataTables, return server-side JSON
        if (request()->ajax()) {
            $query = Employee::with(['unit','department'])
                ->leftJoin('locations', 'employees.location_id', '=', 'locations.id')
                ->select('employees.*', 'locations.location_name as joined_location_name');

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    if($row->photo){
                        return '<img src="'.asset('public/'.$row->photo).'" width="40" height="40" style="border-radius:50%; object-fit:cover;" alt="photo">';
                    }
                    return '<i class="fa fa-user-circle text-muted" style="font-size:40px;"></i>';
                })
                ->editColumn('employee_code', function($row){
                    return $row->employee_code ?? $row->id;
                })
                ->addColumn('unit_name', function($row){
                    return optional($row->unit)->unit_name;
                })
                ->addColumn('department_name', function($row){
                    return optional($row->department)->department_name;
                })
                ->addColumn('location_name', function($row){
                    return $row->joined_location_name ?? '';
                })
                ->addColumn('action', function($row){
                    $edit = auth()->user() && auth()->user()->can('employee-edit') ? '<a class="btn btn-primary" href="'.route('employees.edit', $row->id).'"> <i class="fa fa-edit"></i></a>' : '';
                    $delete = auth()->user() && auth()->user()->can('employee-delete') ? '<button class="btn btn-danger deleteUser" data-eid="'.$row->id.'"><i class="fa fa-minus-circle"></i></button>' : '';
                    return $edit.' '.$delete;
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);
        }

        // Non-AJAX: prepare data for blade fallback (so edit/delete buttons are visible when JS is disabled)
        $employees = Employee::with(['unit','department'])
            ->leftJoin('locations', 'employees.location_id', '=', 'locations.id')
            ->select('employees.*', 'locations.location_name as joined_location_name')
            ->orderBy('employees.id','ASC')->get();

        $employee_lists = $employees->map(function($e){
            return (object)[
                'id' => $e->id,
                'emp_id' => $e->id,
                'employee_id' => $e->employee_code ?? $e->id,
                'photo' => $e->photo,
                'employee_name' => $e->name ?? '',
                'unit_name' => optional($e->unit)->unit_name ?? '',
                'department_name' => optional($e->department)->department_name ?? '',
                'location_name' => $e->joined_location_name ?? '',
            ];
        });

        return view('admin.dashboard.employee.index', compact('employee_lists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $units = Unit::orderBy('unit_name')->get();
        $locations = Location::orderBy('location_name')->get();
        return view('admin.dashboard.employee.create', compact('units', 'locations'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'unit_id' => 'required|exists:units,id',
            'company_id' => 'nullable|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'location_id' => 'nullable|exists:locations,id',
            'employee_code' => 'nullable|string|max:50|unique:employees,employee_code',
            'name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:50',
            'employee_type' => 'nullable|in:Permanent,Contract,Intern',
            'designation' => 'nullable|string|max:100',
            'blood_group' => 'nullable|string|max:10',
            'nid' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'join_date' => 'nullable|date',
            'status' => 'required|in:Active,Inactive',
        ];
        try {
            $validated = $request->validate($rules);

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
                $file->move(public_path('uploads/employees'), $filename);
                $validated['photo'] = 'uploads/employees/'.$filename;
            }

            $employee = Employee::create($validated);

            // Return JSON for AJAX, or redirect for normal requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['message' => 'Employee created', 'employee' => $employee], 201);
            }

            return redirect()->route('employees.index')->with('success', 'Employee created successfully');

        } catch (ValidationException $e) {
            // Return JSON with validation errors for AJAX
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->validator->errors(),
                ], 422);
            }

            throw $e; // fallback to default behavior
        }
        // Return JSON for AJAX, or redirect for normal requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Employee created', 'employee' => $employee], 201);
        }

        return redirect()->route('employees.index')->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        // Authorization: ensure the user can edit employees
        if (!auth()->user() || !auth()->user()->can('employee-edit')) {
            abort(403);
        }

        // Load units for the unit select
        $units = Unit::orderBy('unit_name')->get();
        $locations = Location::orderBy('location_name')->get();

        // Load departments for the employee's unit (if any) so the department select can be pre-filled
        $departments = Department::where('unit_id', $employee->unit_id)->orderBy('department_name')->get();

        // Provide the expected variables used by the edit view
        return view('admin.dashboard.employee.edit', [
            'employee_edit' => $employee,
            'units' => $units,
            'locations' => $locations,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        // Authorization: ensure the user can edit employees
        if (!auth()->user() || !auth()->user()->can('employee-edit')) {
            abort(403);
        }

        $rules = [
            'unit_id' => 'required|exists:units,id',
            'company_id' => 'nullable|exists:companies,id',
            'department_id' => 'nullable|exists:departments,id',
            'location_id' => 'nullable|exists:locations,id',
            'employee_code' => 'nullable|string|max:50|unique:employees,employee_code,' . $employee->id,
            'name' => 'required|string|max:191',
            'email' => 'nullable|email|max:191',
            'phone' => 'nullable|string|max:50',
            'employee_type' => 'nullable|in:Permanent,Contract,Intern',
            'designation' => 'nullable|string|max:100',
            'blood_group' => 'nullable|string|max:10',
            'nid' => 'nullable|string|max:50',
            'photo' => 'nullable|image|max:2048',
            'present_address' => 'nullable|string',
            'permanent_address' => 'nullable|string',
            'join_date' => 'nullable|date',
            'status' => 'required|in:Active,Inactive',
        ];

        $validated = $request->validate($rules);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/employees'), $filename);
            $validated['photo'] = 'uploads/employees/'.$filename;

            // Optionally remove old photo if stored in storage
            try {
                if ($employee->photo && file_exists(public_path($employee->photo))) {
                    unlink(public_path($employee->photo));
                }
            } catch (\Exception $e) {
                // non-fatal
            }
        }

        $employee->update($validated);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

        public function getEmployeeDetails($id)
        {
            $employee = Employee::with(['department', 'unit'])->find($id);

            // dd($id);

            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            }

    //         dd([
    //     // 'employee' => $employee,
    //     'department' => $employee->department,
    //     'unit' => $employee->unit,
    // ]);
            return response()->json([
                 'employee' => $employee,
    //     'department' => $employee->depa
                'department' => $employee->department->department_name ?? '',
                'department_id' => $employee->department->id ?? '',
                'unit_id' => $employee->unit->id ?? '',
                'unit' => $employee->unit->unit_name ?? '',
            ]);
        }

            public function details($id)
            {
                $emp = Employee::with(['department','unit'])->findOrFail($id);

                return response()->json([
                    'department' => $emp->department->department_name ?? '',
                    'unit' => $emp->unit->unit_name ?? '',
                    'department_id' => $emp->department_id,
                    'unit_id' => $emp->unit_id,
                ]);
            }



}
