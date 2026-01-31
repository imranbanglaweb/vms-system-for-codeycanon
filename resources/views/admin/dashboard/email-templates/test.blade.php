@extends('admin.dashboard.master')

@section('title')
Test Email - Transport Management System
@endsection

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold text-primary mb-0">
                <i class="fa fa-paper-plane"></i> Test Email
            </h4>
            <a href="{{ route('email-templates.index') }}" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-arrow-left"></i> Back to Templates
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mx-auto" style="max-width: 800px;">
            <div class="card-body p-4 bg-light">
                <form id="testEmailForm">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold small mb-1">Recipient Email *</label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            class="form-control" 
                            placeholder="Enter recipient email address"
                            required>
                        <small class="text-danger error-text email_error"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small mb-1">Select Template (Optional)</label>
                        <select name="template_id" id="template_id" class="form-select">
                            <option value="">-- No Template (Simple Test) --</option>
                            @foreach($templates as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted">Leave empty for a simple test email</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small mb-1">Subject</label>
                        <input 
                            type="text" 
                            name="subject" 
                            id="subject"
                            class="form-control" 
                            placeholder="Email Subject">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small mb-1">Body (HTML)</label>
                        <textarea 
                            name="body" 
                            id="body"
                            class="form-control" 
                            rows="5" 
                            placeholder="<h2>Hello!</h2>"></textarea>
                    </div>

                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none" id="loader"></span>
                            <i class="fa fa-paper-plane"></i> Send Test Email
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3 mx-auto mt-4" style="max-width: 800px;">
            <div class="card-body p-4">
                <h5 class="fw-bold text-info mb-3">
                    <i class="fa fa-info-circle"></i> Email Configuration
                </h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <th style="width: 200px;">Mailer</th>
                        <td><code>{{ config('mail.default') }}</code></td>
                    </tr>
                    <tr>
                        <th>Host</th>
                        <td><code>{{ config('mail.mailers.smtp.host') }}</code></td>
                    </tr>
                    <tr>
                        <th>Port</th>
                        <td><code>{{ config('mail.mailers.smtp.port') }}</code></td>
                    </tr>
                    <tr>
                        <th>Encryption</th>
                        <td><code>{{ config('mail.mailers.smtp.encryption') }}</code></td>
                    </tr>
                    <tr>
                        <th>From Address</th>
                        <td><code>{{ config('mail.from.address') }}</code></td>
                    </tr>
                    <tr>
                        <th>From Name</th>
                        <td><code>{{ config('mail.from.name') }}</code></td>
                    </tr>
                </table>
                <div class="alert alert-info mt-3">
                    <i class="fa fa-lightbulb-o"></i>
                    <strong>Tip:</strong> If emails are not being delivered, check your Gmail app password and ensure 2-factor authentication is enabled on your Google account.
                </div>
            </div>
        </div>

    </div>
</section>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function() {
    $('#testEmailForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = "{{ route('admin.email.test.send') }}";
        
        $('.error-text').text('');
        $('#loader').removeClass('d-none');
        $('#submitBtn').attr('disabled', true);

        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#loader').addClass('d-none');
                $('#submitBtn').attr('disabled', false);

                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: response.message
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
                        title: 'Error',
                        text: xhr.responseJSON?.message || 'Something went wrong!'
                    });
                }
            }
        });
    });

    // Pre-fill subject and body when template is selected
    $('#template_id').on('change', function() {
        if ($(this).val()) {
            // Could load template content here if needed
            $('#subject').val('');
            $('#body').val('');
        }
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
    font-size: 1em;
}
</style>
@endpush
