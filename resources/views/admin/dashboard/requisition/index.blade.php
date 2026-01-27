@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background:#fff">

    <div class="container-fluid">

        {{-- Header --}}
        <div class="">
            <h2 class="fw-bold text-primary">
                <i class="fa fa-clipboard-list"></i>Requisition Management
            </h2>
            <a href="{{ route('requisitions.create') }}" class="btn btn-primary btn-lg pull-right">
                <i class="fa fa-plus-circle me-2"></i> Add Requisition
            </a>
        </div>

        {{-- Stats Cards --}}
      
          
           
            
        </div>

        {{-- Advanced Search & Filter --}}
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title" style="padding: 10px;">
                    <i class="fa fa-search"></i>Advanced Search & Filters
                </h5>
            </div>
            <div class="card-body">
                <form id="searchForm">
                    <div class="row g-3">

                        {{-- Requisition Number --}}
                        <div class="col-md-3">
                            <label for="requisition_number" class="form-label fw-semibold">Requisition No.</label>
                            <input type="text" name="requisition_number" id="requisition_number"
                                   class="form-control" placeholder="Enter requisition number...">
                        </div>

                        {{-- Employee Search --}}
                        <div class="col-md-3">
                            <label for="employee_name" class="form-label fw-semibold">Employee Name</label>
                            <input type="text" name="employee_name" id="employee_name"
                                   class="form-control" placeholder="Search employee...">
                        </div>

                        {{-- Department --}}
                        <div class="col-md-3">
                            <label for="department_id" class="form-label fw-semibold">Department</label>
                            <select name="department_id" id="department_id" class="form-control select2">
                                <option value="">All Departments</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Status --}}
                        <div class="col-md-3">
                            <label for="status" class="form-label fw-semibold">Status</label>
                            <select name="status" id="status" class="form-control select2">
                                <option value="">All Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                                <option value="2">Rejected</option>
                                <option value="3">Cancelled</option>
                            </select>
                        </div>

                        {{-- Date Range --}}
                        <div class="col-md-3">
                            <label for="start_date" class="form-label fw-semibold">From Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>

                        <div class="col-md-3">
                            <label for="end_date" class="form-label fw-semibold">To Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>

                        {{-- Priority --}}
                        <div class="col-md-3">
                            <label for="priority" class="form-label fw-semibold">Priority</label>
                            <select name="priority" id="priority" class="form-control select2">
                                <option value="">All Priorities</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="col-md-12">
                            <div class="d-flex gap-2 mt-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-search me-2"></i>Search
                                </button>
                                <button type="button" id="resetBtn" class="btn btn-secondary">
                                    <i class="fa fa-redo me-2"></i>Reset
                                </button>
                                <button type="button" id="exportBtn" class="btn btn-success">
                                    <i class="fa fa-file-export me-2"></i>Export
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
<br>
        {{-- Table Section --}}
        <div class="card">
            <div class="card-header  text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fa fa-table me-2"></i> Requisition Records
                </h5>
                <div class="d-flex align-items-center">
                    <label class="text-black me-2 mb-0">Show:</label>
                    <select id="perPage" class="form-select form-select-sm" style="width: auto;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <div class="card-body table-responsive">

                {{-- Preloader --}}
                <div id="loader" class="text-center py-5" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Loading requisitions...</p>
                </div>

                {{-- Table --}}
                <table class="table table-hover  table-bordered table-striped" id="requisitionsTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="50">#</th>
                            <th width="120">Req. Number</th>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Vehicle</th>
                            <th width="100">Travel Date</th>
                            <th width="100">Return Date</th>
                            <th width="100">Priority</th>
                            <th width="100">Status</th>
                            <th width="150">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tableData">
                        @include('admin.dashboard.requisition.table')
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div id="paginationContainer" class="d-flex justify-content-between align-items-center mt-3">
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
<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- Include SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
        // You can update stats cards here if needed
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

<style>
    .select2-container--bootstrap-5 .select2-selection {
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
    }
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }
    .table th {
        border-top: none;
        font-weight: 600;
    }
    .badge {
        font-size: 1em;
    }
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size:15px;
    }
    #requisitionsTable thead{
        background-color: #666;
        color: #fff;
        vertical-align: middle;
    }
    
    #requisitionsTable td,th{
        color: #fff !important;
        vertical-align: middle;
    }
    
    #requisitionsTable td{
        color: #000 !important;
        vertical-align: middle;
    }
</style>
@endsection