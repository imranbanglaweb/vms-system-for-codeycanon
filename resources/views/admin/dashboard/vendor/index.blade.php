@extends('admin.dashboard.master')

@section('main_content')

<section role="main" class="content-body" style="background-color:#fff;">
    <div class="card shadow-lg border-0">
        <div class="">
            <br>
            <h4 class="mb-0"><i class="bi bi-truck"></i> Vendor Management</h4>

            <div class="btn-group">
                <a href="{{ route('vendors.create') }}" class="btn btn-success pull-right">
                    <i class="bi bi-plus-circle"></i> Add Vendor
                </a>
            </div>
        </div>
        <br>

        <div class="card-body position-relative">

            <!-- 🔄 Loading Overlay -->
            <div id="loadingOverlay" 
                 class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-white" 
                 style="z-index:10; display:none;">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <!-- 📋 Vendor DataTable -->
            <div class="table-responsive">
                <table id="vendorsTable" class="table table-bordered table-striped align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Vendor Name</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $('#loadingOverlay').show();

    let table = $('#vendorsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('vendors.index') }}",
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'contact_person', name: 'contact_person' },
            { data: 'contact_number', name: 'contact_number' },
            { data: 'email', name: 'email' },
            { 
                data: 'status', 
                name: 'status',
                render: function (data) {
                    return data === 'Active'
                        ? `<span class="btn btn-success"><i class="fa fa-check-circle"></i> ${data}</span>`
                        : `<span class="btn btn-secondary"><i class="fa fa-minus-circle"></i> ${data}</span>`;
                }
            },
            {
                data: 'action', 
                name: 'action',
                orderable: false, 
                searchable: false,
                render: function (data, type, row) {
                    let editUrl = "{{ route('vendors.edit', ':id') }}".replace(':id', row.id);
                    return `
                        <a href="${editUrl}" class="btn btn-primary me-1">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        <button type="button" class="btn btn-danger" onclick="deleteVendor(${row.id})">
                            <i class="fa fa-minus"></i>
                        </button>`;
                }
            }
        ],
        drawCallback: function () {
            $('#loadingOverlay').hide();
        }
    });
});


/* ============================
   🗑️ DELETE WITH SweetAlert2  
============================ */
function deleteVendor(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "This vendor will be permanently removed!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                // url: `/vendors/${id}`,
                url:"{{ route('vendors.destroy', ':id') }}".replace(':id', id),

                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },

                success: function (response) {
                    Swal.fire({
                        title: "Deleted!",
                        text: "Vendor deleted successfully.",
                        icon: "success",
                        timer: 1500
                    });

                    $('#vendorsTable').DataTable().ajax.reload(null, false);
                },

                error: function () {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to delete vendor.",
                        icon: "error"
                    });
                }
            });

        }
    });
}
</script>
@endpush

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    .card {
        border-radius: 12px;
    }
    .card-header {
        border-top-left-radius: 12px !important;
        border-top-right-radius: 12px !important;
        background: #0d6efd;
    }
    .btn-group .btn {
        border-radius: 20px !important;
        margin-left: 5px;
    }
    .table th, .table td {
        vertical-align: middle !important;
    }
</style>
@endpush
