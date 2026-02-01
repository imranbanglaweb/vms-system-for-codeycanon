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
  .filter-section {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 15px;
    border: 1px solid #e9ecef;
  }
  .filter-section label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 5px;
  }
  .filter-section select, .filter-section input {
    border-radius: 5px;
  }
  .badge-hod {
    background: linear-gradient(135deg, #4f46e5, #4338ca);
    color: white;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 600;
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
    <!-- Advanced Filter Section -->
    <div class="filter-section">
      <div class="row">
        <div class="col-md-3">
          <label><i class="fa fa-search"></i> Search Employee</label>
          <input type="text" id="searchName" class="form-control" placeholder="Name or Employee Code">
        </div>
        <div class="col-md-3">
          <label><i class="fa fa-building"></i> Unit</label>
          <select id="filterUnit" class="form-control">
            <option value="">All Units</option>
          </select>
        </div>
        <div class="col-md-3">
          <label><i class="fa fa-briefcase"></i> Department</label>
          <select id="filterDepartment" class="form-control">
            <option value="">All Departments</option>
          </select>
        </div>
        <div class="col-md-3">
          <label><i class="fa fa-map-marker"></i> Location</label>
          <select id="filterLocation" class="form-control">
            <option value="">All Locations</option>
          </select>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-3">
          <label><i class="fa fa-user"></i> Employee Type</label>
          <select id="filterType" class="form-control">
            <option value="">All Types</option>
            <option value="Permanent">Permanent</option>
            <option value="Contract">Contract</option>
            <option value="Intern">Intern</option>
          </select>
        </div>
        <div class="col-md-3">
          <label><i class="fa fa-toggle-on"></i> Status</label>
          <select id="filterStatus" class="form-control">
            <option value="">All Status</option>
            <option value="Active">Active</option>
            <option value="Inactive">Inactive</option>
          </select>
        </div>
        <div class="col-md-3">
          <label><i class="fa fa-filter"></i> Department Head</label>
          <select id="filterHead" class="form-control">
            <option value="">All</option>
            <option value="yes">Head Only</option>
            <option value="no">Non-Head Only</option>
          </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
          <button type="button" id="btnFilter" class="btn btn-primary me-2">
            <i class="fa fa-filter"></i> Apply Filter
          </button>
          <button type="button" id="btnReset" class="btn btn-secondary">
            <i class="fa fa-refresh"></i> Reset
          </button>
        </div>
      </div>
    </div>

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
          <th>Status</th>
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

/* ========== LOAD FILTER DROPDOWNS ========== */
function loadFilterOptions() {
    // Load Units
    $.ajax({
        url: '{{ route("units.list") }}',
        type: 'GET',
        success: function(units) {
            $('#filterUnit').append('<option value="">All Units</option>');
            units.forEach(function(unit) {
                $('#filterUnit').append('<option value="'+unit.id+'">'+unit.unit_name+'</option>');
            });
        }
    });

    // Load Departments
    $.ajax({
        url: '{{ route("departments.list") }}',
        type: 'GET',
        success: function(departments) {
            $('#filterDepartment').append('<option value="">All Departments</option>');
            departments.forEach(function(dept) {
                $('#filterDepartment').append('<option value="'+dept.id+'">'+dept.department_name+'</option>');
            });
        }
    });

    // Load Locations
    $.ajax({
        url: '{{ route("locations.list") }}',
        type: 'GET',
        success: function(locations) {
            $('#filterLocation').append('<option value="">All Locations</option>');
            locations.forEach(function(loc) {
                $('#filterLocation').append('<option value="'+loc.id+'">'+loc.location_name+'</option>');
            });
        }
    });
}

loadFilterOptions();

/* ========== DATATABLES SERVER-SIDE ========== */
var table = $('#myTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '{{ route("employees.index") }}',
        type: 'GET',
        data: function(d) {
            d.search_name = $('#searchName').val();
            d.unit_id = $('#filterUnit').val();
            d.department_id = $('#filterDepartment').val();
            d.location_id = $('#filterLocation').val();
            d.employee_type = $('#filterType').val();
            d.status = $('#filterStatus').val();
            d.is_head = $('#filterHead').val();
        }
    },
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'photo', name: 'photo', orderable: false, searchable: false },
      { data: 'employee_code', name: 'employee_code' },
      { data: 'name', name: 'name' },
      { data: 'unit_name', name: 'unit.unit_name' },
      { data: 'department_name', name: 'department.department_name' },
      { data: 'location_name', name: 'location_name' },
      { data: 'status', name: 'status', orderable: false, searchable: false },
      { data: 'action', name: 'action', orderable: false, searchable: false }
    ],
    dom: 'Bfrtip',
    buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
});

/* ========== FILTER EVENTS ========== */
$('#btnFilter').on('click', function() {
    table.ajax.reload();
});

$('#btnReset').on('click', function() {
    $('#searchName').val('');
    $('#filterUnit').val('');
    $('#filterDepartment').val('');
    $('#filterLocation').val('');
    $('#filterType').val('');
    $('#filterStatus').val('');
    $('#filterHead').val('');
    table.ajax.reload();
});

// Enter key on search
$('#searchName').on('keypress', function(e) {
    if (e.which === 13) {
        table.ajax.reload();
    }
});

// Change events reload table
$('#filterUnit, #filterDepartment, #filterLocation, #filterType, #filterStatus, #filterHead').on('change', function() {
    table.ajax.reload();
});

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
                    table.ajax.reload();
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

</script>

@endsection
