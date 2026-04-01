<?php

namespace App\Http\Controllers;

use App\Models\GpsTrack;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Models\TripSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class GpsTrackingController extends Controller
{
    /**
     * API endpoint for mobile app to send GPS data
     * POST /api/gps/track
     */
    public function storeGpsData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|exists:vehicles,id',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed' => 'nullable|numeric|min:0|max:300',
            'heading' => 'nullable|numeric|min:0|max:360',
            'altitude' => 'nullable|numeric',
            'battery_level' => 'nullable|integer|min:0|max:100',
            'signal_strength' => 'nullable|integer|min:0|max:100',
            'device_id' => 'nullable|string',
            'device_type' => 'nullable|in:Android,iOS',
            'app_version' => 'nullable|string',
            'trip_sheet_id' => 'nullable|exists:trip_sheets,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->all();
        $data['driver_id'] = $request->driver_id ?? ($request->trip_sheet_id ? 
            TripSheet::find($request->trip_sheet_id)?->driver_id : null);
        
        $data['recorded_at'] = now();
        $data['status'] = $request->speed > 0 ? 'moving' : 'active';

        $gpsTrack = GpsTrack::create($data);

        return response()->json([
            'success' => true,
            'message' => 'GPS data recorded successfully',
            'data' => $gpsTrack
        ], 201);
    }

    /**
     * Batch GPS data upload from mobile app
     * POST /api/gps/batch
     */
    public function storeBatchGpsData(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string',
            'locations' => 'required|array|min:1',
            'locations.*.vehicle_id' => 'required|exists:vehicles,id',
            'locations.*.latitude' => 'required|numeric|between:-90,90',
            'locations.*.longitude' => 'required|numeric|between:-180,180',
            'locations.*.speed' => 'nullable|numeric|min:0',
            'locations.*.heading' => 'nullable|numeric|min:0|max:360',
            'locations.*.altitude' => 'nullable|numeric',
            'locations.*.timestamp' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $inserted = 0;
        foreach ($request->locations as $location) {
            GpsTrack::create([
                'vehicle_id' => $location['vehicle_id'],
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
                'speed' => $location['speed'] ?? 0,
                'heading' => $location['heading'] ?? null,
                'altitude' => $location['altitude'] ?? null,
                'device_id' => $request->device_id,
                'status' => ($location['speed'] ?? 0) > 0 ? 'moving' : 'active',
                'recorded_at' => $location['timestamp'],
            ]);
            $inserted++;
        }

        return response()->json([
            'success' => true,
            'message' => "{$inserted} GPS locations recorded successfully"
        ], 201);
    }

    /**
     * Get live tracking data for all vehicles
     * GET /api/gps/live
     */
    public function getLiveTracking(Request $request)
    {
        try {
            // Get all vehicles without global scopes (to see all vehicles)
            $vehicles = Vehicle::withoutGlobalScopes()
                ->with(['driver', 'vehicleType'])
                ->get()
                ->map(function ($vehicle) {
                    $latestTrack = GpsTrack::where('vehicle_id', $vehicle->id)
                        ->latest('recorded_at')
                        ->first();

                    return [
                        'vehicle_id' => $vehicle->id,
                        'vehicle_name' => $vehicle->vehicle_name ?? $vehicle->vehicle_number ?? $vehicle->license_plate ?? 'Unknown Vehicle',
                        'vehicle_number' => $vehicle->vehicle_number ?? $vehicle->license_plate ?? 'N/A',
                        'vehicle_type' => $vehicle->vehicleType?->name,
                        'driver_name' => $vehicle->driver?->name ?? 'Not Assigned',
                        'driver_phone' => $vehicle->driver?->phone,
                        'latitude' => $latestTrack?->latitude ? round($latestTrack->latitude, 6) : null,
                        'longitude' => $latestTrack?->longitude ? round($latestTrack->longitude, 6) : null,
                        'speed' => $latestTrack?->speed ?? 0,
                        'heading' => $latestTrack?->heading ?? 0,
                        'status' => $latestTrack ? ($latestTrack->status ?? 'active') : 'offline',
                        'last_updated' => $latestTrack?->recorded_at?->toIso8601String(),
                        'device_id' => $latestTrack?->device_id,
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $vehicles,
                'count' => $vehicles->count(),
                'timestamp' => now()->toIso8601String()
            ], 200);
        } catch (\Exception $e) {
            \Log::error('GPS Live Tracking Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading GPS data',
                'error' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get single vehicle tracking data
     * GET /api/gps/vehicle/{id}
     */
    public function getVehicleTracking($vehicleId)
    {
        $vehicle = Vehicle::with(['driver', 'vehicleType'])->findOrFail($vehicleId);
        
        $latestTrack = GpsTrack::where('vehicle_id', $vehicleId)
            ->latest('recorded_at')
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'vehicle' => $vehicle,
                'current_location' => [
                    'latitude' => $latestTrack?->latitude,
                    'longitude' => $latestTrack?->longitude,
                    'speed' => $latestTrack?->speed,
                    'heading' => $latestTrack?->heading,
                    'altitude' => $latestTrack?->altitude,
                    'status' => $latestTrack?->status ?? 'offline',
                    'recorded_at' => $latestTrack?->recorded_at,
                ],
            ]
        ]);
    }

    /**
     * Get vehicle tracking history
     * GET /api/gps/history/{vehicleId}
     */
    public function getTrackingHistory(Request $request, $vehicleId)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'trip_sheet_id' => 'nullable|exists:trip_sheets,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $query = GpsTrack::where('vehicle_id', $vehicleId)
            ->whereBetween('recorded_at', [$request->start_date, $request->end_date])
            ->orderBy('recorded_at');

        if ($request->trip_sheet_id) {
            $query->where('trip_sheet_id', $request->trip_sheet_id);
        }

        $tracks = $query->get();

        return response()->json([
            'success' => true,
            'data' => [
                'vehicle_id' => $vehicleId,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'total_points' => $tracks->count(),
                'path' => $tracks->map(function ($track) {
                    return [
                        'latitude' => $track->latitude,
                        'longitude' => $track->longitude,
                        'speed' => $track->speed,
                        'heading' => $track->heading,
                        'recorded_at' => $track->recorded_at,
                    ];
                }),
            ]
        ]);
    }

    /**
     * Get active trips with live tracking
     * GET /api/gps/active-trips
     */
    public function getActiveTrips()
    {
        $activeTrips = TripSheet::whereIn('status', ['In Progress', 'On Trip'])
            ->with(['vehicle', 'driver', 'requisition'])
            ->get()
            ->map(function ($trip) {
                $latestTrack = GpsTrack::where('trip_sheet_id', $trip->id)
                    ->latest('recorded_at')
                    ->first();

                return [
                    'trip_id' => $trip->id,
                    'trip_number' => $trip->trip_number,
                    'vehicle' => [
                        'id' => $trip->vehicle?->id,
                        'name' => $trip->vehicle?->name,
                        'number' => $trip->vehicle?->vehicle_number,
                    ],
                    'driver' => [
                        'id' => $trip->driver?->id,
                        'name' => $trip->driver?->name,
                        'phone' => $trip->driver?->phone,
                    ],
                    'current_location' => $latestTrack ? [
                        'latitude' => $latestTrack->latitude,
                        'longitude' => $latestTrack->longitude,
                        'speed' => $latestTrack->speed,
                        'heading' => $latestTrack->heading,
                        'recorded_at' => $latestTrack->recorded_at,
                    ] : null,
                    'start_time' => $trip->start_date,
                    'status' => $trip->status,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $activeTrips,
            'timestamp' => now()
        ]);
    }

    /**
     * Admin: View live tracking page
     * GET /admin/gps-tracking
     */
    public function index()
    {
        $vehicles = Vehicle::with(['driver', 'vehicleType'])
            ->orderBy('vehicle_name')
            ->get();

        return view('admin.dashboard.gps-tracking.index', compact('vehicles'));
    }

    /**
     * Admin: View single vehicle tracking
     * GET /admin/gps-tracking/vehicle/{id}
     */
    public function showVehicle($id)
    {
        $vehicle = Vehicle::with(['driver', 'vehicleType'])->findOrFail($id);
        
        $latestTrack = GpsTrack::where('vehicle_id', $id)
            ->latest('recorded_at')
            ->first();

        $todayPath = GpsTrack::where('vehicle_id', $id)
            ->whereDate('recorded_at', Carbon::today())
            ->orderBy('recorded_at')
            ->get(['latitude', 'longitude', 'speed', 'recorded_at']);

        return view('admin.dashboard.gps-tracking.show', compact('vehicle', 'latestTrack', 'todayPath'));
    }

    /**
     * Admin: View trip tracking history
     * GET /admin/gps-tracking/trip/{tripId}
     */
    public function showTrip($tripId)
    {
        $trip = TripSheet::with(['vehicle', 'driver', 'requisition'])->findOrFail($tripId);
        
        $tracks = GpsTrack::where('trip_sheet_id', $tripId)
            ->orderBy('recorded_at')
            ->get();

        return view('admin.dashboard.gps-tracking.trip', compact('trip', 'tracks'));
    }

    /**
     * API: Device registration for tracking
     * POST /api/gps/device/register
     */
    public function registerDevice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|string|unique:gps_tracks,device_id',
            'device_type' => 'required|in:Android,iOS',
            'app_version' => 'nullable|string',
            'driver_id' => 'nullable|exists:drivers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Device registration failed',
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Device registered successfully',
            'data' => [
                'device_id' => $request->device_id,
                'registered_at' => now(),
            ]
        ]);
    }

    /**
     * Get GPS settings/status
     * GET /api/gps/status
     */
    public function getStatus()
    {
        $totalTracks = GpsTrack::count();
        $todayTracks = GpsTrack::whereDate('recorded_at', Carbon::today())->count();
        $activeVehicles = GpsTrack::where('recorded_at', '>', Carbon::now()->subMinutes(30))
            ->distinct('vehicle_id')
            ->count('vehicle_id');
        $movingVehicles = GpsTrack::where('status', 'moving')
            ->where('recorded_at', '>', Carbon::now()->subMinutes(5))
            ->distinct('vehicle_id')
            ->count('vehicle_id');

        return response()->json([
            'success' => true,
            'data' => [
                'total_tracks' => $totalTracks,
                'today_tracks' => $todayTracks,
                'active_vehicles' => $activeVehicles,
                'moving_vehicles' => $movingVehicles,
                'last_updated' => now(),
            ]
        ]);
    }
}