@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Update Your Profile</h2>
        </div>
      {{--   <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('menus.index') }}"> Back</a>
        </div> --}}
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



    <!-- start: page -->

                    <div class="row">
                     
                        <div class="col-md-8 col-lg-12">

                            <div class="tabs">
                                <ul class="nav nav-tabs tabs-primary">
                                    <li class="active">
                                        <a href="#overview" data-toggle="tab">Overview</a>
                                    </li>
                                    <li>
                                        <a href="#edit" data-toggle="tab">Edit</a>
                                    </li>
                                    <li>
                                        <a href="#change_password" data-toggle="tab">Change Password</a>
                                    </li>

                                </ul>
                                <div class="tab-content">
                                    <div id="overview" class="tab-pane active">
                                        <h4 class="mb-md">Profile Status</h4>

                                        <section class="simple-compose-box mb-xlg">
                                            <form method="get" action="/">
                                                <textarea name="message-text" data-plugin-textarea-autosize placeholder="What's on your mind?" rows="1">{{Auth::user()->name}}</textarea>
                                            </form>
                                      
                                        </section>

                                      
                                    </div>
                                    <div id="edit" class="tab-pane">

                                        {!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'profile_update')) !!}
                                            <h4 class="mb-xlg">Personal Information</h4>
                                            <fieldset>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileFirstName"> Name</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="profileFirstName" name="user_name" value="{{Auth::user()->name}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileLastName">Email</label>
                                                    <div class="col-md-8">
                                                        <input type="text" class="form-control" id="profileLastName" name="email" value="{{Auth::user()->email}}">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileLastName">Photo</label>
                                                    <div class="col-md-8">
                                                        <input type="file" class="form-control" id="profileLastName" name="user_image" onchange="previewFile(this);">
                                                    </div>

                                                    @php
                                                        $userImage = Auth::user()->user_image;
                                                        $imagePath = public_path('public/admin_resource/assets/images/user_image/' . $userImage);
                                                        $imageUrl = asset('public/admin_resource/assets/images/default.png');

                                                        if (!empty($userImage) && file_exists($imagePath)) {
                                                            $imageUrl = asset('public/admin_resource/assets/images/user_image/' . $userImage);
                                                        }
                                                    @endphp
                                                     <img id="previewImg" src="{{ $imageUrl }}" width="100" height="100" onerror="this.onerror=null;this.src='{{ asset('public/admin_resource/assets/images/default.png') }}'">
                                                </div>
                                             
                                            </fieldset>
                                                <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-md-9 col-md-offset-3">
                                                        <button  class="btn btn-primary">Submit</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                      {!! Form::close() !!}

                                        </div>

                                    <div id="change_password" class="tab-pane">
                                      {!! Form::open(array('method'=>'POST', 'id'=>'profile_password_update')) !!}
                                            <h4 class="mb-xlg">Change Password</h4>
                                            <fieldset class="mb-xl">
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileNewPassword">New Password</label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control user_password" id="profileNewPassword" name="password">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-3 control-label" for="profileNewPasswordRepeat">Repeat New Password</label>
                                                    <div class="col-md-8">
                                                        <input type="password" class="form-control user_password_confirm" id="profileNewPasswordRepeat"  name="confirm-password"  autocomplete="new-password">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-md-9 col-md-offset-3">
                                                        <button  class="btn btn-primary">Submit</button>
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                     {!! Form::close() !!}


                                    </div>
                                </div>
                            </div>
                        </div>
                    

                    </div>
                    <!-- end: page -->

</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


   $('#profile_update').submit(function(e) {

       e.preventDefault();
       let formData = new FormData(this);
       $('#image-input-error').text('');

       $.ajax({
          type:'POST',
            url:"{{ route('profile-update') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {
              Swal.fire({
            html: '<span style="color:green">Information Updated</span>',
            icon: 'success',
             type: 'success',
              title: 'Setting Edit',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
                allowEscapeKey: false,
             
            }).then((data) => {
                   if(data){
                     // Do Stuff here for success
                     location.reload();
                   }else{
                    // something other stuff
                   }

                })

               $('.saved').html('Saved');
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
           }
       });
  });


   $('#profile_password_update').submit(function(e) {
       e.preventDefault();

       let user_password = $('.user_password').val();
       let user_password_confirm = $('.user_password_confirm').val();

      if(user_password == ""){
         Swal.fire({
            icon: 'warning',
            type: 'error',
            title: 'Enter Password',
              // showCloseButton: true,
              // showCancelButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
             
            });
         $('.user_password').focus();



  return false;

}
else if (user_password_confirm == "") {
  Swal.fire({
            icon: 'warning',
            type: 'error',
            title: 'EnterConfirm Password',
              // showCloseButton: true,
              // showCancelButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
             
            });
    return false;

}

else{
    if (user_password !== user_password_confirm) {

          Swal.fire({
            icon: 'warning',
            type: 'error',
            title: 'Password Doesnt Match',
              // showCloseButton: true,
              // showCancelButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
             
            });
            return false;

    }
}
       $.ajax({
          type:'POST',
            url:"{{ route('profile-password-update') }}",
            data: $('#profile_password_update').serialize(),

           success: (response) => {
              Swal.fire({
            html: '<span style="color:green">Password Updated</span>',
            icon: 'success',
            type: 'success',
            title: 'Password Edit',
              // showCloseButton: true,
              // showCancelButton: true,
            focusConfirm: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
             
            }).then((data) => {
                   if(data){
                     // Do Stuff here for success
                    //  location.reload();
                     window.location.href = response.redirect;
                   }else{
                    // something other stuff
                   }

                })

               $('.saved').html('Saved');
           },
           error: function(response){
              console.log(response);
                $('#image-input-error').text(response.responseJSON.errors.file);
           }
       });
  });

     function previewFile(input){
        var file = $("input[type=file]").get(0).files[0];
 
        if(file){
            var reader = new FileReader();
 
            reader.onload = function(){
                $("#previewImg").attr("src", reader.result);
            }
 
            reader.readAsDataURL(file);
        }
    }

</script>
@endsection