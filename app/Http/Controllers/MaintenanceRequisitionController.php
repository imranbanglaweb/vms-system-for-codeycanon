<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceRequisition;
use App\Models\Vehicle;
use App\Models\MaintenanceCategory;
use App\Models\Employee;
use App\Models\MaintenanceType;
use App\Models\MaintenanceVendor;
use App\Models\MaintenanceSchedule;
use Illuminate\Support\Facades\Auth;
use App\Models\MaintenanceRequisitionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\InventoryItem; // 👈 ADD THIS MODEL
class MaintenanceRequisitionController extends Controller
{
    
    public function index(Request $request)
    {
        
    if ($request->ajax()) {

        $query = MaintenanceRequisition::with(['vehicle','employee'])
            ->select('maintenance_requisitions.*'); // IMPORTANT FIX

        // Filters
        if ($request->vehicle) {
            $query->whereHas('vehicle', function ($q) use ($request) {
                $q->where('vehicle_no', 'like', "%{$request->vehicle}%");
            });
        }

        if ($request->employee) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->employee}%");
            });
        }

        if ($request->type) {
            $query->where('requisition_type', $request->type);
        }

        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        return DataTables::of($query)
            ->addIndexColumn()

            ->addColumn('vehicle', function($row){
                return $row->vehicle->vehicle_name ?? '-';
            })

            ->addColumn('employee', function($row){
                return $row->employee->name ?? '-';
            })

            ->addColumn('grand_total', function($row){
                return '$' . number_format($row->grand_total ?? 0, 2);
            })

            ->addColumn('status', function($row){
                $color = match($row->status) {
                    'Approved' => 'green',
                    'Rejected' => 'red',
                    default     => 'orange'
                };
                return '<span style="color:'.$color.';font-weight:bold;">'.$row->status.'</span>';
            })

            ->addColumn('actions', function($row){
                return '
                    <a href="'.route("maintenance.show",$row->id).'" class="btn btn-info btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                    <a href="'.route("maintenance.edit",$row->id).'" class="btn btn-warning btn-sm">
                        <i class="fa fa-edit"></i>
                    </a>
                    <button data-id="'.$row->id.'" class="btn btn-danger btn-sm deleteBtn">
                        <i class="fa fa-minus"></i>
                    </button>
                ';
            })

            ->rawColumns(['status','actions'])
            ->make(true);
    }

    return view('admin.dashboard.maintenance.index');
    }

    public function history(Request $request)
    {
        if ($request->ajax()) {
            // Fetch requisitions that are processed (e.g., Approved, Rejected, Completed)
            // Adjust the status array based on your workflow's "final" states
            $query = MaintenanceRequisition::with(['vehicle', 'employee'])
                ->where('status', '!=', 'Pending') 
                ->select('maintenance_requisitions.*');

            if ($request->vehicle) {
                $query->whereHas('vehicle', function ($q) use ($request) {
                    $q->where('vehicle_no', 'like', "%{$request->vehicle}%");
                });
            }

            if ($request->employee) {
                $query->whereHas('employee', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->employee}%");
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('vehicle', function($row){
                    return $row->vehicle->vehicle_name ?? '-';
                })
                ->addColumn('employee', function($row){
                    return $row->employee->name ?? '-';
                })
                ->addColumn('grand_total', function($row){
                    return '$' . number_format($row->total_cost ?? 0, 2);
                })
                ->addColumn('status', function($row){
                    $color = match($row->status) {
                        'Approved' => 'green',
                        'Rejected' => 'red',
                        'Completed' => 'blue',
                        default     => 'gray'
                    };
                    return '<span style="color:'.$color.';font-weight:bold;">'.$row->status.'</span>';
                })
                ->addColumn('actions', function($row){
                    return '<a href="'.route("maintenance.show",$row->id).'" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> View</a>';
                })
                ->rawColumns(['status','actions'])
                ->make(true);
        }
        return view('admin.dashboard.maintenance.history');
    }

    public function create()
    {
                $vehicles = Vehicle::all();
        $types = MaintenanceType::all();
        $employees = Employee::all();
        $categories  = MaintenanceCategory::all();
        $vendors = MaintenanceVendor::get();
        // dd($vendors);
        $schedules = MaintenanceSchedule::all();
         $inventoryItems = InventoryItem::where('stock_qty', '>', 0)->get(); // 👈 ADD THIS
    return view('admin.dashboard.maintenance.create', compact(
        'vehicles',
        'types',
        'vendors',
        'schedules',
        'employees',
        'categories',
        'inventoryItems' // 👈 ADD THIS
    ));
    }

    private function generateRequisitionNo()
    {
        $last = MaintenanceRequisition::latest()->first();
        $number = $last ? intval(substr($last->requisition_no, -6)) + 1 : 1;
        return 'MR-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }

    public function store(Request $request)
    {
        $request->validate([
            'requisition_type' => 'required|string',
            'priority' => 'required|string',
            'employee_id' => 'required|exists:employees,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'maintenance_type_id' => 'required|exists:maintenance_types,id',
            'maintenance_date' => 'required|date',
            'vendor_id' => 'nullable|exists:maintenance_vendors,id',
            'service_title' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.category_id' => 'required|exists:maintenance_categories,id',
            'items.*.item_name' => 'required|string|max:255',
            'items.*.qty' => 'required|numeric|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            // Parent record
            $req = MaintenanceRequisition::create([
                'requisition_no' => $this->generateRequisitionNo(),
                'requisition_type' => $request->requisition_type,
                'priority' => $request->priority,
                'employee_id' => $request->employee_id,
                'vehicle_id' => $request->vehicle_id,
                'maintenance_type_id' => $request->maintenance_type_id,
                'vendor_id' => $request->vendor_id,
                'maintenance_date' => $request->maintenance_date,
                'service_title' => $request->service_title,
                'charge_bear_by' => $request->charge_bear_by,
                'charge_amount' => $request->charge_amount,
                'remarks' => $request->remarks,
                'created_by' => Auth::id(),
            ]);

            $total_parts_cost = 0;

            // Child items
            foreach ($request->items as $row) {
                $total = $row['qty'] * $row['unit_price'];

                MaintenanceRequisitionItem::create([
                    'requisition_id' => $req->id,
                    'category_id' => $row['category_id'],
                    'item_name' => $row['item_name'],
                    'qty' => $row['qty'],
                    'unit_price' => $row['unit_price'],
                    'total_price' => $total,
                    'created_by' => Auth::id(),
                ]);

                $total_parts_cost += $total;
            }

            // Update cost summary
            $req->update([
                'total_parts_cost' => $total_parts_cost,
                'total_cost' => $total_parts_cost + $request->charge_amount
            ]);
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Requisition Created Successfully!',
            'redirect_url' => route('maintenance.index')
        ]);
    }
    // edit function
    public function edit($id)
    {
        $requisition = MaintenanceRequisition::with('items')->findOrFail($id);
        $vehicles = Vehicle::all();
        $types = MaintenanceType::all();
        $employees = Employee::all();
        $categories = MaintenanceCategory::all();
        $vendors = MaintenanceVendor::all();

        return view('admin.dashboard.maintenance.edit', compact('requisition','vehicles','types','employees','categories','vendors'));
    }

    // update function

    public function update(Request $request, $id)
        {
            $requisition = MaintenanceRequisition::with('items')->findOrFail($id);

            $request->validate([
                'requisition_type' => 'required|string',
                'priority' => 'required|string',
                'employee_id' => 'required|exists:employees,id',
                'vehicle_id' => 'required|exists:vehicles,id',
                'maintenance_type_id' => 'required|exists:maintenance_types,id',
                'vendor_id' => 'nullable|exists:maintenance_vendors,id',
                'maintenance_date' => 'required|date',
                'service_title' => 'required|string|max:255',
                'items' => 'sometimes|array',
                'items.*.category_id' => 'required|with:items|exists:maintenance_categories,id',
                'items.*.item_name' => 'required|with:items|string|max:255',
            ]);

            DB::transaction(function () use ($request, $requisition) {
                // Update main requisition
                $requisition->update([
                    'requisition_type' => $request->requisition_type,
                    'priority' => $request->priority,
                    'employee_id' => $request->employee_id,
                    'vehicle_id' => $request->vehicle_id,
                    'maintenance_type_id' => $request->maintenance_type_id,
                    'vendor_id' => $request->vendor_id,
                    'maintenance_date' => $request->maintenance_date,
                    'service_title' => $request->service_title,
                    'charge_bear_by' => $request->charge_bear_by,
                    'charge_amount' => $request->charge_amount,
                    'remarks' => $request->remarks,
                ]);

                $total_parts_cost = 0;

                // Delete old items
                $requisition->items()->delete();

                if ($request->has('items')) {
                    // Insert updated items
                    foreach ($request->items as $row) {
                        $total = ($row['qty'] ?? 0) * ($row['unit_price'] ?? 0);

                        MaintenanceRequisitionItem::create([
                            'requisition_id' => $requisition->id,
                            'category_id' => $row['category_id'],
                            'item_name' => $row['item_name'],
                            'qty' => $row['qty'] ?? 1,
                            'unit_price' => $row['unit_price'] ?? 0,
                            'total_price' => $total,
                            'created_by' => Auth::id(),
                        ]);

                        $total_parts_cost += $total;
                    }
                }

                // Update totals
                $requisition->update([
                    'total_parts_cost' => $total_parts_cost,
                    'total_cost' => $total_parts_cost + $request->charge_amount,
                ]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Requisition updated successfully!',
                'redirect_url' => route('maintenance.index')
            ]);
        }


    // show function
     public function show($id)
        {
            $data = MaintenanceRequisition::with([
                'vehicle',
                'employee',
                'vehicle.vehicleType',  
                'items.category',         // still correct — category model pulls from maintenance_categories table
                'maintenanceType'
            ])->findOrFail($id);

            $categories = MaintenanceCategory::all(); // optional if view needs dropdown

            return view('admin.dashboard.maintenance.show', compact('data','categories'));
        }

        // destroy function
    public function destroy($id)
    {
        // dd($id);
        MaintenanceRequisition::findOrFail($id)->delete();
        return back()->with('success', 'Requisition deleted');
    }
}
