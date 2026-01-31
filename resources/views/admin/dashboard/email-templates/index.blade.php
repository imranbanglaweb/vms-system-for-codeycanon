@extends('admin.dashboard.master')

@section('title')
Email Templates
@endsection

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff;">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-primary">
                <br>
                <i class="fa fa-envelope"></i> Email Templates
            </h4>
            <div class="btn-group pull-right">
                <a href="{{ route('admin.email.test') }}" class="btn btn-info btn-sm">
                    <i class="fa fa-paper-plane"></i> Test Email
                </a>
                <a href="{{ route('email-templates.create') }}" class="btn btn-success btn-sm">
                    <i class="fa fa-plus-circle"></i> Add Template
                </a>
            </div>
        </div>
        <br>
        <br>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="emailTemplateTable" class="table table-striped table-bordered align-middle" style="width:100%">
                        <thead class="bg-primary text-white text-center">
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th width="15%">Actions</th>
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
    let table = $('#emailTemplateTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('email-templates.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', className: 'text-center', width: '5%', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'type_label', name: 'type', orderable: false },
            { data: 'subject', name: 'subject' },
            { data: 'is_active', name: 'is_active', className: 'text-center', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
        ],
        language: {
            processing: '<div class="spinner-border text-primary" role="status"></div>'
        },
    });

    // Toggle Status
    $(document).on('click', '.toggleStatusBtn', function() {
        let id = $(this).data('id');
        let isActive = $(this).data('active') == '1';
        let action = isActive ? 'deactivate' : 'activate';
        let newStatus = isActive ? '0' : '1';

        Swal.fire({
            title: 'Are you sure?',
            text: `Do you want to ${action} this template?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, ' + action + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('email-templates.toggle-status') }}",
                    type: 'POST',
                    data: {
                        id: id,
                        is_active: newStatus,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
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

    // Delete Template
    $(document).on('click', '.deleteTemplateBtn', function() {
        let id = $(this).data('id');
        let url = "{{ route('email-templates.destroy', ':id') }}".replace(':id', id);

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
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            table.ajax.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: response.message
                            });
                        }
                    },
                    error: function() {
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
