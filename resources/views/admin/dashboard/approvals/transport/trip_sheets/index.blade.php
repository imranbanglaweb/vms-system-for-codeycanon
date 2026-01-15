@extends('admin.dashboard.master')

@section('main_content')

<style>
    .badge {
    font-size: 14px;
    padding: 8px 14px;
    border-radius: 12px;
}
    .badge-success {
        background-color: #28a745;
        color: #fff;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
</style>
<section class="content-body" style="background:#f1f4f8;">

<div class="container-fluid py-4">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa fa-route me-2"></i> Trip Sheet List
        </h2>
    </div>

    <!-- DataTable Card -->
    <div class="card shadow-lg border-0">
        <div class="card-body">

            <table id="tripSheetTable" class="table table-hover table-bordered"
                style="width:100%; font-size:16px;">
                <thead class="table-light">
                    <tr>
                        <!-- <th>#</th> -->
                        <th>Trip No</th>
                        <th>Vehicle</th>
                        <th>Driver</th>
                        <th>Start Date</th>
                        <th>Status</th>
                        <th width="120">Actions</th>
                    </tr>
                </thead>
            </table>

        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function(){

    $('#tripSheetTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('trip-sheets.data') }}",

        columns: [
            // { data: '', name: '' },
            { data: 'trip_number', name: 'trip_number' },
            { data: 'vehicle', name: 'vehicle' },
            { data: 'driver', name: 'driver' },
            { data: 'start_date', name: 'start_date' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ],

        pageLength: 10,
        responsive: true,
        language: {
            searchPlaceholder: "Search trips...",
            search: "",
        }
    });

});
</script>
@endsection
