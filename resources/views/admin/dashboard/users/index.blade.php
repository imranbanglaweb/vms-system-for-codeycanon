@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff; padding: 10px;">

<div class="row">
    <div class="col-md-4">
       

       
    </div>
    <div class="col-md-8 text-right">
    <br>
    <br>
        <div class="btn-group">
            <a class="btn btn-success" href="{{ route('users.create') }}">
                <i class="fa fa-plus"></i> Add User
            </a>
            <br>
        </div>

    </div>

    
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success myElem">
    <p>{{ $message }}</p>
</div>
@endif

<!-- TABLE -->
<div class="card mt-3 p-2">
    <table class="table table-bordered table-hover" id="myTable" style="width:100%;">
        <thead>
            <tr>
                <th></th>
                <th>User Name</th>
                <th>Name</th>
                <th>Email</th>
                <th>Employee</th>
                <th>Department</th>
                <th>Unit</th>
                <th>Location</th>
                <th>Image</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Delete Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">Are you sure you want to delete this user?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

</section>

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.getData') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'user_name' },
            { data: 'name' },
            { data: 'email' },
            { data: 'employee' },
            { data: 'department' },
            { data: 'unit' },
            { data: 'location' },
            { data: 'user_image', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    $(document).on('click', '.deleteUser', function() {
        var id = $(this).data('id');
        $('#deleteForm').data('id', id);
        $('#deleteModal').modal('show');
    });

    $('#deleteForm').submit(function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        var url = "{{ route('users.destroy', ':id') }}";
        url = url.replace(':id', id);

        $.ajax({
            url: url,
            type: 'DELETE',
            data: $(this).serialize(),
            success: function(response) {
                $('#deleteModal').modal('hide');
                $('#myTable').DataTable().ajax.reload();
                Swal.fire('Deleted!', response.success, 'success');
            }
        });
    });
});

</script>


@endsection
