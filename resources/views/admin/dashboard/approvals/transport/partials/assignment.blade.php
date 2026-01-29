<!-- Assignment section for transport approvals -->
<div class="assignment-section mt-5 mb-4">
    <h4 class="fw-bold text-dark mb-3">
        <i class="fa fa-car me-2"></i> Vehicle & Driver Assignment
    </h4>
    <!-- Optionally, add assignment form if needed -->
    @if(isset($vehicles) && isset($drivers))
    <form id="assignForm" action="{{ route('transport.approvals.assign', $requisition->id) }}" method="POST" class="mt-4" onsubmit="event.preventDefault(); submitAssign();">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <label class="form-label fw-semibold">Select Vehicle</label>
                <select name="assigned_vehicle_id" id="vehicleSelect" class="form-select form-select-lg select2" style="width:100%">
                    <option value="">-- Select Vehicle --</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}"  data-status="{{ $vehicle->availability_status }}" @if(strtolower($vehicle->availability_status) === 'assigned') disabled @endif {{ (isset($requisition->assignedVehicle) && $requisition->assignedVehicle->id == $vehicle->id) ? 'selected' : '' }}>
                            {{ $vehicle->vehicle_name }}@if(!empty($vehicle->number_plate)) - [{{ $vehicle->number_plate }}]@endif
                        </option>
                    @endforeach
                </select>
                 <div id="vehicleStatus" class="mt-2 fw-semibold"></div>
            </div>
            <div class="col-md-5">
                <label class="form-label fw-semibold">Select Driver</label>
                <select name="assigned_driver_id" id="driverSelect" class="form-select form-select-lg select2" style="width:100%">
                    <option value="">-- Select Driver --</option>
                    @foreach($drivers as $driver)
                        <option 
    value="{{ $driver->id }}"
    data-status="{{ $driver->availability_status }}"
    {{ strtolower($driver->availability_status) === 'assigned' ? 'disabled' : '' }}
    {{ (isset($requisition->assignedDriver) && $requisition->assignedDriver->id == $driver->id) ? 'selected' : '' }}
>
    {{ $driver->driver_name }} 
    @if($driver->phone) - [{{ $driver->phone }}] @endif
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
            <div class="col-md-2">
                <br>
                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                    <i class="fa fa-save me-2"></i> Assign
                </button>
            </div>
        </div>
    </form>
    @endif
</div>
