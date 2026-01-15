@extends('admin.dashboard.master')

@section('main_content')
<br><br>

<section role="main" class="content-body" style="background-color: #f8f9fa;">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Edit User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>

<form id="userEditForm" action="{{ route('users.update', $user->id) }}" method="post" enctype="multipart/form-data">
    @csrf
  @method('PUT')
    <div class="row">

        <!-- EMPLOYEE -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Select Employee:</strong>
                <select name="employee_id" class="form-control select2 employee_id" disabled>
                    <option value="">Please Select</option>
                    @foreach($employees as $list)
                        <option value="{{ $list->id }}" {{ $user->employee_id == $list->id ? 'selected' : '' }}>
                            {{ $list->name }} -- {{ $list->employee_code }}
                        </option>
                    @endforeach
                </select>
                <input type="hidden" name="employee_id" value="{{ $user->employee_id }}">
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <!-- USER TYPE -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Select User Type:</strong>
                <select name="user_type" class="form-control select2 user_type">
                    <option value="">Please Select</option>
                    <option value="normal_user"     {{ $user->user_type == 'normal_user' ? 'selected' : '' }}>Normal User</option>
                    <option value="super_user"      {{ $user->user_type == 'super_user' ? 'selected' : '' }}>Super User</option>
                    <option value="admin"           {{ $user->user_type == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="department_head" {{ $user->user_type == 'department_head' ? 'selected' : '' }}>Department Head</option>
                </select>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <!-- NAME -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>User Name:</strong>
                <input type="text" class="form-control" name="user_name" value="{{ $user->name }}">
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <!-- EMAIL -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Email:</strong>
                <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <!-- PHONE -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Phone Number:</strong>
                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <!-- PASSWORD -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Password (Leave blank if not changing):</strong>
                <input type="password" class="form-control" id="user_password" name="password">
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Confirm Password:</strong>
                <input type="password" class="form-control" name="confirm-password">
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <!-- ROLE -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="form-group">
                <strong>Role:</strong>
                <select name="roles" class="form-control select2 roles">
                    <option value="">Please Select</option>
                      @foreach($roles as $role)
        <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
            {{ $role }}
        </option>
    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <!-- IMAGE UPLOAD -->
        <div class="col-xs-6 col-sm-6 col-md-6">
            <div class="card shadow-3d">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="fa fa-upload"></i> User Image Upload</h6>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>Image File</label>
                        <input type="file" name="user_image" class="custom-file-input" id="user_image">

                        <div class="mt-2">
                            <img id="previewImage"
                                 src="{{ $user->user_image 
                                    ? asset('public/admin_resource/assets/images/user_image/'.$user->user_image) 
                                    : asset('no_image.png') }}"
                                 width="120" class="border rounded">
                        </div>

                        <small class="form-text text-muted">Allowed: JPG, JPEG, PNG (Max size: 5MB)</small>
                        <div class="invalid-feedback"></div>
                    </div>

                </div>
            </div>
        </div>

        <!-- SUBMIT BUTTON -->
        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-save"></i> Update User
            </button>
        </div>

    </div>
</form>

<!-- JS + Validation -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {

    // Preview Image
    $("#user_image").on("change", function () {
        let reader = new FileReader();
        reader.onload = function (e) {
            $("#previewImage").attr("src", e.target.result);
        };
        reader.readAsDataURL(this.files[0]);
    });

    // Validate Form
    $("#userEditForm").validate({
        rules: {
            user_type: { required: true },
            user_name: { required: true },
            email: { required: true, email: true },
            phone: { digits: true },
            "confirm-password": { equalTo: "#user_password" },
            roles: { required: true },
            user_image: {
                extension: "jpg|jpeg|png",
                filesize: 5 * 1024 * 1024
            }
        },
        messages: {
            user_type: "Please select a user type.",
            user_name: "Please enter a name.",
            email: "Please enter a valid email address.",
            roles: "Please select a role."
        },
        errorPlacement: function (error, element) {
            $(element).closest(".form-group").find(".invalid-feedback").html(error);
        },
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },

        submitHandler: function (form) {
            let formData = new FormData(form);

            $.ajax({
                url: $(form).attr("action"),
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function () {
                    $("button[type='submit']").prop("disabled", true).text("Updating...");
                },

                success: function (response) {
                    Swal.fire("Success!", "User updated successfully.", "success");
                },

                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`[name="${field}"]`).closest(".form-group")
                            .find(".invalid-feedback").html(errors[field][0]);
                        $(`[name="${field}"]`).addClass("is-invalid");
                    }
                },

                complete: function () {
                    $("button[type='submit']").prop("disabled", false)
                        .html('<i class="fa fa-save"></i> Update User');
                }
            });
        }
    });

    $.validator.addMethod("filesize", function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    });

});
</script>

</section>
@endsection
