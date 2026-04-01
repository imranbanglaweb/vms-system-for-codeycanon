@extends('admin.dashboard.master')

@section('title', isset($gpsDevice) ? 'Edit GPS Device' : 'Add GPS Device')

@section('main_content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-microchip mr-2"></i>
                        {{ isset($gpsDevice) ? 'Edit GPS Device' : 'Add New GPS Device' }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.gps-devices.index') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ isset($gpsDevice) ? route('admin.gps-devices.update', $gpsDevice->id) : route('admin.gps-devices.store') }}" method="POST">
                        @csrf
                        @if(isset($gpsDevice))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <!-- Device Information -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="device_name">Device Name <span class="text-danger">*</span></label>
                                    <input type="text" name="device_name" id="device_name" class="form-control" 
                                           value="{{ old('device_name', isset($gpsDevice) ? $gpsDevice->device_name : '') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="device_type">Device Type</label>
                                    <select name="device_type" id="device_type" class="form-control">
                                        <option value="">Select Device Type</option>
                                        @foreach($deviceTypes as $key => $value)
                                            <option value="{{ $key }}" {{ old('device_type', isset($gpsDevice) ? $gpsDevice->device_type : '') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="imei_number">IMEI Number <span class="text-danger">*</span></label>
                                    <input type="text" name="imei_number" id="imei_number" class="form-control" 
                                           value="{{ old('imei_number', isset($gpsDevice) ? $gpsDevice->imei_number : '') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sim_number">SIM Number</label>
                                    <input type="text" name="sim_number" id="sim_number" class="form-control" 
                                           value="{{ old('sim_number', isset($gpsDevice) ? $gpsDevice->sim_number : '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="protocol">Protocol <span class="text-danger">*</span></label>
                                    <select name="protocol" id="protocol" class="form-control" required>
                                        <option value="">Select Protocol</option>
                                        @foreach($protocols as $key => $value)
                                            <option value="{{ $key }}" {{ old('protocol', isset($gpsDevice) ? $gpsDevice->protocol : 'GT06') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="vehicle_id">Assign to Vehicle</label>
                                    <select name="vehicle_id" id="vehicle_id" class="form-control">
                                        <option value="">Select Vehicle</option>
                                        @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id', isset($gpsDevice) ? $gpsDevice->vehicle_id : '') == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->vehicle_name }} ({{ $vehicle->vehicle_number }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="server_host">Server Host (for device to send data)</label>
                                    <input type="text" name="server_host" id="server_host" class="form-control" 
                                           value="{{ old('server_host', isset($gpsDevice) ? $gpsDevice->server_host : '') }}" placeholder="e.g., yourserver.com or IP">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="server_port">Server Port</label>
                                    <input type="number" name="server_port" id="server_port" class="form-control" 
                                           value="{{ old('server_port', isset($gpsDevice) ? $gpsDevice->server_port : '') }}" placeholder="e.g., 8080">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="installation_date">Installation Date</label>
                                    <input type="date" name="installation_date" id="installation_date" class="form-control" 
                                           value="{{ old('installation_date', isset($gpsDevice) ? $gpsDevice->installation_date : '') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_active">Status</label>
                                    <div class="custom-control custom-switch mt-2">
                                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" 
                                               {{ old('is_active', isset($gpsDevice) ? $gpsDevice->is_active : true) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Device is Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', isset($gpsDevice) ? $gpsDevice->notes : '') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Supported Device Protocols Info -->
                        <div class="alert alert-info mt-3">
                            <h5><i class="fas fa-info-circle"></i> Supported GPS Device Protocols</h5>
                            <p class="mb-0">This system supports various GPS device protocols including: GT06 (Concox), TK103/TK104, A8/A9, Syrus, Meiligao, and custom protocols. The device will send location data to the configured server endpoint.</p>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ isset($gpsDevice) ? 'Update Device' : 'Create Device' }}
                            </button>
                            <a href="{{ route('admin.gps-devices.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection