@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add Menu</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('menus.index') }}"> Back</a>
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


{!! Form::open(array('route' => 'menus.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Menu Name:</strong>
            {!! Form::text('menu_name', null, array('placeholder' => 'Menu Name','class' => 'form-control')) !!}
        </div>
         <div class="form-group">
            <strong>Select Menu Parent:</strong> <br>

            <select class="form-control" name="menu_parent">
                <option value="0">Select Menu</option>
                @foreach($menus as $menu)
                <option value="{{$menu->id}}">{{$menu->menu_name}}</option>
                @endforeach
            </select>
        </div>
       <div class="row">
           <div class="col-md-6">
                 <div class="form-group">

            <select class="form-control menu_permission" name="menu_permission">
                <option value="0">Select Permission</option>
                @foreach($permission_lists as $list)
                <option value="{{$list->name}}">{{$list->name}}</option>
                @endforeach
            </select>
        </div>
           </div>
           <div class="col-md-6">
               <span>You Dont Have Permission Please Add</span><br><br><br>
               <a class="btn btn-primary"  href="{{ route('permissions.create')}}">Add Permission</a>
           </div>
       </div>
        <div class="form-group">
            <strong>Select Menu Location:</strong> <br>
           <label> <input class="menu_location_backend" type="checkbox" name="menu_type" value="backend"> Backend </label><br>
           <label> <input class="menu_location" type="checkbox" name="menu_type" value="frontend"> Frontend </label>
           
         
        </div>
        <div class="form-group menu_location_div">
            <strong>Menu Location:</strong> <br>

            <select class="form-control" name="menu_location">
                <option>Header</option>
                <option>Footer</option>
            </select>
         
           
         
        </div>

        <div class="form-group">
            <strong>Menu Icon</strong>
          <input class="form-control" type="text" name="menu_icon" placeholder="Enter Menu Icon">
        </div>

<div class="form-group">
            <strong>Menu Link</strong>
          <input class="form-control" type="text" name="menu_url" placeholder="Enter Menu URL">
        </div>

        <div class="form-group">
            <strong>Menu Status</strong>
           <select name="status" class="form-control">
               <option value="1">Active</option>
               <option value="0">In Active</option>
           </select>
        </div>
    </div>
{{--     <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Permission:</strong>
            <br/>
            @foreach($permission as $value)
                <label>{{ Form::checkbox('permission[]', $value->id, false, array('class' => 'name')) }}
                {{ $value->name }}</label>
            <br/>
            @endforeach
        </div>
    </div> --}}
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('.menu_permission').select2();
});

    $(".menu_location_div").hide();
$(".menu_location").click(function() {
    if($(this).is(":checked")) {

        $(".menu_location_div").show(300);
        $('.menu_location_backend').prop('checked', false); 
    } else {
        $(".menu_location_div").hide(200);
        $('.menu_location').prop('checked', false); 
    }
});

$(".menu_location_backend").click(function() {
    if($(this).is(":checked")) {
 $(".menu_location_div").hide();
        $('.menu_location').prop('checked', false); 
        $('.menu_location_backend').prop('checked', true); 
    } else {
        $(".menu_location_div").hide(200);
        $('.menu_location').prop('checked', false); 
    }
});


</script>
@endsection