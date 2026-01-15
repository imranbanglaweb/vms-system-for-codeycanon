@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Assign Employee</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('departments.index') }}"> Back</a>
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
            <strong>Employee ID:</strong>
             <select class="form-control select2 employee_id" name="employee_id">
              <option>Please Select</option>
             @foreach($employee_lists as $list)
             <option value="{{ $list->employee_id}}">{{ $list->employee_name}} -- {{ $list->employee_id}}</option>
             @endforeach
           </select>
        </div>
      </div>


<div class="col-md-4">
          <div class="form-group">
            <strong>Unit  Name:</strong>
           <select class="form-control unit_wise_location select2 unit_id" multiple="multiple">
             <option value="">Unit Name</option>
             @foreach($units as $unit)
             <option value="{{ $unit->id}}">{{ $unit->unit_name}}</option>
             @endforeach
           </select>
        </div>
</div>
{{-- <div class="col-md-3">
          <div class="form-group">
            <strong>Location  Name:</strong>
        <select class="location_list form-control location_id" name="location_id[]"></select>
        </div>
</div> --}}
<div class="col-md-4">
        <div class="form-group">
     <label> Department</label>
            <select class="department_list form-control  department_id">

{{--               <option selected="selected">ABC</option>
              <option selected="selected">CBD</option>
              <option>ECD</option>
              <option>FFFF</option> --}}
   {{--            @foreach($department_lists as $d_list)
                <option  value="{{ $d_list->id}}">{{ $d_list->department_name}}</option>
              @endforeach --}}
            </select>
            {{-- <input type="text" name="" class="show_department_name" value=""> --}}
             

      </div>
</div>
    </div>
<div class="col-md-4">
  <h2 style="display: none" class="unit_display">Unit</h2>
   <ul style="display: inline-block; list-style: none;" class="show_unit_name"></ul>
</div>
<div class="col-md-4">
  <h2 style="display: none" class="location_display">Unit Wise Locaion</h2>
   <ul style="display: inline-block; list-style: none;" class="show_location_name"></ul>
   <ul style="display: inline-block; list-style: none;" class="show_location_name_add"></ul>
