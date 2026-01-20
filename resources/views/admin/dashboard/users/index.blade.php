@extends('admin.dashboard.master')

@section('main_content')

<section class="content-body bg-white p-3">

<a href="{{ route('users.create') }}" class="btn btn-success mb-3">
    <i class="fa fa-plus"></i> Add New User
</a>

<table class="table table-bordered" id="myTable" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>User Name</th>
            <th>Name</th>
            <th>Email</th>
            <th>Image</th>
            <th width="120">Action</th>
        </tr>
    </thead>
</table>

</section>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5>Delete User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    Are you sure?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
$(function () {

    let table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.getData') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'user_name' },
            { data: 'name' },
            { data: 'email' },
            {
                data: 'user_image',
                orderable: false,
                searchable: false,
                render: function (data) {

                    let basePath = "{{ asset('admin_resource/assets/images/user_image') }}";
                    let fallback = "{{ asset('admin_resource/assets/images/default.png') }}";

                    let src = data ? basePath + '/' + data : fallback;

                    return `
                        <img src="${src}"
                             width="45"
                             height="45"
                             class="rounded-circle"
                             onerror="this.src='${fallback}'">
                    `;
                }
            },
            { data: 'action', orderable: false, searchable: false }
        ]
    });

    // Delete modal
    $(document).on('click', '.deleteUser', function () {
        let id = $(this).data('id');
        let url = "{{ route('users.destroy', ':id') }}".replace(':id', id);
        $('#deleteForm').attr('action', url);
        $('#deleteModal').modal('show');
    });

});
</script>

<script>
     // LIVE SEARCH
    $('#search').keyup(function() {
        $('#myTable').DataTable().search($(this).val()).draw();
    });
</script>
@endsection
