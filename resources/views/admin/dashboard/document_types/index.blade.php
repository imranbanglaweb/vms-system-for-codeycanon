@extends('admin.dashboard.master')
@section('title', 'Document Types')

@section('main_content')
<div class="inner-wrapper">
    <section role="main" class="content-body">
        <header class="page-header">
            <h2>Document Types</h2>
            <div class="right-wrapper text-right">
                <ol class="breadcrumbs">
                    <li><a href="{{ route('home') }}"><i class="fas fa-home"></i></a></li>
                    <li><span>Document Types</span></li>
                </ol>
            </div>
        </header>
<br>
<br>
<br>
<br>
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions">
                            <button class="btn btn-primary btn-sm" onclick="createDocumentType()">
                                <i class="fa fa-plus"></i> Add Document Type
                            </button>
                        </div>
                        <h2 class="card-title">Document Types List</h2>
                    </header>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0" id="datatable-default">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('admin.dashboard.document_types.table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="documentTypeModal" tabindex="-1" role="dialog" aria-labelledby="documentTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

@push('scripts')
<script>
function createDocumentType() {
    $.ajax({
        url: "{{ route('document-types.create') }}",
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $('#documentTypeModal .modal-content').html(response.view);
                $('#documentTypeModal').modal('show');
            }
        }
    });
}

function editDocumentType(id) {
    $.ajax({
        url: "{{ route('document-types.edit', '') }}/" + id,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $('#documentTypeModal .modal-content').html(response.view);
                $('#documentTypeModal').modal('show');
            }
        }
    });
}

function viewDocumentType(id) {
    $.ajax({
        url: "{{ route('document-types.show', '') }}/" + id,
        type: 'GET',
        success: function(response) {
            if (response.success) {
                $('#documentTypeModal .modal-content').html(response.view);
                $('#documentTypeModal').modal('show');
            }
        }
    });
}

function deleteDocumentType(id) {
    if (confirm('Are you sure you want to delete this document type?')) {
        $.ajax({
            url: "{{ route('document-types.destroy', '') }}/" + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }
}

// Initialize DataTable
$(document).ready(function() {
    $('#datatable-default').DataTable({
        responsive: true,
        order: [[0, 'desc']]
    });
});
</script>
@endpush
@endsection 