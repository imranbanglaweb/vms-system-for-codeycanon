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
</style>

<section role="main" class="content-body" style="background:#fff">

<div class="container-fluid p-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h3 class="m-0">
                <i class="fa fa-car-side me-2 text-primary"></i>
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
                <!-- REQUESTED EMPLOYEE SECTION -->
                <!-- ============================ -->
                <div class="row mb-4">

                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fa fa-user-tie text-primary me-1"></i> Requested Employee
                        </label>
                        <select id="employee_id" name="employee_id" class="form-select form-select-lg select2">
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <small class="text-danger error-text employee_id_error"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-building text-primary me-1"></i> Department</label>
                        <input type="text" id="department_name" class="form-control form-control-lg" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-sitemap text-primary me-1"></i> Unit</label>
                        <input type="text" id="unit_name" class="form-control form-control-lg" readonly>
                    </div>
                       <input type="hidden" id="department_id" class="form-control form-control-lg" 
                               value="{{ $requisition->department->id ?? '' }}" name="department_id">
                               
                         <input type="hidden" id="unit_id" class="form-control form-control-lg" 
                               value="{{ $requisition->unit->id ?? '' }}" name="unit_id">

                </div>

                <hr>

                <!-- ============================ -->
                <!-- VEHICLE & DRIVER SECTION -->
                <!-- ============================ -->
                <div class="row mb-4">

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-car text-primary me-1"></i> Vehicle</label>
                        <select id="vehicle_type" name="vehicle_type" class="form-select form-select-lg select2">
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

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-chair text-primary me-1"></i> Seat Capacity</label>
                        <input type="number" id="seat_capacity_display" class="form-control form-control-lg" readonly placeholder="Auto-populated from vehicle">
                        <input type="hidden" id="seat_capacity" name="seat_capacity" value="">
                        <input type="hidden" id="number_of_passenger" name="number_of_passenger" value="">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">
                            <i class="fa fa-calendar text-primary me-1"></i> Requisition Date
                        </label>
                        <input type="date" name="requisition_date" class="form-control form-control-lg">
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
                        <input type="text" name="from_location" class="form-control form-control-lg">
                        <small class="text-danger error-text from_location_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-map-marker-alt text-primary me-1"></i> To</label>
                        <input type="text" name="to_location" class="form-control form-control-lg">
                        <small class="text-danger error-text to_location_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-clock text-primary me-1"></i> Pickup Time</label>
                        <input type="text" name="travel_date" class="form-control datetimepicker"
       placeholder="Select pickup date & time">

                        <small class="text-danger error-text travel_date_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-calendar-check text-primary me-1"></i> Return Time</label>
                   
                        <input type="text" name="return_date" class="form-control datetimepicker"
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
                        <textarea name="purpose" class="form-control form-control-lg" rows="3"></textarea>
                        <small class="text-danger error-text purpose_error"></small>
                    </div>

                </div>
                
<div class="my-4 border-top"></div>


                <!-- ============================ -->
                <!-- PASSENGERS -->
                <!-- ============================ -->
                <h5 class="fw-bold mb-3">
                    <i class="fa fa-users text-primary me-1"></i> Add Passengers
                    <small class="text-muted ms-2" id="passengerCountInfo"></small>
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

                <!-- ============================ -->
                <!-- SUBMIT -->
                <!-- ============================ -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-4">
                        <i class="fa fa-paper-plane me-2"></i> Submit Requisition
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

</section>
@endsection




