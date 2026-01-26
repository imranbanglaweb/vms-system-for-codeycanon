@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style=background-color:#fff;>
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-store"></i> Add New Vendor
        </h4>
        <a href="{{ route('vendors.index') }}" class="btn btn-primary btn-lg pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 1200px;">
        <div class="card-body p-4 bg-light">
            <form id="vendorForm" action="{{ route('vendors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row gy-3 gx-4 align-items-center">
                    <!-- Vendor Name -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Vendor Name *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-user text-secondary"></i></span>
                            <input type="text" name="vendor_name" value="{{ old('vendor_name') }}" class="form-control border-start-0 py-2" placeholder="Enter Vendor Name">
                        </div>
                        <small class="text-danger error-text vendor_name_error"></small>
                    </div>

                    <!-- Vendor Type -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Vendor Type *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-tags text-secondary"></i></span>
                            <select name="vendor_type" class="form-select border-start-0 py-2">
                                <option value="">Select Type</option>
                                <option value="Local" {{ old('vendor_type') == 'Local' ? 'selected' : '' }}>Local</option>
                                <option value="International" {{ old('vendor_type') == 'International' ? 'selected' : '' }}>International</option>
                            </select>
                        </div>
                        <small class="text-danger error-text vendor_type_error"></small>
                    </div>

                    <!-- Contact Person -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Contact Person *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-user-tie text-secondary"></i></span>
                            <input type="text" name="contact_person" value="{{ old('contact_person') }}" class="form-control border-start-0 py-2" placeholder="Enter Contact Person">
                        </div>
                        <small class="text-danger error-text contact_person_error"></small>
                    </div>

                    <!-- Contact Number -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Contact Number *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-phone text-secondary"></i></span>
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}" class="form-control border-start-0 py-2" placeholder="Enter Contact Number">
                        </div>
                        <small class="text-danger error-text contact_number_error"></small>
                    </div>

                    <!-- Email -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Email *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-envelope text-secondary"></i></span>
                            <input type="email" name="email" value="{{ old('email') }}" class="form-control border-start-0 py-2" placeholder="Enter Email">
                        </div>
                        <small class="text-danger error-text email_error"></small>
                    </div>

                    <!-- Address -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Address *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-map-marker text-secondary"></i></span>
                            <input type="text" name="address" value="{{ old('address') }}" class="form-control border-start-0 py-2" placeholder="Enter Address">
                        </div>
                        <small class="text-danger error-text address_error"></small>
                    </div>

                    <!-- Linked RTA Office -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Linked RTA Office</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-building text-secondary"></i></span>
                            <select name="rta_office_id" class="form-select border-start-0 py-2">
                                <option value="">Select Office</option>
                                @foreach($rtaOffices as $office)
                                    <option value="{{ $office->id }}" {{ old('rta_office_id') == $office->id ? 'selected' : '' }}>
                                        {{ $office->office_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text rta_office_id_error"></small>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small mb-1">Status *</label>
                        <div class="input-group input-group-sm shadow-sm rounded">
                            <span class="input-group-text bg-white border-end-0"><i class="fa fa-toggle-on text-secondary"></i></span>
                            <select name="status" class="form-select border-start-0 py-2">
                                <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <small class="text-danger error-text status_error"></small>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-4 py-1" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="loader" role="status"></span>
                        <i class="fa fa-save"></i> Save Vendor
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
    $('#vendorForm').on('submit', function(e) {
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