</div>
<div class="col-md-4">
  <h2 style="display: none"  class="department_display">Department</h2>
   <ul style="display: inline-block; list-style: none;" class="show_department_name"></ul>
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
// department wise employee
$(".employee_id").on("change",function () {

            var emp_id = $(this).val();
            // var emp_name = $(this).html();

            // alert(emp_id);

            $.ajax({
                type: 'POST',
                url: "{{ route('employee-already-assigned')}}",
                data: { emp_id},
// alert(JSON.stringify(data));
                dataType: 'json',
                success: function (data) {     
                // alert(data); 
$('.unit_id').select2("val", "");
                 //  if (data  > 0) {
                 //      Swal.fire({
                 //        type: 'error',
                 //        title: 'This Employee Already Assigned',
                 //        icon: 'error',
                 //        // showCloseButton: true,
                 //        // showCancelButton: true,
                 //        focusConfirm: true,
                 //        allowOutsideClick: false,
                 //        allowEscapeKey: false,
                       

                 //      })

                 //    $('.employee_id').select2("val", "");

                 //      return false;
                 // }              

  // $('.department_wise_employee').empty();
                
                if (data.employee_exits) {
 $(".unit_display").empty();
                $(".location_display").empty();
                $(".department_display").empty();
                $(".show_department_name").empty();
                // $(".show_unit_name").empty();
                $(".show_location_name").empty();

        // $('.unit_id').prepend("<option value=''>" +'Please Select'+"</option>");

          $.each(data['unit_list'], function (key, unit_list) {

 var li = $('<li> <input type="checkbox" checked name="unit_id[]" id="' + unit_list.id + '" value="'+ unit_list.id +'"/>' +
               '<label for="' + unit_list.id + '"></label></li>');
    li.find('label').text(unit_list.unit_name);
    $('.show_unit_name').append(li);
            $('.unit_display').show();

                    });
                 
      $.each(data['location_list'], function (key, location_list) {

            // $('.location_list').append("<option value='" + location_list.id + "'>" + location_list.location_name +"</option>");

 var li = $('<li> <input type="checkbox" checked name="location_id[]" id="' + location_list.id + '" value="'+ location_list.id +'"/>' +
               '<label for="' + location_list.id + '"></label></li>');
    li.find('label').text(location_list.location_name);
    $('.show_location_name').append(li);
            $('.location_display').show();

                    });

        $.each(data['department_list'], function (key, department_list) {

 var li = $('<li> <input type="checkbox" checked name="department_id[]" id="' + department_list.id + '" value="'+ department_list.id +'"/>' +
               '<label for="' + department_list.id + '"></label></li>');
    li.find('label').text(department_list.department_name);
    $('.show_department_name').append(li);

                    });

  $.each(data['department_list_add'], function (key, department_list_add) {

            $('.department_list').append("<option   value='" + department_list_add.id + "'>" + department_list_add.department_name +"</option>");

                    });

                }

                else{


                   $(".unit_display").empty();
                $(".location_display").empty();
                $(".department_display").empty();
                $(".show_department_name").empty();
                $(".show_unit_name").empty();
                $(".show_location_name").empty();

        // $('.unit_id').prepend("<option value=''>" +'Please Select'+"</option>");

          $.each(data['unit_list'], function (key, unit_list) {

 var li = $('<li> <input type="checkbox"  name="unit_id[]" id="' + unit_list.id + '" value="'+ unit_list.id +'"/>' +
               '<label for="' + unit_list.id + '"></label></li>');
    li.find('label').text(unit_list.unit_name);
    $('.show_unit_name').append(li);
            $('.unit_display').show();

                    });
                 
      $.each(data['location_list'], function (key, location_list) {

            // $('.location_list').append("<option value='" + location_list.id + "'>" + location_list.location_name +"</option>");

 var li = $('<li> <input type="checkbox"  name="location_id[]" id="' + location_list.id + '" value="'+ location_list.id +'"/>' +
               '<label for="' + location_list.id + '"></label></li>');
    li.find('label').text(location_list.location_name);
    $('.show_location_name').append(li);
            $('.location_display').show();

                    });

        $.each(data['department_list'], function (key, department_list) {

 var li = $('<li> <input type="checkbox" name="department_id[]" id="' + department_list.id + '" value="'+ department_list.id +'"/>' +
               '<label for="' + department_list.id + '"></label></li>');
    li.find('label').text(department_list.department_name);
    $('.show_department_name').append(li);

                    });

  $.each(data['department_list_add'], function (key, department_list_add) {

            $('.department_list').append("<option   value='" + department_list_add.id + "'>" + department_list_add.department_name +"</option>");

                    });

                }

               

// $('.landcategory').val("<option value='"+data.cat_id+"'>" + data.category +"</option>");
           
                },
                error: function (_response) {
                    alert("error");
                }

            });

});


  // daagnumbers_with_land_quantity

$(".unit_wise_location").on("change",function () {
  // var unit_id =  $('.unit_wise_location').find('option:selected').val();
            var unit_id = $(this).val();
  var employee_id =  $('.employee_id').find('option:selected').val();
// alert(employee_id);

            $.ajax({
                type: 'GET',
                url: "{{ route('unit-wise-location')}}",
                data: { unit_id,employee_id},
// alert(JSON.stringify(data));
                dataType: 'json',
                success: function (data) {     
                // alert(data.RsDaagNumber);              



                  if (data.employee_exits > 0) {
 // $(".location_list").empty();
                 $(".show_location_name_add").empty();
                 $(".show_unit_name").empty();

        // $('.location_list').prepend("<option value=''>" +'Please Select'+"</option>");

                    $.each(data['location_list'], function (key, location_list) {

            // $('.location_list').append("<option value='" + location_list.id + "'>" + location_list.location_name +"</option>");

 var li = $('<li> <input type="checkbox" name="location_id[]" id="' + location_list.id + '" value="'+ location_list.id +'"/>' +
               '<label for="' + location_list.id + '"></label></li>');
    li.find('label').text(location_list.location_name);
    $('.show_location_name_add').append(li);
            $('.location_display').show();
   // $('.unit_id').select2("val", "");

                      // return false;
                    });

     $.each(data['unit_list'], function (key, unit_list) {

 var li = $('<li> <input type="checkbox" checked name="unit_id[]" id="' + unit_list.id + '" value="'+ unit_list.id +'"/>' +
               '<label for="' + unit_list.id + '"></label></li>');
    li.find('label').text(unit_list.unit_name);
    $('.show_unit_name').append(li);
            $('.unit_display').show();

                    });

                  }

                  else{

                    $(".show_location_name_add").empty();
                    $(".show_location_name").empty();
                 $(".show_unit_name").empty();

        // $('.location_list').prepend("<option value=''>" +'Please Select'+"</option>");

                    $.each(data['location_list'], function (key, location_list) {

            // $('.location_list').append("<option value='" + location_list.id + "'>" + location_list.location_name +"</option>");

 var li = $('<li> <input type="checkbox" name="location_id[]" id="' + location_list.id + '" value="'+ location_list.id +'"/>' +
               '<label for="' + location_list.id + '"></label></li>');
    li.find('label').text(location_list.location_name);
    $('.show_location_name_add').append(li);
            $('.location_display').show();
   // $('.unit_id').select2("val", "");

                      // return false;
                    });

     $.each(data['unit_list'], function (key, unit_list) {

 var li = $('<li> <input type="checkbox" checked name="unit_id[]" id="' + unit_list.id + '" value="'+ unit_list.id +'"/>' +
               '<label for="' + unit_list.id + '"></label></li>');
    li.find('label').text(unit_list.unit_name);
    $('.show_unit_name').append(li);
            $('.unit_display').show();

                    });
                  }
                

// $('.landcategory').val("<option value='"+data.cat_id+"'>" + data.category +"</option>");
           
                },
                error: function (_response) {
                    alert("error");
                }

            });

    });


