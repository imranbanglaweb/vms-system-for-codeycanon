@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color: #f8f9fa; padding: 20px;">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Role Management</h2>
            @can('role-create')
            <a href="{{ route('roles.create') }}" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Create Role</a>
            @endcan
            <br>
            <br>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <table id="rolesTable" class="table table-striped table-hover table-bordered" style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created At</th>
                            <th width="200px">Actions</th>
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
<script>
$(function() {
    $('#rolesTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("roles.data") }}',
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'name', name: 'name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ]
});


    // Delete role
    $(document).on('click', '.deleteBtn', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete!'
        }).then((result) => {
            if(result.isConfirmed) {
                $.ajax({
                    url: '/roles/' + id,
                    method: 'DELETE',
                    data: {_token: "{{ csrf_token() }}"},
                    success: function(res) {
                        table.ajax.reload();
                        Swal.fire('Deleted!', res.message, 'success');
                    }
                });
            }
        });
    });
});
</script>
@endpush