@push('scripts')
{{-- Flatpickr --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {

    /* ================= AJAX FORM SUBMIT ================= */
    $('#requisitionForm').on('submit', function(e) {
        e.preventDefault();

        let form = $(this);
        let btn  = form.find('button[type="submit"]');

        $('.error-text').text('');

        // Count passengers from the table (only count rows with selected employees)
        let passengerCount = countPassengers();
        let seatCapacity = parseInt($('#seat_capacity').val()) || 0;
        
        // Validate passenger count against vehicle capacity
        if (passengerCount > 0 && seatCapacity > 0 && passengerCount > seatCapacity) {
            $('.passenger_count_error').text('Number of passengers (' + passengerCount + ') exceeds vehicle seat capacity (' + seatCapacity + '). Please remove some passengers or select a different vehicle.');
            // Scroll to the error field
            $('html, body').animate({
                scrollTop: $('#passengerTable').offset().top - 100
            }, 500);
            return false;
        }

        btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Submitting...');

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                }).then(() => {
                    window.location.href = "{{ route('requisitions.index') }}";
                });
            },
            error: function(xhr) {
                btn.prop('disabled', false).html('<i class="fa fa-paper-plane me-2"></i> Submit Requisition');

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function(field, messages) {
                        let errorClass = field.replace(/\./g, '_') + '_error';
                        $('.' + errorClass).text(messages[0]);
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong', 'error');
                }
            }
        });
    });

    /* ================= VEHICLE DETAILS (Driver & Seat Capacity) ================= */
    $('#vehicle_type').on('change', function () {
        let vehicleId = $(this).val();

        // Clear fields if no vehicle selected
        if (!vehicleId) {
            $('#driver_name_display').val('');
            $('#driver_id').val('');
            $('#seat_capacity_display').val('');
            $('#seat_capacity').val('');
            $('#number_of_passenger').val('');
            updatePassengerCountInfo();
            return;
        }

        // Fetch vehicle details (driver name and seat capacity)
        $.get("{{ url('/vehicles') }}/" + vehicleId + "/details", function (res) {
            if (res.success) {
                $('#driver_name_display').val(res.driver_name || 'No driver assigned');
                $('#driver_id').val(res.driver_id || '');
                $('#seat_capacity_display').val(res.seat_capacity || 0);
                $('#seat_capacity').val(res.seat_capacity || 0);
                // Set number_of_passenger to seat_capacity
                $('#number_of_passenger').val(res.seat_capacity || 0);
                
                // Update passenger count info and validate
                updatePassengerCountInfo();
                validatePassengerCount();
            }
        }).fail(function () {
            $('#driver_name_display').val('Error loading driver');
            $('#driver_id').val('');
            $('#seat_capacity_display').val('');
            $('#seat_capacity').val('');
            $('#number_of_passenger').val('');
        });
    });

    /* ================= COUNT PASSENGERS FROM TABLE ================= */
    function countPassengers() {
        let count = 0;
        $('#passengerTable tbody tr').each(function() {
            let employeeId = $(this).find('.passenger-employee').val();
            if (employeeId && employeeId !== '') {
                count++;
            }
        });
        return count;
    }

    /* ================= UPDATE PASSENGER COUNT INFO ================= */
    function updatePassengerCountInfo() {
        let passengerCount = countPassengers();
        let seatCapacity = parseInt($('#seat_capacity').val()) || 0;
        
        if (seatCapacity > 0) {
            $('#passengerCountInfo').text('(' + passengerCount + ' / ' + seatCapacity + ' seats)');
            if (passengerCount > seatCapacity) {
                $('#passengerCountInfo').removeClass('text-muted').addClass('text-danger');
            } else {
                $('#passengerCountInfo').removeClass('text-danger').addClass('text-muted');
            }
        } else {
            $('#passengerCountInfo').text('(' + passengerCount + ' passengers)');
            $('#passengerCountInfo').removeClass('text-danger').addClass('text-muted');
        }
    }

    /* ================= PASSENGER COUNT VALIDATION ================= */
    function validatePassengerCount(showPopup = false) {
        let passengerCount = countPassengers();
        let seatCapacity = parseInt($('#seat_capacity').val()) || 0;
        
        // Only validate if there are passengers and seat capacity is set
        if (passengerCount > 0 && seatCapacity > 0 && passengerCount > seatCapacity) {
            let errorMsg = 'Number of passengers (' + passengerCount + ') exceeds vehicle seat capacity (' + seatCapacity + ')';
            $('.passenger_count_error').text(errorMsg);
            
            if (showPopup) {
                Swal.fire({
                    icon: 'error',
                    title: 'Passenger Limit Exceeded',
                    text: errorMsg + '. Please remove some passengers or select a different vehicle.',
                    confirmButtonColor: '#d33'
                });
            }
            return false;
        } else {
            $('.passenger_count_error').text('');
            return true;
        }
    }

    /* ================= EMPLOYEE DETAILS (Department & Unit) ================= */
    $('#employee_id').on('change', function () {
        let employeeId = $(this).val();

        // Clear fields if no employee selected
        if (!employeeId) {
            $('#department_name').val('');
            $('#unit_name').val('');
            $('#department_id').val('');
            $('#unit_id').val('');
            return;
        }

        $.get("{{ url('/get-employee-details') }}/" + employeeId, function (res) {
            $('#department_name').val(res.department || '');
            $('#unit_name').val(res.unit || '');
            $('#department_id').val(res.department_id || '');
            $('#unit_id').val(res.unit_id || '');
        }).fail(function () {
            $('#department_name').val('');
            $('#unit_name').val('');
            $('#department_id').val('');
            $('#unit_id').val('');
        });
    });

    /* ================= PASSENGER EMPLOYEE DETAILS ================= */
    $(document).on('change', '.passenger-employee', function () {
        let row = $(this).closest('tr');
        let employeeId = $(this).val();

        if (!employeeId) {
            row.find('.passenger-department').val('');
            row.find('.passenger-unit').val('');
            // Update count and validate when employee is deselected
            updatePassengerCountInfo();
            validatePassengerCount();
            return;
        }

        $.get("{{ url('/get-employee-details') }}/" + employeeId, function (res) {
            row.find('.passenger-department').val(res.department || '');
            row.find('.passenger-unit').val(res.unit || '');
            // Update count and validate when employee is selected - show popup if exceeds
            updatePassengerCountInfo();
            validatePassengerCount(true);
        }).fail(function () {
            row.find('.passenger-department').val('');
            row.find('.passenger-unit').val('');
        });
    });

    /* ================= ADD/REMOVE PASSENGER ROWS ================= */
    let rowIndex = 1;

    $(document).on('click', '.addRow', function () {
        // Check if adding would exceed capacity
        let seatCapacity = parseInt($('#seat_capacity').val()) || 0;
        let currentCount = countPassengers();
        
        if (seatCapacity > 0 && currentCount >= seatCapacity) {
            Swal.fire({
                icon: 'error',
                title: 'Passenger Limit Reached',
                text: 'Cannot add more passengers. Vehicle seat capacity (' + seatCapacity + ') has been reached. Please select a different vehicle with more capacity.',
                confirmButtonColor: '#d33'
            });
            return false;
        }
        
        let newRow = `
            <tr>
                <td>
                    <select name="passengers[${rowIndex}][employee_id]" class="form-select passenger-employee select2">
                        <option value="">-- Select --</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger error-text passengers_${rowIndex}_employee_id_error"></small>
                </td>
                <td>
                    <input type="text" class="form-control passenger-department" readonly>
                </td>
                <td>
                    <input type="text" class="form-control passenger-unit" readonly>
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm removeRow"><i class="fa fa-minus"></i></button>
                </td>
            </tr>
        `;
        $('#passengerTable tbody').append(newRow);
        
        // Reinitialize select2 for the new row if needed
        $('#passengerTable tbody tr:last .select2').select2();
        
        rowIndex++;
        
        // Update count info
        updatePassengerCountInfo();
    });

    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
        // Update count and clear error after removing
        updatePassengerCountInfo();
        validatePassengerCount();
    });

    /* ================= FLATPICKR DATETIME PICKER ================= */
    flatpickr('.datetimepicker', {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        time_24hr: true
    });

});
</script>


@endpush
