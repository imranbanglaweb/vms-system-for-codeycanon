<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\TripSheet;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TripSheetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:trip-manage');
    }

    /**
     * Display a listing of trip sheets.
     */
    public function index()
    {
        return view('admin.dashboard.approvals.transport.trip_sheets.index');
    }

    /**
     * Get trip sheets data for DataTables.
     */
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
                      $v->where('vehicle_name', 'like', "%$search%")
                        ->orWhere('number_plate', 'like', "%$search%");
                  })
                  ->orWhereHas('driver', function($d) use($search) {
                      $d->where('driver_name', 'like', "%$search%");
                  });
            });
        }

        return datatables()->of($query)
            ->addIndexColumn()
            ->addColumn('vehicle', function ($t) {
                return $t->vehicle 
                    ? $t->vehicle->vehicle_name . ' (' . $t->vehicle->number_plate . ')' 
                    : 'N/A';
            })
            ->addColumn('driver', function ($t) {
                return $t->driver ? $t->driver->driver_name : 'N/A';
            })
            ->addColumn('start_date', function ($t) {
                return $t->formatted_start_date;
            })
            ->addColumn('end_date', function ($t) {
                return $t->formatted_end_date;
            })
            ->addColumn('status', function ($t) {
                return match($t->status) {
                    TripSheet::STATUS_IN_PROGRESS => '<span class="badge bg-warning px-3 py-2">In Progress</span>',
                    TripSheet::STATUS_COMPLETED => '<span class="badge bg-success px-3 py-2">Completed</span>',
                    TripSheet::STATUS_CANCELLED => '<span class="badge bg-danger px-3 py-2">Cancelled</span>',
                    default => '<span class="badge bg-secondary px-3 py-2">Pending</span>',
                };
            })
            ->addColumn('action', function ($t) {
                $view = '<a href="'.route('trip-sheets.show', $t->id).'" 
                            class="btn btn-sm btn-primary me-1" title="View Details">
                            <i class="fa fa-eye"></i>
                        </a>';

                $end = $t->status == TripSheet::STATUS_IN_PROGRESS
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

    /**
     * Display the specified trip sheet.
     */
    public function show($id)
    {
        $trip = TripSheet::with(['requisition', 'vehicle', 'driver', 'requisition.passengers'])
            ->findOrFail($id);
            
        return view('admin.dashboard.approvals.transport.trip_sheets.show', compact('trip'));
    }
    
    /**
     * Show the form for ending a trip.
     */
    public function endTripForm($id)
    {
        $trip = TripSheet::with(['vehicle', 'driver'])->findOrFail($id);

        if ($trip->status !== TripSheet::STATUS_IN_PROGRESS) {
            return redirect()->back()->with('error', 'Only active trips can be ended.');
        }

        return view('admin.dashboard.approvals.transport.trip_sheets.end', compact('trip'));
    }

    /**
     * Save the trip end details.
     */
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
        $trip->trip_end_time  = $request->end_date . ' ' . $request->end_time;
        $trip->closing_meter  = $request->closing_meter;
        $trip->end_location   = $request->end_location;
        $trip->remarks        = $request->remarks;
        $trip->status         = TripSheet::STATUS_COMPLETED;
        
        // Calculate total KM if both values exist
        if ($request->closing_meter && $trip->start_meter) {
            $trip->total_km = $request->closing_meter - $trip->start_meter;
            $trip->end_km = $request->closing_meter;
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

    /**
     * Start a new trip from a requisition.
     */
    public function startTrip($reqId)
    {
        $requisition = Requisition::findOrFail($reqId);

        // Check if vehicle and driver are assigned
        if (!$requisition->assigned_vehicle_id || !$requisition->assigned_driver_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'Vehicle and driver must be assigned before starting the trip.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Check for existing in-progress trip for same requisition
            $existingTrip = TripSheet::where('requisition_id', $requisition->id)
                ->where('status', TripSheet::STATUS_IN_PROGRESS)
                ->first();

            if ($existingTrip) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'An active trip already exists for this requisition.'
                ], 400);
            }

            $trip = TripSheet::create([
                'requisition_id' => $requisition->id,
                'vehicle_id' => $requisition->assigned_vehicle_id,
                'driver_id' => $requisition->assigned_driver_id,
                'trip_start_time' => now(),
                'start_date' => now()->format('Y-m-d'),
                'start_location' => $requisition->pickup_location ?? 'N/A',
                'start_meter' => $requisition->assigned_vehicle->current_meter ?? 0,
                'start_km' => $requisition->assigned_vehicle->current_meter ?? 0,
            ]);

            // Update vehicle and driver status
            $vehicle = Vehicle::find($requisition->assigned_vehicle_id);
            if ($vehicle) {
                $vehicle->availability_status = 'busy';
                $vehicle->current_meter = $trip->start_meter;
                $vehicle->save();
            }

            $driver = Driver::find($requisition->assigned_driver_id);
            if ($driver) {
                $driver->availability_status = 'busy';
                $driver->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Trip started successfully.',
                'trip_id' => $trip->id,
                'trip_number' => $trip->trip_number
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error starting trip: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to start trip. Please try again.'
            ], 500);
        }
    }

    /**
     * Finish a trip (alternative method for API/JSON endpoints).
     */
    public function finishTrip(Request $request, $tripId)
    {
        $request->validate([
            'end_location' => 'required|string|max:255',
            'end_km' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $trip = TripSheet::findOrFail($tripId);

        if ($trip->status !== TripSheet::STATUS_IN_PROGRESS) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only active trips can be completed.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $endKm = $request->end_km ?? $trip->start_km;
            
            $trip->update([
                'trip_end_time' => now(),
                'end_date' => now()->format('Y-m-d'),
                'end_location' => $request->end_location,
                'end_km' => $endKm,
                'total_km' => $endKm - $trip->start_km,
                'closing_meter' => $endKm,
                'remarks' => $request->remarks,
                'status' => TripSheet::STATUS_COMPLETED
            ]);

            // Update vehicle availability
            $vehicle = Vehicle::find($trip->vehicle_id);
            if ($vehicle) {
                $vehicle->availability_status = 'available';
                $vehicle->current_meter = $endKm;
                $vehicle->save();
            }

            // Update driver availability
            $driver = Driver::find($trip->driver_id);
            if ($driver) {
                $driver->availability_status = 'available';
                $driver->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Trip completed successfully.',
                'trip' => $trip->fresh()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error finishing trip: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to complete trip. Please try again.'
            ], 500);
        }
    }

    /**
     * Cancel a trip.
     */
    public function cancelTrip(Request $request, $id)
    {
        $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $trip = TripSheet::findOrFail($id);

        if ($trip->status !== TripSheet::STATUS_IN_PROGRESS) {
            return response()->json([
                'status' => 'error',
                'message' => 'Only active trips can be cancelled.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $trip->status = TripSheet::STATUS_CANCELLED;
            $trip->remarks = $trip->remarks . '\nCancellation Reason: ' . ($request->cancellation_reason ?? 'No reason provided');
            $trip->save();

            // Update vehicle availability
            $vehicle = Vehicle::find($trip->vehicle_id);
            if ($vehicle) {
                $vehicle->availability_status = 'available';
                $vehicle->save();
            }

            // Update driver availability
            $driver = Driver::find($trip->driver_id);
            if ($driver) {
                $driver->availability_status = 'available';
                $driver->save();
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Trip cancelled successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error cancelling trip: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to cancel trip. Please try again.'
            ], 500);
        }
    }

    /**
     * Get trip statistics.
     */
    public function getStatistics()
    {
        $stats = [
            'total_trips' => TripSheet::count(),
            'in_progress' => TripSheet::inProgress()->count(),
            'completed' => TripSheet::completed()->count(),
            'cancelled' => TripSheet::cancelled()->count(),
            'total_km' => TripSheet::completed()->sum('total_km'),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $stats
        ]);
    }
}
