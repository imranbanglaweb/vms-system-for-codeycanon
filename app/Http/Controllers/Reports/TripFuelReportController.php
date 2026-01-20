<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TripSheet;
use App\Models\Vehicle;
use App\Models\Driver;
use Yajra\DataTables\Facades\DataTables;

class TripFuelReportController extends Controller
{
    public function index(Request $request)
    {
        $query = TripSheet::with(['vehicle', 'driver']);

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('start_date', [$request->date_from, $request->date_to]);
        }

        // Fetch records to pass to the view to resolve "Undefined variable $records"
        $records = $query->latest()->get();

        $vehicles = Vehicle::all();
        $drivers = Driver::all();

        return view('admin.dashboard.reports.trips_fuel.index', compact('records', 'vehicles', 'drivers'));
    }

    public function ajax(Request $request)
    {
        $query = TripSheet::with(['vehicle', 'driver']);

        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('start_date', [$request->date_from, $request->date_to]);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function excel()
    {
        // Implement Excel export logic here
        return redirect()->back()->with('info', 'Excel export not implemented yet.');
    }

    public function pdf()
    {
        // Implement PDF export logic here
        return redirect()->back()->with('info', 'PDF export not implemented yet.');
    }
}