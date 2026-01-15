@extends('admin.dashboard.master')

@section('main_content')
<br>
<br>
<section role="main" class="content-body" style="background-color: #f8f9fa;">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New User</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>
        </div>
    </div>
</div>

@if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif

<form id="usertForm" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Select Employee:</strong>
            <select name="employee_id" class="form-control select2 employee_id">
                <option value="">Please Select</option>
            @foreach($employees as $list)
                <option value="{{ $list->id}}">{{ $list->name }} -- {{  $list->employee_code}}</option>
            @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6">
    <div class="form-group">
        <strong>Select User Type:</strong>
        <select name="user_type" class="form-control select2 user_type">
            <option value="">Please Select</option>
                   <option value="normal_user">Normal User</option>
                   <option value="super_user">Super User</option>
                   <option value="admin">Admin</option>
                   <option value="department_head">Department Head</option>
            </select>
            <div class="invalid-feedback"></div>
    </div>
    </div>
      <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Name:</strong>
              <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter User name" autocomplete="username">
              <div class="invalid-feedback"></div>
        </div>
    </div>
      <div class="col-xs-6 col-sm-6 col-md-6">
         <div class="form-group">
            <strong>Email:</strong>
              <input type="text" class="form-control" id="user_email" name="email" placeholder="Enter User Email" autocomplete="email">
              <div class="invalid-feedback"></div>
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6">
          <div class="form-group">
            <strong>Phone Number:</strong>
              <input type="text" class="form-control" id="user_phone" name="phone" placeholder="Enter phone" autocomplete="tel">
              <div class="invalid-feedback"></div>
        </div>
    </div>
     <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Password:</strong>
        <input type="password" class="form-control" id="user_password" name="password" placeholder="Enter Password" autocomplete="new-password">
        </div>
    </div>
   <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Confirm Password:</strong>
              <input type="password" class="form-control" id="user_cpassword" name="confirm-password" placeholder="Enter Confirm Password" autocomplete="new-password">
        </div>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="form-group">
            <strong>Role:</strong>
             <select name="roles" class="form-control select2 roles">
          <option value="">Please Select</option>
                    @foreach($roles as $role)
                     <option value="{{$role->name}}">{{$role->name}}</option>
                    @endforeach
            </select>
            <div class="invalid-feedback"></div>
        </div>
    </div>
      <div class="col-xs-6 col-sm-6 col-md-6">
        <div class="card shadow-3d">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="fa fa-upload"></i> User Image Upload</h6>
                    </div>
                    <div class="card-body">
                       <div class="form-group">
                            <label>Image File</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="user_image" name="user_image">
                               {{--  <label class="custom-file-label" for="user_image">Choose file</label> --}}
                            </div>
                            <small class="form-text text-muted">
                                Allowed files: PDF, DOC, DOCX, XLS, XLSX (Max size: 5MB)
                            </small>
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
             </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Save User
        </button>
    </div>
</div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/additional-methods.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</section>
<script type="text/javascript">
$(document).ready(function () {

    
    $("#usertForm").validate({
        rules: {
            employee_id: { required: true },
            user_type: { required: true },
            user_name: { required: true },
            email: { required: true, email: true },
            phone: { required: true, digits: true, minlength: 10, maxlength: 15 },
            password: { required: true, minlength: 6 },
            "confirm-password": { required: true, equalTo: "#user_password" },
            roles: { required: true },
            user_image: { 
                required: true,
                extension: "jpg|jpeg|png",
                filesize: 5 * 1024 * 1024 // 5MB in bytes
            }
        },
        messages: {
            employee_id: "Please select an employee.",
            user_type: "Please select a user type.",
            user_name: "Please enter a name.",
            email: "Please enter a valid email address.",
            phone: "Please enter a valid phone number.",
            password: "Password must be at least 6 characters.",
            "confirm-password": "Passwords do not match.",
            roles: "Please select a role.",
            user_image: {
                required: "Please upload an image.",
                extension: "Only JPG, JPEG, and PNG files are allowed.",
                filesize: "File size must be less than 5MB."
            }
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
                    $("button[type='submit']").prop("disabled", true).text("Saving...");
                },
                success: function (response) {
                    Swal.fire("Success!", "User added successfully.", "success");
                    form.reset();
                    $(".is-invalid").removeClass("is-invalid");
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    for (let field in errors) {
                        $(`[name="${field}"]`).closest(".form-group").find(".invalid-feedback").html(errors[field][0]);
                        $(`[name="${field}"]`).addClass("is-invalid");
                    }
                },
                complete: function () {
                    $("button[type='submit']").prop("disabled", false).html('<i class="fa fa-save"></i> Save Document');
                }
            });
        }
    });

    // Custom file validation
    $.validator.addMethod("filesize", function (value, element, param) {
        return this.optional(element) || (element.files[0].size <= param);
    });
});

</script>
@endsection