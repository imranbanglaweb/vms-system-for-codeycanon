@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff">
    <div class="row">
        <div class="col-12 mb-3 d-flex justify-content-between align-items-center">
            <h2>Create New User</h2>
            <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
        </div>
    </div>

    {{-- Error Messages --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-lg border-0 rounded-lg mt-3">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0" style="padding: 10px;"><i class="fa fa-user-plus"></i> User Registration Form</h4>
        </div>
        <div class="card-body">
            <form id="userForm" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    {{-- Company --}}
                    <div class="col-md-6">
                        <label for="company_id" class="form-label"><strong>Select Company <span class="text-danger">*</span></strong></label>
                        <select name="company_id" id="company_id" class="form-control select2">
                            <option value="">Please Select Company</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Employee --}}
                    <div class="col-md-6">
                        <label for="employee_id" class="form-label"><strong>Select Employee <span class="text-danger">*</span></strong></label>
                        <select name="employee_id" class="form-control select2 employee_id">
                            <option value="">Please Select</option>
                            @foreach($employees as $list)
                                <option value="{{ $list->id }}">{{ $list->name }} -- {{ $list->employee_code }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- User Type --}}
                    <div class="col-md-6">
                        <label for="user_type" class="form-label"><strong>Select User Type <span class="text-danger">*</span></strong></label>
                        <select name="user_type" class="form-control select2 user_type">
                            <option value="">Please Select</option>
                            <option value="normal_user">Normal User</option>
                            <option value="super_user">Super User</option>
                            <option value="admin">Admin</option>
                            <option value="department_head">Department Head</option>
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Name --}}
                    <div class="col-md-6">
                        <label for="user_name" class="form-label"><strong>Name <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User name" autocomplete="username">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label for="user_email" class="form-label"><strong>Email <span class="text-danger">*</span></strong></label>
                        <input type="email" class="form-control" id="user_email" name="email" placeholder="Enter User Email" autocomplete="email">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Phone --}}
                    <div class="col-md-6">
                        <label for="user_phone" class="form-label"><strong>Phone Number <span class="text-danger">*</span></strong></label>
                        <input type="text" class="form-control" id="user_phone" name="phone" placeholder="Enter phone" autocomplete="tel">
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Password --}}
                    <div class="col-md-6 position-relative">
                        <label for="user_password" class="form-label"><strong>Password <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="user_password" name="password" placeholder="Enter Password" autocomplete="new-password">
                            <span class="input-group-text toggle-password" data-target="#user_password" style="cursor: pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="col-md-6 position-relative">
                        <label for="user_cpassword" class="form-label"><strong>Confirm Password <span class="text-danger">*</span></strong></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="user_cpassword" name="confirm-password" placeholder="Confirm Password" autocomplete="new-password">
                            <span class="input-group-text toggle-password" data-target="#user_cpassword" style="cursor: pointer;">
                                <i class="fa fa-eye"></i>
                            </span>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Role --}}
                    <div class="col-md-6">
                        <label for="roles" class="form-label"><strong>Role <span class="text-danger">*</span></strong></label>
                        <select name="roles" class="form-control select2 roles">
                            <option value="">Please Select</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Image Upload --}}
                    <div class="col-md-6">
                        <label class="form-label"><strong>User Image Upload</strong></label>
                        <div class="text-center mb-3">
                            <img id="previewImg" src="{{ asset('public/admin_resource/assets/images/user_image/default.png') }}" class="img-thumbnail rounded-circle" width="100" height="100">
                        </div>
                        <input type="file" class="form-control" id="user_image" name="user_image" onchange="previewFile(this);">
                        <small class="form-text text-muted">
                            Allowed files: JPG, JPEG, PNG (Max size: 5MB)
                        </small>
                        <div class="invalid-feedback"></div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="col-12 text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                            <i class="fa fa-save"></i> Save User
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</section>

