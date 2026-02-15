@extends('admin.dashboard.master')

@section('main_content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #fff !important;
    }
    .card {
        border-radius: 10px;
        border: none;
    }
    .card-body {
        padding: 1.8rem;
    }
    label.form-label {
        font-weight: 600;
        color: #000;
        margin-bottom: 0.4rem;
    }
    .input-group-text {
        background-color: #eef1f5;
        border-right: 0;
    }
    .form-control, .form-select {
        border-left: 0;
        height: 42px;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.15rem rgba(0, 123, 255, 0.15);
    }
    h5.section-title {
        color: #0d6efd;
        font-weight: 600;
        font-size: 1rem;
        border-left: 4px solid #0d6efd;
        padding-left: 10px;
        margin-bottom: 1rem;
        margin-top: 1.5rem;
    }
    .btn-success {
        font-weight: 600;
        border-radius: 6px;
    }
    .btn-outline-primary {
        border-radius: 6px;
    }
    .is-invalid {
        border-color: #dc3545 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5zM6 8.2a.3.3 0 000 .6.3.3 0 000-.6z'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat !important;
        background-position: right calc(0.375em + 0.1875rem) center !important;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem) !important;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: block;
    }
    /* Loader styles */
    .btn-loading {
        position: relative;
        color: transparent !important;
        pointer-events: none;
    }
    .btn-loading::after {
        content: "";
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        margin-left: -8px;
        margin-top: -8px;
        border: 2px solid #fff;
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-active {
        background-color: #d4edda;
        color: #155724;
    }
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }
</style>

<section role="main" class="content-body" style="background-color:#fff;">
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
        <h3 class="fw-bold text-primary mb-0"><i class="bi bi-car-front-fill me-2"></i>Edit Vehicle</h3>
        <a class="btn btn-primary btn-lg px-3 pull-right" href="{{ route('vehicles.index') }}">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form id="vehicle_edit_form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" id="vehicle_id" name="id" value="{{ $vehicle->id }}">

                <!-- Vehicle Basic Info -->
                <h5 class="section-title"><i class="bi bi-info-circle me-1"></i> Vehicle Information</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-car"></i></span>
                            <input type="text" class="form-control" id="vehicle_name" name="vehicle_name" value="{{ $vehicle->vehicle_name }}" placeholder="Enter vehicle name">
                        </div>
                        <span class="invalid-feedback" id="vehicle_name_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Vehicle Number</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-hash"></i></span>
                            <input type="text" class="form-control" value="{{ $vehicle->vehicle_number }}" readonly>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">License Plate <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                            <input type="text" class="form-control" id="license_plate" name="license_plate" value="{{ $vehicle->license_plate }}" placeholder="Enter license plate">
                        </div>
                        <span class="invalid-feedback" id="license_plate_error"></span>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Vehicle Type <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-layout-text-window-reverse"></i></span>
                            <select class="form-select" id="vehicle_type_id" name="vehicle_type_id">
                                <option value="">Select Vehicle Type</option>
                                @foreach($vehicleTypes as $id => $name)
                                    <option value="{{ $id }}" {{ $vehicle->vehicle_type_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="invalid-feedback" id="vehicle_type_id_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Ownership <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-badge"></i></span>
                            <select class="form-select" id="ownership" name="ownership">
                                <option value="">Select Ownership</option>
                                @foreach($ownerships as $value => $label)
                                    <option value="{{ $value }}" {{ $vehicle->ownership == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="invalid-feedback" id="ownership_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Seat Capacity <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-people"></i></span>
                            <input type="number" class="form-control" id="seat_capacity" name="seat_capacity" value="{{ $vehicle->seat_capacity }}" placeholder="Enter seat capacity" min="1">
                        </div>
                        <span class="invalid-feedback" id="seat_capacity_error"></span>
                    </div>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-md-4">
                        <label class="form-label">Registration Date <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                            <input type="date" class="form-control" id="registration_date" name="registration_date" value="{{ $vehicle->registration_date }}">
                        </div>
                        <span class="invalid-feedback" id="registration_date_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Alert Cell Number <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-phone"></i></span>
                            <input type="text" class="form-control" id="alert_cell_number" name="alert_cell_number" value="{{ $vehicle->alert_cell_number }}" placeholder="Enter alert number">
                        </div>
                        <span class="invalid-feedback" id="alert_cell_number_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <div class="mt-2">
                            @if($vehicle->status == 1)
                                <span class="status-badge status-active"><i class="bi bi-check-circle"></i> Active</span>
                            @else
                                <span class="status-badge status-inactive"><i class="bi bi-x-circle"></i> Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Department & Assignment -->
                <h5 class="section-title"><i class="bi bi-building me-1"></i> Department & Assignment</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Department <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                            <select class="form-select" id="department_id" name="department_id">
                                <option value="">Select Department</option>
                                @foreach($departments as $id => $name)
                                    <option value="{{ $id }}" {{ $vehicle->department_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="invalid-feedback" id="department_id_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Driver <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <select class="form-select" id="driver_id" name="driver_id">
                                <option value="">Select Driver</option>
                                @foreach($drivers as $id => $name)
                                    <option value="{{ $id }}" {{ $vehicle->driver_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="invalid-feedback" id="driver_id_error"></span>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Vendor</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-shop"></i></span>
                            <select class="form-select" id="vendor_id" name="vendor_id">
                                <option value="">Select Vendor (Optional)</option>
                                @foreach($vendors as $id => $name)
                                    <option value="{{ $id }}" {{ $vehicle->vendor_id == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <span class="invalid-feedback" id="vendor_id_error"></span>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary me-2">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-success" id="submit_btn">
                            <span id="btn_text"><i class="bi bi-check-circle"></i> Update Vehicle</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2();

    // Clear validation errors on input change
    $('#vehicle_edit_form input, #vehicle_edit_form select').on('input change', function() {
        $(this).removeClass('is-invalid');
        const errorElement = $('#' + $(this).attr('id') + '_error');
        if (errorElement.length) {
            errorElement.text('');
        }
    });

    // Form submission with AJAX
    $('#vehicle_edit_form').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').text('');

        const submitBtn = $('#submit_btn');
        const btnText = $('#btn_text');
        const vehicleId = $('#vehicle_id').val();
        const url = "{{ route('vehicles.update', ':id') }}".replace(':id', vehicleId);

        // Add loading state
        submitBtn.addClass('btn-loading');
        submitBtn.prop('disabled', true);

        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                submitBtn.removeClass('btn-loading');
                submitBtn.prop('disabled', false);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false,
                        willClose: () => {
                            window.location.href = "{{ route('vehicles.index') }}";
                        }
                    });
                }
            },
            error: function(xhr) {
                submitBtn.removeClass('btn-loading');
                submitBtn.prop('disabled', false);

                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    
                    for (const [field, messages] of Object.entries(errors)) {
                        const input = $('#' + field);
                        if (input.length) {
                            input.addClass('is-invalid');
                            const errorElement = $('#' + field + '_error');
                            if (errorElement.length) {
                                errorElement.text(messages[0]);
                            }
                        }
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please check the form for errors and try again.',
                        confirmButtonColor: '#dc3545'
                    });
                } else if (xhr.status === 403) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Access Denied',
                        text: xhr.responseJSON.message || 'You do not have permission to perform this action.',
                        confirmButtonColor: '#ffc107'
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again later.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            },
            complete: function() {
                submitBtn.removeClass('btn-loading');
                submitBtn.prop('disabled', false);
            }
        });
    });
});
</script>
@endpush
@endsection
