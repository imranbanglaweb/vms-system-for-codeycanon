<?php

namespace App\Http\Controllers;

use App\Models\VehicleType;
use Illuminate\Http\Request;
use DataTables;

class VehicleTypeController extends Controller
{
    // LIST + DATATABLE
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = VehicleType::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '
                        <a href="'.route('vehicle-type.edit', $row->id).'" 
                           class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>

                        <button class="btn btn-sm btn-danger deleteBtn" 
                                data-id="'.$row->id.'"><i class="fa fa-trash"></i></button>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.dashboard.vehicletypes.index');
    }

    // LOAD CREATE FORM
    public function create()
    {
        return view('admin.dashboard.vehicletypes.form', [
            'vehicleType' => null,
            'action' => route('vehicle-type.store'),
            'method' => 'POST'
        ]);
    }

    // STORE RECORD (AJAX)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|in:0,1',
        ]);

        VehicleType::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id() ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type created successfully!'
        ]);
    }

    // LOAD EDIT FORM
    public function edit($id)
    {
        $vehicleType = VehicleType::findOrFail($id);

        return view('admin.dashboard.vehicletypes.form', [
            'vehicleType' => $vehicleType,
            'action' => route('vehicle-type.update', $vehicleType->id),
            'method' => 'PUT'
        ]);
    }

    // UPDATE RECORD (AJAX)
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required|in:0,1',
        ]);

        $vehicleType = VehicleType::findOrFail($id);

        $vehicleType->update([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => auth()->id() ?? 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type updated successfully!'
        ]);
    }

    // DELETE
    public function destroy($id)
    {
        VehicleType::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle type deleted successfully'
        ]);
    }
}
