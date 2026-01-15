<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaintenanceVendor;
use Illuminate\Support\Facades\Auth;
class MaintenanceVendorController extends Controller
{
    // ---------- List all vendors ----------
    public function index()
    {
        $vendors = MaintenanceVendor::latest()->get();
        return view('admin.dashboard.maintenance.vendors.index', compact('vendors'));
    }

    // ---------- Store new vendor ----------
    public function store(Request $request)
    {
        $request->validate([
            'vendor_name'    => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:500',
        ]);

        $vendor = MaintenanceVendor::create([
            'name'           => $request->vendor_name,
            'contact_person' => $request->contact_person,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
            'created_by'     => Auth::id(),
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Vendor added successfully.',
            'vendor'  => $vendor
        ]);
    }

    // ---------- Get vendor details for edit ----------
    public function edit(MaintenanceVendor $vendor)
    {
        return response()->json([
            'id'             => $vendor->id,
            'vendor_name'    => $vendor->name,
            'contact_person' => $vendor->contact_person,
            'email'          => $vendor->email,
            'phone'          => $vendor->phone,
            'address'        => $vendor->address,
        ]);
    }

    // ---------- Update existing vendor ----------
    public function update(Request $request, MaintenanceVendor $vendor)
    {
        $request->validate([
            'vendor_name'    => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:50',
            'address'        => 'nullable|string|max:500',
        ]);

        $vendor->update([
            'name'           => $request->vendor_name,
            'contact_person' => $request->contact_person,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'address'        => $request->address,
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Vendor updated successfully.',
            'vendor'  => $vendor
        ]);
    }

    // ---------- Delete vendor ----------
    public function destroy(MaintenanceVendor $vendor)
    {
        $vendor->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Vendor deleted successfully.'
        ]);
    }
}
