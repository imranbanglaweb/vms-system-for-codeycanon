@extends('admin.dashboard.master')
@section('title', 'Lands')

@section('main_content')
<div class="content-header">
    <div class="container-fluid content-body">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Lands</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Lands</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
   <section role="main" class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Land List</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-primary btn-sm" onclick="createLand()">
                                <i class="fa fa-plus"></i> Add New Land
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="alert-container"></div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Location</th>
                                        <th>Area</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @include('admin.dashboard.lands.table')
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<!-- Modal -->
<div class="modal fade" id="landModal" tabindex="-1" role="dialog" aria-labelledby="landModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal content will be loaded here -->
        </div>
    </div>
</div>

@push('scripts')
<script>
function createLand() {
    $.ajax({
        url: "{{ route('lands.create') }}",
        type: 'GET',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#landModal .modal-content').html(response.view);
                $('#landModal').modal('show');
            } else {
                showAlert('error', response.message || 'Error loading form');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading form: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

function viewLand(id) {
    $.ajax({
        url: "{{ url('lands') }}/" + id,
        type: 'GET',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#landModal .modal-content').html(response.view);
                $('#landModal').modal('show');
            } else {
                showAlert('error', response.message || 'Error loading land');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading land: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

function editLand(id) {
    $.ajax({
        url: "{{ url('lands') }}/" + id + "/edit",
        type: 'GET',
        beforeSend: function() {
            toggleLoading(true);
        },
        success: function(response) {
            if (response.success) {
                $('#landModal .modal-content').html(response.view);
                $('#landModal').modal('show');
            } else {
                showAlert('error', response.message || 'Error loading form');
            }
        },
        error: function(xhr, status, error) {
            showAlert('error', 'Error loading land: ' + error);
        },
        complete: function() {
            toggleLoading(false);
        }
    });
}

function deleteLand(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ url('lands') }}/" + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        $('#land-' + id).remove();
                    } else {
                        showAlert('error', response.message);
                    }
                },
                error: function(xhr, status, error) {
                    showAlert('error', 'Error deleting land: ' + error);
                }
            });
        }
    });
}

// Add this to handle modal cleanup
$('#landModal').on('hidden.bs.modal', function () {
    $(this).find('.modal-content').html('');
});
</script>
@endpush
@endsection 