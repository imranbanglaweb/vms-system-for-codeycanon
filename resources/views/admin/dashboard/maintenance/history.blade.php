@extends('admin.dashboard.master')

@section('main_content')
<section class="content-body" style="background-color:#fff;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-primary"><i class="fa fa-history me-2"></i> Maintenance History</h3>
            <a href="{{ route('maintenance.index') }}" class="btn btn-secondary btn-sm pull-right">
                <i class="fa fa-arrow-left me-1"></i> Back to Active Requests
            </a>
        </div>
<br>
        {{-- Filters --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <input type="text" id="searchVehicle" class="form-control" placeholder="Search Vehicle">
            </div>
            <div class="col-md-4">
                <input type="text" id="searchEmployee" class="form-control" placeholder="Search Employee">
            </div>
            <div class="col-md-4 text-end">
                <button id="refreshTable" class="btn btn-light border"><i class="fa fa-refresh"></i> Refresh</button>
            </div>
        </div>
<hr>
        {{-- History Table --}}
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle" id="historyTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Requisition No</th>
                        <th>Type</th>
                        <th>Vehicle</th>
                        <th>Employee</th>
                        <th>Maintenance Date</th>
                        <th>Total Cost</th>
                        <th>Status</th>
                        <th style="width: 100px;">Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</section>

{{-- ------------------------ --}}
{{-- Required JS/CSS --}}
{{-- ------------------------ --}}

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
$(document).ready(function() {

    let table = $('#historyTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        paging: true,
        searching: false,
        autoWidth: false,
        order: [[0, 'desc']], // Default sort by ID desc

        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', text: 'Excel', className: 'btn btn-success btn-sm' },
            { extend: 'pdf', text: 'PDF', className: 'btn btn-danger btn-sm' },
            { extend: 'print', text: 'Print', className: 'btn btn-secondary btn-sm' },
        ],

        ajax: {
            url: '{{ route("admin-maintenance.history") }}',
            data: function(d) {
                d.vehicle = $('#searchVehicle').val();
                d.employee = $('#searchEmployee').val();
            }
        },

        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false },
            { data: 'requisition_no', name: 'requisition_no', className: "text-center" },
            { data: 'requisition_type', name: 'requisition_type', className: "text-center" },
            { data: 'vehicle', name: 'vehicle' },
            { data: 'employee', name: 'employee.name' },
            { data: 'maintenance_date', name: 'maintenance_date', className: "text-center" },
            { data: 'grand_total', name: 'total_cost', className: "text-end" },
            { data: 'status', name: 'status', className: "text-center" },
            { data: 'actions', name: 'actions', orderable: false, searchable: false, className: "text-center" },
        ]
    });

    $('#searchVehicle, #searchEmployee').on('keyup', function() { table.draw(); });
    $('#refreshTable').on('click', function() { table.draw(); });
});
</script>
@endsection