@extends('admin.dashboard.master')

@section('title', 'GPS Device Management')

@section('main_content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-microchip mr-2"></i>
                        GPS Device Management
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gps-devices.create') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add New Device
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="form-inline">
                        <div class="form-group mr-2">
                            <input type="text" name="search" class="form-control" placeholder="Search by device name, IMEI, SIM..." value="{{ request('search') }}">
                        </div>
                        <div class="form-group mr-2">
                            <select name="vehicle_id" class="form-control">
                                <option value="">All Vehicles</option>
                                @foreach(\App\Models\Vehicle::orderBy('vehicle_name')->get() as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->vehicle_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mr-2">
                            <select name="is_active" class="form-control">
                                <option value="">All Status</option>
                                <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.gps-devices.index') }}" class="btn btn-secondary ml-2">Reset</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body table-responsive">
                    <table id="gpsDevicesTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Device Name</th>
                                <th>Device Type</th>
                                <th>IMEI Number</th>
                                <th>SIM Number</th>
                                <th>Protocol</th>
                                <th>Vehicle</th>
                                <th>Status</th>
                                <th>Last Location</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($devices as $device)
                            <tr>
                                <td>{{ $device->id }}</td>
                                <td>{{ $device->device_name }}</td>
                                <td>{{ $device->device_type ?? 'N/A' }}</td>
                                <td>{{ $device->imei_number }}</td>
                                <td>{{ $device->sim_number ?? 'N/A' }}</td>
                                <td>{{ $device->protocol }}</td>
                                <td>
                                    @if($device->vehicle)
                                        <span class="badge badge-info">{{ $device->vehicle->vehicle_name }}</span>
                                    @else
                                        <span class="badge badge-secondary">Not Assigned</span>
                                    @endif
                                </td>
                                <td>
                                    @if(!$device->is_active)
                                        <span class="badge badge-secondary">Inactive</span>
                                    @elseif($device->isOnline())
                                        <span class="badge badge-success">Online</span>
                                    @else
                                        <span class="badge badge-danger">Offline</span>
                                    @endif
                                </td>
                                <td>
                                    @if($device->latestLocation)
                                        {{ number_format($device->latestLocation->latitude, 4) }}, {{ number_format($device->latestLocation->longitude, 4) }}
                                    @else
                                        No Data
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.gps-devices.show', $device->id) }}" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.gps-devices.edit', $device->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.gps-devices.destroy', $device->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this device?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">No GPS devices found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $devices->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection