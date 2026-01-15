@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #f8f9fa; padding: 20px;">
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2>Permission Management</h2>
            </div>
            <div class="pull-right">
         
                    <a class="btn btn-success" href="{{ route('permissions.create') }}"> 
                        <i class="fa fa-plus"></i> Add Permission
                    </a>
              
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($message = Session::get('danger'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <section class="panel">
      
        <div class="panel-body">
            <table class="table table-bordered table-striped mb-none" id="permissionsTable" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Table</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </section>

    <!-- Delete Confirmation Modal -->
    <div class="modal" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this permission?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- JavaScript Libraries -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js"></script>

<script>
$(document).ready(function() {

    $.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
});

    // Initialize DataTables with server-side processing
    var table = $('#permissionsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('permissions.list') }}",
            type: "GET",
            error: function(xhr, error, thrown) {
                console.log("AJAX Error:", xhr.responseText);
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '5%'
            },
            {
                data: 'name',
                name: 'name',
                width: '45%'
            },
            
            {
                data: 'table_name',
                name: 'table_name',
                width: '35%'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false,
                width: '50%'
            }
        ],
        order: [[1, 'asc']], // Default sort by name
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        pageLength: 10,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'colvis',
                text: 'Show/Hide Columns',
                className: 'btn btn-secondary btn-sm'
            }
        ],
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search permissions...",
            lengthMenu: "_MENU_ records per page",
            zeroRecords: "No permissions found",
            info: "Showing _START_ to _END_ of _TOTAL_ permissions",
            infoEmpty: "Showing 0 to 0 of 0 permissions",
            infoFiltered: "(filtered from _MAX_ total permissions)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });

    // Handle delete button clicks
   
    $(document).on('click', '.delete-btn', function(e) {
    e.preventDefault();

    let deleteUrl = $(this).data('url');
    $('#deleteForm').attr('action', deleteUrl);

    let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();

    $('#deleteForm').off('submit').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            success: function(response) {

                deleteModal.hide();
                $('#permissionsTable').DataTable().ajax.reload();

                // Show success alert
                $('section.content-body').prepend(`
                    <div class="alert alert-success alert-dismissible fade show">
                        ${response.success}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                `);
            },
            error: function(xhr) {
                console.log(xhr.responseText);
                alert("Delete failed");
            }
        });
    });
});

    // Close modal handler
    $('#deleteModal').on('hidden.bs.modal', function () {
        $('#deleteForm').off('submit');
    });
});
</script>

<!-- Make sure Bootstrap JS is loaded (if not already in layout) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .dataTables_wrapper .dataTables_filter {
        float: right;
        text-align: right;
    }
    .dataTables_wrapper .dataTables_length {
        float: left;
    }
    .dataTables_wrapper .dt-buttons {
        float: left;
        margin-right: 10px;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 1.475rem;
    }
</style>

@endsection