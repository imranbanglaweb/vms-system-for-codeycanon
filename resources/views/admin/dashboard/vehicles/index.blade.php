@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style=background-color:#fff;>
<div class="container">
<br>
<br>
<br>
<br>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary mb-0">
            <i class="fa fa-car"></i> Vehicles
        </h4>
        <a href="{{ route('vehicles.create') }}" class="btn btn-success btn-sm pull-right">
            <i class="fa fa-plus-circle"></i> Add Vehicle
        </a>
    </div>
<br>
<hr>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="vehicleTable" class="table table-striped table-bordered align-middle">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <!-- <th>#</th> -->
                            <th>Vehicle Name</th>
                            <th>Department</th>
                            <th>License Plate</th>
                            <th>Driver</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</div>
</section>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function() {
    // Initialize DataTable
    let table = $('#vehicleTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vehicles.index') }}",
        columns: [
            // { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '3%' },
            { data: 'vehicle_name', name: 'vehicle_name' },
            { data: 'department', name: 'department' },
            { data: 'license_plate', name: 'license_plate' },
            { data: 'driver', name: 'driver' },
            { data: 'status', name: 'status', className: 'text-center' },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"></div>'
        },
    });

    // Delete Vehicle
    $(document).on('click', '.deleteVehicleBtn', function() {
        let id = $(this).data('id');
        let url = "{{ route('vehicles.destroy', ':id') }}".replace(':id', id);

        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        table.ajax.reload();
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: 'Something went wrong!'
                        });
                    }
                });
            }
        });
    });
});
</script>

<style>
.table th, .table td {
    vertical-align: middle !important;
    font-size: 15px;
}
.badge {
    font-size: 15px;
}
</style>
@endpush
