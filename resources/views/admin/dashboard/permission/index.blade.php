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
                    <a class="btn btn-success" href="{{ route('admin.permissions.create') }}"> 
                        <i class="fa fa-plus"></i> Add Permission
                    </a>
            </div>
        </div>
    </div>

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

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

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
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>
@endpush

@push('scripts')
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
            url: "{{ route('admin.permissions.list') }}",
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

                    // Show premium toast notification
                    showPremiumToast(
                        'success',
                        '<i class="fas fa-check-circle me-2"></i>Deleted',
                        response.success || 'Permission deleted successfully',
                        5000
                    );
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    showPremiumToast(
                        'error',
                        '<i class="fas fa-times-circle me-2"></i>Failed',
                        'Delete failed. Please try again.',
                        5000
                    );
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
</style>

@endpush

@endsection
