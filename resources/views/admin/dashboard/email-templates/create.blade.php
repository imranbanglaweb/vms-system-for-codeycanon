@extends('admin.dashboard.master')

@section('title')
Create Email Template
@endsection

@section('main_content')
<section role="main" class="content-body" style="background: linear-gradient(135deg, #f5f7fa 0%, #e8ecf1 100%); min-height: 100vh;">
    <div class="container-fluid">

        {{-- Header Section --}}
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-2" style="color: #1e3a5f;">
                        <i class="fa fa-envelope-open-text me-3" style="color: #2d5a87;"></i> Create New Email Template
                    </h2>
                    <p class="text-muted mb-0">Design and configure your email communication template</p>
                </div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-info px-3" onclick="previewEmail()" title="Preview email template">
                        <i class="fa fa-eye me-2"></i> Preview
                    </button>
                    <a href="{{ route('email-templates.index') }}" class="btn btn-outline-secondary px-3">
                        <i class="fa fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Main Card --}}
        <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 1200px; background: white;">
            <div class="card-body p-5">
                <form id="emailTemplateForm" action="{{ route('email-templates.store') }}" method="POST">
                    @csrf

                    {{-- Basic Information Section --}}
                    <div class="mb-5">
                        <h5 class="fw-bold mb-4" style="color: #1e3a5f; border-bottom: 2px solid #2d5a87; padding-bottom: 10px;">
                            <i class="fa fa-info-circle me-2" style="color: #2d5a87;"></i> Basic Information
                        </h5>
                        <div class="row gy-4 gx-4">
                            {{-- Template Name --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Template Name <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name"
                                    class="form-control form-control-lg border-2" 
                                    placeholder="e.g., Requisition Created Notification"
                                    value="{{ old('name') }}"
                                    style="border-color: #e2e8f0;">
                                <small class="text-danger error-text name_error"></small>
                                <small class="d-block text-muted mt-1">A descriptive name for this email template</small>
                            </div>

                            {{-- Template Slug --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Slug <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    name="slug" 
                                    id="slug"
                                    class="form-control form-control-lg border-2" 
                                    placeholder="e.g., requisition-created"
                                    value="{{ old('slug') }}"
                                    style="border-color: #e2e8f0;">
                                <small class="text-danger error-text slug_error"></small>
                                <small class="d-block text-muted mt-1">Unique identifier (use lowercase and hyphens)</small>
                            </div>

                            {{-- Template Type --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Template Type <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-select form-select-lg border-2">
                                    <option value="">Select a template type...</option>
                                    @foreach($templateTypes as $key => $label)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger error-text type_error"></small>
                                <small class="d-block text-muted mt-1">Choose the purpose of this email</small>
                            </div>

                            {{-- Active Status --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Status</label>
                                <select name="is_active" class="form-select form-select-lg border-2">
                                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>
                                        <i class="fa fa-check-circle"></i> Active
                                    </option>
                                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>
                                        <i class="fa fa-times-circle"></i> Inactive
                                    </option>
                                </select>
                                <small class="d-block text-muted mt-1">Enable or disable this template</small>
                            </div>
                        </div>
                    </div>

                    {{-- Email Content Section --}}
                    <div class="mb-5">
                        <h5 class="fw-bold mb-4" style="color: #1e3a5f; border-bottom: 2px solid #2d5a87; padding-bottom: 10px;">
                            <i class="fa fa-file-text me-2" style="color: #2d5a87;"></i> Email Content
                        </h5>
                        <div class="row gy-4 gx-4">
                            {{-- Email Subject --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Email Subject <span class="text-danger">*</span></label>
                                <input 
                                    type="text" 
                                    name="subject" 
                                    id="subject"
                                    class="form-control form-control-lg border-2" 
                                    placeholder="e.g., New Vehicle Requisition: @@requisition_number"
                                    value="{{ old('subject') }}"
                                    style="border-color: #e2e8f0;">
                                <small class="text-danger error-text subject_error"></small>
                                <small class="d-block text-muted mt-1">The subject line recipients will see in their inbox</small>
                            </div>

                            {{-- Email Greeting --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Greeting</label>
                                <input 
                                    type="text" 
                                    name="greeting" 
                                    id="greeting"
                                    class="form-control form-control-lg border-2" 
                                    placeholder="e.g., Dear @@head_name,"
                                    value="{{ old('greeting') }}"
                                    style="border-color: #e2e8f0;">
                                <small class="d-block text-muted mt-1">Opening greeting with personalization variables</small>
                            </div>

                            {{-- Email Main Content --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Main Message</label>
                                <textarea 
                                    name="content_text" 
                                    id="content_text"
                                    class="form-control form-control-lg border-2" 
                                    rows="3" 
                                    placeholder="Primary message content..."
                                    style="border-color: #e2e8f0;">{{ old('content_text') }}</textarea>
                                <small class="d-block text-muted mt-1">Core message of the email</small>
                            </div>

                            {{-- Email Body (HTML) --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Email Body (HTML Template) <span class="text-danger">*</span></label>
                                <textarea 
                                    name="body" 
                                    id="body"
                                    class="form-control border-2" 
                                    rows="14" 
                                    placeholder="Paste your email HTML template here..."
                                    style="border-color: #e2e8f0; font-family: 'Courier New', monospace; font-size: 12px;">{{ old('body') }}</textarea>
                                <small class="text-danger error-text body_error"></small>
                                <div class="mt-3 p-3 rounded" style="background-color: #fef3c7; border-left: 4px solid #f59e0b;">
                                    <strong class="text-warning"><i class="fa fa-lightbulb me-2"></i> Available Variables:</strong><br>
                                    <small class="text-dark">
                                        <code>@@requisition_number</code> 
                                        <code>@@requester_name</code> 
                                        <code>@@department_name</code> 
                                        <code>@@pickup_location</code> 
                                        <code>@@dropoff_location</code> 
                                        <code>@@pickup_date</code> 
                                        <code>@@pickup_time</code> 
                                        <code>@@purpose</code> 
                                        <code>@@passengers</code> 
                                        <code>@@admin_logo_url</code> 
                                        <code>@@admin_title</code> 
                                        <code>@@company_name</code> 
                                        <code>@@year</code>
                                    </small>
                                </div>
                            </div>

                            {{-- Email Footer Text --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Footer Message</label>
                                <textarea 
                                    name="footer_text" 
                                    id="footer_text"
                                    class="form-control form-control-lg border-2" 
                                    rows="3" 
                                    placeholder="e.g., Copyright notice, unsubscribe info, etc."
                                    style="border-color: #e2e8f0;">{{ old('footer_text') }}</textarea>
                                <small class="d-block text-muted mt-1">Footer text (copyright, contact info, etc.)</small>
                            </div>
                        </div>
                    </div>

                    {{-- Advanced Section --}}
                    <div class="mb-5">
                        <h5 class="fw-bold mb-4" style="color: #1e3a5f; border-bottom: 2px solid #2d5a87; padding-bottom: 10px;">
                            <i class="fa fa-sliders-h me-2" style="color: #2d5a87;"></i> Additional Variables (Optional)
                        </h5>
                        <div class="row gy-4 gx-4">
                            <div class="col-12">
                                <label class="form-label fw-semibold mb-2" style="color: #1e293b;">Custom Variables (JSON Format)</label>
                                <textarea 
                                    name="variables" 
                                    id="variables"
                                    class="form-control border-2" 
                                    rows="6" 
                                    placeholder='{"variable_name": "description", "key": "value"}'
                                    style="border-color: #e2e8f0; font-family: 'Courier New', monospace; font-size: 12px;">{{ old('variables') }}</textarea>
                                <small class="d-block text-muted mt-1">Define additional variables in JSON format for custom use cases</small>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="row mt-5 pt-4 border-top">
                        <div class="col-12 d-flex gap-3 justify-content-between">
                            <a href="{{ route('email-templates.index') }}" class="btn btn-outline-secondary px-5 py-2">
                                <i class="fa fa-times me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-semibold" id="submitBtn" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border: none;">
                                <span class="spinner-border spinner-border-sm d-none me-2" id="loader" role="status"></span>
                                <i class="fa fa-save me-2"></i> Create Template
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>
</section>

<!-- Preview Modal -->
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
    color: #1e293b;
    font-size: 14px;
    font-weight: 600;
}
.card {
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
}
.form-control, .form-select {
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    transition: all 0.3s ease;
}
.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}
.input-group-text {
    background-color: transparent;
    border: none;
}
textarea.form-control {
    resize: vertical;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}
.btn {
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
}
.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
}

</style>
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
