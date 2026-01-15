@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">
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
            @foreach($employee_lists as $list)
                <option value="{{ $list->id}}">{{ $list->employee_name }} -- {{  $list->employee_id}}</option>
            @endforeach
            </select>
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
            <i class="fa fa-save"></i> Save Document
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
$(document).ready(function() {
    const form = $('#usertForm');
    
    // Initialize Select2 with proper configuration
    $('.select2-searchable').select2({
        theme: 'bootstrap4',
        width: '100%',
        placeholder: 'Select an option',
        allowClear: true,
        minimumResultsForSearch: 10,
    }).on('select2:open', function() {
        // Fix dropdown positioning if needed
        setTimeout(function() {
            $('.select2-search__field').focus();
        }, 10);
    });

    // Initialize validation
    form.validate({
        ignore: [], // Don't ignore hidden Select2 inputs
        rules: {
            // employee_id: "required",
            // user_type: "required",
            // user_name: "required",
            // email: "required",
            // password: "required",
            // roles: "required",
            // user_image: {
            //     required: false,  // Set true if file is mandatory
            //     extension: "jpg|jpeg|png|pdf|docx",
            //     filesize: 8 * 1024 * 1024  // 8MB limit
            // }
        },
        messages: {
            // employee_id: "Employee Name Field Required",
            // user_type: "User Type Field Required",
            // user_name: "User Name Field Required",
            // email: "required",
            // password: "required",
            // roles: "Please User Role",
            // user_image: {
            //     extension: "Allowed file types: jpg, jpeg, png, pdf, docx.",
            //             filesize: "File size must be less than 8MB."
            // }
        },
        errorElement: 'span',
        errorClass: 'invalid-feedback',
        validClass: 'valid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
            if ($(element).hasClass('select2-searchable')) {
                $(element).next('.select2-container')
                    .find('.select2-selection')
                    .addClass('is-invalid')
                    .removeClass('is-valid');
            }
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
            if ($(element).hasClass('select2-searchable')) {
                $(element).next('.select2-container')
                    .find('.select2-selection')
                    .removeClass('is-invalid')
                    .addClass('is-valid');
            }
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2-searchable')) {
                error.addClass('d-block');
                error.insertAfter(element.next('.select2-container'));
            } else {
                error.addClass('d-block');
                error.insertAfter(element);
            }
        }
    });

    // Handle form submission
    form.on('submit', function(e) {
        e.preventDefault();
        
        if (form.valid()) {
            submitForm($(this));
        }
    });

    // Move Select2 change handler inside document ready
    $('.select2-searchable').on('change', function() {
        $(this).valid();
        $(this).next('.select2-container').removeClass('is-invalid');
        $(this).next('.select2-container').next('.error').remove();
    });

    // Custom file input handler
    // $(".custom-file-input").on("change", function() {
    //     let fileName = $(this).val().split("\\").pop();
    //     $(this).next(".custom-file-label").addClass("selected").html(fileName);
    //     form.submit(); // Submit the form when an image is selected
    // }).on('change', function(e) {
    //     // Mark event listener as passive
    //     e.preventDefault();
    // }, { passive: true });
});

// Keep submitForm function outside document ready
function submitForm($form) {
    const submitBtn = $form.find('button[type="submit"]');
    const originalText = submitBtn.html();

    let formData = new FormData($form[0]); // Create FormData object manually

    $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: formData,
        processData: false,  // Prevent jQuery from processing the data
        contentType: false,  // Prevent jQuery from setting the content type
        beforeSend: function() {
            submitBtn.html('<i class="fa fa-spinner fa-spin"></i> Processing...').prop('disabled', true);
        },
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload(); // Reload the same page
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: response.message || 'An error occurred'
                });
            }
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                Object.keys(errors).forEach(field => {
                    const element = $form.find(`[name="${field}"]`);
                    element.addClass('is-invalid');
                    element.next('.invalid-feedback').html(errors[field][0]);
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'An error occurred while saving the user'
                });
            }
        },
        complete: function() {
            submitBtn.html(originalText).prop('disabled', false);
        }
    });
}

 // Debugging: Log file details
//             $("#user_image").on("change", function() {
//                 let file = this.files[0];
//                 if (file) {
//                     console.log("Selected file:", file.name, "Size:", file.size);
//                 } else {
//                     console.log("No file selected.");
//                 }
//             });
// $.validator.addMethod("filesize", function(value, element, param) {
//     // Ensure the input element has 'files' and at least one file is selected
//     if (!element || !element.files || element.files.length === 0) {
//         return true; // No file selected, so it's valid
//     }

//     return element.files[0].size <= param;
// }, "File size must be less than {0}");

</script>
@endsection