// $(".location_list").on("change",function () {

$(".location_list").change(function () {
             var location_id = $(this).val();
            // var emp_name = $(this).html();
             var unit_id     =  $('.unit_id').find('option:selected').val();
             var employee_id =  $('.employee_id').find('option:selected').val();
            // alert(unit_id);

            $.ajax({
                type: 'GET',
                url: "{{ route('employee-already-assigned')}}",
                data: { employee_id,unit_id,location_id},
// alert(JSON.stringify(data));
                dataType: 'json',
                success: function (data) {     
                // alert(data); 
     

        $(".show_department_name").empty();
        $(".department_list").empty();

        // $('.department_list').prepend("<option value=''>" +'Please Select'+"</option>");


           $.each(data['department_list'], function (key, department_list) {

 var li = $('<li> <input type="checkbox" checked name="department_id[]" id="' + department_list.id + '" value="'+ department_list.id +'"/>' +
               '<label for="' + department_list.id + '"></label></li>');
    li.find('label').text(department_list.department_name);
    $('.show_department_name').append(li);

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
  var employee_id =  $('.employee_id').find('option:selected').val();
            // alert(department_id);

            $.ajax({
                type: 'POST',
                {{-- url: "{{ route('add-department-to-location')}}", --}}
                url: "{{ route('employee-already-assigned')}}",
                data: {department_id,employee_id},
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

        // $(".show_department_name").empty();

        // $('.department_list').prepend("<option value=''>" +'Please Select'+"</option>");

          $.each(data['department_list_add'], function (key, department_list_add) {
 var li = $('<li> <input type="checkbox"  name="department_id[]" id="' + department_list_add.id + '" value="'+ department_list_add.id +'"/>' +
               '<label for="' + department_list_add.id + '"></label></li>');
              // alert(department_list_add.department_name)
    li.find('label').text(department_list_add.department_name);

    // if (department_list_add.id = department_id ) {

                  $('.show_department_name').append(li);
                  $('.department_display').show();
                  $('.department_list').select2("val", "");


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




});


   $('#department_add').submit(function(e) {

       e.preventDefault();

       var unit_id  = $('.unit_id').val();
       var department_name  = $('.department_name').val();
       // alert(company_name);

       if (department_name  == '') {
            Swal.fire({
              type: 'warning',
              title: 'Please Enter Department Name',
              icon: 'warning',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
              allowEscapeKey: false,

            })
       }

       // else if (department_name  == '') {
       //      Swal.fire({
       //        type: 'warning',
       //        title: 'Please Enter Department Name',
       //        icon: 'warning',
       //        // showCloseButton: true,
       //        // showCancelButton: true,
       //        focusConfirm: false,
       //        allowOutsideClick: false,
       //        allowEscapeKey: false,

       //      })
       // }
       let formData = new FormData(this);
       $('#image-input-error').text('');

       $.ajax({
          type:'POST',
            url:"{{ route('assign-employee.store') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {

             Swal.fire({
            html: '<span style="color:green">Assign Employee Added</span>',
            icon: 'success',
            type: 'success',
            title: 'Assign Employee Added',
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


</script>
@endsection