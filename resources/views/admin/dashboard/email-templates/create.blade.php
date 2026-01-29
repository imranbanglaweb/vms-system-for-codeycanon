@extends('admin.dashboard.master')

@section('title')
Create Email Template
@endsection

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary mb-0">
                <i class="fa fa-envelope"></i> Create Email Template
            </h4>
            <a href="{{ route('email-templates.index') }}" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 1200px;">
            <div class="card-body p-4 bg-light">
                <form id="emailTemplateForm" action="{{ route('email-templates.store') }}" method="POST">
                    @csrf

                    <div class="row gy-3 gx-4 align-items-center">
                        {{-- Template Name --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">Template Name *</label>
                            <div class="input-group input-group-sm shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa fa-tag text-secondary"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name"
                                    class="form-control border-start-0 py-2" 
                                    placeholder="Template Name" 
                                    value="{{ old('name') }}">
                            </div>
                            <small class="text-danger error-text name_error"></small>
                        </div>

                        {{-- Template Slug --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">Slug *</label>
                            <div class="input-group input-group-sm shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa fa-code text-secondary"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="slug" 
                                    id="slug"
                                    class="form-control border-start-0 py-2" 
                                    placeholder="template-slug" 
                                    value="{{ old('slug') }}">
                            </div>
                            <small class="text-danger error-text slug_error"></small>
                        </div>

                        {{-- Template Type --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">Template Type *</label>
                            <div class="input-group input-group-sm shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa fa-list text-secondary"></i>
                                </span>
                                <select name="type" id="type" class="form-select border-start-0 py-2">
                                    <option value="">Select Type</option>
                                    @foreach($templateTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <small class="text-danger error-text type_error"></small>
                        </div>

                        {{-- Active Status --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mb-1">Status</label>
                            <div class="input-group input-group-sm shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa fa-power-off text-secondary"></i>
                                </span>
                                <select name="is_active" class="form-select border-start-0 py-2">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        {{-- Email Subject --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold small mb-1">Email Subject *</label>
                            <div class="input-group input-group-sm shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa fa-heading text-secondary"></i>
                                </span>
                                <input 
                                    type="text" 
                                    name="subject" 
                                    class="form-control border-start-0 py-2" 
                                    placeholder="Email Subject" 
                                    value="{{ old('subject') }}">
                            </div>
                            <small class="text-danger error-text subject_error"></small>
                        </div>

                        {{-- Email Body --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold small mb-1">Email Body *</label>
                            <div class="input-group shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0" style="height: 38px;">
                                    <i class="fa fa-envelope-open-text text-secondary"></i>
                                </span>
                                <textarea 
                                    name="body" 
                                    id="body"
                                    class="form-control border-start-0" 
                                    rows="10" 
                                    placeholder="Email body content...">{{ old('body') }}</textarea>
                            </div>
                            <small class="text-danger error-text body_error"></small>
                            <div class="mt-2">
                                <span class="badge bg-info">Use {{'{{variable_name}}'}} for dynamic content</span>
                            </div>
                        </div>

                        {{-- Variables (JSON) --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold small mb-1">Available Variables (JSON)</label>
                            <div class="input-group input-group-sm shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa fa-code-branch text-secondary"></i>
                                </span>
                                <textarea 
                                    name="variables" 
                                    id="variables"
                                    class="form-control border-start-0 py-2" 
                                    rows="3" 
                                    placeholder='{"variable_name": "description", ...}'>{{ old('variables') }}</textarea>
                            </div>
                            <small class="text-muted">Define available variables in JSON format for documentation purposes.</small>
                            <small class="text-danger error-text variables_error"></small>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none" id="loader" role="status"></span>
                            <i class="fa fa-save"></i> Save Template
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function() {
    // Auto-generate slug from name
    $('#name').on('input', function() {
        let name = $(this).val();
        let slug = name.toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        $('#slug').val(slug);
    });

    // Form validation and submission
    $('#emailTemplateForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let method = 'POST';
        let formData = form.serialize();

        $('.error-text').text('');
        $('#loader').removeClass('d-none');
        $('#submitBtn').attr('disabled', true);

        $.ajax({
            url: url,
            method: method,
            data: formData,
            success: function(response) {
                $('#loader').addClass('d-none');
                $('#submitBtn').attr('disabled', false);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        }
                    });
                }
            },
            error: function(xhr) {
                $('#loader').addClass('d-none');
                $('#submitBtn').attr('disabled', false);

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please check the form for errors.'
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
textarea.form-control {
    font-size: 1.2em;
}
</style>
@endpush
