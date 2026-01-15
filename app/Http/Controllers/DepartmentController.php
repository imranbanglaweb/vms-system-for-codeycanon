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
            'department_code' => 'required|string|max:50|unique:departments,department_code,'.$request->id,
            'status' => 'required|in:0,1'
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()], 422);
        }

        if($request->id){
            // Update
            $dept = Department::find($request->id);
            if(!$dept){
                return response()->json(['message'=>'Department not found'], 404);
            }
        } else {
            $dept = new Department();
            $dept->created_by = Auth::id() ?? 1;
        }

        $dept->unit_id = $request->unit_id;
        $dept->department_name = $request->department_name;
        $dept->department_code = $request->department_code;
        $dept->department_short_name = $request->department_short_name;
        $dept->location = $request->location;
        $dept->description = $request->description;
        $dept->status = $request->status;
        $dept->updated_by = Auth::id() ?? 1;
        $dept->save();

        $msg = $request->id ? 'Department updated successfully' : 'Department created successfully';
        return response()->json(['message'=>$msg]);
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

    


}
