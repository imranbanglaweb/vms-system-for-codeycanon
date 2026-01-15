@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Assign Project Department</h2>
        </div>
  
    </div>
</div>
<meta name="csrf-token" content="{{ csrf_token() }}">

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


{!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'department_add')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">


<div class="col-md-4">
          <div class="form-group">
            <strong>Location  Name:</strong>
        <select class="location_list form-control location_id" name="location_id">
          
          @foreach($location_lists as $location_list)
              <option value="{{ $location_list->id}}">{{ $location_list->location_name}}</option>
          @endforeach
        </select>
        </div>
</div>
<div class="col-md-4">
        <div class="form-group">
     <label> Department List</label>
<br>
              @foreach($department_lists as $d_list)

<ul style="list-style: none">
    <li><label><input type="checkbox" name="department_id" value="{{ $d_list->id}}">{{ $d_list->department_name}}</label></li>
</ul>
 @endforeach

             

      </div>
</div>
    </div>
{{-- <div class="col-md-4">
  <h2 style="display: none" class="unit_display">Unit</h2>
   <ul style="display: inline-block; list-style: none;" class="show_unit_name"></ul>
</div> --}}
<div class="col-md-4">
  <h2 style="display: none" class="location_display">Unit Wise Location</h2>
   <ul style="display: inline-block; list-style: none;" class="show_location_name"></ul>
   <ul style="display: inline-block; list-style: none;" class="show_location_name_add"></ul>
</div>
<div class="col-md-4">
  <h2 style="display: none"  class="department_display">Department</h2>
   <ul style="display: inline-block; list-style: none;" class="show_department_name"></ul>
</div>
<div class="col-md-4">
  <h2></h2>
  <br>
   <ul style="display: inline-block; list-style: none;" class="show_department_name_add"></ul>
</div>


    <div class="col-xs-12 col-sm-12 col-md-12">
      <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>



</div>
{!! Form::close() !!}
</section>

{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
  <script src="{{ asset('public/admin_resource/')}}/assets/vendor/jquery/jquery.js"></script>
<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> --}}
<!-- Script -->
{{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> --}}
<script>

$(document).ready(function() {

     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  // daagnumbers_with_land_quantity

$(".unit_wise_location").on("change",function () {

// $(".location_list").on("change",function () {

$(".location_list").change(function () {
             var location_id = $(this).val();
            // var emp_name = $(this).html();
             var unit_id     =  $('.unit_id').find('option:selected').val();
            // alert(location_id);

            $.ajax({
                type: 'POST',
                url: "{{ route('location-wise-department')}}",
                data: { location_id},
// alert(JSON.stringify(data));
                dataType: 'json',
                success: function (data) {     
                // alert(data); 

           $.each(data['location_list_add'], function (key, location_list_add) {

// if (location_list_add.id = location_id) {

//   alert('Data Already Exits');
//   return false;

// }
 var li = $('<li> <input type="checkbox"  name="location_id[]" id="' + location_list_add.id + '" value="'+ location_list_add.id +'"/>' +
               '<label for="' + location_list_add.id + '"></label></li>');
    li.find('label').text(location_list_add.location_name);
    $('.show_location_name_add').append(li);

                    });

           // $.each(data['department_list_add'], function (key, department_list_add) {

           //  $('.department_list').append("<option   value='" + department_list_add.id + "'>" + department_list_add.department_name +"</option>");

           //          });

                 

// $('.landcategory').val("<option value='"+data.cat_id+"'>" + data.category +"</option>");
           
                },
                error: function (_response) {
                    alert("error");
                }

            });

    });



// department add
$(".department_list").on("change",function () {
// $(".department_list").change(function () {
             var department_id = $(this).val();
            // alert(department_id);

            $.ajax({
                type: 'POST',
                {{-- url: "{{ route('add-department-to-location')}}", --}}
                url: "{{ route('department-wise-user')}}",
                data: {department_id},
// alert(JSON.stringify(data));
                dataType: 'json',
                success: function (data) {     
                // alert(data.department_exits); 
     
             if (data.department_exits  > 0) {
                      Swal.fire({
                        type: 'error',
                        title: 'This Department Already Exits',
                        icon: 'error',
                        // showCloseButton: true,
                        // showCancelButton: true,
                        focusConfirm: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                       

                      })

                    $('.department_list').select2("val", "");

                      return false;
                 } 

        $(".show_department_name_add").empty();

        // $('.department_list').prepend("<option value=''>" +'Please Select'+"</option>");

          $.each(data['department_list_add'], function (key, department_list_add) {
 var li = $('<li> <input type="checkbox"  name="department_id[]" id="' + department_list_add.id + '" value="'+ department_list_add.id +'"/>' +
               '<label for="' + department_list_add.id + '"></label></li>');
              // alert(department_list_add.department_name)
    li.find('label').text(department_list_add.department_name);

    // if (department_list_add.id = department_id ) {

                  $('.show_department_name_add').append(li);
                  $('.department_display').show();
                  // $('.department_list').select2("val", "");


                    });
                 
           
                },
                error: function (_response) {
                    alert("error");
                }

            });

    });




});



</script>
@endsection