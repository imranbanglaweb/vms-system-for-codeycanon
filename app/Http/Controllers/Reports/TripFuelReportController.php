<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TripSheet;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Exports\TripFuelReportExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class TripFuelReportController extends Controller
{
    public function index(Request $request)
    {
        $query = TripSheet::with(['vehicle', 'driver']);

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('start_date', [$request->from_date, $request->to_date]);
        }

        // Fetch records to pass to the view to resolve "Undefined variable $records"
        $records = $query->latest()->paginate(10);

        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        return view('admin.dashboard.reports.trips_fuel.index', compact('records', 'vehicles', 'drivers'));
    }

    public function ajax(Request $request)
    {
        $query = TripSheet::with(['vehicle', 'driver']);

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('start_date', [$request->from_date, $request->to_date]);
        }

        $records = $query->latest()->paginate(15);

        return view('admin.dashboard.reports.trips_fuel.table', compact('records'))->render();
    }

    public function excel(Request $request)
    {
        return Excel::download(
            new TripFuelReportExport(
                $request->vehicle_id,
                $request->driver_id,
                $request->from_date,
                $request->to_date
            ),
            'trip-fuel-report-' . date('Y-m-d') . '.xlsx'
        );
    }

    public function pdf(Request $request)
    {
        $query = TripSheet::with(['vehicle', 'driver']);

        if ($request->filled('vehicle_id')) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->filled('driver_id')) {
            $query->where('driver_id', $request->driver_id);
        }

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('start_date', [$request->from_date, $request->to_date]);
        }

        $records = $query->latest()->get();

        $pdf = Pdf::loadView('admin.dashboard.reports.trips_fuel.pdf', compact('records'));

        return $pdf->download('trip-fuel-report-' . date('Y-m-d') . '.pdf');
    }
}