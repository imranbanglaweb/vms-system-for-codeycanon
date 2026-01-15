<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class VendorController extends Controller
{
    /**
     * Display a listing of vendors.
     */
public function index(Request $request)
    {
       if ($request->ajax()) {
        $data = Vendor::select('id', 'name', 'contact_person', 'contact_number', 'email', 'status');
        return DataTables::of($data)->make(true);
    }

    return view('admin.dashboard.vendor.index');
    }

    /**
     * Show the form for creating a new vendor.
     */
    public function create()
    {
        return view('admin.dashboard.vendor.form');
    }

    /**
     * Store a newly created vendor in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'contact_person'   => 'required|string|max:255',
            'contact_number'   => 'required|string|max:50',
            'email'            => 'nullable|email|max:255',
            'address'          => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:100',
            'country'          => 'nullable|string|max:100',
            'status'           => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        Vendor::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Vendor created successfully!'
        ]);
    }

    /**
     * Show the form for editing the specified vendor.
     */
    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.dashboard.vendor.form', compact('vendor'));
    }

    /**
     * Update the specified vendor in storage.
     */
    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name'             => 'required|string|max:255',
            'contact_person'   => 'required|string|max:255',
            'contact_number'   => 'required|string|max:50',
            'email'            => 'nullable|email|max:255',
            'address'          => 'nullable|string|max:255',
            'city'             => 'nullable|string|max:100',
            'country'          => 'nullable|string|max:100',
            'status'           => 'required|in:Active,Inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $vendor->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Vendor updated successfully!'
        ]);
    }

    /**
     * Remove the specified vendor from storage.
     */
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vendor deleted successfully!'
        ]);
    }
}
