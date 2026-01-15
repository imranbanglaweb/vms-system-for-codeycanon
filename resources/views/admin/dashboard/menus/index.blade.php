@extends('admin.dashboard.master')

@section('main_content')

<style>
#menuTable td {
    cursor: move;
}
</style>

<section role="main" class="content-body">
    <div class="row">
        <div class="col-lg-12"><h2>Menu Manage</h2></div>
        <div class="col-lg-12 text-end">
            @can('menu-create')
                <a class="btn btn-success" href="{{ route('menus.create') }}">
                    <i class="fa fa-plus"></i> Add Menu
                </a>
            @endcan
        </div>
    </div>

    <div id="successMessage">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">{{ $message }}</div>
        @endif
        @if ($message = Session::get('danger'))
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>

    <section class="panel">
        <header class="panel-heading">
            <h4>Menu List</h4>
        </header>
        <div class="panel-body">
            <table class="table table-bordered table-striped" id="menuTable">
                <thead>
                    <tr>
                        <th style="display:none;">Order</th>
                        <th>No</th>
                        <th>Name</th>
                        <th>Menu Type</th>
                        <th>Menu Icon</th>
                        <th>Menu URL</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </section>

    <!-- Delete Modal -->
    <div id="applicantDeleteModal" class="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h4 class="modal-title text-center">Delete Menu</h4>
                        <button type="button" class="btn btn-secondary close" data-bs-dismiss="modal">×</button>

                    </div>
                    <div class="modal-body">
                        <h5 class="text-danger text-center">Are you sure you want to delete this menu?</h5>
                        <input type="hidden" name="menu_id" id="menu_id">
                    </div>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {

    var table = $('#menuTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("menus.index") }}',
    columns: [
        { data: 'menu_order', visible: false },
        { data: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'menu_name' },
        { data: 'menu_type' },
        { data: 'menu_icon', orderable: false, searchable: false },
        { data: 'menu_url' },
        { data: 'action', orderable: false, searchable: false }
    ],
    rowReorder: {
        dataSrc: 'menu_order'
    },
    order: [[0, 'asc']]
});


    // Row reorder AJAX
   table.on('row-reorder', function(e, diff, edit) {

    var orderedData = table.rows().data();   // full table data in new order
    var reorderData = [];

    orderedData.each(function(row, index) {
        reorderData.push({
            id: row.id,
            newPosition: index + 1
            
        });
    });

    $.ajax({
        url: '{{ route("menus.reorder") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            order: reorderData
        },
        success: function(response) {
            if(response.success) {
                toastr.success('Menu order updated successfully!');
                table.ajax.reload(null, false);
            } else {
                toastr.error(response.message || 'Error updating order');
            }
        },
        error: function(xhr) {
            console.error(xhr);
            toastr.error('Error updating order');
        }
        });

    });


    // Delete menu
    $(document).on('click', '.deleteUser', function() {
        var menu_id = $(this).data('menuid');
        let deleteRoute = "{{ route('menus.destroy', ':id') }}"; 
            deleteRoute = deleteRoute.replace(':id', menu_id);
        $('#menu_id').val(menu_id);
        // $('#deleteForm').attr('action', '/menus/' + menu_id);
        $('#deleteForm').attr('action', deleteRoute);
        $('#applicantDeleteModal').modal('show');
    });

});


</script>
@endsection
