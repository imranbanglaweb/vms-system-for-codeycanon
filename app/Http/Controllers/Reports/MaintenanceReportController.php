<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MaintenanceRequisition;
use App\Models\Vehicle;
use App\Models\MaintenanceType;
use App\Models\MaintenanceVendor;
use PDF;
use Excel;

class MaintenanceReportController extends Controller
{
    public function index()
    {
           $records = MaintenanceRequisition::with(['vehicle','maintenanceType','vendor'])->latest()->paginate(15);
    // dd($records);

        return view('admin.dashboard.reports.maintenance.index', [
            'vehicles' => Vehicle::select('id','vehicle_name','vehicle_number')->get(),
            'types' => MaintenanceType::select('id','name')->get(),
            'vendors' => MaintenanceVendor::select('id','name')->get(),
            'records' => $records
        ]);
        
    }

    public function ajax(Request $request)
{

  
    // 🔹 Start query with all necessary relationships
    $query = MaintenanceRequisition::with(['vehicle','maintenanceType','employee','vendor']);

    // 🔹 Role-based filtering
    if (auth()->user()->hasRole('Manager')) {
        $query->where('department_id', auth()->user()->department_id);
    }

    // 🔹 Filters from request
    if ($request->vehicle_id) {
        $query->where('vehicle_id', $request->vehicle_id);
    }

    if ($request->type_id) {
        $query->where('maintenance_type_id', $request->type_id);
    }

    if ($request->vendor_id) {
        $query->where('vendor_id', $request->vendor_id);
    }

    if ($request->from_date && $request->to_date) {
        $query->whereBetween('maintenance_date', [
            $request->from_date,
            $request->to_date
        ]);
    }

    // 🔹 Debug: log SQL query and bindings
    \Log::info('Maintenance AJAX Query:', [
        'sql' => $query->toSql(),
        'bindings' => $query->getBindings()
    ]);

    // 🔹 Fetch paginated results
    $records = $query->latest()->paginate(15);

    // 🔹 Debug: dump count of records (only for testing)
    // dd($records->count(), $records->toArray());

    // 🔹 Render table view
    return view('admin.dashboard.reports.maintenance.table', compact('records'))->render();
}


    public function excel()
    {
        return Excel::download(
            new \App\Exports\MaintenanceExport,
            'maintenance-report.xlsx'
        );
    }

    public function pdf()
    {
        $records = MaintenanceRequisition::with(['vehicle','maintenanceType'])->get();
        $pdf = PDF::loadView('admin.dashboard.reports.maintenance.pdf', compact('records'));
        return $pdf->download('maintenance-report.pdf');
    }
}
