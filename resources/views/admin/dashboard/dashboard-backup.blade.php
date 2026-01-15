@extends('admin.dashboard.master')

@section('main_content')
<style type="text/css">
	.body{

  background-color: #f8f9fa;
	}
	.card-header{
        padding: 10px 15px;
    }


</style>
<br>
<br>
<br>
<br>
<section role="main" class="content-body">
<div class="container-fluid">

    {{-- ===================== --}}
    {{--  Summary Status Cards --}}
    {{-- ===================== --}}
    <div class="row mb-4">

        <div class="col-md-3">
            <div class="card shadow-sm border-left-primary">
                <div class="card-body text-center">
                    <h5 class="text-primary">Pending</h5>
                    <h2 class="fw-bold">
                       {{ $chartData['Pending'] ?? 0 }}

                    </h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-left-success">
                <div class="card-body text-center">
                    <h5 class="text-success">Approved</h5>
                    <h2 class="fw-bold">{{ $chartData['Approved'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-left-danger">
                <div class="card-body text-center">
                    <h5 class="text-danger">Rejected</h5>
                    <h2 class="fw-bold">{{ $chartData['Rejected'] }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-left-info">
                <div class="card-body text-center">
                    <h5 class="text-info">Completed</h5>
                    <h2 class="fw-bold">{{ $chartData['Completed'] }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- ===================== --}}
    {{--  Approval Quick Panel --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Pending Approvals</strong>
        </div>
        <div class="card-body">

            @if($pendingRequisitions->count() == 0)
                <p class="text-muted">No pending approvals.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Employee</th>
                            <th>From – To</th>
                            <th>Date</th>
                            <th>Purpose</th>
                            <th>Action</th>
                            <!-- <th>Status</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingRequisitions as $req)
                            <tr>
                                <td>{{ $req->id }}</td>
                                <td>{{ $req->requestedBy->name ?? 'N/A' }}</td>
                                <td>{{ $req->from_location }} → {{ $req->to_location }}</td>
                                <td>{{ date('d M Y', strtotime($req->travel_date)) }}</td>
                                <td>{{ $req->purpose }}</td>
                                <td>
                                    <a href="{{ route('requisitions.show', $req->id) }}" class="btn btn-info btn-sm">View</a>
                                    <!-- <button class="btn btn-success btn-sm approve-btn" data-id="{{ $req->id }}">Approve</button>
                                    <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $req->id }}">Reject</button> -->

                                    <!-- <button class="btn btn-success btn-sm action-btn approve-btn" data-id="{{ $req->id }}">
    <i class="fa fa-check"></i> Approve
</button>

<button class="btn btn-danger btn-sm action-btn reject-btn" data-id="{{ $req->id }}">
    <i class="fa fa-times"></i> Reject
</button> -->

                                </td>
                                <td>
    <span id="status-badge-{{ $req->id }}" 
        class="badge 
        @if($req->status=='Approved') badge-success
        @elseif($req->status=='Rejected') badge-danger
        @else badge-warning @endif">
        {{ $req->status }}
    </span>
</td>

<td id="action-buttons-{{ $req->id }}">
    @if($req->status == 'Pending')
        <button class="btn btn-success btn-sm action-btn approve-btn" data-id="{{ $req->id }}">
            Approve
        </button>
        <button class="btn btn-danger btn-sm action-btn reject-btn" data-id="{{ $req->id }}">
            Reject
        </button>
    @else
        <small class="text-muted">No actions</small>
    @endif
</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>
    </div>

    {{-- ===================== --}}
    {{--  Status Chart --}}
    {{-- ===================== --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-secondary text-white">
            <strong>Requisition Status Overview</strong>
        </div>
        <div class="card-body">
            <canvas id="statusChart"></canvas>
        </div>
    </div>

    {{-- ===================== --}}
    {{--  Recent Requisitions --}}
    {{-- ===================== --}}
    <div class="card shadow mb-5">
        <div class="card-header bg-dark text-white">
            <strong>Recent Requisitions</strong>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Employee</th>
                        <th>From – To</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>More</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentRequisitions as $req)
                        <tr>
                            <td>{{ $req->id }}</td>
                            <td>{{ $req->requestedBy->name ?? 'N/A' }}</td>
                            <td>{{ $req->from_location }} → {{ $req->to_location }}</td>
                            <td>{{ date('d M Y', strtotime($req->travel_date)) }}</td>
                            <td>
                                <span class="badge bg-{{ $req->statusBadgeColor() }}">
                                    {{ $req->status }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('requisitions.show', $req->id) }}" class="btn btn-sm btn-primary">Details</a>
                            </td>
                        </tr>    
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
</section>

<script src="{{ asset('public/admin_resource/')}}/plugins/jquery/jquery.min.js"></script>
<script src="{{ asset('public/admin_resource/')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('public/admin_resource/')}}/dist/js/adminlte.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Toastr -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- 
<script>
    
// Wait for document to be fully loaded
jQuery(document).ready(function($) {
    console.log('Script loaded successfully!');
    // Initialize Chart

    $('body').on('click', function() {
        console.log('Body clicked!');
    });

    const statusChart = document.getElementById('statusChart');
    if (statusChart) {
        new Chart(statusChart, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Approved', 'Rejected', 'Completed'],
                datasets: [{
                    label: 'Requisitions',
                    backgroundColor: ['#ffc107','#28a745','#dc3545','#17a2b8'],
                    data: [
                        {{ $chartData['Pending'] ?? 0 }},
                        {{ $chartData['Approved'] ?? 0 }},
                        {{ $chartData['Rejected'] ?? 0 }},
                        {{ $chartData['Completed'] ?? 0 }}
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Approve button handler
    $('body').on('click', '.approve-btn', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const requisitionId = button.data('id');
        
        if (!confirm('Are you sure you want to approve requisition #' + requisitionId + '?')) {
            return;
        }
        
        // Disable button and show loading
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing');
        
        // Make AJAX request
        $.ajax({
            url: "{{ route('requisitions.updateStatus', '') }}/" + requisitionId,
            type: "POST",
            data: {
                status: 'Approved',
                _token: "{{ csrf_token() }}",
                _method: 'PUT'
            },
            success: function(response) {
                if (response.success) {
                    // Show success message and reload
                    showAlert('Requisition approved successfully!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(response.message || 'Error approving requisition', 'error');
                    button.prop('disabled', false).text('Approve');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                showAlert('Error approving requisition. Please try again.', 'error');
                button.prop('disabled', false).text('Approve');
            }
        });
    });

    // Reject button handler
    $('body').on('click', '.reject-btn', function(e) {
        e.preventDefault();
        
        const button = $(this);
        const requisitionId = button.data('id');
        
        const reason = prompt('Please enter reason for rejection:');
        if (reason === null) return; // User cancelled
        
        if (!reason.trim()) {
            alert('Reason is required for rejection.');
            return;
        }
        
        // Disable button and show loading
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing');
        
        // Make AJAX request
        $.ajax({
            url: "{{ route('requisitions.updateStatus', '') }}/" + requisitionId,
            type: "POST",
            data: {
                status: 'Rejected',
                reason: reason.trim(),
                _token: "{{ csrf_token() }}",
                _method: 'PUT'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('Requisition rejected successfully!', 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    showAlert(response.message || 'Error rejecting requisition', 'error');
                    button.prop('disabled', false).text('Reject');
                }
            },
            error: function(xhr) {
                console.error('Error:', xhr);
                showAlert('Error rejecting requisition. Please try again.', 'error');
                button.prop('disabled', false).text('Reject');
            }
        });
    });

    // Helper function to show alerts
    function showAlert(message, type = 'info') {
        // Remove existing alerts
        $('.custom-alert').remove();
        
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'error' ? 'alert-danger' : 'alert-info';
        
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show custom-alert" role="alert" 
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        $('body').append(alertHtml);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            $('.custom-alert').alert('close');
        }, 5000);
    }
});
</script> -->
<script>
$(document).ready(function() {

     const statusChart = document.getElementById('statusChart');
    if (statusChart) {
        new Chart(statusChart, {
            type: 'bar',
            data: {
                labels: ['Pending', 'Approved', 'Rejected', 'Completed'],
                datasets: [{
                    label: 'Requisitions',
                    backgroundColor: ['#ffc107','#28a745','#dc3545','#17a2b8'],
                    data: [
                        {{ $chartData['Pending'] ?? 0 }},
                        {{ $chartData['Approved'] ?? 0 }},
                        {{ $chartData['Rejected'] ?? 0 }},
                        {{ $chartData['Completed'] ?? 0 }}
                    ]
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
    function updateStatus(id, status) {

        let button = $('.action-btn[data-id="'+id+'"]');

        // Disable buttons + show spinner
        button.prop('disabled', true).html(
            '<span class="spinner-border spinner-border-sm"></span> Processing...'
        );

        $.ajax({
            url: "{{ url('/requisitions/update-status') }}/" + id,
            type: "POST",
            data: {
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {

                // Update status badge instantly
                let badgeClass =
                    status === "Approved" ? "badge-success" :
                    status === "Rejected" ? "badge-danger" : "badge-warning";

                $("#status-badge-" + id).removeClass().addClass("badge " + badgeClass).text(status);

                // Remove Approve/Reject buttons after action
                $("#action-buttons-" + id).fadeOut();

                toastr.success("Status updated to " + status + " successfully!");
            },
            error: function(err){
                toastr.error("Error updating status!");
                console.log(err);
            },
            complete: function() {
                button.prop('disabled', false).html(status);
            }
        });
    }

    // Approve
    $(document).on("click", ".approve-btn", function() {
        let id = $(this).data("id");

        Swal.fire({
            title: "Approve this requisition?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Approve",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, "Approved");
            }
        });

    });

    // Reject
    $(document).on("click", ".reject-btn", function() {
        let id = $(this).data("id");

        Swal.fire({
            title: "Reject this requisition?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Reject",
            cancelButtonText: "Cancel",
        }).then((result) => {
            if (result.isConfirmed) {
                updateStatus(id, "Rejected");
            }
        });

    });

});
</script>

@endsection