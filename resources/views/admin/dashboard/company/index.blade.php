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
            <h2>Company Manage</h2>
        </div>
        <div class="pull-right">
        @can('unit-create')
            <a class="btn btn-success" href="{{ route('company.create') }}"> <i class="fa fa-plus"></i>    Add Company</a>
            @endcan
        </div>
    </div>
</div>


@if ($message = Session::get('success'))
    <div class="alert alert-success myElem">
        <p>{{ $message }}</p>
    </div>
@endif
@if ($message = Session::get('danger'))
    <div class="alert alert-danger myElem">
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
     <th>Company Name</th>
     <th>Company Code</th>
     <th>Unit Name</th>
     <th width="">Action</th>
  </tr>
</thead>
  <tbody id="menu_list" class="" >
    @foreach ($companies as $key => $company)
    <tr  id="{{ $company->id }}">
        <td>{{ ++$key }}</td>
        <td >{{ $company->company_name }}</td>
        <td >{{ $company->company_code }}</td>
        <td >{{ $company->unit_name }}</td>
        <td>
          {{--   <a class="btn btn-info" href="{{ route('permissions.show',$permission->id) }}"> <i class="fa fa-eye"></i> Show</a> --}}
            @can('unit-edit')
                <a class="btn btn-primary" href="{{ route('company.edit',$company->c_id) }}"><i class="fa fa-edit"></i> Edit</a>
            @endcan
            @can('unit-delete')

                {!! Form::open(['method' => 'DELETE','route' => ['company.destroy', $company->c_id],'style'=>'display:inline']) !!}

                    <i class="fa fa-trash-o"></i> 
                     {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}

                   {{--   {{ Form::button('<i class="fa fa-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-warning btn-sm'] )  }} --}}

                {!! Form::close() !!}
            @endcan
        </td>
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
    $(".myElem").show().delay(5000).fadeOut();
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