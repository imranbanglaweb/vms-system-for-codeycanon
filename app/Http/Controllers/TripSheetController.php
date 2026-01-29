<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\TripSheet;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;

class TripSheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:trip-manage');
    }
    public function index()
    {
        return view('admin.dashboard.approvals.transport.trip_sheets.index');
    }

    public function getData(Request $request)
    {
        $query = TripSheet::with(['requisition', 'vehicle', 'driver'])
            ->orderBy('id', 'desc');

        // Filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereDate('start_date', '>=', $request->date_from)
                  ->whereDate('start_date', '<=', $request->date_to);
        }
        if ($request->filled('search_text')) {
            $search = $request->search_text;
            $query->where(function($q) use($search) {
                $q->where('trip_number', 'like', "%$search%")
                  ->orWhereHas('vehicle', function($v) use($search) {
                      $v->where('vehicle_name', 'like', "%$search%");
                  })
                  ->orWhereHas('driver', function($d) use($search) {
                      $d->where('driver_name', 'like', "%$search%");
                  });
            });
        }

        return datatables()->of($query)
            ->addIndexColumn()

            ->addColumn('vehicle', function ($t) {
                return $t->vehicle ? $t->vehicle->vehicle_name . ' (' . $t->vehicle->number_plate . ')' : 'N/A';
            })

            ->addColumn('driver', function ($t) {
                return $t->driver ? $t->driver->driver_name : 'N/A';
            })

            ->addColumn('start_date', function ($t) {
                return $t->start_date ? date('d M Y', strtotime($t->start_date)) : '-';
            })

            ->addColumn('end_date', function ($t) {
                return $t->end_date ? date('d M Y', strtotime($t->end_date)) : '-';
            })

            ->addColumn('status', function ($t) {
                return match($t->status) {
                    'in_progress' => '<span class="badge bg-warning px-3 py-2">In Progress</span>',
                    'completed'   => '<span class="badge bg-success px-3 py-2">Completed</span>',
                    'cancelled'   => '<span class="badge bg-danger px-3 py-2">Cancelled</span>',
                    default       => '<span class="badge bg-secondary px-3 py-2">Pending</span>',
                };
            })

            ->addColumn('action', function ($t) {
                $view = '<a href="'.route('trip-sheets.show', $t->id).'" 
                            class="btn btn-sm btn-primary me-1" title="View Details">
                            <i class="fa fa-eye"></i>
                        </a>';

                $end = $t->status == 'in_progress'
                    ? '<a href="'.route('trip-sheets.end.form', $t->id).'" 
                            class="btn btn-sm btn-warning" title="End Trip">
                            <i class="fa fa-flag-checkered"></i>
                      </a>'
                    : '';

                return $view . $end;
            })

            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function show($id)
    {
        $trip = TripSheet::with('requisition', 'vehicle', 'driver')->findOrFail($id);
        return view('admin.dashboard.approvals.transport.trip_sheets.show', compact('trip'));
    }
    
    public function endTripForm($id)
    {
        $trip = TripSheet::with(['vehicle', 'driver'])->findOrFail($id);

        if ($trip->status !== 'in_progress') {
            return redirect()->back()->with('error', 'Only active trips can be ended.');
        }

        return view('admin.dashboard.approvals.transport.trip_sheets.end', compact('trip'));
    }

    public function endTripSave(Request $request, $id)
    {
        $request->validate([
            'end_date'        => 'required|date',
            'end_time'        => 'required',
            'closing_meter'   => 'nullable|numeric|min:0',
            'end_location'    => 'required|string|max:255',
            'remarks'         => 'nullable|string',
        ]);

        $trip = TripSheet::findOrFail($id);
        
        // Validate closing meter
        if ($request->closing_meter && $trip->start_meter && $request->closing_meter < $trip->start_meter) {
            return redirect()->back()->with('error', 'Closing meter cannot be less than starting meter.')->withInput();
        }

        // Update Trip
        $trip->end_date       = $request->end_date;
        $trip->trip_end_time  = $request->end_time;
        $trip->closing_meter  = $request->closing_meter;
        $trip->end_location   = $request->end_location;
        $trip->remarks        = $request->remarks;
        $trip->status         = 'completed';
        
        // Calculate total KM if both values exist
        if ($request->closing_meter && $trip->start_meter) {
            $trip->total_km = $request->closing_meter - $trip->start_meter;
        }
        
        $trip->save();

        // Update Vehicle Status
        $vehicle = Vehicle::find($trip->vehicle_id);
        if ($vehicle) {
            $vehicle->availability_status = 'available';
            $vehicle->save();
        }

        // Update Driver Status
        $driver = Driver::find($trip->driver_id);
        if ($driver) {
            $driver->availability_status = 'available';
            $driver->save();
        }

        return redirect()->route('trip-sheets.index')->with('success', 'Trip ended successfully!');
    }

    public function startTrip($reqId)
    {
        $requisition = Requisition::findOrFail($reqId);

        $trip = TripSheet::create([
            'requisition_id' => $requisition->id,
            'vehicle_id' => $requisition->assigned_vehicle_id,
            'driver_id' => $requisition->assigned_driver_id,
            'trip_start_time' => now(),
            'start_location' => $requisition->pickup_location,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Trip started successfully.',
            'trip_id' => $trip->id
        ]);
    }

    public function finishTrip(Request $request, $tripId)
    {
        $trip = TripSheet::findOrFail($tripId);

        $trip->update([
            'trip_end_time' => now(),
            'end_location' => $request->end_location,
            'end_km' => $request->end_km,
            'total_km' => $request->end_km - $trip->start_km,
            'remarks' => $request->remarks,
            'status' => 'finished'
        ]);

        // Update vehicle availability
        Vehicle::find($trip->vehicle_id)->update([
            'availability_status' => 'available'
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Trip completed successfully.'
        ]);
    }
}
