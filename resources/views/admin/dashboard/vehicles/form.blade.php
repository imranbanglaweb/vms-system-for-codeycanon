@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style=background-color:#fff;>
<div class="container">
<br>
<br>
<br>
<br>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-car"></i> {{ isset($vehicle) ? 'Edit Vehicle' : 'Add New Vehicle' }}
        </h4>
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 1200px;">
        <div class="card-body p-4 bg-light">
            <form id="vehicleForm" action="{{ isset($vehicle) ? route('vehicles.update', $vehicle->id) : route('vehicles.store') }}" method="POST">
                @csrf
                @if(isset($vehicle))
                    @method('PUT')
                @endif

                <div class="row gy-3 gx-4 align-items-center">

                    {{-- Vehicle Name --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Vehicle Name *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-car text-secondary"></i>
                            </span>
                            <input 
                                type="text" 
                                name="vehicle_name" 
                                class="form-control border-start-0 py-2" 
                                placeholder="Vehicle Name" 
                                value="{{ old('vehicle_name', $vehicle->vehicle_name ?? '') }}">
                        </div>
                        <small class="text-danger error-text vehicle_name_error"></small>
                    </div>

                    {{-- Department Dropdown --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Department *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-building text-secondary"></i>
                            </span>
                            <select name="department_id" class="form-select border-start-0 py-2">
                                <option value="">Select Department</option>
                                @foreach($departments as $id => $name)
                                    <option value="{{ $id }}" {{ old('department_id', $vehicle->department_id ?? '') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text department_id_error"></small>
                    </div>

                    {{-- Registration Date --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Registration Date *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-calendar text-secondary"></i>
                            </span>
                            <input 
                                type="date" 
                                name="registration_date" 
                                class="form-control border-start-0 py-2" 
                                value="{{ old('registration_date', $vehicle->registration_date ?? '') }}">
                        </div>
                        <small class="text-danger error-text registration_date_error"></small>
                    </div>

                    {{-- License Plate --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">License Plate *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-id-card text-secondary"></i>
                            </span>
                            <input 
                                type="text" 
                                name="license_plate" 
                                class="form-control border-start-0 py-2" 
                                placeholder="License Plate" 
                                value="{{ old('license_plate', $vehicle->license_plate ?? '') }}">
                        </div>
                        <small class="text-danger error-text license_plate_error"></small>
                    </div>

                    {{-- Alert Cell Number --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Alert Cell Number *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-phone text-secondary"></i>
                            </span>
                            <input 
                                type="text" 
                                name="alert_cell_number" 
                                class="form-control border-start-0 py-2" 
                                placeholder="Alert Cell Number" 
                                value="{{ old('alert_cell_number', $vehicle->alert_cell_number ?? '') }}">
                        </div>
                        <small class="text-danger error-text alert_cell_number_error"></small>
                    </div>

                    {{-- Ownership Dropdown --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Ownership *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-user-shield text-secondary"></i>
                            </span>
                            <select name="ownership" class="form-select border-start-0 py-2">
                                <option value="">Select Ownership</option>
                                @foreach($ownerships as $key => $label)
                                    <option value="{{ $key }}" {{ old('ownership', $vehicle->ownership ?? '') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text ownership_error"></small>
                    </div>
</div>
<hr>
<div class="row">
                    {{-- Vehicle Type Dropdown --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Vehicle Type *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-truck text-secondary"></i>
                            </span>
                            <select name="vehicle_type_id" class="form-select border-start-0 py-2">
                                <option value="">Select Type</option>
                                @foreach($vehicleTypes as $id => $name)
                                    <option value="{{ $id }}" {{ old('vehicle_type_id', $vehicle->vehicle_type_id ?? '') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text vehicle_type_id_error"></small>
                    </div>

                    {{-- RTA Office Dropdown --}}
                   

                    {{-- Driver Dropdown --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Driver *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-user-tie text-secondary"></i>
                            </span>
                            <select name="driver_id" class="form-select border-start-0 py-2">
                                <option value="">Select Driver</option>
                                @foreach($drivers as $id => $name)
                                    <option value="{{ $id }}" {{ old('driver_id', $vehicle->driver_id ?? '') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text driver_id_error"></small>
                    </div>

                    {{-- Vendor Dropdown --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Vendor *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-store text-secondary"></i>
                            </span>
                            <select name="vendor_id" class="form-select border-start-0 py-2">
                                <option value="">Select Vendor</option>
                                @foreach($vendors as $id => $name)
                                    <option value="{{ $id }}" {{ old('vendor_id', $vehicle->vendor_id ?? '') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text vendor_id_error"></small>
                    </div>

                    {{-- Seat Capacity --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Seat Capacity with Driver *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-chair text-secondary"></i>
                            </span>
                            <input 
                                type="number" 
                                name="seat_capacity" 
                                class="form-control border-start-0 py-2" 
                                placeholder="Seat Capacity" 
                                value="{{ old('seat_capacity', $vehicle->seat_capacity ?? '') }}">
                        </div>
                        <small class="text-danger error-text seat_capacity_error"></small>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary px-4 py-1" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="loader" role="status"></span>
                        <i class="fa fa-save"></i> {{ isset($vehicle) ? 'Update Vehicle' : 'Save Vehicle' }}
                    </button>
                </div>

            </form>
        </div>
    </div>

</div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<script>
$(function() {
    $('#vehicleForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let method = form.find('input[name="_method"]').val() || 'POST';
        let formData = form.serialize();

        $('.error-text').text('');
        $('#loader').removeClass('d-none');
        $('#submitBtn').attr('disabled', true);

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function (response) {
                $('#loader').addClass('d-none');
                $('#submitBtn').attr('disabled', false);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    form[0].reset();
                }
            },
            error: function (xhr) {
                $('#loader').addClass('d-none');
                $('#submitBtn').attr('disabled', false);

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.'
                    });
                }
            }
        });
    });
});
</script>

<style>
    .form-label {
        color: #000;
        font-size: 15px;
    }
    .card {
        background-color: #fff;
        padding: 20px;
    }
    .form-control, .form-select {
        font-size: 1.2em;
    }
    .input-group-text {
        width: 38px;
        justify-content: center;
    }
    .row > [class*="col-"] {
        margin-bottom: 8px;
    }
</style>
@endpush
