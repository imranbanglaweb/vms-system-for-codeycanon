@extends('admin.dashboard.master')

@section('main_content')
<br>
<br>
<section class="content-body" style="background-color:#fff;">
<div class="container">

    <div class="card shadow-sm p-4 mx-auto" style="max-width: 800px;">
        
        <a href="{{ route('vehicle-type.index') }}" class="btn btn-primary btn-lg pull-right">
            <i class="fa fa-arrow-left"></i> Back
        </a>
        <h4 class="fw-bold mb-3 text-primary">
            {{ $vehicleType ? 'Edit Vehicle Type' : 'Add Vehicle Type' }}
        </h4>

        <form id="vehicleTypeForm" action="{{ $action }}" method="POST">
            @csrf
            @if($method == 'PUT')
                @method('PUT')
            @endif

            <div class="mb-3">
                <label class="form-label fw-semibold">Name *</label>
                <input type="text" name="name" class="form-control"
                       value="{{ $vehicleType->name ?? '' }}">
                <small class="text-danger error-text name_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" class="form-control" rows="3">{{ $vehicleType->description ?? '' }}</textarea>
                <small class="text-danger error-text description_error"></small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Status *</label>
                <select name="status" class="form-select">
                    <option value="1" {{ isset($vehicleType) && $vehicleType->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ isset($vehicleType) && $vehicleType->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
                <small class="text-danger error-text status_error"></small>
            </div>

            <button type="submit" id="submitBtn" class="btn btn-primary w-100">
                <span id="loader" class="spinner-border spinner-border-sm d-none"></span>
                {{ $vehicleType ? 'Update' : 'Save' }}
            </button>
        </form>
    </div>

</div>
</section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function() {
    $('#vehicleTypeForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let method = form.find('input[name="_method"]').val() || 'POST';

        $('#submitBtn').attr('disabled', true);
        $('#loader').removeClass('d-none');
        $('.error-text').text('');

        $.ajax({
            url: url,
            type: method,
            data: form.serialize(),
            success: function(response) {
                $('#submitBtn').attr('disabled', false);
                $('#loader').addClass('d-none');

                Swal.fire({
                    icon: 'success',
                    title: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                if (method === 'POST') form[0].reset();
            },
            error: function(xhr) {
                $('#submitBtn').attr('disabled', false);
                $('#loader').addClass('d-none');

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            }
        });
    });
});
</script>
@endpush
