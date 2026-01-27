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

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-car text-primary me-1"></i> Vehicle</label>
                        <select id="vehicle_type" name="vehicle_type" class="form-select form-select-lg select2">
                            <option value="">Select vehicle</option>
                            @foreach($vehicles as $id => $name)
                                <option value="{{ $name->id }}">{{ $name->vehicle_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text vehicle_id_error"></small>
                    </div>

                  <div class="col-md-4">
    <label class="form-label"><i class="fa fa-id-badge text-primary me-1"></i> Driver</label>
    <select id="driver_id" name="driver_id" class="form-select form-select-lg">
        <option value="">Select Driver</option>
    </select>
</div>


                    <div class="col-md-4">
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
                <!-- PURPOSE & PASSENGERS COUNT -->
                <!-- ============================ -->
                <div class="row mb-4">

                    <div class="col-md-6">
                        <label class="form-label"><i class="fa fa-users text-primary me-1"></i> Number of Passengers</label>
                        <input type="number" name="number_of_passenger" class="form-control form-control-lg">
                        <small class="text-danger error-text number_of_passenger_error"></small>
                    </div>

                    <div class="col-md-6">
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
                </h5>

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

    /* ================= VEHICLE AUTO SUGGEST ================= */
    $('input[name="number_of_passenger"]').on('keyup change', function () {
        let count = $(this).val();

        if (!count || count < 1) return;

        $.get("{{ route('vehicles.by.capacity') }}", { passenger_count: count }, function (res) {
            let vehicleSelect = $('#vehicle_type');
            vehicleSelect.empty().append('<option value="">Select vehicle</option>');

            res.vehicles.forEach(v => {
                vehicleSelect.append(`<option value="${v.id}">${v.name} (Capacity: ${v.capacity})</option>`);
            });

            Swal.fire('Suggested', 'Vehicles updated based on passenger count', 'info');
        });
    });

    /* ================= DRIVER BY VEHICLE ================= */
    $('#vehicle_type').on('change', function () {
        let vehicleId = $(this).val();
        let driverSelect = $('#driver_id');

        driverSelect.html('<option value="">Loading...</option>');

        if (!vehicleId) {
            driverSelect.html('<option value="">Select Driver</option>');
            return;
        }
$.get("{{ route('drivers.by.vehicle', ':id') }}".replace(':id', vehicleId), function (res) {
            driverSelect.empty().append('<option value="">Select Driver</option>');

            if (res.drivers.length === 0) {
                driverSelect.append('<option value="">No driver assigned</option>');
                return;
            }

            res.drivers.forEach(d => {
                driverSelect.append(`<option value="${d.id}">${d.driver_name}</option>`);
            });
        });
    });

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
            return;
        }

        $.get("{{ url('/get-employee-details') }}/" + employeeId, function (res) {
            row.find('.passenger-department').val(res.department || '');
            row.find('.passenger-unit').val(res.unit || '');
        }).fail(function () {
            row.find('.passenger-department').val('');
            row.find('.passenger-unit').val('');
        });
    });

    /* ================= ADD/REMOVE PASSENGER ROWS ================= */
    let rowIndex = 1;

    $(document).on('click', '.addRow', function () {
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
    });

    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
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
