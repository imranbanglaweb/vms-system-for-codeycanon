<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Unit;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class DepartmentController extends Controller
{
    

  // Show view
    public function index()
    {
        $units = Unit::all();
        return view('admin.dashboard.department.index', compact('units'));
    }

    // Data for DataTables
    public function data()
    {
        $departments = Department::with('unit')->select('departments.*');

        return datatables()->of($departments)
            ->addColumn('unit_name', function($dept){
                return $dept->unit->unit_name ?? '';
            })
            ->addColumn('action', function($dept){
                $edit = '<button class="btn btn-sm btn-primary editBtn" data-id="'.$dept->id.'"> <i class="fa fa-edit"></i></button>';
                $delete = '<button class="btn btn-sm btn-danger deleteBtn" data-id="'.$dept->id.'"><i class="fa fa-minus-circle"></i></button>';
                return $edit.' '.$delete;
            })
            ->make(true);
    }

    // Store / Update
    public function store(Request $request)
    {
        $rules = [
            'unit_id' => 'required|exists:units,id',
            'department_name' => 'required|string|max:255',
            'department_code' => 'required|string|max:50|unique:departments,department_code',
            'department_short_name' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'head_employee_id' => 'nullable|exists:employees,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = [
            'unit_id' => $request->unit_id,
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
            'department_short_name' => $request->department_short_name,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status,
            'head_employee_id' => $request->head_employee_id,
            'updated_by' => Auth::id() ?? 1,
        ];

        $data['created_by'] = Auth::id() ?? 1;
        Department::create($data);

        return response()->json(['message' => 'Department created successfully']);
    }

    // Update
    public function update(Request $request, $id)
    {
        $rules = [
            'unit_id' => 'required|exists:units,id',
            'department_name' => 'required|string|max:255',
            'department_code' => 'required|string|max:50|unique:departments,department_code,'.$id,
            'department_short_name' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:0,1',
            'head_employee_id' => 'nullable|exists:employees,id',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $department = Department::find($id);
        if (!$department) {
            return response()->json(['message' => 'Department not found'], 404);
        }

        $data = [
            'unit_id' => $request->unit_id,
            'department_name' => $request->department_name,
            'department_code' => $request->department_code,
            'department_short_name' => $request->department_short_name,
            'location' => $request->location,
            'description' => $request->description,
            'status' => $request->status,
            'head_employee_id' => $request->head_employee_id,
            'updated_by' => Auth::id() ?? 1,
        ];

        $department->update($data);

        return response()->json(['message' => 'Department updated successfully']);
    }

    // Edit (return JSON)
    public function edit($id)
    {
        $dept = Department::find($id);
        if(!$dept){
            return response()->json(['message'=>'Department not found'], 404);
        }
        return response()->json($dept);
    }

    // Delete
    public function destroy($id)
    {
        $dept = Department::find($id);
        if(!$dept){
            return response()->json(['message'=>'Department not found'], 404);
        }
        $dept->delete();
        return response()->json(['message'=>'Department deleted successfully']);
    }
    public function unitWiseDepartment(Request $request)
    {
        $unit_id = $request->get('unit_id');
        $departments = [];
        if ($unit_id) {
            $departments = Department::where('unit_id', $unit_id)->orderBy('department_name')->get(['id', 'department_name']);
        }

        // Log for debugging: request and result count
        try {
            Log::info('unitWiseDepartment called', ['unit_id' => $unit_id, 'count' => count($departments)]);
        } catch (\Exception $e) {
            // ignore logging errors
        }

        $department_list = collect($departments)->map(function ($d) {
            return ['id' => $d->id, 'department_name' => $d->department_name];
        });

        return response()->json(['department_list' => $department_list]);
    }

    /**
     * Get department head info (name and email)
     */
    public function getHeadInfo($id)
    {
        $department = Department::with('headEmployee')->find($id);
        
        if (!$department) {
            return response()->json(['success' => false, 'message' => 'Department not found'], 404);
        }
        
        return response()->json([
            'success' => true,
            'head_name' => $department->head_name,
            'head_email' => $department->head_email
        ]);
    }



}
