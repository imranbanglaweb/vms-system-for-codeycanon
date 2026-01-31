@extends('admin.dashboard.master')

@section('main_content')

<style>
    body {
        background: #fff !important;
    }

    .form-label {
        font-size: 1.7rem;
        font-weight: 600;
    }
    .card {
        border-radius: 16px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #1e1e2f, #2a2a40);
        border-bottom: 0;
    }
    .form-control-lg, .form-select-lg {
        font-size: 1.5rem;
        padding: 10px 14px;
    }

    table td, table th {
        font-size: 1.65rem;
    }

    .error-text {
        font-size: 1.55rem;
        font-weight: 500;
        transition: all 0.3s;
        animation: fadeIn 0.5s;
    }
     @keyframes fadeIn {
         from {opacity: 0; transform: translateY(-4px);}
         to {opacity: 1; transform: translateY(0);}
     }

    .btn-lg {
        border-radius: 30px;
        padding: 10px 28px;
        font-size: 1.45rem;
    }
    
    .form-control[readonly] {
        background-color: #f8f9fa;
        cursor: not-allowed;
    }
    
    .passenger-row {
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
    
    .table {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #1e1e2f, #2a2a40);
        color: #fff;
        border: none;
        padding: 15px;
        font-weight: 600;
    }
    
    .table tbody td {
        padding: 12px 15px;
        vertical-align: middle;
        border-color: #e0e0e0;
    }
    
    .table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    .table .form-control, 
    .table .form-select {
        border-radius: 6px;
    }
    
    .passenger-count-badge {
        font-size: 0.9rem;
        padding: 4px 12px;
        border-radius: 20px;
    }
</style>

<section role="main" class="content-body" style="background:#fff">

<div class="container-fluid p-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h3 class="m-0">
                <i class="fa fa-car-side me-2 text-warning"></i>
                Create Requisition
            </h3>
            <a href="{{ route('requisitions.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body p-4">

            <!-- AJAX Message -->
            <div id="formMessage" class="alert d-none"></div>

            <form id="requisitionForm" action="{{ route('requisitions.store') }}" method="POST">
                @csrf

                <!-- ============================ -->
                @php
                    $isReadonly = isset($selectedEmployeeId) && $selectedEmployeeId;
                @endphp
                <!-- REQUESTED EMPLOYEE SECTION -->
                <!-- ============================ -->
                <div class="row mb-4">

                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fa fa-user-tie text-primary me-1"></i> Requested Employee <span class="text-danger">*</span>
                        </label>
                        <select id="employee_id" name="employee_id" class="form-select form-select-lg select2 {{ $isReadonly ? '' : '' }}" {{ $isReadonly ? 'disabled' : '' }}>
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ isset($selectedEmployeeId) && $selectedEmployeeId == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        @if($isReadonly)
                            <input type="hidden" name="employee_id" value="{{ $selectedEmployeeId }}">
                        @endif
                        <small class="text-danger error-text employee_id_error"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-building text-primary me-1"></i> Department <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light"><i class="fa fa-sitemap text-muted"></i></span>
                            <select id="department_id" name="department_id" class="form-select form-select-lg">
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->department_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text department_id_error"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-layer-group text-primary me-1"></i> Unit <span class="text-danger">*</span></label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light"><i class="fa fa-cubes text-muted"></i></span>
                            <select id="unit_id" name="unit_id" class="form-select form-select-lg">
                                <option value="">-- Select Unit --</option>
                                @foreach($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->unit_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <small class="text-danger error-text unit_id_error"></small>
                    </div>

                </div>

                <hr>

                <!-- ============================ -->
                <!-- VEHICLE & DRIVER SECTION -->
                <!-- ============================ -->
                <div class="row mb-4">

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-car text-primary me-1"></i> Vehicle</label><br>
                        <select id="vehicle_id" name="vehicle_id" class="form-select form-select-lg select2">
                            <option value="">Select vehicle</option>
                            @foreach($vehicles as $id => $name)
                                <option value="{{ $name->id }}">{{ $name->vehicle_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text vehicle_id_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-id-badge text-primary me-1"></i> Driver</label>
                        <input type="text" id="driver_name_display" class="form-control form-control-lg" readonly placeholder="Auto-populated from vehicle">
                        <input type="hidden" id="driver_id" name="driver_id" value="">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label"><i class="fa fa-chair text-primary me-1"></i> Seat Capacity</label>
                        <input type="number" id="seat_capacity_display" class="form-control form-control-lg" readonly placeholder="Auto-populated" value="">
                        <input type="hidden" id="seat_capacity" name="seat_capacity" value="">
                        <input type="hidden" id="number_of_passenger" name="number_of_passenger" value="1">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fa fa-calendar text-primary me-1"></i> Requisition Date
                        </label>
                        <input type="date" name="requisition_date" class="form-control form-control-lg" value="{{ date('Y-m-d') }}">
                        <small class="text-danger error-text requisition_date_error"></small>
                    </div>

                </div>

                <hr>

                <!-- ============================ -->
                <!-- TRAVEL DETAILS -->
                <!-- ============================ -->
                <div class="row mb-4">

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-location-dot text-primary me-1"></i> From</label>
                        <input type="text" name="from_location" class="form-control form-control-lg" placeholder="Starting location">
                        <small class="text-danger error-text from_location_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-map-marker-alt text-primary me-1"></i> To</label>
                        <input type="text" name="to_location" class="form-control form-control-lg" placeholder="Destination">
                        <small class="text-danger error-text to_location_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-clock text-primary me-1"></i> Pickup Time</label>
                        <input type="text" name="travel_date" class="form-control form-control-lg datetimepicker"
                               placeholder="Select pickup date & time">
                        <small class="text-danger error-text travel_date_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-calendar-check text-primary me-1"></i> Return Time</label>
                        <input type="text" name="return_date" class="form-control form-control-lg datetimepicker"
                               placeholder="Select return date & time">
                    </div>
                </div>

                <div class="my-4 border-top"></div>

                <!-- ============================ -->
                <!-- PURPOSE -->
                <!-- ============================ -->
                <div class="row mb-4">
                    <div class="col-md-12">
                        <label class="form-label"><i class="fa fa-list text-primary me-1"></i> Purpose</label>
                        <textarea name="purpose" class="form-control form-control-lg" rows="3" placeholder="Reason for requisition"></textarea>
                        <small class="text-danger error-text purpose_error"></small>
                    </div>
                </div>

                <div class="my-4 border-top"></div>

                <!-- ============================ -->
                <!-- PASSENGERS -->
                <!-- ============================ -->
                <h5 class="fw-bold mb-3">
                    <i class="fa fa-users text-primary me-1"></i> Add Passengers
                    <small class="text-muted ms-2 passenger-count-badge" id="passengerCountInfo"></small>
                </h5>
                <small class="text-danger error-text passenger_count_error d-block mb-2"></small>

                <table class="table table-bordered" id="passengerTable">
                    <thead class="table-light">
                        <tr>
                            <th>Employee</th>
                            <th>Department</th>
                            <th>Unit</th>
                            <th width="5%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>
                                <select name="passengers[0][employee_id]" class="form-select passenger-employee select2">
                                    <option value="">-- Select --</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger error-text passengers_0_employee_id_error"></small>
                            </td>

                            <td>
                                <input type="text" class="form-control passenger-department" readonly>
                            </td>

                            <td>
                                <input type="text" class="form-control passenger-unit" readonly>
                            </td>

                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm addRow"><i class="fa fa-plus"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Submit Button -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5" id="submitBtn">
                        <i class="fa fa-paper-plane me-2"></i> Submit Requisition
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</section>

{{-- Flatpickr --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function () {

    /* ================= INITIALIZE ================= */
    updatePassengerCountInfo();
    
    // Select2 is already initialized in master layout, reinitialize dynamic elements only

    /* ================= AUTO-LOAD EMPLOYEE DETAILS FOR LOGGED IN USER ================= */
    @if(isset($selectedEmployeeId) && $selectedEmployeeId)
        var selectedEmployeeId = {{ $selectedEmployeeId }};
        // Set the employee dropdown value
        $('#employee_id').val(selectedEmployeeId).trigger('change');
        
        // Fetch employee details using named route
        $.get("{{ route('employee.details', ['id' => $selectedEmployeeId]) }}", function (res) {
            // Set department dropdown
            $('#department_id').val(res.department_id || '').trigger('change');
            // Set unit dropdown
            $('#unit_id').val(res.unit_id || '').trigger('change');
        });
    @endif

    /* ================= BLOCK PAST DATES ================= */
    let today = new Date().toISOString().split('T')[0];
    $('input[name="requisition_date"]').attr('min', today);

    flatpickr('.datetimepicker', {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true,
        minDate: "today"
    });

    function updateHiddenPassengerField() {
        let count = countPassengers();
        $('#number_of_passenger').val(count);
    }

    /* ================= AJAX FORM SUBMIT ================= */
    $('#requisitionForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let btn = $('#submitBtn');
        $('.error-text').text('');

        let passengerCount = countPassengers();
        updateHiddenPassengerField();
        let seatCapacity = parseInt($('#seat_capacity').val()) || 0;

        if (seatCapacity > 0 && passengerCount > seatCapacity) {
            $('.passenger_count_error').text(
                'Passengers ('+passengerCount+') exceed vehicle capacity ('+seatCapacity+')'
            );
            $('html, body').animate({ scrollTop: $('#passengerTable').offset().top - 100 }, 500);
            return false;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');

        $.post(form.attr('action'), form.serialize())
            .done(res => {
                Swal.fire({ icon:'success', title:'Success', text:res.message })
                    .then(()=> window.location.href="{{ route('requisitions.index') }}");
            })
            .fail(xhr => {
                btn.prop('disabled', false).html('<i class="fa fa-paper-plane me-2"></i> Submit Requisition');
                if(xhr.status===422){
                    $.each(xhr.responseJSON.errors,(f,m)=>{
                        $('.'+f.replace(/\./g,'_')+'_error').text(m[0]);
                    });
                } else Swal.fire('Error','Something went wrong','error');
            });
    });

    /* ================= VEHICLE DETAILS ================= */
    $('#vehicle_id').on('change', function () {
        let vehicleId = $(this).val();
        if (!vehicleId) return resetVehicleFields();

            $.get("{{ url('/vehicles') }}/" + vehicleId + "/details", function (res) {
            if (!res.success) return resetVehicleFields();

            $('#driver_name_display').val(res.driver_name || 'No driver');
            $('#driver_id').val(res.driver_id || '');
            $('#seat_capacity_display').val(res.seat_capacity || 0);
            $('#seat_capacity').val(res.seat_capacity || 0);

            autoTrimPassengers(res.seat_capacity);
            updatePassengerCountInfo();
        });
    });

    function resetVehicleFields(){
        $('#driver_name_display,#seat_capacity_display').val('');
        $('#driver_id,#seat_capacity').val('');
        updatePassengerCountInfo();
    }

    function autoTrimPassengers(capacity){
        if (capacity <= 0) return;
        while(countPassengers()>capacity){
            $('#passengerTable tbody tr:not(:has(.addRow))').last().remove();
        }
    }

    /* ================= EMPLOYEE DETAILS ================= */
    $('#employee_id').on('change', function () {
        let id = $(this).val();
        if(!id) return clearEmployeeInfo();
        $.get("{{ route('employee.details', ['id' => '__ID__']) }}".replace('__ID__', id), function (res) {
            // Set department dropdown
            $('#department_id').val(res.department_id || '').trigger('change');
            // Set unit dropdown
            $('#unit_id').val(res.unit_id || '').trigger('change');
        });
    });

    function clearEmployeeInfo(){
        $('#department_id, #unit_id').val('').trigger('change');
    }

    /* ================= PASSENGER SELECTION ================= */
    $(document).on('change','.passenger-employee',function(){
        let row=$(this).closest('tr');
        let empId=$(this).val();
        let requester=$('#employee_id').val();

        if(empId && empId===requester){
            Swal.fire('Not Allowed','Requester cannot be a passenger','warning');
            return resetPassengerRow(row,this);
        }

        let duplicate=false;
        $('.passenger-employee').not(this).each(function(){
            if($(this).val() && $(this).val()===empId) duplicate=true;
        });

        if(duplicate){
            Swal.fire('Duplicate','Passenger already added','error');
            return resetPassengerRow(row,this);
        }

        if(!empId) return resetPassengerRow(row,this,false);

        $.get("{{ url('/get-employee-details') }}/" + empId, function (res) {
            row.find('.passenger-department').val(res.department);
            row.find('.passenger-unit').val(res.unit);
            updatePassengerCountInfo();
            validatePassengerCount(true);
        });
    });

    function resetPassengerRow(row,el,clearSelect=true){
        if(clearSelect) $(el).val('').trigger('change.select2');
        row.find('.passenger-department, .passenger-unit').val('');
        updatePassengerCountInfo();
    }

    /* ================= ADD/REMOVE ROWS ================= */
    let rowIndex = 1;

    $(document).on('click','.addRow',function(e){
        e.preventDefault();
        updateHiddenPassengerField();
        let cap=parseInt($('#seat_capacity').val())||0;
        if(cap>0 && countPassengers()>=cap){
            return Swal.fire('Limit Reached','Vehicle capacity full','error');
        }

        $('#passengerTable tbody').append(`
            <tr>
                <td>
                    <select name="passengers[${rowIndex}][employee_id]" class="form-select passenger-employee select2">
                        <option value="">-- Select --</option>
                        @foreach($employees as $e)
                        <option value="{{ $e->id }}">{{ $e->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger error-text passengers_${rowIndex}_employee_id_error"></small>
                </td>
                <td><input type="text" class="form-control passenger-department" readonly></td>
                <td><input type="text" class="form-control passenger-unit" readonly></td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                </td>
            </tr>
        `);

        $('#passengerTable tbody tr:last').find('select').select2();
        rowIndex++;
        updatePassengerCountInfo();
    });

    $(document).on('click','.removeRow',function(){
        $(this).closest('tr').remove();
        updatePassengerCountInfo();
        updateHiddenPassengerField();
    });

    /* ================= PASSENGER COUNT ================= */
    function countPassengers(){
        let c=0;
        $('.passenger-employee').each(function(){ if($(this).val()) c++; });
        return c;
    }

    function updatePassengerCountInfo(){
        let count=countPassengers();
        let cap=parseInt($('#seat_capacity').val())||0;
        let info=$('#passengerCountInfo');
        $('#number_of_passenger').val(count);

        if(cap>0){
            info.text(`(${count} / ${cap} seats)`);
            if(count>=cap){
                info.removeClass('text-muted').addClass('text-danger fw-bold');
                disableAddButton(true);
            } else {
                info.removeClass('text-danger fw-bold').addClass('text-muted');
                disableAddButton(false);
            }
        } else {
            info.text(`(${count} passengers)`);
            disableAddButton(false);
        }
    }

    function disableAddButton(disable){
        let btn=$('.addRow');
        btn.prop('disabled',disable)
           .toggleClass('btn-success',!disable)
           .toggleClass('btn-secondary',disable);
    }

    function validatePassengerCount(popup=false){
        let count=countPassengers();
        let cap=parseInt($('#seat_capacity').val())||0;
        if(cap>0 && count>cap && popup){
            Swal.fire('Exceeded','Passenger count exceeds seat capacity','error');
        }
    }

});
</script>

@endsection
