@extends('admin.dashboard.master')

@section('main_content')
<style>
    table{
        color:#000;
        font-size:15px;
    }
</style>
<section role="main" class="content-body" style="background-color:#f1f4f8;">
<div class="container-fluid px-4 mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">
            <i class="fa-solid fa-truck-moving me-2"></i>Transport Approval Panel
        </h3>
    </div>

    <div class="card shadow border-0">
        <div class="card-body p-4">

            <!-- Filter Bar -->
            <div class="row g-2 mb-3" id="filterBar">
                <div class="col-md-3">
                    <input type="text" id="searchBox" class="form-control" placeholder="Search requisition # or text">
                </div>
                <div class="col-md-2">
                    <select id="filterDepartment" class="form-select">
                        <option value="">All Departments</option>
                        <!-- Option values should be loaded dynamically or via JS -->
                    </select>
                </div>
                <div class="col-md-2">
                    <select id="filterStatus" class="form-select">
                        <option value="">All Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Assigned">Assigned</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <input type="date" id="dateFrom" class="form-control">
                    <input type="date" id="dateTo" class="form-control">
                </div>
                <div class="col-12 mt-2">
                    <button id="btnFilter" class="btn btn-primary btn-sm">Apply</button>
                    <button id="btnReset" class="btn btn-outline-secondary btn-sm">Reset</button>
                </div>
            </div>
            <hr>
            <!-- DataTable -->
            <div class="table-responsive">
                <table id="transportTable" class="table table-striped table-hover align-middle w-100">
                    <thead class="bg-dark text-white sticky-top">
                        <tr>
                            <th>Req No</th>
                            <th>Requested By</th>
                            <th>Department</th>
                            <th>Passengers</th>
                            <th>Dept Approved</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>

<!-- Scripts for DataTable -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function(){
    // DataTable
    var table = $('#transportTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('transport.approvals.ajax') }}",
            data: function(d){
                d.department_id = $('#filterDepartment').val();
                d.status = $('#filterStatus').val();
                d.date_from = $('#dateFrom').val();
                d.date_to = $('#dateTo').val();
                d.search_text = $('#searchBox').val();
            }
        },
        columns: [
            { data: 'requisition_number', name: 'requisition_number' },
            { data: 'requested_by', name: 'requestedBy.name' },
            { data: 'department', name: 'department.name' },
            { data: 'number_of_passenger', name: 'number_of_passenger' },
            { data: 'department_status', name: 'department_status' },
            { data: 'status_badge', name: 'status' },
            { data: 'action', name: 'action', orderable:false, searchable:false }
        ],
        order: [[4,'desc']]
    });

    // Filters
    $('#btnFilter').click(function(){ table.ajax.reload(); });
    $('#btnReset').click(function(){
        $('#filterDepartment,#filterStatus,#dateFrom,#dateTo,#searchBox').val('');
        table.ajax.reload();
    });
    $('#searchBox').on('keypress', function(e){ if(e.which==13) table.ajax.reload(); });
});
</script>

        </div>
    </div>

</div>
</section>
@endsection
