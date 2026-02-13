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
.myDiv{
  display:none;
    padding:10px;
    margin-top:20px;
}  
</style>
<section role="main" class="content-body" style="background-color: #ffffff;">
    <div class="row">
        <div class="col-lg-12">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Employee Manage</h2>

    
              <div>
                <select class="form-control select_employee_file">
                  <option>Select Employee Export/Import</option>
                  <option value="Import">Import</option>
                  <option value="Export">Export</option>
                </select>
              </div>
          
<br>
          <div id="showImport" class="myDiv">
           <form action="{{ route('employee.import')}}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
              <input type="file" name="file" required=""><br>
               <button class="btn btn-info"><i class="fa fa-download" aria-hidden="true"></i> Import  </button>
           </form>
          </div>
         
          <br>
          <div id="showExport" class="myDiv">
              <form  method="POST" action="{{ route('employee.export')}}" enctype="multipart/form-data">
                 <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
              <button class="btn btn-success"><i></i> <i class="fa fa-file-excel-o" aria-hidden="true"></i>  Export
            </button>
             </form>
          </div>

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
                            <div class="pull-left">
                              @can('employee-create')
                              <a class="btn btn-success" href="{{ route('employees.create') }}"> <i class="fa fa-plus"></i>    Add Employee</a>
                              @endcan
                            </div>
                            <div class="panel-body">
    <table class="table table-bordered table-striped mb-none" id="myTable" style="width:100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Employee Id</th>
          <th>Name</th>
          <th>Unit Name</th>
          <th>Department Name</th>
          <th>Location Name</th>
          <th width="15%">Action</th>
        </tr>
      </thead>
      <tbody>
        @isset($employee_lists)
          @foreach ($employee_lists as $key => $list)
            <tr id="{{ $list->id }}">
              <td>{{ $loop->iteration }}</td>
              <td>{{ $list->employee_id }}</td>
              <td>{{ $list->employee_name }}</td>
              <td>{{ $list->unit_name }}</td>
              <td>{{ $list->department_name }}</td>
              <td>{{ $list->location_name }}</td>
              <td>
                <a class="btn btn-primary" href="{{ route('employees.edit', $list->id) }}"><i class="fa fa-edit"></i></a>
                <button class="btn btn-danger deleteUser" data-eid="{{ $list->id }}"><i class="fa fa-minus-circle"></i></button>
              </td>
            </tr>
          @endforeach
        @endisset
      </tbody>
    </table>
</section>
</div>
</div>
</div>
</section>
<div id="applicantDeleteModal" class="modal modal-danger" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog" style="width:55%;">
    <div class="modal-content">

      {{-- Use a simple form and set its action dynamically in JS to avoid referencing $list outside the loop --}}
      <form id="applicantDeleteForm" method="POST" action="{{ route('employees.destroy', ['employee' => 'EMPID']) }}" style="display:inline">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title text-center" id="custom-width-modalLabel">
          Delete Employee</h4>
        </div>
        <div class="modal-body">
          <h4 class="text-center text-danger">Are You Sure Delete Employee</h4>
          <input type="hidden" name="e_id" id="e_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger waves-effect remove-data-from-delete-form">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>
</section>
{{-- <script  src="{{ asset('js/')}}/function.js"></script> --}}
<!-- jQuery & jQueryUI (kept) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<!-- DataTables & Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>


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

  <script>

$(document).on('click','.deleteUser',function(){
  var e_id = $(this).attr('data-eid');
  $('#e_id').val(e_id);
  // Build the delete URL by replacing the EMPID placeholder in the Blade-generated template
  var urlTemplate = '{{ route("employees.destroy", ["employee" => "EMPID"]) }}';
  var url = urlTemplate.replace('EMPID', e_id);
  $('#applicantDeleteForm').attr('action', url);
  $('#applicantDeleteModal').modal('show');
});


$(document).ready(function(){


  $('.select_employee_file').on('change', function(){
    var demovalue = $(this).val(); 
    // alert(demovalue);
    $(".myDiv").hide();
    $("#show"+demovalue).show();
  });
});


</script>

<script>
$(document).ready(function(){
  // Initialize DataTable with server-side processing
  var table = $('#myTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '{{ route("employees.index") }}',
      type: 'GET'
    },
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'employee_code', name: 'employee_code' },
      { data: 'name', name: 'name' },
      { data: 'unit_name', name: 'unit.unit_name' },
      { data: 'department_name', name: 'department.department_name' },
      { data: 'location_name', name: 'location_name', orderable: false, searchable: false },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    order: [[1, 'asc']],
    dom: 'Bfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ]
  });

  // Rebind delete button after table draw
  $('#myTable').on('click', '.deleteUser', function(){
    var e_id = $(this).attr('data-eid');
    $('#e_id').val(e_id);
    var urlTemplate = '{{ route("employees.destroy", ["employee" => "EMPID"]) }}';
    var url = urlTemplate.replace('EMPID', e_id);
    $('#applicantDeleteForm').attr('action', url);
    $('#applicantDeleteModal').modal('show');
  });
});
</script>
@endsection