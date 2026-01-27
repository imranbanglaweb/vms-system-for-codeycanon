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
</style>

<section role="main" class="content-body">

<div class="container-fluid p-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center py-3">
            <h3 class="m-0">
                <i class="fa fa-edit me-2 text-warning"></i>
                Edit Requisition
            </h3>
            <a href="{{ route('requisitions.index') }}" class="btn btn-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="card-body p-4">

            <!-- AJAX Message -->
            <div id="formMessage" class="alert d-none"></div>

            <form id="requisitionForm" action="{{ route('requisitions.update', $requisition->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- REQUESTED EMPLOYEE -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label">
                            <i class="fa fa-user-tie text-primary me-1"></i> Requested Employee
                        </label>
                        <select id="employee_id" name="employee_id" class="form-select form-select-lg select2">
                            <option value="">-- Select Employee --</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" 
                                    {{ ($requisition->requested_by ?? $requisition->employee_id ?? '') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                        <br>
                        <small class="text-danger error-text employee_id_error"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-building text-primary me-1"></i> Department</label>
                        <input type="text" id="department_name" class="form-control form-control-lg"
                               value="{{ $requisition->department->department_name ?? '' }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-sitemap text-primary me-1"></i> Unit</label>
                        <input type="text" id="unit_name" class="form-control form-control-lg"
                               value="{{ $requisition->unit->unit_name ?? '' }}" readonly>

                        <input type="hidden" id="department_id" name="department_id" 
                               value="{{ $requisition->department->id ?? '' }}">
                        <input type="hidden" id="unit_id" name="unit_id" 
                               value="{{ $requisition->unit->id ?? '' }}">
                    </div>
                </div>

                <hr>

                <!-- VEHICLE & DRIVER -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-car text-primary me-1"></i> Vehicle</label>
                        <select id="vehicle_id" name="vehicle_id" class="form-select form-select-lg select2">
                            <option value="">Select vehicle</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}" 
                                    {{ optional($requisition->vehicle)->id == $v->id || $requisition->vehicle_id == $v->id ? 'selected' : '' }}>
                                    {{ $v->vehicle_name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text vehicle_id_error"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-user text-primary me-1"></i> Driver</label>
                        <select name="driver_id" class="form-select form-select-lg select2">
                            <option value="">Select driver</option>
                            @foreach($drivers as $driver)
                                <option value="{{ $driver->id }}" 
                                    {{ optional($requisition->driver)->id == $driver->id || $requisition->driver_id == $driver->id ? 'selected' : '' }}>
                                    {{ $driver->driver_name }}
                                </option>
                            @endforeach
                        </select>
                        <small class="text-danger error-text driver_id_error"></small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label"><i class="fa fa-calendar text-primary me-1"></i> Requisition Date</label>
                        <input type="date" name="requisition_date" class="form-control form-control-lg"
                               value="{{ $requisition->requisition_date ? \Carbon\Carbon::parse($requisition->requisition_date)->format('Y-m-d') : '' }}">
                        <small class="text-danger error-text requisition_date_error"></small>
                    </div>
                </div>

                <hr>

                <!-- TRAVEL DETAILS -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-location-dot text-primary me-1"></i> From</label>
                        <input type="text" name="from_location" class="form-control form-control-lg"
                               value="{{ $requisition->from_location }}">
                        <small class="text-danger error-text from_location_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-map-marker-alt text-primary me-1"></i> To</label>
                        <input type="text" name="to_location" class="form-control form-control-lg"
                               value="{{ $requisition->to_location }}">
                        <small class="text-danger error-text to_location_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-clock text-primary me-1"></i> Pickup Time</label>
                        <input type="datetime-local" name="travel_date" class="form-control form-control-lg"
                               value="{{ $requisition->travel_date ? \Carbon\Carbon::parse($requisition->travel_date)->format('Y-m-d\TH:i') : '' }}">
                        <small class="text-danger error-text travel_date_error"></small>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label"><i class="fa fa-calendar-check text-primary me-1"></i> Return Time</label>
                        <input type="datetime-local" name="return_date" class="form-control form-control-lg"
                               value="{{ $requisition->return_date ? \Carbon\Carbon::parse($requisition->return_date)->format('Y-m-d\TH:i') : '' }}">
                    </div>
                </div>

                <hr>

                <!-- PURPOSE & PASSENGERS COUNT -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fa fa-users text-primary me-1"></i> Number of Passengers</label>
                        <input type="number" name="number_of_passenger" class="form-control form-control-lg"
                               value="{{ $requisition->number_of_passenger }}">
                        <small class="text-danger error-text number_of_passenger_error"></small>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label"><i class="fa fa-list text-primary me-1"></i> Purpose</label>
                        <textarea name="purpose" class="form-control form-control-lg" rows="3">{{ $requisition->purpose }}</textarea>
                        <small class="text-danger error-text purpose_error"></small>
                    </div>
                </div>

                <hr>

                <!-- PASSENGERS -->
                <h5 class="fw-bold mb-3">
                    <i class="fa fa-users text-primary me-1"></i> Passengers
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
                        @if(isset($requisition->passengers) && count($requisition->passengers) > 0)
                            @foreach($requisition->passengers as $index => $passenger)
                                <tr>
                                    <td>
                                        <select name="passengers[{{ $index }}][employee_id]" 
                                                class="form-select passenger-employee select2">
                                            <option value="">-- Select --</option>
                                            @foreach($employees as $employee)
                                                <option value="{{ $employee->id }}" 
                                                    {{ $passenger->employee_id == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger error-text passengers_{{ $index }}_employee_id_error"></small>
                                    </td>

                                    <td><input type="text" class="form-control passenger-department" readonly></td>
                                    <td><input type="text" class="form-control passenger-unit" readonly></td>

                                    <td class="text-center">
                                        @if($index === 0)
                                            <button type="button" class="btn btn-success btn-sm addRow">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-danger btn-sm removeRow">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
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
                                <td><input type="text" class="form-control passenger-department" readonly></td>
                                <td><input type="text" class="form-control passenger-unit" readonly></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-success btn-sm addRow">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>

                <!-- SUBMIT -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-warning btn-lg px-4">
                        <i class="fa fa-save me-2"></i> Update Requisition
                    </button>
                    <a href="{{ route('requisitions.index') }}" class="btn btn-secondary btn-lg px-4 ms-2">
                        <i class="fa fa-arrow-left me-2"></i> Back
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>

</section>
@endsection

@push('scripts')
<script>
$(function () {
    let rowIndex = {{ isset($requisition->passengers) ? count($requisition->passengers) : 1 }};

    // AUTO-FILL MAIN EMPLOYEE
    $('#employee_id').on('change', function() {
        let empId = $(this).val();
        if (!empId) {
            $('#department_name').val('');
            $('#unit_name').val('');
            $('#department_id').val('');
            $('#unit_id').val('');
            return;
        }
        $.get("{{ url('/get-employee-details') }}/" + empId, function(data) {
            $('#department_name').val(data.department || '');
            $('#department_id').val(data.department_id || '');
            $('#unit_name').val(data.unit || '');
            $('#unit_id').val(data.unit_id || '');
        }).fail(function() {
            $('#department_name').val('');
            $('#unit_name').val('');
            $('#department_id').val('');
            $('#unit_id').val('');
        });
    });

    // AUTO-FILL PASSENGERS
    $(document).on('change', '.passenger-employee', function () {
        let id = $(this).val();
        let row = $(this).closest('tr');
        if (!id) {
            row.find('.passenger-department').val('');
            row.find('.passenger-unit').val('');
            return;
        }
        $.get("{{ url('/get-employee-details') }}/" + id, function (res) {
            row.find('.passenger-department').val(res.department || '');
            row.find('.passenger-unit').val(res.unit || '');
        }).fail(function() {
            row.find('.passenger-department').val('');
            row.find('.passenger-unit').val('');
        });
    });

    // ADD PASSENGER ROW
    $(document).on('click', '.addRow', function () {
        let row = `
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
            <td><input type="text" class="form-control passenger-department" readonly></td>
            <td><input type="text" class="form-control passenger-unit" readonly></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm removeRow">
                    <i class="fa fa-minus"></i>
                </button>
            </td>
        </tr>`;
        $('#passengerTable tbody').append(row);
        $('#passengerTable tbody tr:last .select2').select2({ theme: 'bootstrap-5' });
        rowIndex++;
    });

    // REMOVE PASSENGER ROW
    $(document).on('click', '.removeRow', function () {
        $(this).closest('tr').remove();
        rowIndex = 0;
        $('#passengerTable tbody tr').each(function() {
            $(this).find('select').attr('name', 'passengers[' + rowIndex + '][employee_id]');
            $(this).find('.error-text').attr('class', 'text-danger error-text passengers_' + rowIndex + '_employee_id_error');
            rowIndex++;
        });
    });

    // AJAX FORM SUBMIT
    $('#requisitionForm').submit(function (e) {
        e.preventDefault();
        let form = this;
        let formData = $(form).serialize();
        $(".error-text").text("");
        $('#formMessage').addClass('d-none');

        $.ajax({
            url: $(form).attr("action"),
            method: "POST",
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                $("button[type=submit]").prop("disabled", true).html("<i class='fa fa-spinner fa-spin'></i> Updating...");
            },
            success: function (res) {
                if (res.status === "validation_error") {
                    $.each(res.errors, function (field, messages) {
                        let errorField = field.replace(/\./g, '_') + '_error';
                        $('.' + errorField).text(messages[0]);
                    });
                    $('#formMessage').removeClass('d-none alert-success').addClass('alert-danger')
                        .html('<i class="fa fa-exclamation-triangle me-2"></i> Please fix the validation errors below.').show();
                    return;
                }
                if (res.status === "success") {
                    $('#formMessage').removeClass('d-none alert-danger').addClass('alert-success')
                        .html('<i class="fa fa-check-circle me-2"></i> ' + res.message).show();
                    setTimeout(function() {
                        window.location.href = res.redirect_url || "{{ route('requisitions.index') }}";
                    }, 1500);
                }
            },
            error: function (xhr) {
                let message = xhr.responseJSON?.message || "Something went wrong. Please try again.";
                $('#formMessage').removeClass('d-none alert-success').addClass('alert-danger')
                    .html('<i class="fa fa-exclamation-circle me-2"></i> ' + message).show();
            },
            complete: function () {
                $("button[type=submit]").prop("disabled", false).html('<i class="fa fa-save me-2"></i> Update Requisition');
            }
        });
    });

    // INITIALIZE SELECT2
    $('.select2').select2({ theme: 'bootstrap-5' });

    // AUTO-FILL ON PAGE LOAD
    @if($requisition->requested_by ?? $requisition->employee_id)
        $.get("{{ url('/get-employee-details') }}/{{ $requisition->requested_by ?? $requisition->employee_id }}", function(data) {
            $('#department_name').val(data.department || '');
            $('#unit_name').val(data.unit || '');
            $('#department_id').val(data.department_id || '');
            $('#unit_id').val(data.unit_id || '');
        });
    @endif

    @if(isset($requisition->passengers))
        @foreach($requisition->passengers as $index => $passenger)
            @if($passenger->employee_id)
                $.get("{{ url('/get-employee-details') }}/{{ $passenger->employee_id }}", function(data) {
                    $('#passengerTable tbody tr:eq({{ $index }}) .passenger-department').val(data.department || '');
                    $('#passengerTable tbody tr:eq({{ $index }}) .passenger-unit').val(data.unit || '');
                });
            @endif
        @endforeach
    @endif
});
</script>
@endpush
