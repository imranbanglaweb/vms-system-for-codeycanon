@extends('admin.dashboard.master')

@section('main_content')
<style>
    /* Labels */
    .form-label {
        font-size: 1.35rem;
        font-weight: 600;
        color: #2c2c2c;
    }

    /* Inputs & selects */
    .form-control,
    .form-select {
        font-size:  1.35rem;
        padding: 8px 12px;
        border-radius: 8px;
    }

    /* Select2 height fix */
    .select2-container .select2-selection--single {
        height: 38px;
        border-radius: 8px;
        padding: 4px 10px;
        font-size:  1.35rem;
    }

    .select2-selection__rendered {
        line-height: 30px !important;
    }

    .select2-selection__arrow {
        height: 36px !important;
    }

    /* Card */
    .card {
        border-radius: 14px;
    }

    /* Errors */
    .error-text {
        font-size:  1.35rem;
    }

    /* Button */
    #submitBtn {
        font-size:  1.35rem;
        padding: 8px 26px;
        border-radius: 20px;
    }
</style>

<section role="main" class="content-body" style="background:#fff;">
<div class="container">
<br>
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-car"></i> Edit Vehicle
        </h4>
        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    {{-- CARD --}}
    <div class="card shadow-sm border-0 rounded-3 mx-auto">
        <div class="card-body p-4 bg-light">

            <form id="vehicleForm"
                  action="{{ route('vehicles.update', $vehicle->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="row gy-3 gx-4">

                    {{-- Vehicle Name --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Vehicle Name *</label>
                        <input type="text" name="vehicle_name" class="form-control form-control-sm"
                               value="{{ $vehicle->vehicle_name }}">
                        <small class="text-danger error-text vehicle_name_error"></small>
                    </div>

                    {{-- Department --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Department *</label>
                        <select name="department_id" class="form-select form-select-sm select2">
                            <option value="">Select</option>
                            @foreach($departments as $id => $name)
                                <option value="{{ $id }}" {{ $vehicle->department_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text department_id_error"></small>
                    </div>

                    {{-- Registration Date --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Registration Date *</label>
                        <input type="date" name="registration_date" class="form-control form-control-sm"
                               value="{{ $vehicle->registration_date }}">
                        <small class="text-danger error-text registration_date_error"></small>
                    </div>

                    {{-- License Plate --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">License Plate *</label>
                        <input type="text" name="license_plate" class="form-control form-control-sm"
                               value="{{ $vehicle->license_plate }}">
                        <small class="text-danger error-text license_plate_error"></small>
                    </div>

                    {{-- Alert Cell --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Alert Cell Number *</label>
                        <input type="text" name="alert_cell_number" class="form-control form-control-sm"
                               value="{{ $vehicle->alert_cell_number }}">
                        <small class="text-danger error-text alert_cell_number_error"></small>
                    </div>

                    {{-- Ownership --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Ownership *</label>
                        <select name="ownership" class="form-select form-select-sm">
                            <option value="">Select</option>
                            @foreach($ownerships as $key => $label)
                                <option value="{{ $key }}" {{ $vehicle->ownership == $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text ownership_error"></small>
                    </div>

                    {{-- Vehicle Type --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Vehicle Type *</label>
                        <select name="vehicle_type_id" class="form-select form-select-sm select2">
                            <option value="">Select</option>
                            @foreach($vehicleTypes as $id => $name)
                                <option value="{{ $id }}" {{ $vehicle->vehicle_type_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text vehicle_type_id_error"></small>
                    </div>

                    {{-- Driver --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Driver *</label>
                        <select name="driver_id" class="form-select form-select-sm select2">
                            <option value="">Select</option>
                            @foreach($drivers as $id => $name)
                                <option value="{{ $id }}" {{ $vehicle->driver_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text driver_id_error"></small>
                    </div>

                    {{-- Vendor --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Vendor *</label>
                        <select name="vendor_id" class="form-select form-select-sm select2">
                            <option value="">Select</option>
                            @foreach($vendors as $id => $name)
                                <option value="{{ $id }}" {{ $vehicle->vendor_id == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text vendor_id_error"></small>
                    </div>

                    {{-- Seat Capacity --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small">Seat Capacity *</label>
                        <input type="number" name="seat_capacity" class="form-control form-control-sm"
                               value="{{ $vehicle->seat_capacity }}">
                        <small class="text-danger error-text seat_capacity_error"></small>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="loader"></span>
                        <i class="fa fa-save"></i> Update Vehicle
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
