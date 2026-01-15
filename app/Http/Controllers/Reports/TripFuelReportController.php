<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Driver;
use PDF;
use Excel;

class TripFuelReportController extends Controller
{
    public function index()
    {
        return view('admin.dashboard.reports.trips_fuel.index', [
            'vehicles' => Vehicle::select('id','vehicle_name')->get(),
            'drivers'  => Driver::select('id','driver_name')->get()
        ]);
    }

    public function ajax(Request $request)
    {
        $query = Trip::with(['vehicle','driver']);

        // 🔐 RBAC filtering
        if (auth()->user()->hasRole('Manager')) {
            $query->where('department_id', auth()->user()->department_id);
        }

        // Filters
        if ($request->vehicle_id)
            $query->where('vehicle_id', $request->vehicle_id);

        if ($request->driver_id)
            $query->where('driver_id', $request->driver_id);

        if ($request->from_date && $request->to_date)
            $query->whereBetween('trip_start_date', [
                $request->from_date,
                $request->to_date
            ]);

        $records = $query->latest()->paginate(15);

        return view('admin.dashboard.reports.trips_fuel.table', compact('records'))->render();
    }

    public function excel()
    {
        return Excel::download(
            new \App\Exports\TripFuelExport,
            'trip-fuel-report.xlsx'
        );
    }

    public function pdf()
    {
        $records = Trip::with(['vehicle','driver'])->get();
        $pdf = PDF::loadView('admin.dashboard.reports.trips_fuel.pdf', compact('records'));
        return $pdf->download('trip-fuel-report.pdf');
    }
}

