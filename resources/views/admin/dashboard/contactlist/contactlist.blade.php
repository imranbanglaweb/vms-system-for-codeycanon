@extends('admin.dashboard.master')


@section('main_content')
<style>
  #menu_list {
  padding: 0px;
}
#menu_list td {
  list-style: none;
  margin-bottom: 10px;
  border: 1px solid #d4d4d4;
      -webkit-border-radius: 3px;
      -moz-border-radius: 3px;
      border-radius: 3px;
      border-color: #D4D4D4 #D4D4D4 #BCBCBC;
      padding: 6px;
      cursor: move;
      background: #f6f6f6;
      background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #ededed 100%);
      background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffffff), color-stop(47%,#f6f6f6), color-stop(100%,#ededed));
      background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
      background: -o-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
      background: -ms-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
      background: linear-gradient(to bottom,  #ffffff 0%,#f6f6f6 47%,#ededed 100%);
      filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
}
</style>
<section role="main" class="content-body">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Contact  List</h2>
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
@if ($message = Session::get('danger'))
    <div class="alert alert-danger">
        <p>{{ $message }}</p>
    </div>
@endif

<section class="panel">
                            <header class="panel-heading">
                                <div class="panel-actions">
                                    <a href="#" class="fa fa-caret-down"></a>
                                    <a href="#" class="fa fa-times"></a>
                                </div>
                        
                               
                            </header>
                            <div class="panel-body">
    <table class="table table-bordered table-striped mb-none" id="datatable-default">
<thead>
      <tr>
     <th>No</th>
     <th>Name</th>
     <th>Mobile</th>
     <th>Email</th>
     {{-- <th>Message</th> --}}
     <th width="">Action</th>
  </tr>
</thead>
  <tbody id="menu_list" class="" >
    @foreach ($contact_list_views as $key => $list)



    <tr  id="{{ $list->id }}">
        <td>{{ ++$key }}</td>
        <td >{{ $list->contact_name }}</td>
        <td >{{ $list->contact_mobile }}</td>
        <td >{{ $list->contact_email }}</td>
        {{-- <td >{{ $list->contact_content }}</td> --}}
        <td>
        {{-- <td> --}}

          {{--   <a class="btn btn-info" href="{{ route('permissions.show',$permission->id) }}"> <i class="fa fa-eye"></i> Show</a> --}}
  
            @can('contact-delete')
                {!! Form::open(['method' => 'DELETE','route' => ['contactlistviewdelete', $list->id],'style'=>'display:inline']) !!}
                    <i class="fa fa-trash-o"></i> 
                     {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                {!! Form::close() !!}
            @endcan
          </td>
        {{-- </td> --}}
    </tr>



    @endforeach
  </tbody>
</table>
</section>
</div>
</div>
</div>
</section>

</section>
{{-- <script  src="{{ asset('js/')}}/function.js"></script> --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
    $(function(){
      $("#menu_list").sortable({
        stop: function(){
          $.map($(this).find('tr'), function(el) {
            var itemID = el.id;
            var itemIndex = $(el).index();
            // alert(itemIndex);
            $.ajax({
              url:'{{URL::to("order-menu")}}',
              type:'GET',
              dataType:'json',
              data: {itemID:itemID, itemIndex: itemIndex},
            })
          });
        }
      });
    });
  </script>
@endsection