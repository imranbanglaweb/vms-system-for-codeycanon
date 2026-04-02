@extends('admin.dashboard.master')

@section('title', isset($gpsDevice) ? 'Edit GPS Device' : 'Add GPS Device')

@section('main-content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="page-title">
                            <i class="fas fa-microchip mr-2"></i>
                            {{ isset($gpsDevice) ? 'Edit GPS Device' : 'Add New GPS Device' }}
                        </h4>
                        <p class="text-muted">{{ isset($gpsDevice) ? 'Update GPS tracking device configuration' : 'Register a new GPS tracking device' }}</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.gps-devices.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left mr-1"></i> Back to List
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form id="gpsDeviceForm" method="POST" action="{{ isset($gpsDevice) ? route('admin.gps-devices.update', $gpsDevice->id) : route('admin.gps-devices.store') }}">
                        @csrf
                        @if(isset($gpsDevice))
                            @method('PUT')
                        @endif

                        <!-- Device Information Section -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-info-circle mr-2"></i>Device Information
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="device_name">Device Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                            </div>
                                            <input type="text" name="device_name" id="device_name" class="form-control"
                                                   value="{{ old('device_name', isset($gpsDevice) ? $gpsDevice->device_name : '') }}" required>
                                        </div>
                                        <div class="invalid-feedback" id="device_name_error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="device_type">Device Type</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-microchip"></i></span>
                                            </div>
                                            <select name="device_type" id="device_type" class="form-control select2">
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
                            </div>
                        </div>

                        <!-- Connection Details Section -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-link mr-2"></i>Connection Details
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="imei_number">IMEI Number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                            </div>
                                            <input type="text" name="imei_number" id="imei_number" class="form-control"
                                                   value="{{ old('imei_number', isset($gpsDevice) ? $gpsDevice->imei_number : '') }}" required>
                                        </div>
                                        <div class="invalid-feedback" id="imei_number_error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="sim_number">SIM Number</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-sim-card"></i></span>
                                            </div>
                                            <input type="text" name="sim_number" id="sim_number" class="form-control"
                                                   value="{{ old('sim_number', isset($gpsDevice) ? $gpsDevice->sim_number : '') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="protocol">Protocol <span class="text-danger">*</span></label>
                                        <select name="protocol" id="protocol" class="form-control select2" required>
                                            <option value="">Select Communication Protocol</option>
                                            @foreach($protocols as $key => $value)
                                                <option value="{{ $key }}" {{ old('protocol', isset($gpsDevice) ? $gpsDevice->protocol : 'GT06') == $key ? 'selected' : '' }}>
                                                    {{ $value }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback" id="protocol_error"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Server Configuration Section -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-server mr-2"></i>Server Configuration
                            </h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="server_host">Server Host / IP Address</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                            </div>
                                            <input type="text" name="server_host" id="server_host" class="form-control"
                                                   value="{{ old('server_host', isset($gpsDevice) ? $gpsDevice->server_host : '') }}" placeholder="e.g., yourserver.com or IP">
                                        </div>
                                        <small class="text-muted">The GPS device will send data to this server</small>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="server_port">Server Port</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-plug"></i></span>
                                            </div>
                                            <input type="number" name="server_port" id="server_port" class="form-control"
                                                   value="{{ old('server_port', isset($gpsDevice) ? $gpsDevice->server_port : '') }}" placeholder="e.g., 8080">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Assignment Section -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-car mr-2"></i>Vehicle Assignment
                            </h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="vehicle_id">Assign to Vehicle</label>
                                        <select name="vehicle_id" id="vehicle_id" class="form-control select2">
                                            <option value="">Select Vehicle (Optional)</option>
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}" {{ old('vehicle_id', isset($gpsDevice) ? $gpsDevice->vehicle_id : '') == $vehicle->id ? 'selected' : '' }}>
                                                    {{ $vehicle->vehicle_name }} ({{ $vehicle->vehicle_number }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Link this GPS device to a specific vehicle</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Settings Section -->
                        <div class="form-section mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-cog mr-2"></i>Additional Settings
                            </h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="installation_date">Installation Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <input type="date" name="installation_date" id="installation_date" class="form-control"
                                                   value="{{ old('installation_date', isset($gpsDevice) ? $gpsDevice->installation_date : '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <div class="custom-control custom-switch mt-2">
                                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active"
                                                   {{ old('is_active', isset($gpsDevice) ? $gpsDevice->is_active : true) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="is_active">Device is Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="notes">Notes</label>
                                        <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes', isset($gpsDevice) ? $gpsDevice->notes : '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Supported Device Protocols Info -->
                        <div class="alert alert-info mt-3">
                            <h5><i class="fas fa-info-circle"></i> Supported GPS Device Protocols</h5>
                            <p class="mb-0">This system supports various GPS device protocols including: GT06 (Concox), TK103/TK104, A8/A9, Syrus, Meiligao, and custom protocols. The device will send location data to the configured server endpoint.</p>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions d-flex justify-content-end pt-3 border-top">
                            <button type="button" class="btn btn-light mr-2" onclick="window.location.href='{{ route('admin.gps-devices.index') }}'">
                                <i class="fas fa-times mr-1"></i> Cancel
                            </button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span class="btn-content">
                                    <i class="fas fa-save mr-1"></i> {{ isset($gpsDevice) ? 'Update Device' : 'Create Device' }}
                                </span>
                                <span class="btn-loader d-none">
                                    <span class="spinner-border spinner-border-sm mr-1"></span>
                                    {{ isset($gpsDevice) ? 'Updating...' : 'Creating...' }}
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .page-header { padding: 1.5rem 0; }
    .page-title { color: #2c3e50; font-weight: 600; margin-bottom: 0.25rem; }
    .section-title { color: #495057; font-weight: 600; font-size: 0.95rem; padding-bottom: 0.5rem; border-bottom: 2px solid #e9ecef; margin-bottom: 1.5rem; }
    .form-section { background: #f8f9fa; padding: 1.5rem; border-radius: 8px; }
    .input-group-text { background-color: #f8f9fa; border-color: #e9ecef; color: #6c757d; }
    .form-control:focus { border-color: #4a90e2; box-shadow: 0 0 0 0.2rem rgba(74, 144, 226, 0.15); }
    .select2-container--default .select2-selection--single { height: 45px; border: 1px solid #e9ecef; border-radius: 4px; }
    .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 43px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 43px; }
    .custom-switch .custom-control-label::before { height: 22px; width: 44px; }
    .custom-switch .custom-control-label::after { width: 18px; height: 18px; }
    .custom-switch .custom-control-input:checked ~ .custom-control-label::after { transform: translateX(22px); }
    .is-invalid { border-color: #dc3545 !important; }
    .invalid-feedback { display: block; color: #dc3545; font-size: 80%; margin-top: 0.25rem; }
    .card { border-radius: 12px; }
    .btn { border-radius: 6px; padding: 0.5rem 1.25rem; font-weight: 500; transition: all 0.2s ease; }
    .btn:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .btn-primary { background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%); border: none; }
    .btn-primary:hover { background: linear-gradient(135deg, #357abd 0%, #2a6ab5 100%); }
    .btn-light { background: #f8f9fa; border: 1px solid #dee2e6; color: #495057; }
    .btn-loader { display: inline-flex; align-items: center; }
    #submitBtn.processing { pointer-events: none; opacity: 0.8; }
    #submitBtn.processing .btn-content { display: none; }
    #submitBtn.processing .btn-loader { display: inline-flex; }
</style>
@endpush

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({ placeholder: 'Select an option', allowClear: true, width: '100%' });

    // Form validation and AJAX submission
    $('#gpsDeviceForm').on('submit', function(e) {
        e.preventDefault();

        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        var formData = new FormData(this);
        var submitBtn = $('#submitBtn');
        submitBtn.addClass('processing');

        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                submitBtn.removeClass('processing');
                if (response.success) {
                    Swal.fire({ icon: 'success', title: 'Success!', text: response.message || 'GPS Device saved successfully!', confirmButtonColor: '#4a90e2' })
                    .then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = response.redirect || '{{ route("admin.gps-devices.index") }}';
                        }
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error!', text: response.message || 'Something went wrong!' });
                }
            },
            error: function(xhr) {
                submitBtn.removeClass('processing');
                if (xhr.status === 422) {
                    var errors = xhr.responseJSON.errors;
                    for (var field in errors) {
                        $('#' + field).addClass('is-invalid');
                        $('#' + field + '_error').text(errors[field][0]);
                    }
                    Swal.fire({ icon: 'error', title: 'Validation Error', text: errors[Object.keys(errors)[0]][0] });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error!', text: 'Something went wrong. Please try again.' });
                }
            }
        });
    });

    $('#gpsDeviceForm input, #gpsDeviceForm select, #gpsDeviceForm textarea').on('change input', function() {
        $(this).removeClass('is-invalid');
        var errorId = '#' + $(this).attr('id') + '_error';
        if ($(errorId).length) { $(errorId).text(''); }
    });
});
</script>
@endsection
