<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TripSheet;
use App\Models\Driver;
use DB;
use PDF;
use Excel;

class DriverPerformanceReportController extends Controller
{
    public function index(Request $request)
    {
        $query = TripSheet::with('driver')
            ->select(
                'driver_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(end_km - start_km) as total_distance'),
                // NOTE: The 'fuel_liter' column does not exist in the 'trip_sheets' table. Using 0 as a placeholder.
                DB::raw('SUM(0) as total_fuel'),
                // NOTE: 'delay_minutes' and 'incident_reported' columns do not exist. Using 0.
                DB::raw('SUM(0) as delayed_trips'),
                DB::raw('SUM(0) as incidents')
            )
            ->groupBy('driver_id');

        // 🔐 RBAC – Manager sees only own department
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        $records = $query->paginate(15);

        return view('admin.dashboard.reports.driver_performance.index', [
            'drivers' => Driver::select('id','driver_name')->get(),
            'records' => $records
        ]);
    }

    public function ajax(Request $request)
    {
        $query = TripSheet::with('driver')
            ->select(
                'driver_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(end_km - start_km) as total_distance'),
                // NOTE: The 'fuel_liter' column does not exist in the 'trip_sheets' table. Using 0 as a placeholder.
                DB::raw('SUM(0) as total_fuel'),
                // NOTE: 'delay_minutes' and 'incident_reported' columns do not exist. Using 0.
                DB::raw('SUM(0) as delayed_trips'),
                DB::raw('SUM(0) as incidents')
            )
            ->groupBy('driver_id');

        // 🔐 RBAC – Manager sees only own department
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        if ($request->driver_id)
            $query->where('driver_id', $request->driver_id);

        if ($request->from_date && $request->to_date)
            $query->whereBetween('start_date', [
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
        $records = TripSheet::with('driver')
            ->select(
                'driver_id',
                DB::raw('COUNT(id) as total_trips'),
                DB::raw('SUM(end_km - start_km) as total_distance'),
                // NOTE: The 'fuel_liter' column does not exist in the 'trip_sheets' table. Using 0 as a placeholder.
                DB::raw('SUM(0) as total_fuel'),
                // NOTE: 'delay_minutes' and 'incident_reported' columns do not exist. Using 0.
                DB::raw('SUM(0) as delayed_trips'),
                DB::raw('SUM(0) as incidents')
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
