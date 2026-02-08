@extends('admin.dashboard.master')

<style>
body { background:#ffffff !important; }
.content-body { padding:20px 25px !important; }
.card { border-radius:12px; }
.info-card { background: #f8f9fa; border-radius: 8px; padding: 15px; }
.badge-lg { font-size: 14px; padding: 8px 12px; }
.table th { background: #f1f3f5; }
</style>

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

@section('main_content')
<section role="main" class="content-body">
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold">
            <i class="fa-solid fa-clipboard-check me-2"></i> Maintenance Approval: {{ $requisition->requisition_no }}
        </h3>
        <a href="{{ route('maintenance_approvals.index') }}" class="btn btn-secondary btn-sm">
            <i class="fa fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="row">
        <!-- Requisition Details -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-wrench me-2"></i> Requisition Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Service Title</label>
                                <h6 class="mb-0">{{ $requisition->service_title }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card">
                                <label class="text-muted small">Type</label>
                                <h6 class="mb-0 text-capitalize">{{ $requisition->requisition_type }}</h6>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-card">
                                <label class="text-muted small">Priority</label>
                                @php
                                    $priorityClass = match($requisition->priority) {
                                        'Low' => 'success',
                                        'Medium' => 'warning',
                                        'High' => 'danger',
                                        'Urgent' => 'dark',
                                        default => 'secondary'
                                    };
                                @endphp
                                <span class="badge bg-{{ $priorityClass }} badge-lg">{{ $requisition->priority }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Vehicle</label>
                                <h6 class="mb-0">
                                    {{ $requisition->vehicle->vehicle_name ?? 'N/A' }}
                                    @if($requisition->vehicle)
                                        <small class="text-muted">({{ $requisition->vehicle->vehicle_no }})</small>
                                    @endif
                                </h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Maintenance Date</label>
                                <h6 class="mb-0">{{ date('d M, Y', strtotime($requisition->maintenance_date)) }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Requested By</label>
                                <h6 class="mb-0">{{ $requisition->employee->name ?? 'N/A' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-card">
                                <label class="text-muted small">Maintenance Type</label>
                                <h6 class="mb-0">{{ $requisition->maintenanceType->type_name ?? 'N/A' }}</h6>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="info-card">
                                <label class="text-muted small">Charge Bear By</label>
                                <h6 class="mb-0">{{ $requisition->charge_bear_by ?? 'N/A' }}</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card">
                                <label class="text-muted small">Charge Amount</label>
                                <h6 class="mb-0">${{ number_format($requisition->charge_amount ?? 0, 2) }}</h6>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-card">
                                <label class="text-muted small">Total Cost</label>
                                <h6 class="mb-0 fw-bold">${{ number_format($requisition->total_cost ?? 0, 2) }}</h6>
                            </div>
                        </div>
                    </div>

                    @if($requisition->vendor)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="info-card">
                                <label class="text-muted small">Vendor</label>
                                <h6 class="mb-0">{{ $requisition->vendor->vendor_name }}</h6>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($requisition->remarks)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="info-card">
                                <label class="text-muted small">Remarks</label>
                                <p class="mb-0">{{ $requisition->remarks }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Approval Actions -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-gavel me-2"></i> Approval Actions</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Current Status</label>
                        <span class="badge bg-warning badge-lg">{{ $requisition->status }}</span>
                    </div>

                    @if($requisition->status == 'Pending Approval')
                    <div class="d-grid gap-2">
                        <button type="button" class="btn btn-success" onclick="approveRequisition()">
                            <i class="fa fa-check me-1"></i> Approve
                        </button>
                        <button type="button" class="btn btn-danger" onclick="showRejectModal()">
                            <i class="fa fa-times me-1"></i> Reject
                        </button>
                    </div>
                    @elseif($requisition->status == 'Approved')
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle me-1"></i> This requisition has been approved.
                        @if($requisition->approvedBy)
                            <br><small>By: {{ $requisition->approvedBy->name }}</small>
                        @endif
                        @if($requisition->approved_at)
                            <br><small>On: {{ date('d M, Y H:i', strtotime($requisition->approved_at)) }}</small>
                        @endif
                    </div>
                    @elseif($requisition->status == 'Rejected')
                    <div class="alert alert-danger">
                        <i class="fa fa-times-circle me-1"></i> This requisition has been rejected.
                    </div>
                    @endif
                </div>
            </div>

            @if($requisition->items->count() > 0)
            <div class="card shadow-sm border-0">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fa-solid fa-list me-2"></i> Items</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($requisition->items as $item)
                            <tr>
                                <td>{{ $item->category->category_name ?? 'N/A' }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>${{ number_format($item->total_price, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-end"><strong>Parts Cost:</strong></td>
                                <td><strong>${{ number_format($requisition->total_parts_cost ?? 0, 2) }}</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
</section>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Reject Requisition</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Rejection Remarks <span class="text-danger">*</span></label>
                        <textarea name="remarks" class="form-control" rows="3" required placeholder="Please provide a reason for rejection..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Approve Requisition</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="approveForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Approval Remarks (Optional)</label>
                        <textarea name="remarks" class="form-control" rows="3" placeholder="Add any notes for approval..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Approve</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
$(function() {
    // Approve
    $('#approveForm').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to approve this maintenance requisition?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, approve it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('maintenance_approvals.approve', $requisition->id) }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Approved!', response.message, 'success')
                                .then(() => window.location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                    }
                });
            }
        });
    });

    // Reject
    $('#rejectForm').submit(function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to reject this maintenance requisition?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject it!',
            cancelButtonText: 'No, keep it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('maintenance_approvals.reject', $requisition->id) }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Rejected!', response.message, 'success')
                                .then(() => window.location.reload());
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Error!', xhr.responseJSON?.message || 'Something went wrong', 'error');
                    }
                });
            }
        });
    });
});

function approveRequisition() {
    $('#approveModal').modal('show');
}

function showRejectModal() {
    $('#rejectModal').modal('show');
}
</script>
@endsection
