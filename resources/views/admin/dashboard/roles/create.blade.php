@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Create New Role</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('roles.index') }}"> Back</a>
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


{!! Form::open(array('route' => 'roles.store','method'=>'POST')) !!}
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Name:</strong>
            {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
           
             <h3> <strong>General Permission:</strong> </h3>
                                     
            <ul style="list-style: none" class="permissions">
 
          
                            
                            <label> <input type="checkbox" class="selectall" value="Select All">Select All</label> / 
                            <label>
                                <input type="checkbox" class="deselect">Deselect All
                            </label>
                            
            @foreach($general_permissions as $list)

       <li>
                <label>
                    {{-- {{ Form::checkbox('', $list->permission_id, false, array('class' => 'permission-group')) }} --}}
                     <strong>{{ ucwords($list->table_name) }}</strong>
{{-- 
                        <input type="checkbox" id="permission-{{$list->table_name}}-sub" class="permission-group"> --}}
                 </label>
                 
            @foreach($permission as $value)

                &nbsp;&nbsp; &nbsp;&nbsp;
                 @if(empty($value->table_name))
                <label>
                     <input type="checkbox" id="permission-{{$value->id}}" name="permissions[]" class="the-permission checkbox_item" value="{{$value->id}}" data-table_name="{{$value->table_name}}">
                     {{ $value->name }}
                 </label>
            <br/>
                 @endif
            
            @endforeach
        
       </li>
            @endforeach
           
            <h3><strong>Permission : </strong> </h3>                           
      
 
            @foreach($table_lists as $list)

       <li>
                @if(!empty($list->table_name))
                &nbsp;&nbsp;&nbsp;&nbsp;<label>
                    {{-- {{ Form::checkbox('', $list->permission_id, false, array('class' => 'permission-group')) }} --}}
                     <strong>{{ ucwords($list->table_name) }}</strong>
{{-- 
                        <input type="checkbox" id="permission-{{$list->table_name}}-sub" class="permission-group"> --}}
                 </label>
                 <br/>
            @foreach($permission as $value)

            @if(!empty($list->table_name == $value->table_name))
                
                &nbsp;&nbsp; &nbsp;&nbsp;
                <label>
                    {{-- {{ Form::checkbox('permission[]', $value->id, false, array('class' => 'the-permission')) }} --}}
                     <input type="checkbox"  id="permission-{{$value->id}}" name="permissions[]" class="the-permission checkbox_item" value="{{$value->id}}">
                     {{ $value->name }}
                 </label>
            <br/>
            @endif
            @endforeach
            @endif
       </li>
            @endforeach
            </ul>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
{!! Form::close() !!}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script language="javascript">
// $(function(){

//     // add multiple select / deselect functionality
//     $(".selectall").click(function () {
//           $('.case').attr('checked', this.checked);
//     });

//     // if all checkbox are selected, check the selectall checkbox
//     // and viceversa
//     $(".case").click(function(){

//         if($(".case").length == $(".case:checked").length) {
         
//             $(".selectall").prop('checked', true);
//         } else {
//             $(".selectall").prop('checked', false);
//             // $(".selectall").removeAttr("checked");
//         }

//     });
// });

 // $(".selectall").click(function (e) {
 //    e.preventDefault();
 //    // $(this).closest('.a');
 //     // $('input:checkbox').not(this).closest('input:checkbox').prop('checked', this.checked);
 //     $('input:checkbox').not(this).prop('checked', this.checked);
 // });
</script>


<script type="text/javascript">

$(document).ready(function(){
    $('.selectall').on('click',function(){
        if(this.checked){
            $('.checkbox_item').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox_item').each(function(){
                this.checked = false;
            });
        }
    });
    
    // $('.checkbox_item').on('click',function(){
    //     if($('.checkbox:checked').length == $('.checkbox').length){
    //         $('.selectall').prop('checked',true);
    //     }else{
    //         $('.selectall').prop('checked',false);
    //     }
    // });
});

</script>

</section>
@endsection