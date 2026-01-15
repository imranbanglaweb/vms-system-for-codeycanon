@extends('admin.dashboard.master')

@section('main_content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<section role="main" class="content-body" style="background:#eef1f6; min-height:100vh;">
<div class="container py-5">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary" style="font-size:28px;">
            <i class="fa fa-shuttle-van me-2"></i> Transport Assignment Panel
        </h3>
    </div>

    <!-- MAIN CARD -->
    <div class="card shadow rounded-4 border-0">
        <div class="card-body p-4">

            <!-- REQUISITION INFO -->
            <h5 class="mb-4 fw-semibold text-secondary">
                <i class="fa fa-info-circle me-2"></i> Requisition Details
            </h5>

            <div class="row mb-4 g-4">
                <div class="col-md-3">
                    <div class="info-box bg-white shadow-sm p-3 rounded-4 text-center border">
                        <span class="fw-bold fs-5 text-primary d-block">Req No</span>
                        <span class="fs-6 text-muted">{{ $requisition->requisition_number }}</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box bg-white shadow-sm p-3 rounded-4 text-center border">
                        <span class="fw-bold fs-5 text-primary d-block">Requester</span>
                        <span class="fs-6 text-muted">{{ $requisition->requestedBy->name }}</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box bg-primary shadow-sm p-3 rounded-4 text-center">
                        <span class="fw-bold fs-5 text-white d-block">Department</span>
                        <span class="fs-6 text-white">{{ $requisition->department->department_name }}</span>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="info-box bg-success shadow-sm p-3 rounded-4 text-center">
                        <span class="fw-bold fs-5 text-white d-block">Passengers</span>
                        <span class="fs-6 text-white">
                            {{ $requisition->number_of_passenger }}
                            @if($requisition->unit)
                                <span class="fw-normal">({{ $requisition->unit->unit_name }})</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <hr class="my-4">

            <!-- ASSIGNMENT SECTION -->
            <h5 class="mb-3 fw-semibold text-secondary">
                <i class="fa fa-car-side me-2"></i> Assign Vehicle & Driver
            </h5>

            <form id="assignForm">
                @csrf
                <div class="row g-3">

                    <!-- <div class="col-md-6">
                        <label class="form-label fw-semibold">Select Vehicle</label>
                        <select name="assigned_vehicle_id" class="form-select select2 form-select-lg">
                            <option value="">-- Choose Vehicle --</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}">{{ $v->vehicle_name }} ({{ $v->model }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Select Driver</label>
                        <select name="assigned_driver_id" class="form-select select2 form-select-lg">
                            <option value="">-- Choose Driver --</option>
                            @foreach($drivers as $d)
                                <option value="{{ $d->id }}">{{ $d->driver_name }}</option>
                            @endforeach
                        </select>
                    </div> -->

                    <!-- VEHICLE SELECT -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Select Vehicle</label>
                            <select name="assigned_vehicle_id" id="vehicleSelect" class="form-select select2 form-select-lg">
                                <option value="">-- Choose Vehicle --</option>
                                @foreach($vehicles as $v)
                                    <option value="{{ $v->id }}"
                                        data-status="{{ $v->availability_status }}"
                                        @if(strtolower($v->availability_status) === 'assigned') disabled @endif
                                    >
                                        {{ $v->vehicle_name }} ({{ $v->model }})
                                    </option>
                                @endforeach
                            </select>
                            <div id="vehicleStatus" class="mt-2 fw-semibold"></div>
                        </div>

                        <!-- DRIVER SELECT -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Select Driver</label>
                            <select name="assigned_driver_id" id="driverSelect" class="form-select select2 form-select-lg">
                                <option value="">-- Choose Driver --</option>
                                @foreach($drivers as $d)
                                    <option value="{{ $d->id }}"
                                        data-status="{{ $d->availability_status }}"
                                        @if(strtolower($d->availability_status) === 'assigned') disabled @endif
                                    >
                                        {{ $d->driver_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div id="driverStatus" class="mt-2 fw-semibold"></div>
                        </div>

                        <!-- Assignment Summary -->
                        <div class="mt-4 p-3 bg-light rounded-4 border" id="assignmentSummary" style="display:none;">
                            <h6 class="fw-bold mb-2">Assignment Summary:</h6>
                            <p class="mb-1"><strong>Vehicle:</strong> <span id="summaryVehicle"></span></p>
                            <p class="mb-1"><strong>Driver:</strong> <span id="summaryDriver"></span></p>
                        </div>

                </div>

                <button type="button" onclick="submitAssign()" class="btn btn-primary btn-lg mt-4 rounded-4 w-100">
                    <i class="fa fa-paper-plane me-2"></i> Assign Now
                </button>
            </form>

            <hr class="my-5">

            <!-- FINAL APPROVAL -->
            <h5 class="mb-3 fw-semibold text-secondary">
                <i class="fa fa-check-circle me-2"></i> Final Approval Action
            </h5>

            <form id="actionForm">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Remarks</label>
                    <textarea name="remarks" class="form-control form-control-lg" placeholder="Enter remarks before approval/rejection"></textarea>
                </div>

                <div class="d-flex gap-3 mt-3 flex-wrap">
                    <button type="button" onclick="submitAction('approve')" class="btn btn-success btn-lg flex-fill rounded-4">
                        <i class="fa fa-thumbs-up me-2"></i> Approve
                    </button>

                    <button type="button" onclick="submitAction('reject')" class="btn btn-danger btn-lg flex-fill rounded-4">
                        <i class="fa fa-thumbs-down me-2"></i> Reject
                    </button>

                    <a href="{{ route('transport.approvals.index') }}" class="btn btn-secondary btn-lg flex-fill rounded-4">
                        <i class="fa fa-times me-2"></i> Cancel
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        if ((vText && vText.trim() !== '-- Choose Vehicle --') || (dText && dText.trim() !== '-- Choose Driver --')) {
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
    // Requires backend route: transport.approvals.availability
    function refreshAvailability() {
        $.get("{{ route('transport.approvals.availability', $requisition->id) }}")
            .done(function(res){
                // res expected: { vehicles: [{id, availability_status}], drivers: [{id, availability_status}], assigned_info: { vehicle_id, driver_id, vehicle_name, driver_name } }
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

                // optional: if server sends currently assigned info, show small popup (non-intrusive)
                if (res.assigned_info) {
                    // only show if there is a conflict with the current requisition
                    // e.g. assigned_info = { vehicle_id, vehicle_name, driver_id, driver_name } OR message
                    $('#vehicleStatus').append('');
                    // you can implement a subtle badge update or toast here if you want
                }

                // update status displays/summary after refresh
                updateStatusDisplays();
                updateSummary();
            })
            .fail(function(){
                // silent fail (do nothing) — avoid annoying the user
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
$(document).ready(function(){
    $('.select2').select2({ width: "100%" });


    
});

// SweetAlert Popup
function alertBox(type, message){
    Swal.fire({
        icon: type,
        text: message,
        confirmButtonColor: type === 'success' ? '#28a745' : '#dc3545',
        confirmButtonText: "OK",
        background: "#f4f6f9",
        color: "#333",
        customClass: { popup: "rounded-4 shadow" }
    });
}

// Assign Vehicle & Driver
// function submitAssign() {
//     if(!$('select[name="assigned_vehicle_id"]').val() || !$('select[name="assigned_driver_id"]').val()){
//         alertBox('error', 'Please select both vehicle and driver.');
//         return;
//     }

//     $.post("{{ route('transport.approvals.assign', $requisition->id) }}",
//         $("#assignForm").serialize(),
//         function(res){
//             alertBox('success', res.message);
//             setTimeout(()=>location.reload(), 1500);
//         }
//     ).fail(function(xhr){
//         let msg = xhr.responseJSON?.message || "Assignment failed.";
//         alertBox('error', msg);
//     });
// }


function submitAssign() {

    if (!$('select[name="assigned_vehicle_id"]').val() || !$('select[name="assigned_driver_id"]').val()) {
        alertBox('error', 'Please select both vehicle and driver.');
        return;
    }

    $.ajax({
        url: "{{ route('transport.approvals.assign', $requisition->id) }}",
        type: "POST",
        data: $("#assignForm").serialize(),
        success: function(res) {
            alertBox('success', res.message);
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

                // CASE 2: Custom backend conflict messages (vehicle/driver already assigned)
                else if (xhr.responseJSON.message) {
                    alertBox('error', xhr.responseJSON.message);
                }
                
            } else {
                alertBox('error', 'Assignment failed. Please try again.');
            }
        }
    });
}


// Approve or Reject
function submitAction(type){
    let remarks = $('textarea[name="remarks"]').val().trim();

    if(!remarks){
        alertBox('error', 'Remarks are required.');
        return;
    }

    let url = type === "approve"
        ? "{{ route('transport.approvals.approve', $requisition->id) }}"
        : "{{ route('transport.approvals.reject', $requisition->id) }}";

    $.post(url, $("#actionForm").serialize(), function(res){
        alertBox('success', res.message);
        setTimeout(()=>window.location.href="{{ route('transport.approvals.index') }}", 1500);
    }).fail(function(xhr){
        let msg = xhr.responseJSON?.message || "Action failed.";
        alertBox('error', msg);
    });
}
</script>

@endsection
