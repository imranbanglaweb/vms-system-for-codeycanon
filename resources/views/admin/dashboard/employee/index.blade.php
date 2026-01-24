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
    border-radius: 3px;
    padding: 6px;
    cursor: move;
    background: linear-gradient(to bottom, #ffffff 0%, #f6f6f6 47%, #ededed 100%);
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

<div class="pull-left">
  <br>
  <h2>Employee Manage</h2>

</div>

@if(Session::get('success'))
<div class="alert alert-success myElem"><p>{{ Session::get('success') }}</p></div>
@endif

@if(Session::get('danger'))
<div class="alert alert-danger myElem"><p>{{ Session::get('danger') }}</p></div>
@endif

<section class="panel">
  <header class="panel-heading"></header>

  <div class="pull-right">
    <br>
    <br>
 
    @can('employee-create')
    <a class="btn btn-success" href="{{ route('employees.create') }}">
      <i class="fa fa-plus"></i> Add Employee
    </a>
       <br>
    <br>
    @endcan
  </div>

  <div class="panel-body">
    <table class="table table-bordered table-striped" id="myTable" style="width:100%">
      <thead>
        <tr>
          <th>No</th>
          <th>Photo</th>
          <th>Employee Code</th>
          <th>Name</th>
          <th>Unit</th>
          <th>Department</th>
          <th>Location</th>
          <th width="15%">Action</th>
        </tr>
      </thead>
    </table>
  </div>
</section>

</div>
</div>
</section>


<!-- JS Section -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery UI (sortable) -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<!-- Bootstrap 4 JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables -->
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

/* ========== SORTABLE ========== */
$(function(){
  $("#menu_list").sortable({
    stop: function(){
      $.map($(this).find('tr'), function(el) {
        $.ajax({
          url:'{{URL::to("order-menu")}}',
          type:'GET',
          data: {itemID: el.id, itemIndex: $(el).index()},
        });
      });
    }
  });
});

/* ========== DELETE MODAL ========== */
$(document).on('click', '.deleteUser', function(e){
    e.preventDefault();

    var e_id = $(this).data('eid');
    var urlTemplate = '{{ route("employees.destroy", "EMPID") }}';
    var deleteURL = urlTemplate.replace('EMPID', e_id);

    Swal.fire({
        title: 'Are you sure?',
        text: "This employee will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                url: deleteURL,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: '{{ csrf_token() }}'
                },
                success: function (res) {

                    Swal.fire(
                        'Deleted!',
                        res.message ?? 'Employee deleted successfully.',
                        'success'
                    );

                    // Refresh DataTable
                    $('#myTable').DataTable().ajax.reload();
                },
                error: function (xhr) {
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Please try again.',
                        'error'
                    );
                }
            });
        }
    });
});

/* ========== IMPORT / EXPORT SECTION ========== */
$('.select_employee_file').on('change', function(){
  $(".myDiv").hide();
  $("#show" + $(this).val()).show();
});

/* ========== DATATABLES SERVER-SIDE ========== */
$(document).ready(function(){
  $('#myTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("employees.index") }}',
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'photo', name: 'photo', orderable: false, searchable: false },
      { data: 'employee_code', name: 'employee_code' },
      { data: 'name', name: 'name' },
      { data: 'unit_name', name: 'unit.unit_name' },
      { data: 'department_name', name: 'department.department_name' },
      { data: 'location_name', name: 'location_name' },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    dom: 'Bfrtip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
  });
});
</script>

@endsection