{{-- Scripts --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js" defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" defer></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
window.addEventListener('load', function() {

    // Initialize Select2 (Check if not already initialized by theme)
    if (!$('.select2').hasClass("select2-offscreen")) {
        $('.select2').select2({ width: '100%' });
    }

    // Trigger validation on Select2 change
    $('.select2').on('change', function () {
        $(this).valid();
    });

    // Toggle password visibility
    $(document).on('click', '.toggle-password', function () {
        const input = $($(this).data('target'));
        const icon = $(this).find('i');
        if (input.attr('type') === 'password') {
            input.attr('type', 'text'); 
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password'); 
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });

    // Custom file size validation
    $.validator.addMethod("filesize", function(value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    }, "File size must be less than 5MB.");

    // Initialize jQuery Validation
    $("#userForm").validate({
        ignore: [],
        rules: {
            company_id: { required: true },
            employee_id: { required: true },
            user_type: { required: true },
            user_name: { required: true },
            email: { required: true, email: true },
            phone: { required: true, digits: true, minlength: 10, maxlength: 15 },
            password: { required: true, minlength: 6 },
            "confirm-password": { required: true, equalTo: "#user_password" },
            roles: { required: true },
            user_image: { extension: "jpg|jpeg|png", filesize: 5*1024*1024 }
        },
        messages: {
            company_id: "Please select a company.",
            employee_id: "Please select an employee.",
            user_type: "Please select a user type.",
            user_name: "Please enter a name.",
            email: "Please enter a valid email address.",
            phone: "Please enter a valid phone number.",
            password: "Password must be at least 6 characters.",
            "confirm-password": "Passwords do not match.",
            roles: "Please select a role.",
            user_image: { extension: "Only JPG, JPEG, PNG allowed.", filesize: "Max size 5MB." }
        },
        errorPlacement: function(error, element) {
            element.closest('.col-md-6, .col-12').find('.invalid-feedback').html(error);
        },
        highlight: function(element) {
            var elem = $(element);
            if (elem.hasClass('select2-hidden-accessible')) {
                elem.next('.select2-container').find('.select2-selection').addClass('is-invalid');
            } else {
                elem.addClass('is-invalid');
            }
        },
        unhighlight: function(element) {
            var elem = $(element);
            if (elem.hasClass('select2-hidden-accessible')) {
                elem.next('.select2-container').find('.select2-selection').removeClass('is-invalid');
            } else {
                elem.removeClass('is-invalid');
            }
        },

        // AJAX submission on valid form
        submitHandler: function(form) {
            let formData = new FormData(form);
            $.ajax({
                url: $(form).attr("action"),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    $("button[type='submit']").prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');
                    $(".invalid-feedback").html(''); // clear old errors
                    $(".is-invalid").removeClass("is-invalid");
                },
                success: function(response) {
                    Swal.fire({
                        title: "Success!",
                        text: "User added successfully.",
                        icon: "success"
                    }).then(() => {
                        form.reset();
                        $('.select2').val(null).trigger('change');
                        $('#previewImg').attr('src', "{{ asset('public/admin_resource/assets/images/user_image/default.png') }}");
                        $("#userForm").validate().resetForm();
                        $('.select2-selection').removeClass('is-invalid');
                    });
                },
                error: function(xhr) {
                    if(xhr.status === 422){ // Laravel validation errors
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(field, messages){
                            let input = $(`[name="${field}"]`);
                            input.addClass("is-invalid");
                            input.closest('.col-md-6, .col-12').find('.invalid-feedback').html(messages[0]);
                        });
                    } else {
                        toastr.error("Something went wrong! Please try again.");
                    }
                },
                complete: function() {
                    $("button[type='submit']").prop("disabled", false).html('<i class="fa fa-save"></i> Save User');
                }
            });
        }
    });
});

// Preview image
function previewFile(input){
    const file = input.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(e){ $("#previewImg").attr("src", e.target.result); }
        reader.readAsDataURL(file);
    }
}

</script>
@endsection
