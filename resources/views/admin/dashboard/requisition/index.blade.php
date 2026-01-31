@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background:#ffffff">

    <div class="container-fluid">
        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1" style="font-size: 1.5rem;">
                    <i class="fa fa-clipboard-list text-primary me-2" style="font-size: 1.25rem;"></i>Requisition Management
                </h2>
                <p class="text-muted mb-0" style="font-size: 0.9rem;">Manage and track all transport requisitions</p>
            </div>
            <a href="{{ route('requisitions.create') }}" class="btn btn-primary btn-lg shadow-sm" style="font-size: 0.9rem;">
                <i class="fa fa-plus-circle me-2"></i>Add Requisition
            </a>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 0.5rem;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fa fa-clipboard-list text-primary" style="font-size: 1.25rem;"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">Total</p>
                                <h4 class="fw-bold mb-0" style="font-size: 1.5rem;">{{ $stats['total'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 0.5rem;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded bg-warning bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fa fa-clock text-warning" style="font-size: 1.25rem;"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">Pending</p>
                                <h4 class="fw-bold mb-0" style="font-size: 1.5rem;">{{ $stats['pending'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 0.5rem;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded bg-success bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fa fa-check-circle text-success" style="font-size: 1.25rem;"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">Approved</p>
                                <h4 class="fw-bold mb-0" style="font-size: 1.5rem;">{{ $stats['approved'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 0.5rem;">
                    <div class="card-body py-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded bg-danger bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="fa fa-times-circle text-danger" style="font-size: 1.25rem;"></i>
                            </div>
                            <div class="ms-3">
                                <p class="text-muted mb-0" style="font-size: 0.85rem;">Rejected</p>
                                <h4 class="fw-bold mb-0" style="font-size: 1.5rem;">{{ $stats['rejected'] ?? 0 }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Advanced Search & Filter --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 0.5rem;">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="card-title mb-0 text-dark" style="font-size: 1rem;">
                    <i class="fa fa-filter me-2"></i>Filters & Search
                </h5>
            </div>
            <div class="card-body">
                <form id="searchForm">
                    <div class="row g-3">
                        {{-- Requisition Number --}}
                        <div class="col-md-3">
                            <label for="requisition_number" class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Requisition No.</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="fa fa-search text-muted"></i></span>
                                <input type="text" name="requisition_number" id="requisition_number"
                                       class="form-control border-start-0" placeholder="Enter requisition number..." style="font-size: 0.875rem;">
                            </div>
                        </div>

                        {{-- Employee Search --}}
                        <div class="col-md-3">
                            <label for="employee_name" class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Employee</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0"><i class="fa fa-user text-muted"></i></span>
                                <input type="text" name="employee_name" id="employee_name"
                                       class="form-control border-start-0" placeholder="Search employee..." style="font-size: 0.875rem;">
                            </div>
                        </div>

                        {{-- Department --}}
                        <div class="col-md-3">
                            <label for="department_id" class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Department</label>
                            <select name="department_id" id="department_id" class="form-select form-select-sm" style="font-size: 0.875rem;">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-3">
                            <label for="status" class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">Status</label>
                            <select name="status" id="status" class="form-select form-select-sm" style="font-size: 0.875rem;">
                                <option value="">All Status</option>
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        {{-- Date Range --}}
                        <div class="col-md-3">
                            <label for="start_date" class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">From Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" style="font-size: 0.875rem;">
                        </div>

                        <div class="col-md-3">
                            <label for="end_date" class="form-label fw-semibold mb-1" style="font-size: 0.85rem;">To Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" style="font-size: 0.875rem;">
                        </div>

                        {{-- Action Buttons --}}
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm" style="font-size: 0.85rem;">
                                    <i class="fa fa-search me-1"></i>Search
                                </button>
                                <button type="button" id="resetBtn" class="btn btn-outline-secondary btn-sm" style="font-size: 0.85rem;">
                                    <i class="fa fa-redo me-1"></i>Reset
                                </button>
                                <button type="button" id="exportBtn" class="btn btn-success btn-sm" style="font-size: 0.85rem;">
                                    <i class="fa fa-file-export me-1"></i>Export
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table Section --}}
        <div class="card border-0 shadow-sm" style="border-radius: 0.5rem;">
            <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-dark" style="font-size: 1rem;">
                    <i class="fa fa-table me-2 text-primary"></i>Requisition Records
                </h5>
                <div class="d-flex align-items-center">
                    <span class="me-2 text-muted" style="font-size: 0.85rem;">Show:</span>
                    <select id="perPage" class="form-select form-select-sm" style="width: auto; font-size: 0.85rem;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="card-body p-0">

                {{-- Preloader --}}
                <div id="loader" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted" style="font-size: 0.9rem;">Loading requisitions...</p>
                </div>

                {{-- Table --}}
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0" id="requisitionsTable" style="font-size: 0.875rem;">
                        <thead>
                            <tr style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);">
                                <th width="50" class="text-center text-white py-3" style="font-weight: 500; font-size: 0.85rem;">#</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Req. Number</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Requested By</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Department</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Route</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Travel Date</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Return Date</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Vehicle</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Approval Status</th>
                                <th class="text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Status</th>
                                <th width="120" class="text-center text-white py-3" style="font-weight: 500; font-size: 0.85rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">
                            @include('admin.dashboard.requisition.table')
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div id="paginationContainer" class="p-3 border-top bg-light">
                    @include('admin.dashboard.requisition.pagination')
                </div>

            </div>
        </div>

    </div>

</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('public/admin_resource/')}}/assets/vendor/jquery/jquery.js"></script>
<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.5rem 0.85rem;
        font-size: 0.95rem;
    }
    .card {
        transition: box-shadow 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    .table th {
        border-bottom: 2px solid #dee2e6 !important;
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
        white-space: nowrap;
    }
    .table td {
        vertical-align: middle;
        padding: 0.85rem;
        font-size: 0.95rem;
    }
    .badge {
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.4em 0.65em;
    }
    .btn-sm {
        padding: 0.45rem 0.75rem;
        font-size: 0.9rem;
    }
    .btn-group .btn {
        margin: 0 1px;
    }
    #requisitionsTable tbody tr:hover {
        background-color: #f8f9fa !important;
    }
    .input-group-text {
        border-right: none;
        font-size: 0.95rem;
    }
    .input-group .form-control {
        border-left: none;
        font-size: 0.95rem;
    }
    .input-group .form-control:focus {
        border-color: #ced4da;
        box-shadow: none;
    }
    .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
        border-radius: 0.375rem;
    }
    .input-group:focus-within .input-group-text,
    .input-group:focus-within .form-control {
        border-color: #86b7fe;
    }
    .form-control, .form-select {
        font-size: 0.95rem;
    }
    .form-label {
        font-size: 0.9rem;
    }
    .card-header {
        font-size: 0.95rem;
    }
    h2 {
        font-size: 1.75rem;
    }
    h4 {
        font-size: 1.5rem;
    }
</style>

<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap-5',
            placeholder: 'Select an option',
            allowClear: true
        });

        // Search with AJAX
        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
            fetchData(1);
        });

        // Reset form
        $('#resetBtn').on('click', function() {
            $('#searchForm')[0].reset();
            $('.select2').val(null).trigger('change');
            fetchData(1);
        });

        // Per page change
        $('#perPage').on('change', function() {
            fetchData(1);
        });

        // Pagination
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const page = $(this).attr('href').split('page=')[1];
            fetchData(page);
        });

        // Export functionality
        $('#exportBtn').on('click', function() {
            Swal.fire({
                title: 'Export Requisitions',
                text: 'Choose export format',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fa fa-file-excel me-2"></i>Excel',
                cancelButtonText: '<i class="fa fa-file-pdf me-2"></i>PDF',
                showDenyButton: true,
                denyButtonText: '<i class="fa fa-file-csv me-2"></i>CSV',
                denyButtonColor: '#198754'
            }).then((result) => {
                if (result.isConfirmed) {
                    exportData('excel');
                } else if (result.isDenied) {
                    exportData('csv');
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    exportData('pdf');
                }
            });
        });
    });

    // Fetch data with pagination
    function fetchData(page = 1) {
        $('#loader').show();
        $('#tableData').hide();
        $('#paginationContainer').hide();

        const formData = $('#searchForm').serialize() + '&per_page=' + $('#perPage').val() + '&page=' + page;

        $.ajax({
            url: "{{ route('requisitions.index') }}",
            data: formData,
            success: function (response) {
                $('#tableData').html(response.html || response.table);
                $('#paginationContainer').html(response.pagination || '');
                $('#tableData').show();
                $('#paginationContainer').show();
                $('#loader').hide();
                
                // Update stats if provided
                if (response.stats) {
                    updateStats(response.stats);
                }
            },
            error: function(xhr) {
                $('#loader').hide();
                $('#tableData').show();
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load data. Please try again.'
                });
            }
        });
    }

    // Update stats cards
    function updateStats(stats) {
        console.log('Stats updated:', stats);
    }

    // Export data
    function exportData(format) {
        const formData = $('#searchForm').serialize();
        
        Swal.fire({
            title: 'Exporting Data',
            text: 'Please wait while we prepare your file...',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false
        });

        let url = "";
        if (format === 'pdf') {
            url = "{{ route('requisitions.export.pdf') }}";
        } else {
            url = "{{ route('requisitions.export.excel') }}";
        }
        window.location.href = url + "?" + formData;
        
        setTimeout(() => {
            Swal.close();
        }, 2000);
    }

    // Approve with SweetAlert
    $(document).on('click', '.approveRequest', function () {
        const id = $(this).data('id');
        const reqNumber = $(this).data('req-number');
        
        Swal.fire({
            title: 'Approve Requisition?',
            html: `Are you sure you want to approve requisition <strong>${reqNumber}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-check me-2"></i>Yes, Approve!',
            cancelButtonText: '<i class="fa fa-times me-2"></i>Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 1, reqNumber);
            }
        });
    });

    // Reject with SweetAlert
    $(document).on('click', '.rejectRequest', function () {
        const id = $(this).data('id');
        const reqNumber = $(this).data('req-number');
        
        Swal.fire({
            title: 'Reject Requisition?',
            html: `Are you sure you want to reject requisition <strong>${reqNumber}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-times me-2"></i>Yes, Reject!',
            cancelButtonText: '<i class="fa fa-arrow-left me-2"></i>Cancel',
            reverseButtons: true,
            input: 'textarea',
            inputLabel: 'Rejection Reason (Optional)',
            inputPlaceholder: 'Enter reason for rejection...',
            inputAttributes: {
                'aria-label': 'Enter reason for rejection'
            },
            showCancelButton: true
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, 2, reqNumber, result.value);
            }
        });
    });

    // Delete with SweetAlert
    $(document).on('click', '.deleteItem', function () {
        const id = $(this).data('id');
        const reqNumber = $(this).data('req-number');
        
        Swal.fire({
            title: 'Delete Requisition?',
            html: `You are about to delete requisition <strong>${reqNumber}</strong>. This action cannot be undone!`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa fa-trash me-2"></i>Yes, Delete!',
            cancelButtonText: '<i class="fa fa-times me-2"></i>Cancel',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                deleteRequisition(id, reqNumber);
            }
        });
    });

    // Update status function
    function updateStatus(id, status, reqNumber, reason = null) {
        const statusText = status == 1 ? 'approved' : 'rejected';
        
        $.ajax({
            url: "{{ route('requisitions.updateStatus', '') }}/" + id,
            type: "POST",
            data: {
                id: id,
                status: status,
                reason: reason,
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Processing...',
                    text: `Updating requisition ${reqNumber}`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || `Requisition ${reqNumber} has been ${statusText} successfully.`,
                    timer: 2000,
                    showConfirmButton: false
                });
                fetchData();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || `Failed to update requisition ${reqNumber}.`
                });
            }
        });
    }

    // Delete requisition function
    function deleteRequisition(id, reqNumber) {
        const deleteUrl = "{{ route('requisitions.destroy', ':id') }}".replace(':id', id);
        
        $.ajax({
            url: deleteUrl,
            type: "DELETE",
            data: {
                _token: "{{ csrf_token() }}"
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Deleting...',
                    text: `Removing requisition ${reqNumber}`,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: response.message || `Requisition ${reqNumber} has been deleted successfully.`,
                    timer: 2000,
                    showConfirmButton: false
                });
                fetchData();
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: xhr.responseJSON?.message || `Failed to delete requisition ${reqNumber}.`
                });
            }
        });
    }
</script>
@endsection
