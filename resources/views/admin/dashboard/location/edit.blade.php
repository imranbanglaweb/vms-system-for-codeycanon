@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2> Location Edit</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('locations.index') }}"><i class="fa fa-arrow-left"></i>  Back</a>
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


{!! Form::open(array('method'=>'POST','enctype'=>'multipart/form-data', 'id'=>'location_edit')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">


      <div class="form-group">
            <strong>Unit  Name:</strong>
           <select class="form-control unit_wise_company unit_id" name="unit_id">

             @foreach($units as $unit)
             <option @if($unit->id == $location_edit->unit_id )  {{'selected' }} @endif value="{{ $unit->id}}">{{ $unit->unit_name}}</option>
             @endforeach
           </select>
        </div>
{{--       <div class="form-group">
            <strong>Department  Name:</strong>
           <select class="form-control department_lists" name="department_id">
             @foreach($department_lists as $list)
             <option @if($list->id == $location_edit->department_id) {{ 'selected'}}  @endif value="{{ $list->id}}">{{ $list->department_name}}</option>
             @endforeach
           </select>
        </div> --}}
        <div class="form-group">
            <strong>Location Name:</strong>
            {!! Form::text('location_name', $location_edit->location_name, array('placeholder' => 'Location Name','class' => 'form-control location_name ','focus'=>'focus')) !!}
            <input type="hidden" name="id" value="{{ $location_edit->id }}">
        </div>
        <div class="form-group">
            <strong>Location Address:</strong>
            {!! Form::textarea('address', $location_edit->address, array('placeholder' => 'Location Address','class' => 'form-control address ','focus'=>'focus')) !!}
            <input type="hidden" name="id" value="{{ $location_edit->id }}">
        </div>



    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
      <br>
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>

{!! Form::close() !!}

</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
      CKEDITOR.replace( 'textarea' );
  </script>
<script>
// In your Javascript (external.js resource or <script> tag)
$(document).ready(function() {
    $('.service_select2').select2();
});
</script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


// unit change: populate departments (and companies if needed) for location edit form
$(document).ready(function(){
  $(document).on('change', '.unit_wise_company', function () {
    var unit_id = $(this).val();

    // departments
    $.ajax({
      type: 'GET',
      url: "{{ route('unit-wise-department') }}",
      data: { unit_id: unit_id },
      dataType: 'json',
        success: function (data) {
        console.log('unit-wise-department (location.edit) response:', data);
        if ($('.department_lists').data('select2')) {
          try { $('.department_lists').select2('destroy'); } catch(e) { console.warn('select2 destroy failed', e); }
        }
        if ($('.department_name').data('select2')) {
          try { $('.department_name').select2('destroy'); } catch(e) { console.warn('select2 destroy failed', e); }
        }
        var prevLists = $('.department_lists').val();
        var prevName = $('.department_name').val();
        if ($('.department_lists').length) {
          $(".department_lists").empty().append("<option value=''>Please Select</option>");
          $.each(data['department_list'] || [], function (k, d) {
            $('.department_lists').append("<option value='" + d.id + "'>" + d.department_name + "</option>");
          });
          if (prevLists) { $('.department_lists').val(prevLists); }
          $('.department_lists').trigger('change');
        }
        if ($('.department_name').length) {
          $(".department_name").empty().append("<option value=''>Please Select</option>");
          $.each(data['department_list'] || [], function (k, d) {
            $('.department_name').append("<option value='" + d.id + "'>" + d.department_name + "</option>");
          });
          if (prevName) { $('.department_name').val(prevName); }
          $('.department_name').trigger('change');
        }
      },
      error: function (xhr, status, err) {
        console.error('Error loading departments for unit', unit_id, status, err);
      }
    });

    // companies endpoint removed — not required in this project
  });
});




   $('#location_edit').submit(function(e) {

       e.preventDefault();

       // alert(unit_name);

        var unit_id  = $('.unit_id').val();
        var location_name  = $('.location_name').val();
       // alert(company_name);

       if (unit_id  == '') {
            Swal.fire({
              type: 'warning',
              title: 'Please Enter Location Name',
              icon: 'warning',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
              allowEscapeKey: false,

            })
       }

       else if (unit_id  == '') {
            Swal.fire({
              type: 'warning',
              title: 'Please Enter Unit Name',
              icon: 'warning',
              // showCloseButton: true,
              // showCancelButton: true,
              focusConfirm: false,
              allowOutsideClick: false,
              allowEscapeKey: false,

            })
       }
       let formData = new FormData(this);
       $('#image-input-error').text('');

       $.ajax({
          type:'POST',
            url:"{{ route('locations.store') }}",
           data: formData,
           contentType: false,
           processData: false,
           success: (response) => {

             Swal.fire({
            html: '<span style="color:green">Information Updated</span>',
            icon: 'success',
             type: 'success',
              title: 'Location Updated',
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