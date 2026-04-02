<?php

namespace App\Http\Controllers;

use App\Models\GpsDevice;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GpsDeviceController extends Controller
{
    /**
     * Display a listing of GPS devices.
     */
    public function index(Request $request)
    {
        $query = GpsDevice::with(['vehicle', 'latestLocation']);

        if ($request->has('vehicle_id') && $request->vehicle_id) {
            $query->where('vehicle_id', $request->vehicle_id);
        }

        if ($request->has('device_type') && $request->device_type) {
            $query->where('device_type', $request->device_type);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('device_name', 'like', "%{$search}%")
                    ->orWhere('imei_number', 'like', "%{$search}%")
                    ->orWhere('sim_number', 'like', "%{$search}%");
            });
        }

        $devices = $query->orderBy('id', 'desc')->paginate(15);
        $deviceTypes = $this->getDeviceTypes();

        return view('admin.dashboard.gps-device.index', compact('devices', 'deviceTypes'));
    }

    /**
     * Show the form for creating a new GPS device.
     */
    public function create()
    {
        $vehicles = Vehicle::orderBy('vehicle_name')->get();
        $deviceTypes = $this->getDeviceTypes();
        $protocols = $this->getProtocols();

        return view('admin.dashboard.gps-device.create', compact('vehicles', 'deviceTypes', 'protocols'));
    }

    /**
     * Store a newly created GPS device.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_name' => 'required|string|max:255',
            'device_type' => 'nullable|string|max:100',
            'imei_number' => 'required|string|unique:gps_devices,imei_number|max:50',
            'sim_number' => 'nullable|string|max:20',
            'protocol' => 'required|string|max:50',
            'server_host' => 'nullable|string|max:255',
            'server_port' => 'nullable|integer|min:1|max:65535',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'installation_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        GpsDevice::create($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'GPS Device created successfully!',
                'redirect' => route('admin.gps-devices.index')
            ], 200);
        }

        return redirect()->route('admin.gps-devices.index')
            ->with('success', 'GPS Device created successfully!');
    }

    /**
     * Display the specified GPS device.
     */
    public function show(GpsDevice $gpsDevice)
    {
        $gpsDevice->load(['vehicle', 'gpsTracks' => function ($query) {
            $query->latest('recorded_at')->limit(100);
        }]);

        return view('admin.dashboard.gps-device.show', compact('gpsDevice'));
    }

    /**
     * Show the form for editing the GPS device.
     */
    public function edit(GpsDevice $gpsDevice)
    {
        $vehicles = Vehicle::orderBy('vehicle_name')->get();
        $deviceTypes = $this->getDeviceTypes();
        $protocols = $this->getProtocols();

        return view('admin.dashboard.gps-device.edit', compact('gpsDevice', 'vehicles', 'deviceTypes', 'protocols'));
    }

    /**
     * Update the specified GPS device.
     */
    public function update(Request $request, GpsDevice $gpsDevice)
    {
        $validator = Validator::make($request->all(), [
            'device_name' => 'required|string|max:255',
            'device_type' => 'nullable|string|max:100',
            'imei_number' => 'required|string|unique:gps_devices,imei_number,' . $gpsDevice->id . '|max:50',
            'sim_number' => 'nullable|string|max:20',
            'protocol' => 'required|string|max:50',
            'server_host' => 'nullable|string|max:255',
            'server_port' => 'nullable|integer|min:1|max:65535',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'installation_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $gpsDevice->update($request->all());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'GPS Device updated successfully!',
                'redirect' => route('admin.gps-devices.index')
            ], 200);
        }

        return redirect()->route('admin.gps-devices.index')
            ->with('success', 'GPS Device updated successfully!');
    }

    /**
     * Remove the specified GPS device.
     */
    public function destroy(GpsDevice $gpsDevice)
    {
        $gpsDevice->delete();

        return redirect()->route('admin.gps-devices.index')
            ->with('success', 'GPS Device deleted successfully!');
    }

    /**
     * Get list of common GPS device types
     */
    private function getDeviceTypes()
    {
        return [
            // Teltonika
            'Teltonika FMB920' => 'Teltonika FMB920',
            'Teltonika FMB130' => 'Teltonika FMB130',
            'Teltonika FMB140' => 'Teltonika FMB140',
            'Teltonika FMB210' => 'Teltonika FMB210',
            
            // Concox
            'Concox GT06N' => 'Concox GT06N',
            'Concox GT06F' => 'Concox GT06F',
            'Concox JM01' => 'Concox JM01',
            'Concox MBT-1000' => 'Concox MBT-1000',
            
            // SinoTrack
            'SinoTrack ST-901' => 'SinoTrack ST-901',
            'SinoTrack ST-903' => 'SinoTrack ST-903',
            
            // TK (Various)
            'TK103' => 'TK103',
            'TK104' => 'TK104',
            'TK110' => 'TK110',
            'TK200' => 'TK200',
            
            // A/D/L
            'A8' => 'A8',
            'A9' => 'A9',
            'D100' => 'D100',
            'L200' => 'L200',
            
            // Syrus
            'Syrus SY-GT001' => 'Syrus SY-GT001',
            'Syrus SY-DB001' => 'Syrus SY-DB001',
            
            // Others
            'Meiligao VT100' => 'Meiligao VT100',
            'Xexun TK102' => 'Xexun TK102',
            'Mini GPS' => 'Mini GPS',
            'Magnetic GPS' => 'Magnetic GPS',
            'OBD GPS' => 'OBD GPS',
            'Other' => 'Other',
        ];
    }

    /**
     * Get supported protocols
     */
    private function getProtocols()
    {
        return [
            'GT06' => 'GT06 (Concox) - Most common',
            'TK103' => 'TK103/TK104 Protocol',
            'A8' => 'A8/A9 Protocol',
            'Syrus' => 'Syrus Protocol',
            'Meiligao' => 'Meiligao Protocol',
            'Protocol_7' => 'Protocol 7 (Various)',
            'Protocol_8' => 'Protocol 8 (Various)',
            'Protocol_10' => 'Protocol 10 (TK110)',
            'H02' => 'H02 Protocol',
            'Fischer' => 'Fischer Protocol',
            'Walktree' => 'Walktree Protocol',
            'Tellteck' => 'Tellteck Protocol',
            'Custom' => 'Custom Protocol',
        ];
    }

    /**
     * Get devices list for DataTable
     */
    public function data(Request $request)
    {
        $devices = GpsDevice::with(['vehicle', 'latestLocation'])
            ->select('gps_devices.*');

        return datatables()->of($devices)
            ->addColumn('vehicle_name', function ($device) {
                return $device->vehicle ? $device->vehicle->vehicle_name : 'Not Assigned';
            })
            ->addColumn('status', function ($device) {
                if (!$device->is_active) {
                    return '<span class="badge badge-secondary">Inactive</span>';
                }
                if ($device->isOnline()) {
                    return '<span class="badge badge-success">Online</span>';
                }
                return '<span class="badge badge-danger">Offline</span>';
            })
            ->addColumn('last_location', function ($device) {
                if ($device->latestLocation) {
                    return number_format($device->latestLocation->latitude, 6) . ', ' . 
                           number_format($device->latestLocation->longitude, 6);
                }
                return 'No Data';
            })
            ->addColumn('actions', function ($device) {
                return view('admin.dashboard.gps-device.partials.actions', compact('device'))->render();
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    /**
     * Get devices for a specific vehicle
     */
    public function getByVehicle($vehicleId)
    {
        $devices = GpsDevice::where('vehicle_id', $vehicleId)
            ->where('is_active', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $devices
        ]);
    }
}