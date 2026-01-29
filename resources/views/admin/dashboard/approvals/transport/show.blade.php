@extends('admin.dashboard.master')

@section('main_content')
<style>
    .text-secondary {
        color: #0088cc !important;
        font-size: 15px;
        font-weight: 700;
    }
    .text-dark {
        color: #000!important;
        font-size: 16px;
        font-weight: 600;
    }
    .table th,td{
        font-size: 15px!important;
        font-weight: 500!important;
    }
    .table th{
        font-size: 16px!important;
        font-weight: 500!important;
        color: #fff!important;
        background-color: #0088cc!important;
    }
</style>
<section role="main" class="content-body" style="background-color:#eef2f7;">
<br>
<div class="container py-4">
    <!-- PAGE TITLE -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa fa-file-alt me-2"></i> Transport Requisition Review
        </h2>
    </div>
    <br>
    <!-- CARD -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">
            <h4 class="fw-bold text-dark mb-3">
                <i class="fa fa-info-circle me-2"></i> Requisition Information
            </h4>
            <hr>
            <!-- GRID INFO -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Requisition No</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->requisition_number }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Requested By</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->requestedBy->name }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Department</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->department->department_name }}</div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Unit</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->unit->unit_name ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Number of Passengers</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->number_of_passenger }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Created Date</span>
                        <div class="fs-5 fw-bold text-dark">
                            {{ $requisition->created_at->format('d M Y, h:i A') }}
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">From Location</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->from_location ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">To Location</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->to_location ?? '-' }}</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box p-3 bg-white rounded-3 shadow-sm">
                        <span class="fw-bold text-secondary">Pickup Location</span>
                        <div class="fs-5 fw-bold text-dark">{{ $requisition->pickup_location ?? '-' }}</div>
                    </div>
                </div>
            </div>
            <hr>
            <!-- Passenger List -->
            <h4 class="fw-bold text-dark mt-5 mb-3">
                <i class="fa fa-users me-2"></i> Passenger List
            </h4>
            <table class="table table-bordered table-striped shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">SL</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requisition->passengers as $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $p->employee->name }}</td>
                            <td>{{ $p->employee->designation }}</td>
                            <td>{{ $p->employee->department->department_name ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr class="mt-4">
            <!-- Vehicle/Driver Assignment Section (keep your existing form here) -->
            @include('admin.dashboard.approvals.transport.partials.assignment', ['requisition' => $requisition, 'vehicles' => $vehicles, 'drivers' => $drivers])
            <hr class="my-5">
            <!-- ACTION BUTTONS -->
            <form id="actionForm" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Remarks</label>
                    <textarea name="remarks" class="form-control form-control-lg" placeholder="Enter remarks before approval/rejection"></textarea>
                </div>
                <div class="d-flex gap-3">
                    <button type="button" class="btn btn-success btn-lg px-4 fw-bold" onclick="submitAction('approve')">
                        <i class="fa fa-thumbs-up me-2"></i> Approve
                    </button>
                    <button type="button" class="btn btn-danger btn-lg px-4 fw-bold" onclick="submitAction('reject')">
                        <i class="fa fa-thumbs-down me-2"></i> Reject
                    </button>
                    <a href="{{ route('transport.approvals.index') }}" class="btn btn-secondary btn-lg px-4 fw-bold">
                        <i class="fa fa-arrow-left me-2"></i> Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</section>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
$(document).ready(function(){

    // initialize select2 (clean option A style)
    $('.select2').select2({
        width: '100%',
        templateResult: function(opt) {
            if (!opt.id) return opt.text;
            var status = $(opt.element).data('status') || '';
            // Option A: simple text with indicator
            if (status.toLowerCase() === 'assigned') {
                return $('<span class="text-danger">' + opt.text + ' — Unavailable</span>');
            } else {
                return $('<span class="text-success">' + opt.text + ' — Available</span>');
            }
        },
        templateSelection: function(opt) {
            if (!opt.id) return opt.text;
            // remove the "- Available/Unavailable" in selection, show plain text
            return opt.text;
        },
        escapeMarkup: function(m) { return m; }
    });

    // helper: update small badges/text below selects
    function updateStatusDisplays() {
        let vStatus = $('#vehicleSelect option:selected').data('status') || '';
        let dStatus = $('#driverSelect option:selected').data('status') || '';

        if (!vStatus) $('#vehicleStatus').html('');
        else if (vStatus.toLowerCase() === 'assigned') {
            $('#vehicleStatus').html('<span class="text-danger">🚫 Vehicle already assigned</span>');
        } else {
            $('#vehicleStatus').html('<span class="text-success">✔ Vehicle available</span>');
        }

        if (!dStatus) $('#driverStatus').html('');
        else if (dStatus.toLowerCase() === 'assigned') {
            $('#driverStatus').html('<span class="text-danger">🚫 Driver already assigned</span>');
        } else {
            $('#driverStatus').html('<span class="text-success">✔ Driver available</span>');
        }
    }

    // show assignment summary
    function updateSummary() {
        let vText = $('#vehicleSelect option:selected').text();
        let dText = $('#driverSelect option:selected').text();

        // remove " — Available/Unavailable" suffix if select2 shows it in text
        vText = vText ? vText.replace(/\s+—\s+(Available|Unavailable|Unavailable)/, '') : '';
        dText = dText ? dText.replace(/\s+—\s+(Available|Unavailable|Unavailable)/, '') : '';

        if ((vText && vText.trim() !== '-- Select Vehicle --') || (dText && dText.trim() !== '-- Select Driver --')) {
            $('#assignmentSummary').show();
            $('#summaryVehicle').text(vText.trim() || '—');
            $('#summaryDriver').text(dText.trim() || '—');
        } else {
            $('#assignmentSummary').hide();
        }
    }

    // when selection changes, update status & summary, and block if unavailable
    $('#vehicleSelect').on('change', function(){
        let status = $(this).find(':selected').data('status') || '';
        if (status.toLowerCase() === 'assigned' && $(this).val() !== '') {
            // show popup and reset selection
            Swal.fire({
                icon: 'warning',
                title: 'Vehicle Unavailable',
                text: 'Selected vehicle is currently assigned. Please choose another vehicle.',
                confirmButtonText: 'OK'
            });
            $(this).val(null).trigger('change'); // clear selection
        }
        updateStatusDisplays();
        updateSummary();
    });

    $('#driverSelect').on('change', function(){
        let status = $(this).find(':selected').data('status') || '';
        if (status.toLowerCase() === 'assigned' && $(this).val() !== '') {
            // show popup and reset selection
            Swal.fire({
                icon: 'warning',
                title: 'Driver Unavailable',
                text: 'Selected driver is currently assigned. Please choose another driver.',
                confirmButtonText: 'OK'
            });
            $(this).val(null).trigger('change'); // clear selection
        }
        updateStatusDisplays();
        updateSummary();
    });

    // run initial update (if something pre-selected)
    updateStatusDisplays();
    updateSummary();

    // Live refresh: poll availability endpoint every 10 seconds and update options
    function refreshAvailability() {
        $.get("{{ route('transport.approvals.availability', $requisition->id) }}")
            .done(function(res){
                if (!res) return;

                // update options for vehicles
                if (res.vehicles && Array.isArray(res.vehicles)) {
                    res.vehicles.forEach(function(v){
                        let opt = $('#vehicleSelect option[value="'+v.id+'"]');
                        if (opt.length) {
                            opt.data('status', v.availability_status);
                            // disable if assigned
                            if (String(v.availability_status).toLowerCase() === 'assigned') {
                                opt.prop('disabled', true);
                            } else {
                                opt.prop('disabled', false);
                            }
                        }
                    });
                }

                // update options for drivers
                if (res.drivers && Array.isArray(res.drivers)) {
                    res.drivers.forEach(function(d){
                        let opt = $('#driverSelect option[value="'+d.id+'"]');
                        if (opt.length) {
                            opt.data('status', d.availability_status);
                            if (String(d.availability_status).toLowerCase() === 'assigned') {
                                opt.prop('disabled', true);
                            } else {
                                opt.prop('disabled', false);
                            }
                        }
                    });
                }

                // refresh select2 so disabled changes take effect visually
                $('#vehicleSelect, #driverSelect').trigger('change.select2');

                // update status displays/summary after refresh
                updateStatusDisplays();
                updateSummary();
            })
            .fail(function(){
                console.warn('Failed to refresh availability');
            });
    }

    // start polling
    var availabilityInterval = setInterval(refreshAvailability, 10000); // 10s
    // optional: run once immediately
    refreshAvailability();

    // Auto-stop polling when user leaves page (cleanup)
    $(window).on('beforeunload', function(){ clearInterval(availabilityInterval); });

});
</script>
<script>
// SweetAlert Popup
function alertBox(type, message, title = ''){
    Swal.fire({
        icon: type,
        title: title,
        text: message,
        confirmButtonColor: type === 'success' ? '#28a745' : '#dc3545',
        confirmButtonText: 'OK',
        background: '#f4f6f9',
        color: '#333',
        customClass: { popup: 'rounded-4 shadow' }
    });
}

// Assign Vehicle & Driver
function submitAssign() {
    if (!$('#vehicleSelect').val() || !$('#driverSelect').val()) {
        alertBox('error', 'Please select both vehicle and driver.');
        return;
    }

    $.ajax({
        url: "{{ route('transport.approvals.assign', $requisition->id) }}",
        type: 'POST',
        data: $('#assignForm').serialize(),
        success: function(res) {
            alertBox('success', res.message, 'Success!');
            setTimeout(() => location.reload(), 1500);
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                // CASE 1: Laravel validation errors
                if (xhr.responseJSON.errors) {
                    let errors = xhr.responseJSON.errors;
                    let firstError = Object.values(errors)[0][0];
                    alertBox('error', firstError);
                }
                // CASE 2: Custom backend conflict messages
                else if (xhr.responseJSON.message) {
                    alertBox('error', xhr.responseJSON.message);
                }
            } else {
                alertBox('error', 'Assignment failed. Please try again.');
            }
        }
    });
}

// Approve or Reject - remarks required only for reject
function submitAction(type){
    let remarks = $('textarea[name="remarks"]').val().trim();
    
    // For reject, remarks are required
    if(type === 'reject' && !remarks){
        alertBox('error', 'Remarks are required for rejection.');
        return;
    }

    let url = type === 'approve'
        ? "{{ route('transport.approvals.approve', $requisition->id) }}"
        : "{{ route('transport.approvals.reject', $requisition->id) }}";

    $.post(url, $('#actionForm').serialize(), function(res){
        alertBox('success', res.message, 'Success!');
        setTimeout(()=>window.location.href="{{ route('transport.approvals.index') }}", 1500);
    }).fail(function(xhr){
        let msg = xhr.responseJSON?.message || 'Action failed.';
        alertBox('error', msg);
    });
}
</script>
@endsection
