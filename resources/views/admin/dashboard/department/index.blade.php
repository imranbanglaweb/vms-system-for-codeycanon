@extends('admin.dashboard.master')

@section('main_content')

<section role="main" class="content-body" style="background-color:#f1f4f8;">
    <br>
    <br>
    <br>
<div class="container">
    <h3>Departments Manage</h3>
    <button class="btn btn-success mb-3" id="addNew"><i class="fa fa-plus"></i> Add Department</button>
<table id="departmentsTable" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Unit</th>
            <th>Name</th>
            <th>Code</th>
            <th>Short Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
</table>
</div>
<!-- Modal -->

<div class="modal" id="deptModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deptForm">
        <div class="modal-header">
          <h5 class="modal-title">Department</h5>
          <button type="button" class="btn-close pull-right btn-danger" data-bs-dismiss="modal">Close</button>
          <br>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id" id="deptId">
            <div class="mb-3">
                <label>Unit</label>
                <select name="unit_id" id="unit_id" class="form-select select2">
                    <option value="">Select Unit</option>
                    @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="department_name" id="department_name" class="form-control">
            </div>
            <div class="mb-3">
                <label>Code</label>
                <input type="text" name="department_code" id="department_code" class="form-control">
            </div>
            <div class="mb-3">
                <label>Short Name</label>
                <input type="text" name="department_short_name" id="department_short_name" class="form-control">
            </div>
            <div class="mb-3">
                <label>Location</label>
                <input type="text" name="location" id="location" class="form-control">
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>
            <div class="mb-3">
                <label>Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="submit">Save</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>
</section>
@endsection

@push('scripts')

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
$(function(){
    var table = $('#departmentsTable').DataTable({
        processing:true,
        serverSide:true,
        ajax: "{{ route('departments.data') }}",
        columns:[
            {data:'id', name:'id'},
            {data:'unit_name', name:'unit_name'},
            {data:'department_name', name:'department_name'},
            {data:'department_code', name:'department_code'},
            {data:'department_short_name', name:'department_short_name'},
            {data:'status', name:'status', render:function(d){ return d==1 ? 'Active':'Inactive'; }},
            {data:'action', name:'action', orderable:false, searchable:false}
        ]
    });

    // Add New
    $('#addNew').click(function(){
        $('#deptForm')[0].reset();
        $('#deptId').val('');
        $('#deptModal').modal('show');
    });

    // Edit
    $(document).on('click','.editBtn', function(){
        var id = $(this).data('id');
        $.get("departments/"+id+"/edit", function(data){
            $('#deptId').val(data.id);
            $('#unit_id').val(data.unit_id);
            $('#department_name').val(data.department_name);
            $('#department_code').val(data.department_code);
            $('#department_short_name').val(data.department_short_name);
            $('#location').val(data.location);
            $('#description').val(data.description);
            $('#status').val(data.status);
            $('#deptModal').modal('show');
        }).fail(function(){
            Swal.fire('Error','Failed to load department data.','error');
        });
    });

    // Save form (Add/Edit)
    $('#deptForm').off('submit').on('submit', function(e){
        e.preventDefault();
        var id = $('#deptId').val();
        var url = id ? "departments/"+id : "{{ route('departments.store') }}";
        var method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: method,
            data: $(this).serialize(),
            success: function(res){
                Swal.fire('Success', res.message, 'success');
                $('#deptModal').modal('hide');
                table.ajax.reload();
            },
            error: function(xhr){
                let errors = xhr.responseJSON?.errors;
                let msg = xhr.responseJSON?.message || 'Validation failed';
                if(errors){
                    msg = Object.values(errors).flat().join('<br>');
                }
                Swal.fire('Error', msg, 'error');
            }
        });
    });

    // Delete
    $(document).on('click','.deleteBtn', function(){
        var id = $(this).data('id');
        Swal.fire({
            title:'Delete Department?',
            icon:'warning',
            showCancelButton:true,
            confirmButtonText:'Yes, Delete'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    url:"departments/"+id,
                    type:'DELETE',
                    success:function(res){
                        Swal.fire('Deleted', res.message, 'success');
                        table.ajax.reload();
                    },
                    error:function(){
                        Swal.fire('Error','Failed to delete department.','error');
                    }
                });
            }
        });
    });

});
</script>

@endpush
