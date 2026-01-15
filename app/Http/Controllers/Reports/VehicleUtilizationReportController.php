<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Trip;
use DB;
use PDF;
use Excel;

class VehicleUtilizationReportController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.reports.vehicle_utilization.index', [
            'vehicles' => Vehicle::select('id','vehicle_no')->get()
        ]);
    }

    public function ajax(Request $request)
    {
        $query = Trip::with('vehicle')
            ->select(
                'vehicle_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(distance_km) as total_distance'),
                DB::raw('SUM(fuel_liter) as total_fuel')
            )
            ->groupBy('vehicle_id');

        // 🔐 Role-based restriction
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        if ($request->vehicle_id)
            $query->where('vehicle_id', $request->vehicle_id);

        if ($request->from_date && $request->to_date)
            $query->whereBetween('trip_start_date', [
                $request->from_date,
                $request->to_date
            ]);

        $records = $query->paginate(15);

        return view(
            'admin.dashboard.reports.vehicle_utilization.table',
            compact('records')
        )->render();
    }

    public function excel()
    {
        return Excel::download(
            new \App\Exports\VehicleUtilizationExport,
            'vehicle-utilization.xlsx'
        );
    }

    public function pdf()
    {
        $records = Trip::with('vehicle')
            ->select(
                'vehicle_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(distance_km) as total_distance'),
                DB::raw('SUM(fuel_liter) as total_fuel')
            )
            ->groupBy('vehicle_id')
            ->get();

        $pdf = PDF::loadView(
            'admin.dashboard.reports.vehicle_utilization.pdf',
            compact('records')
        );

        return $pdf->download('vehicle-utilization-report.pdf');
    }
}
