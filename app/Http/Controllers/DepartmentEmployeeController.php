<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Unit;
use App\Models\Location;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class DepartmentEmployeeController extends Controller
{
    /**
     * Display a listing of department employees.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get department ID from logged in user
        $departmentId = $user->department_id;
        
        if (!$departmentId) {
            return response()->json(['error' => 'Department not assigned to user'], 403);
        }

        if ($request->ajax()) {
            $query = Employee::with(['unit', 'department'])
                ->leftJoin('locations', 'employees.location_id', '=', 'locations.id')
                ->select('employees.*', 'locations.location_name as joined_location_name')
                ->where('employees.department_id', $departmentId);

            // Apply filters
            $searchName = $request->get('search_name');
            $unitId = $request->get('unit_id');
            $employeeType = $request->get('employee_type');
            $status = $request->get('status');

            if ($searchName) {
                $query->where(function($q) use ($searchName) {
                    $q->where('employees.name', 'like', '%' . $searchName . '%')
                      ->orWhere('employees.employee_code', 'like', '%' . $searchName . '%');
                });
            }

            if ($unitId) {
                $query->where('employees.unit_id', $unitId);
            }

            if ($employeeType) {
                $query->where('employees.employee_type', $employeeType);
            }

            if ($status) {
                $query->where('employees.status', $status);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('photo', function($row){
                    if($row->photo && file_exists(public_path($row->photo))){
                        return '<img src="'.asset('public/'.$row->photo).'" width="40" height="40" style="border-radius:50%; object-fit:cover;" alt="photo">';
                    }
                    return '<i class="fa fa-user-circle text-muted" style="font-size:40px;"></i>';
                })
                ->addColumn('name', function($row){
                    return $row->name;
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
                ->addColumn('status', function($row){
                    if ($row->status == 'Active') {
                        return '<span class="badge bg-success" style="font-size: 11px;"><i class="fa fa-check-circle me-1"></i>Active</span>';
                    }
                    return '<span class="badge bg-danger" style="font-size: 11px;"><i class="fa fa-times-circle me-1"></i>Inactive</span>';
                })
                ->addColumn('action', function($row){
                    $edit = auth()->user() && auth()->user()->can('employee-edit') ? '<a class="btn btn-primary btn-sm" href="'.route('admin.employees.edit', $row->id).'"> <i class="fa fa-edit"></i></a>' : '';
                    $delete = auth()->user() && auth()->user()->can('employee-delete') ? '<button class="btn btn-danger btn-sm deleteUser" data-eid="'.$row->id.'"><i class="fa fa-minus-circle"></i></button>' : '';
                    return $edit.' '.$delete;
                })
                ->rawColumns(['photo', 'action', 'status', 'name'])
                ->make(true);
        }

        // Non-AJAX: prepare data for blade fallback
        $employees = Employee::with(['unit','department'])
            ->leftJoin('locations', 'employees.location_id', '=', 'locations.id')
            ->select('employees.*', 'locations.location_name as joined_location_name')
            ->where('employees.department_id', $departmentId)
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

        $department = Department::find($departmentId);
        
        return view('admin.dashboard.department_head.employees.index', compact('employee_lists', 'department'));
    }

    /**
     * Show the form for creating a new department employee.
     */
    public function create()
    {
        $user = Auth::user();
        $departmentId = $user->department_id;
        
        if (!$departmentId) {
            return response()->json(['error' => 'Department not assigned to user'], 403);
        }

        $units = Unit::orderBy('unit_name')->get();
        $locations = Location::orderBy('location_name')->get();
        $departments = Department::where('id', $departmentId)->orderBy('department_name')->get();
        
        return view('admin.dashboard.department_head.employees.create', compact('units', 'locations', 'departments'));
    }

    /**
     * Store a newly created department employee in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $departmentId = $user->department_id;
        
        if (!$departmentId) {
            return response()->json(['error' => 'Department not assigned to user'], 403);
        }

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
        
        // Force department_id to user's department
        $validated = $request->validate($rules);
        $validated['department_id'] = $departmentId;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/employees'), $filename);
            $validated['photo'] = 'uploads/employees/'.$filename;
        }

        $employee = Employee::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['message' => 'Employee created', 'employee' => $employee], 201);
        }

        return redirect()->route('admin.employees.department.index')->with('success', 'Employee created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $user = Auth::user();
        $departmentId = $user->department_id;
        
        // Only show employees from user's department
        if ($employee->department_id != $departmentId) {
            return response()->json(['error' => 'Employee not found in your department'], 403);
        }

        return response()->json([
            'id' => $employee->id,
            'name' => $employee->name,
            'email' => $employee->email,
            'department_id' => $employee->department_id,
            'department' => $employee->department ? $employee->department->department_name : null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $user = Auth::user();
        $departmentId = $user->department_id;
        
        // Only allow editing employees from user's department
        if ($employee->department_id != $departmentId) {
            abort(403);
        }

        // Authorization: ensure the user can edit employees
        if (!auth()->user() || !auth()->user()->can('employee-edit')) {
            abort(403);
        }

        $units = Unit::orderBy('unit_name')->get();
        $locations = Location::orderBy('location_name')->get();
        $departments = Department::where('id', $departmentId)->orderBy('department_name')->get();

        return view('admin.dashboard.department_head.employees.edit', [
            'employee_edit' => $employee,
            'units' => $units,
            'locations' => $locations,
            'departments' => $departments,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $user = Auth::user();
        $departmentId = $user->department_id;
        
        // Only allow updating employees from user's department
        if ($employee->department_id != $departmentId) {
            abort(403);
        }

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
        
        // Force department_id to user's department
        $validated['department_id'] = $departmentId;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)).'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/employees'), $filename);
            $validated['photo'] = 'uploads/employees/'.$filename;

            try {
                if ($employee->photo && file_exists(public_path($employee->photo))) {
                    unlink(public_path($employee->photo));
                }
            } catch (\Exception $e) {
                // non-fatal
            }
        }

        $employee->update($validated);

        return redirect()->route('admin.employees.department.index')->with('success', 'Employee updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $user = Auth::user();
        $departmentId = $user->department_id;
        
        // Only allow deleting employees from user's department
        if ($employee->department_id != $departmentId) {
            return response()->json(['error' => 'Employee not found in your department'], 403);
        }

        $employee->delete();
        
        return response()->json(['message' => 'Employee deleted successfully']);
    }
}
