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

<section role="main" class="content-body">

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

                    <div class="col-md-6">
                        <label class="form-label"><i class="fa fa-car text-primary me-1"></i> Vehicle Type</label>
                        <select id="vehicle_type" name="vehicle_type" class="form-select form-select-lg select2">
                            <option value="">Select vehicle</option>
                            @foreach($vehicles as $id => $name)
                                <option value="{{ $name->id }}">{{ $name->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text vehicle_id_error"></small>
                    </div>

                    <!-- <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-user text-primary me-1"></i> Driver</label>
                        <select name="driver_id" class="form-select form-select-lg select2">
                            <option value="">Select driver</option>
                            @foreach($drivers as $id => $name)
                                <option value="{{ $id }}">{{ $name->driver_name }}</option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text driver_id_error"></small>
                    </div> -->

                    <div class="col-md-6">
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
// Flatpickr (Date + Time)
$('.datetimepicker').flatpickr({
    enableTime: true,
    dateFormat: "Y-m-d H:i",
    time_24hr: true,
    minuteIncrement: 5
});
    // ================= AUTO-FILL MAIN EMPLOYEE =================
    $('#employee_id').on('change', function() {
        let empId = $(this).val();
        if (!empId) {
            $('#department_name, #unit_name').val('');
            return;
        }
        // $.get('/get-employee-details/' + empId, function(data) {
        //     $('#department_name').val(data.department);
        //     $('#unit_name').val(data.unit);
        // });

        $.get("{{ route('employee.details', ':id') }}".replace(':id', empId), function(data) {
            $('#department_name').val(data.department);
            $('#unit_name').val(data.unit);
            $('#unit_id').val(data.unit_id);
            $('#department_id').val(data.department_id);
        });

    });

    

    // ================= AUTO-FILL PASSENGERS =================
    $(document).on('change', '.passenger-employee', function () {
        let id = $(this).val();
        let row = $(this).closest('tr');

        if (!id) {
            row.find('.passenger-department').val('');
            row.find('.passenger-unit').val('');
            return;
        }
         $.get("{{ route('employee.details', ':id') }}".replace(':id', id), function (res) {
            row.find('.passenger-department').val(res.department);
            row.find('.passenger-unit').val(res.unit);
        });
    });

    // ================= ADD PASSENGER ROW =================
    let rowIndex = 1;
    $('.addRow').click(function () {

        let row = `
        <tr>
            <td>
                <select name="passengers[${rowIndex}][employee_id]" 
                        class="form-select passenger-employee select2">
                    <option value="">-- Select --</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
                <small class="text-danger error-text passengers_${rowIndex}_employee_id_error"></small>
            </td>

            <td><input type="text" class="form-control passenger-department" readonly></td>

            <td><input type="text" class="form-control passenger-unit" readonly></td>

            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm removeRow">
                    <i class="fa fa-minus"></i>
                </button>
            </td>
        </tr>`;

        $('#passengerTable tbody').append(row);
        rowIndex++;
    });

    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
    });

    // ================= AJAX FORM SUBMIT =================

$('#requisitionForm').submit(function (e) {
    e.preventDefault();

    let form = this;
    let formData = $(form).serialize();
    
    console.log('Form Data:', formData); // Debug
    
    // Clear previous errors
    $(".error-text").text("");
    $('#formMessage').addClass('d-none');

    $.ajax({
        url: $(form).attr("action"),
        method: "POST",
        data: formData,
        dataType: 'json', // Ensure we're expecting JSON response

        beforeSend: function () {
            $("button[type=submit]").prop("disabled", true).html("<i class='fa fa-spinner fa-spin'></i> Submitting...");
        },

        success: function (res) {
            console.log('Success Response:', res); // Debug
            
            if (res.status === "validation_error") {
                console.log('Validation Errors Found:', res.errors); // Debug
                
                // Clear all previous errors
                $('.error-text').text('');
                
                // Display validation errors
                $.each(res.errors, function (field, messages) {
                    console.log('Processing error for field:', field, 'Message:', messages[0]); // Debug
                    
                    // Convert field name to match error class naming convention
                    let errorField = field.replace(/\./g, '_') + '_error';
                    console.log('Looking for error element: .' + errorField); // Debug
                    
                    // Find the error element and set the message
                    let errorElement = $('.' + errorField);
                    if (errorElement.length > 0) {
                        errorElement.text(messages[0]);
                        console.log('Error message set for: .' + errorField); // Debug
                    } else {
                        console.warn('Error element not found: .' + errorField);
                    }
                });
                
                // Show general error message
                $('#formMessage')
                    .removeClass('d-none alert-success')
                    .addClass('alert-danger')
                    .html('<i class="fa fa-exclamation-triangle me-2"></i> Please fix the validation errors below.')
                    .show();
                
                return;
            }

            if (res.status === "success") {
                 Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: res.message,
                        confirmButtonText: 'OK',
                        timer: 2500,
                        timerProgressBar: true
                    }).then(() => {
                        if (res.redirect_url) {
                            window.location.href = res.redirect_url;
                        }
                    });
                $('#formMessage')
                    .removeClass('d-none alert-danger')
                    .addClass('alert-success')
                    .html('<i class="fa fa-check-circle me-2"></i> ' + res.message)
                    .show();

                // Reset form on success
                setTimeout(function() {
                    if (res.redirect_url) {
                        window.location.href = res.redirect_url;
                    } else {
                        form.reset();
                        // Reset passenger table
                        $('#passengerTable tbody').html(`<tr>
                            <td>
                                <select name="passengers[0][employee_id]" class="form-select passenger-employee select2">
                                    <option value="">-- Select --</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                <small class="text-danger error-text passengers_0_employee_id_error"></small>
                            </td>
                            <td><input type="text" class="form-control passenger-department" readonly></td>
                            <td><input type="text" class="form-control passenger-unit" readonly></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success btn-sm addRow"><i class="fa fa-plus"></i></button>
                            </td>
                        </tr>`);
                        rowIndex = 1;
                    }
                }, 2000);
            }
        },

        error: function (xhr, status, error) {
            console.log('AJAX Error Status:', status);
            console.log('AJAX Error:', error);
            console.log('Full XHR response:', xhr);
            console.log('Response Text:', xhr.responseText);
            
            // Handle different types of errors
            if (xhr.status === 422) {
                // Laravel validation error
                let errors = xhr.responseJSON.errors;
                console.log('422 Validation Errors:', errors);
                
                if (errors) {
                    // Clear previous errors
                    $('.error-text').text('');
                    
                    // Display validation errors
                    $.each(errors, function (field, messages) {
                        let errorField = field.replace(/\./g, '_') + '_error';
                        let errorElement = $('.' + errorField);
                        if (errorElement.length > 0) {
                            errorElement.text(messages[0]);
                        }
                    });
                    
                    $('#formMessage')
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .html('<i class="fa fa-exclamation-triangle me-2"></i> Please fix the validation errors below.')
                        .show();
                }
            } else {
                // Other server errors
                let message = "Something went wrong. Please try again.";
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    message = xhr.responseJSON.message;
                }
                
                $('#formMessage')
                    .removeClass('d-none alert-success')
                    .addClass('alert-danger')
                    .html('<i class="fa fa-exclamation-circle me-2"></i> ' + message)
                    .show();
            }
        },

        complete: function () {
            $("button[type=submit]").prop("disabled", false)
                .html('<i class="fa fa-paper-plane me-2"></i> Submit Requisition');
        }
    });
});

});
</script>
@endpush
