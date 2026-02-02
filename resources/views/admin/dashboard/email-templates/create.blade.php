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
            <div>
                <button type="button" class="btn btn-info btn-sm me-2" onclick="previewEmail()">
                    <i class="fa fa-eye"></i> Preview Email
                </button>
                <a href="{{ route('email-templates.index') }}" class="btn btn-primary btn-sm pull-right">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </div>
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
                                    id="subject"
                                    class="form-control border-start-0 py-2" 
                                    placeholder="Email Subject" 
                                    value="{{ old('subject') }}">
                            </div>
                            <small class="text-danger error-text subject_error"></small>
                        </div>

                        {{-- Email Body with CKEditor --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold small mb-1">Email Body *</label>
                            <textarea 
                                name="body" 
                                id="body"
                                class="form-control border-start-0" 
                                rows="10" 
                                placeholder="Email body content...">{{ old('body') }}</textarea>
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

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fa fa-envelope-open me-2"></i>Email Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="previewFrame" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

<script>
$(function() {
    // Initialize CKEditor
    CKEDITOR.replace('body', {
        height: 300,
        toolbar: [
            { name: 'document', items: ['Source'] },
            { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'] },
            { name: 'editing', items: ['Find', 'Replace', 'SelectAll'] },
            { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat'] },
            { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'] },
            { name: 'links', items: ['Link', 'Unlink', 'Anchor'] },
            { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
            { name: 'styles', items: ['Styles', 'Format'] },
            { name: 'tools', items: ['Maximize'] }
        ],
        allowedContent: true,
        bodyClass: 'email-body'
    });

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

        // Update CKEditor content before submitting
        for (var instanceName in CKEDITOR.instances) {
            CKEDITOR.instances[instanceName].updateElement();
        }

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

// Preview Email Function
function previewEmail() {
    // Update CKEditor content
    for (var instanceName in CKEDITOR.instances) {
        CKEDITOR.instances[instanceName].updateElement();
    }

    const subject = $('#subject').val() || 'Email Subject';
    const body = CKEDITOR.instances.body.getData() || 'Email body content...';

    // Get logo from settings
    $.ajax({
        url: '{{ route("admin.settings.get-logo") }}',
        method: 'GET',
        success: function(logoData) {
            const logoUrl = logoData.logo_url || '';
            
            // Create preview HTML
            const previewHtml = `
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>${subject}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; }
        .email-wrapper { padding: 40px 15px; }
        .email-container { max-width: 700px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .email-header { background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 35px 40px; text-align: center; color: #ffffff; }
        .email-header img { max-width: 200px; height: auto; margin-bottom: 10px; }
        .email-header h1 { margin: 0 0 8px 0; font-size: 28px; font-weight: 700; }
        .email-header p { margin: 0; color: rgba(255,255,255,0.85); font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .email-content { padding: 40px; color: #64748b; font-size: 16px; line-height: 1.8; }
        .email-footer { background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 30px 40px; color: rgba(255,255,255,0.8); text-align: center; }
        .email-footer p { margin: 0 0 5px 0; font-size: 13px; }
        .email-footer small { color: rgba(255,255,255,0.6); font-size: 12px; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                ${logoUrl ? `<img src="${logoUrl}" alt="Logo">` : '<h1>Transport Management System</h1>'}
                <p>Vehicle Management System</p>
            </div>
            <div class="email-content">
                <h2 style="color: #1e293b; margin: 0 0 25px 0;">Hello,</h2>
                <div>${body}</div>
                <div style="margin-top: 30px; padding-top: 25px; border-top: 1px dashed #e2e8f0;">
                    <p style="margin: 0 0 8px 0; color: #1e293b; font-weight: 600;">Best regards,</p>
                    <p style="margin: 0; color: #64748b;">The Transport Management System Team</p>
                </div>
            </div>
            <div class="email-footer">
                <p>&copy; ${new Date().getFullYear()} Transport Management System. All rights reserved.</p>
                <small>This is an automated message. Please do not reply directly to this email.</small>
            </div>
        </div>
    </div>
</body>
</html>`;

            // Show modal and load preview
            $('#previewModal').modal('show');
            $('#previewFrame').contents().find('html').html(previewHtml);
        },
        error: function() {
            // Fallback without logo
            const previewHtml = `
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>${subject}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f1f5f9; }
        .email-wrapper { padding: 40px 15px; }
        .email-container { max-width: 700px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .email-header { background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 35px 40px; text-align: center; color: #ffffff; }
        .email-header h1 { margin: 0; font-size: 28px; font-weight: 700; }
        .email-header p { margin: 0; color: rgba(255,255,255,0.85); font-size: 14px; text-transform: uppercase; letter-spacing: 1px; }
        .email-content { padding: 40px; color: #64748b; font-size: 16px; line-height: 1.8; }
        .email-footer { background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%); padding: 30px 40px; color: rgba(255,255,255,0.8); text-align: center; }
        .email-footer p { margin: 0 0 5px 0; font-size: 13px; }
        .email-footer small { color: rgba(255,255,255,0.6); font-size: 12px; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">
            <div class="email-header">
                <h1>Transport Management System</h1>
                <p>Vehicle Management System</p>
            </div>
            <div class="email-content">
                <h2 style="color: #1e293b; margin: 0 0 25px 0;">Hello,</h2>
                <div>${body}</div>
                <div style="margin-top: 30px; padding-top: 25px; border-top: 1px dashed #e2e8f0;">
                    <p style="margin: 0 0 8px 0; color: #1e293b; font-weight: 600;">Best regards,</p>
                    <p style="margin: 0; color: #64748b;">The Transport Management System Team</p>
                </div>
            </div>
            <div class="email-footer">
                <p>&copy; ${new Date().getFullYear()} Transport Management System. All rights reserved.</p>
                <small>This is an automated message. Please do not reply directly to this email.</small>
            </div>
        </div>
    </div>
</body>
</html>`;

            $('#previewModal').modal('show');
            $('#previewFrame').contents().find('html').html(previewHtml);
        }
    });
}
</script>
@endpush
