@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style=background-color:#fff;>
<div class="container">
<br>
    <div class="d-flex justify-content-between">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-store"></i> {{ isset($vendor) ? 'Edit Vendor' : 'Add New Vendor' }}
        </h4>
        <a href="{{ route('vendors.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-3 bg-light">
            <form id="vendorForm" action="{{ isset($vendor) ? route('vendors.update', $vendor->id) : route('vendors.store') }}" method="POST">
                @csrf
                @if(isset($vendor))
                    @method('PUT')
                @endif

                <div class="row g-2">
                    @php
                        $fields = [
                            ['name'=>'name','label'=>'Vendor Name','icon'=>'fa-store','type'=>'text'],
                            ['name'=>'contact_person','label'=>'Contact Person','icon'=>'fa-user-tie','type'=>'text'],
                            ['name'=>'contact_number','label'=>'Contact Number','icon'=>'fa-phone','type'=>'text'],
                            ['name'=>'email','label'=>'Email','icon'=>'fa-envelope','type'=>'email'],
                            ['name'=>'address','label'=>'Address','icon'=>'fa-map-marker-alt','type'=>'text'],
                            ['name'=>'city','label'=>'City','icon'=>'fa-city','type'=>'text'],
                            ['name'=>'country','label'=>'Country','icon'=>'fa-globe','type'=>'text'],
                            ['name'=>'status','label'=>'Status','icon'=>'fa-toggle-on','type'=>'select','options'=>['Active'=>'Active','Inactive'=>'Inactive']],
                        ];
                    @endphp

                    @foreach($fields as $field)
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small mb-1">{{ $field['label'] }} *</label>
                            <div class="input-group input-group-sm shadow-sm rounded">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fa {{ $field['icon'] }} text-secondary"></i>
                                </span>

                                @if($field['type'] === 'select')
                                    <select name="{{ $field['name'] }}" class="form-control border-start-0 py-2">
                                        <option value="">-- Select {{ $field['label'] }} --</option>
                                        @foreach($field['options'] as $key => $option)
                                            <option value="{{ $key }}"
                                                {{ (isset($vendor) && $vendor->{$field['name']} == $key) || old($field['name']) == $key ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <input 
                                        type="{{ $field['type'] }}" 
                                        name="{{ $field['name'] }}" 
                                        class="form-control border-start-0 py-2"
                                        placeholder="{{ $field['label'] }}" 
                                        value="{{ $vendor->{$field['name']} ?? old($field['name']) }}">
                                @endif
                            </div>
                            <small class="text-danger error-text {{ $field['name'] }}_error"></small>
                        </div>
                    @endforeach
                </div>

                <hr>

                <div class="text-center mt-3">
                    <button type="submit" class="btn btn-primary px-4 py-1" id="submitBtn">
                        <span class="spinner-border spinner-border-sm d-none" id="loader" role="status"></span>
                        <i class="fa fa-save"></i> {{ isset($vendor) ? 'Update Vendor' : 'Save Vendor' }}
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
    body {
        background-color: #f7f9fc;
    }
    .card {
        max-width: 1100px;
        padding: 10px;
        margin: auto;
        background-color: #fff;
    }
    .form-label {
        color: #444;
    }
    .form-control:focus {
        box-shadow: 0 0 4px rgba(13,110,253,0.25);
        border-color: #0d6efd;
    }
    .input-group-text {
        width: 40px;
        justify-content: center;
    }
</style>
@endpush
