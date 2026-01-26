@extends('admin.dashboard.master')

@section('main_content')
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

<section role="main" class="content-body" style="background:#fff;">
<div class="container">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-car"></i> Edit Vehicle
        </h4>
        <a href="{{ route('vehicles.index') }}" class="btn btn-primary btn-lg pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- CARD --}}
    <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 1200px;">
        <div class="card-body p-4 bg-light">

            <form id="vehicleForm"
                  action="{{ route('vehicles.update', $vehicle->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row gy-3 gx-4 align-items-center">

                    {{-- Vehicle Name --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Vehicle Name *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-car text-secondary"></i>
                            </span>
                            <input type="text" name="vehicle_name" class="form-control border-start-0 py-2"
                                value="{{ $vehicle->vehicle_name }}" placeholder="Vehicle Name">
                        </div>
                        <small class="text-danger error-text vehicle_name_error"></small>
                    </div>

                    {{-- Department --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Department *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-building text-secondary"></i>
                            </span>
                            <select name="department_id" class="form-select border-start-0 py-2">
                                <option value="">Select Department</option>
                            @foreach($departments as $id => $name)
                                <option value="{{ $id }}" {{ $vehicle->department_id == $id ? 'selected' : '' }}>
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
                            <input type="date" name="registration_date" class="form-control border-start-0 py-2"
                               value="{{ $vehicle->registration_date }}">
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
                            <input type="text" name="license_plate" class="form-control border-start-0 py-2"
                                value="{{ $vehicle->license_plate }}" placeholder="License Plate">
                        </div>
                        <small class="text-danger error-text license_plate_error"></small>
                    </div>

                    {{-- Alert Cell --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Alert Cell Number *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-phone text-secondary"></i>
                            </span>
                            <input type="text" name="alert_cell_number" class="form-control border-start-0 py-2"
                                value="{{ $vehicle->alert_cell_number }}" placeholder="Alert Cell Number">
                        </div>
                        <small class="text-danger error-text alert_cell_number_error"></small>
                    </div>

                    {{-- Ownership --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Ownership *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-user-shield text-secondary"></i>
                            </span>
                            <select name="ownership" class="form-select border-start-0 py-2">
                                <option value="">Select Ownership</option>
                            @foreach($ownerships as $key => $label)
                                <option value="{{ $key }}" {{ $vehicle->ownership == $key ? 'selected' : '' }}>
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
                    {{-- Vehicle Type --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Vehicle Type *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-truck text-secondary"></i>
                            </span>
                            <select name="vehicle_type_id" class="form-select border-start-0 py-2">
                                <option value="">Select Type</option>
                            @foreach($vehicleTypes as $id => $name)
                                <option value="{{ $id }}" {{ $vehicle->vehicle_type_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text vehicle_type_id_error"></small>
                    </div>

                    {{-- Driver --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Driver *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-user-tie text-secondary"></i>
                            </span>
                            <select name="driver_id" class="form-select border-start-0 py-2">
                                <option value="">Select Driver</option>
                            @foreach($drivers as $id => $name)
                                <option value="{{ $id }}" {{ $vehicle->driver_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text driver_id_error"></small>
                    </div>

                    {{-- Vendor --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Vendor *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-store text-secondary"></i>
                            </span>
                            <select name="vendor_id" class="form-select border-start-0 py-2">
                                <option value="">Select Vendor</option>
                            @foreach($vendors as $id => $name)
                                <option value="{{ $id }}" {{ $vehicle->vendor_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text vendor_id_error"></small>
                    </div>

                    {{-- Seat Capacity --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold small mb-1">Seat Capacity *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="fa fa-chair text-secondary"></i>
                            </span>
                            <input type="number" name="seat_capacity" class="form-control border-start-0 py-2"
                                value="{{ $vehicle->seat_capacity }}" placeholder="Seat Capacity">
                        </div>
                        <small class="text-danger error-text seat_capacity_error"></small>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="text-center mt-4">
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
$(function () {

    $('#vehicleForm').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let formData = form.serialize();

        $('.error-text').text('');
        $('#loader').removeClass('d-none');
        $('#submitBtn').prop('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            success: function (res) {
                $('#loader').addClass('d-none');
                $('#submitBtn').prop('disabled', false);

                Swal.fire({
                    icon: 'success',
                    title: 'Updated',
                    text: res.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    window.location.href = "{{ route('vehicles.index') }}";
                }, 1500);
            },
            error: function (xhr) {
                $('#loader').addClass('d-none');
                $('#submitBtn').prop('disabled', false);

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                }
            }
        });
    });

});
</script>
@endpush
