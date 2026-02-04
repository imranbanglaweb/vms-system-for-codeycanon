@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color:#fff;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary"><i class="fa fa-tools me-2"></i> Maintenance Requisitions</h3>
            <a href="{{ route('maintenance.create') }}" class="btn btn-primary btn-sm pull-right">
                <i class="fa fa-plus me-1"></i> Create New
            </a>
        </div>
<br>
<br>
        {{-- Filters --}}
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="text" id="searchVehicle" class="form-control" placeholder="Search Vehicle">
            </div>
            <div class="col-md-3">
                <input type="text" id="searchEmployee" class="form-control" placeholder="Search Employee">
            </div>
            <div class="col-md-3">
                <select id="searchType" class="form-select form-control">
                    <option value="">All Types</option>
                    <option value="Maintenance">Maintenance</option>
                    <option value="Breakdown">Breakdown</option>
                    <option value="Inspection">Inspection</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="searchPriority" class="form-select form-control">
                    <option value="">All Priorities</option>
                    <option value="Low">Low</option>
                    <option value="Medium">Medium</option>
                    <option value="High">High</option>
                    <option value="Urgent">Urgent</option>
                </select>
            </div>
        </div>
<hr>
        {{-- Requisitions Table --}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="requisitionsTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Requisition No</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Vehicle</th>
                        <th>Employee</th>
                        <th>Maintenance Date</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th style="width: 110px;">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {

    let table = $('#requisitionsTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        paging: true,
        searching: false,
        autoWidth: false,

        dom: 'Bfrtip',   // Export buttons
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', text: 'PDF', className: 'btn btn-danger btn-sm' },
            { extend: 'print', text: 'Print', className: 'btn btn-secondary btn-sm' },
        ],

        ajax: {
            url: '{{ route("maintenance.index") }}',
            data: function(d) {
                d.vehicle = $('#searchVehicle').val();
                d.employee = $('#searchEmployee').val();
                d.type = $('#searchType').val();
                d.priority = $('#searchPriority').val();
            }
        },

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false },

            { data: 'requisition_no', name: 'requisition_no', className: "text-center" },

            { data: 'requisition_type', name: 'requisition_type', className: "text-center" },

            { data: 'priority', name: 'priority', className: "text-center" },

            { data: 'vehicle', name: 'vehicle' },

            { data: 'employee', name: 'employee.name' },

            { data: 'maintenance_date', name: 'maintenance_date', className: "text-center" },

            { data: 'grand_total', name: 'grand_total', className: "text-end" },

            { data: 'status', name: 'status', className: "text-center" },

            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: "text-center" },
        ]
    });

    // Filter events
    $('#searchVehicle, #searchEmployee').on('keyup', function() {
        table.draw();
    });

    $('#searchType, #searchPriority').on('change', function() {
        table.draw();
    });

      // Delete button click
    $('#requisitionsTable').on('click', '.deleteBtn', function() {
        var id = $(this).data('id');

    var urlTemplate = '{{ route("maintenance.destroy", "id") }}';
    var deleteURL = urlTemplate.replace('id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "This will permanently delete the requisition!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    // url: '/maintenance/' + id,
                    url: deleteURL,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire(
                            'Deleted!',
                            response.success,
                            'success'
                        );
                        table.ajax.reload(null, false); // reload DataTable
                    },
                    error: function(xhr) {
                        Swal.fire(
                            'Error!',
                            'Something went wrong while deleting.',
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

@endsection
