<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Driver;
use DB;
use PDF;
use Excel;

class DriverPerformanceReportController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.reports.driver_performance.index', [
            'drivers' => Driver::select('id','driver_name')->get()
        ]);
    }

    public function ajax(Request $request)
    {
        $query = Trip::with('driver')
            ->select(
                'driver_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(distance_km) as total_distance'),
                DB::raw('SUM(fuel_liter) as total_fuel'),
                DB::raw('SUM(CASE WHEN delay_minutes > 0 THEN 1 ELSE 0 END) as delayed_trips'),
                DB::raw('SUM(CASE WHEN incident_reported = 1 THEN 1 ELSE 0 END) as incidents')
            )
            ->groupBy('driver_id');

        // 🔐 RBAC – Manager sees only own department
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        if ($request->driver_id)
            $query->where('driver_id', $request->driver_id);

        if ($request->from_date && $request->to_date)
            $query->whereBetween('trip_start_date', [
                $request->from_date,
                $request->to_date
            ]);

        $records = $query->paginate(15);

        return view(
            'admin.dashboard.reports.driver_performance.table',
            compact('records')
        )->render();
    }

    public function excel()
    {
        return Excel::download(
            new \App\Exports\DriverPerformanceExport,
            'driver-performance.xlsx'
        );
    }

    public function pdf()
    {
        $records = Trip::with('driver')
            ->select(
                'driver_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(distance_km) as total_distance'),
                DB::raw('SUM(fuel_liter) as total_fuel'),
                DB::raw('SUM(CASE WHEN delay_minutes > 0 THEN 1 ELSE 0 END) as delayed_trips'),
                DB::raw('SUM(CASE WHEN incident_reported = 1 THEN 1 ELSE 0 END) as incidents')
            )
            ->groupBy('driver_id')
            ->get();

        $pdf = PDF::loadView(
            'admin.dashboard.reports.driver_performance.pdf',
            compact('records')
        );

        return $pdf->download('driver-performance-report.pdf');
    }
}
