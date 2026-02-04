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

        <br>
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
                <th>Status</th>
                <th>Image</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
    </table>
</div>

</section>

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>
@endpush

@push('scripts')
<!-- Load SweetAlert2 from CDN to ensure it's available -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    console.log('jQuery loaded:', typeof $);
    console.log('Swal loaded:', typeof Swal);
    
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
            { data: 'status' },
            { data: 'user_image', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Delete click handler
    $(document).on('click', '.deleteUser', function(e) {
        e.preventDefault();
        var id = $(this).data('id');
        console.log('Clicked delete, ID:', id);
        
        if (!id) {
            alert('Error: No user ID found!');
            return;
        }
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'This user will be deleted permanently!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route("users.destroy", ":id") }}'.replace(':id', id),
                    type: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    success: function(response) {
                        $('#myTable').DataTable().ajax.reload();
                        Swal.fire('Deleted!', 'User has been deleted.', 'success');
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Delete failed', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush

@endsection
