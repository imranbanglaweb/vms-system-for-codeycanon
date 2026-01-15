<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceType;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
class MaintenanceTypeController extends Controller
{

    
   public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $types = MaintenanceType::latest()->get();
        return view('admin.dashboard.maintenance.types.index', compact('types'));
    } /**
     * DataTable Server Side
     */
    public function data(Request $request)
    {
        $query = MaintenanceType::select(['id', 'name', 'description', 'status', 'created_at']);

        // ----- Global Search -----
        if ($request->search_text) {
            $search = $request->search_text;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()

            // Status Badge Column
            ->addColumn('status_badge', function ($row) {
                $color = $row->status == 1 ? 'success' : 'secondary';
                return '<span class="badge bg-' . $color . '">' . ($row->status ? 'Active' : 'Inactive') . '</span>';
            })

            // Action Buttons
            ->addColumn('action', function ($row) {
                return '
                    <button class="btn btn-sm btn-info editBtn" data-id="' . $row->id . '">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="' . $row->id . '">
                        <i class="fa fa-minus"></i>
                    </button>
                ';
            })

            ->rawColumns(['status_badge', 'action'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $request->validate([
            'mtype_name' => 'required|string|max:255',
        ]);

// dd(Auth::id());
        $maintenanceType = MaintenanceType::create([
            'name' => $request->mtype_name,
            'description' => $request->description,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['status' => 'success', 'message' => 'Maintenance type added successfully.']);
    }

    public function edit(MaintenanceType $maintenanceType)
    {
        return response()->json($maintenanceType);
    }

         public function update(Request $request, MaintenanceType $maintenanceType)
    {
        $request->validate([
            'mtype_name' => 'required|string|max:255|unique:maintenance_types,name,' . $maintenanceType->id,
        ]);

        $maintenanceType->update([
            'name' => $request->mtype_name,
            'description' => $request->description,
            'status' => $request->status,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Maintenance type updated successfully.'
        ]);
    }


    public function destroy(MaintenanceType $maintenanceType)
    {
        $maintenanceType->delete();
        return response()->json(['status' => 'success', 'message' => 'Maintenance type deleted successfully.']);
    }
}
