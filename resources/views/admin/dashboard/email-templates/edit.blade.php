@extends('admin.dashboard.master')

@section('title')
Edit Email Template
@endsection

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary mb-0">
                <i class="fa fa-envelope"></i> Edit Email Template
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
                <form id="emailTemplateForm" action="{{ route('email-templates.update', $emailTemplate->id) }}" method="POST">
                    @csrf
                    @method('PUT')

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
                                    value="{{ old('name', $emailTemplate->name) }}">
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
                                    value="{{ old('slug', $emailTemplate->slug) }}">
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
                                        <option value="{{ $key }}" {{ old('type', $emailTemplate->type) == $key ? 'selected' : '' }}>
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
                                    <option value="1" {{ old('is_active', $emailTemplate->is_active) == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ old('is_active', $emailTemplate->is_active) == '0' ? 'selected' : '' }}>Inactive</option>
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
                                    value="{{ old('subject', $emailTemplate->subject) }}">
                            </div>
                            <small class="text-danger error-text subject_error"></small>
                        </div>

                        {{-- Email Body --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold small mb-1">Email Body *</label>
                            <textarea 
                                name="body" 
                                id="body"
                                class="form-control border-start-0" 
                                rows="10" 
                                placeholder="Email body content (HTML supported)..."><?php echo old('body', $escapedBody ?? ''); ?></textarea>
                            <small class="text-danger error-text body_error"></small>
                            <div class="mt-2">
                                <span class="badge bg-info">Use @@&#123;&#123;variable_name&#125;&#125; for dynamic content</span>
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
                                    placeholder='{"variable_name": "description", ...}'>{{ old('variables', $emailTemplate->variables ? json_encode($emailTemplate->variables, JSON_PRETTY_PRINT) : '') }}</textarea>
                            </div>
                            <small class="text-muted">Define available variables in JSON format for documentation purposes.</small>
                            <small class="text-danger error-text variables_error"></small>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none" id="loader" role="status"></span>
                            <i class="fa fa-save"></i> Update Template
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>

<!-- Preview Modal -->
<div class="modal" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fa fa-envelope-open me-2"></i>Email Preview</h5>
                <button type="button" class="btn-close btn-close-white" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="previewFrame" style="width: 100%; height: 600px; border: none;"></iframe>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

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
    resize: vertical;
    font-family: 'Courier New', Courier, monospace;
}
/* Modal styles fix */
.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5) !important;
    opacity: 1 !important;
    z-index: 1040;
}
.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
}
#previewModal {
    z-index: 1050;
}
#previewModal .modal-dialog {
    max-width: 900px;
}
#previewModal .modal-body {
    background-color: #fff;
    padding: 0;
}
#previewFrame {
    background-color: #ffffff;
    min-height: 600px;
}
</style>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function() {
    // Auto-generate slug from name (only if slug is empty or user wants to regenerate)
    let originalSlug = '{{ $emailTemplate->slug }}';
    
    $('#name').on('input', function() {
        let name = $(this).val();
        // Only auto-generate if the slug hasn't been manually changed from original
        let currentSlug = $('#slug').val();
        if (currentSlug === originalSlug || currentSlug === '') {
            let slug = name.toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
            $('#slug').val(slug);
        }
    });

    // Form validation and submission
    $('#emailTemplateForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let method = 'PUT';
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
    const subject = $('#subject').val() || 'Email Subject';
    let logoUrl = $('#admin_logo_url').val() || '';

    // Get body content from textarea
    let body = $('#body').val() || 'Email body content...';
    // ================== PREVIEW VARIABLE REPLACEMENT ==================

body = body
    .replaceAll('@@adminlogo_url', logoUrl || '')
    .replaceAll('@@admin_logo_url', logoUrl || '')
    .replaceAll('@@company_name', 'Transport Management System')
    .replaceAll('@@year', new Date().getFullYear());

// Blade-safe cleanup of unresolved variables
body = body
    .replace(new RegExp('\\{\\{.*?\\}\\}', 'g'), '')
    .replace(new RegExp('@@\\w+', 'g'), '');

// ================== END ==================

    // Get logo from settings
    $.ajax({
        url: '{{ route("admin.settings.get-logo") }}',
        method: 'GET',
        success: function(logoData) {
            let logoUrl = logoData.logo_url || '';
            
            // Check if logo URL contains template variables
            if (logoUrl && (logoUrl.includes('{') || logoUrl.includes('}'))) {
                logoUrl = '';
            }
            
            // Create preview HTML
            const previewHtml = `<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>${subject}</title>
    <style>
        body { margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #fff; }
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
            const previewHtml = `<!DOCTYPE html>
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
