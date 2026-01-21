@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color:#fff; padding:20px;">
    <div class="container-fluid">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-dark">Role Management</h3>

            <div>
                @can('role-create')
                    <a href="{{ route('permissions.index') }}" class="btn btn-outline-info me-2">
                        <i class="fa fa-shield"></i> Permissions
                    </a>

                    <a href="{{ route('roles.create') }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Create Role
                    </a>
                @endcan
            </div>
        </div>

        <!-- CARD -->
        <div class="card shadow-sm border-0">
            <div class="card-body">

                <table id="rolesTable" class="table table-hover table-bordered w-100">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th>Name</th>
                            <th width="180">Created At</th>
                            <th width="200">Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
        </div>

    </div>
</section>
@endsection


@push('scripts')
<!-- REQUIRED LIBS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DATATABLE & SWEETALERT SCRIPT -->
<script>
@if(session('success'))
Swal.fire({
    icon: 'success',
    title: 'Success',
    text: "{{ session('success') }}",
    timer: 2000,
    showConfirmButton: false
});
@endif
</script>
<script>
$(document).ready(function () {

    /* ==============================
       DATATABLE INITIALIZATION
    =============================== */
    let table = $('#rolesTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: "{{ route('roles.data') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'actions', orderable: false, searchable: false }
        ],
        language: {
            processing: "Loading roles..."
        }
    });

    /* ==============================
       DELETE ROLE (SweetAlert)
    =============================== */
    $(document).on('click', '.deleteRole', function () {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Delete Role?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('roles.destroy', ':id') }}".replace(':id', id),
                    method: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (res) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: res.message,
                            timer: 1500,
                            showConfirmButton: false
                        });
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        Swal.fire(
                            'Failed!',
                            'Unable to delete role.',
                            'error'
                        );
                    }
                });

            }
        });
    });

});
</script>
@endpush
