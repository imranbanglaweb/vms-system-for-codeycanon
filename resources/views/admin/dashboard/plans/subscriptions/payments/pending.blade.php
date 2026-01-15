@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
<div class="container-fluid py-4">

<h4 class="fw-bold mb-4">
    <i class="fa-solid fa-clock text-warning"></i> Pending Manual Payments
</h4>

<div class="card border-0 shadow-sm">
<div class="card-body">

<table id="paymentsTable" class="table table-hover align-middle w-100">
    <thead class="table-light">
        <tr>
            <th>#</th>
            <th>Company</th>
            <th>Plan</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Requested At</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
</table>

</div>
</div>

</div>
</section>

<!-- APPROVE MODAL -->
<div class="modal" id="approveModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow">
    <div class="modal-header">
        <h5 class="modal-title">Approve Payment</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body text-center">
        <i class="fa fa-circle-check fa-3x text-success mb-3"></i>
        <p>Confirm payment approval?</p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-success" id="confirmApprove">Approve</button>
    </div>
</div>
</div>
</div>

<!-- REJECT CONFIRM MODAL -->
<div class="modal" id="rejectModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow">
    <div class="modal-header">
        <h5 class="modal-title text-danger">Reject Payment</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body text-center">
        <i class="fa fa-circle-xmark fa-3x text-danger mb-3"></i>
        <p>Are you sure you want to reject this payment?</p>
    </div>
    <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-danger" id="confirmReject">
            Reject
        </button>
    </div>
</div>
</div>
</div>

<!-- SUCCESS MODAL -->
<div class="modal" id="successModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow">
    <div class="modal-body text-center py-5">
        <i class="fa fa-circle-check fa-4x text-success mb-3"></i>
        <h5 class="fw-bold">Payment Approved</h5>
        <p class="text-muted mb-4">
            The payment has been approved successfully.
        </p>
        <button class="btn btn-success px-4" data-bs-dismiss="modal">
            OK
        </button>
    </div>
</div>
</div>
</div>
<!-- REJECT SUCCESS MODAL -->
<div class="modal" id="rejectSuccessModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content border-0 shadow">
    <div class="modal-body text-center py-5">
        <i class="fa fa-circle-xmark fa-4x text-danger mb-3"></i>
        <h5 class="fw-bold">Payment Rejected</h5>
        <p class="text-muted">The payment has been rejected successfully.</p>
        <button class="btn btn-danger px-4" data-bs-dismiss="modal">
            OK
        </button>
    </div>
</div>
</div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
let paymentId = null;

$(function () {
    $('#paymentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.payments.pending') }}",
        columns: [
            { data: 'DT_RowIndex', orderable:false, searchable:false },
            { data: 'company' },
            { data: 'plan', orderable:false },
            { data: 'amount' },
            { data: 'method', orderable:false },
            { data: 'created_at' },
            { data: 'action', orderable:false, searchable:false }
        ]
    });
});

// Approve button click
$(document).on('click','.approveBtn',function(){
    paymentId = $(this).data('id');
    $('#approveModal').modal('show');
});

$('#confirmApprove').click(function(){
    $.post("{{ url('admin/payments/approve') }}/" + paymentId, {
        _token: '{{ csrf_token() }}'
    }, function () {

        // Close confirm modal
        $('#approveModal').modal('hide');

        // Reload table
        $('#paymentsTable').DataTable().ajax.reload(null, false);

        // Show success modal
        setTimeout(function(){
            $('#successModal').modal('show');
        }, 300);
    });
});

$('#successModal').on('shown.bs.modal', function () {
    setTimeout(() => {
        $('#successModal').modal('hide');
    }, 2000);
});

// reject route
$(document).on('click','.rejectBtn',function(){
    rejectPaymentId = $(this).data('id');
    $('#rejectModal').modal('show');
});

$('#confirmReject').click(function(){
    $.post("{{ route('admin.payments.reject','') }}/" + rejectPaymentId, {
        _token:'{{ csrf_token() }}'
    }, function () {

        $('#rejectModal').modal('hide');
        $('#paymentsTable').DataTable().ajax.reload(null,false);

        setTimeout(function(){
            $('#rejectSuccessModal').modal('show');
        }, 300);
    });
});
</script>
@endpush
