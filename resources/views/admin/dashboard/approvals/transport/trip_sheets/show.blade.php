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
<section class="content-body" style="background-color:#eef1f5;">

<div class="container py-5">

    <!-- Page Title -->
    <div class="mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fa fa-route me-2"></i> Trip Summary (Read Only)
        </h2>
    </div>

    <!-- Trip & Requisition Info -->
    <div class="card shadow-lg border-0 mb-5">
        <div class="card-body p-4">

            <h4 class="text-secondary fw-bold mb-4">
                <i class="fa fa-info-circle me-2"></i> Trip Information
            </h4>

            <div class="row g-4">

                <!-- Trip ID -->
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded-3">
                        <div class="fw-bold fs-5 text-dark">Trip ID</div>
                        <div class="fs-5 text-bold">{{ $trip->trip_number }}</div>
                    </div>
                </div>

                <!-- Req No -->
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded-3">
                        <div class="fw-bold fs-5 text-dark">Requisition No</div>
                        <div class="fs-5 text-bold">{{ $trip->requisition->requisition_number }}</div>
                    </div>
                </div>

                <!-- Requester -->
                <div class="col-md-4">
                    <div class="p-3 bg-light border rounded-3">
                        <div class="fw-bold fs-5 text-dark">Requested By</div>
                        <div class="fs-5 text-bold">{{ $trip->requisition->requestedBy->name }}</div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-2">

                <!-- Department -->
                <div class="col-md-4">
                    <div class="p-3 bg-info text-white rounded-3">
                        <div class="fw-bold fs-5">Department</div>
                        <div class="fs-5">{{ $trip->requisition->department->department_name }}</div>
                    </div>
                </div>

                <!-- Unit -->
                <div class="col-md-4">
                    <div class="p-3 bg-primary text-white rounded-3">
                        <div class="fw-bold fs-5">Unit</div>
                        <div class="fs-5">
                            {{ $trip->requisition->unit->unit_name ?? 'N/A' }}
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="col-md-4">
                    <div class="p-3 bg-success text-white rounded-3">
                        <div class="fw-bold fs-5">Trip Status</div>
                        <div class="fs-5 text-white text-capitalize">
                            {{ $trip->status }}
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- Vehicle & Driver Info -->
    <div class="card shadow-lg border-0 mb-5">
        <div class="card-body p-4">

            <h4 class="text-secondary fw-bold mb-4">
                <i class="fa fa-car me-2"></i> Vehicle & Driver
            </h4>

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="p-3 bg-light border rounded-3">
                        <div class="fw-bold fs-5 text-dark">Vehicle</div>
                        <div class="fs-5 text-bold">
                            {{ $trip->vehicle->vehicle_name }}  
                            ({{ $trip->vehicle->vehicle_type }})
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light border rounded-3">
                        <div class="fw-bold fs-5 text-dark">Driver</div>
                        <div class="fs-5 text-bold">
                            {{ $trip->driver->driver_name }} 
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <!-- Passenger List -->
    <div class="card shadow-lg border-0 mb-5">
        <div class="card-body p-4">

            <h4 class="text-secondary fw-bold mb-4">
                <i class="fa fa-users me-2"></i> Passenger List
            </h4>

            <table class="table table-bordered table-striped fs-5">
                <thead class="table-dark fs-5">
                    <tr>
                        <th>Name</th>
                        <th>Employee ID</th>
                        <th>Mobile</th>
                    </tr>
                </thead>

                <tbody>
                  @forelse($trip->requisition->passengers ?? [] as $i => $p)
                    <tr>
                        <td>{{ $p->employee->name }}</td>
                        <td>{{ $p->employee->employee_code }}</td>
                        <td>{{ $p->employee->mobile }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>


    <!-- Trip End Details -->
    <div class="card shadow-lg border-0 mb-5">
        <div class="card-body p-4">

            <h4 class="fw-bold text-secondary mb-4">
                <i class="fa fa-flag-checkered me-2"></i> Trip End Summary
            </h4>

            <div class="row g-4">

                <div class="col-md-4">
                    <div class="p-3 border bg-light rounded-3">
                        <div class="fw-bold fs-5">Start KM</div>
                        <div class="fs-5 text-muted">{{ $trip->start_km }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 border bg-light rounded-3">
                        <div class="fw-bold fs-5">End KM</div>
                        <div class="fs-5 text-muted">{{ $trip->end_km }}</div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="p-3 border bg-light rounded-3">
                        <div class="fw-bold fs-5">Fuel Used (L)</div>
                        <div class="fs-5 text-muted">{{ $trip->fuel_used }}</div>
                    </div>
                </div>

            </div>

            <div class="row g-4 mt-2">

                <div class="col-md-6">
                    <div class="p-3 border bg-light rounded-3">
                        <div class="fw-bold fs-5">Start Time</div>
                        <div class="fs-5 text-muted">{{ $trip->start_time }}</div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border bg-light rounded-3">
                        <div class="fw-bold fs-5">End Time</div>
                        <div class="fs-5 text-muted">{{ $trip->end_time }}</div>
                    </div>
                </div>

            </div>

            <div class="mt-4 p-3 border bg-light rounded-3">
                <div class="fw-bold fs-5">Remarks</div>
                <div class="fs-5 text-muted">
                    {{ $trip->remarks ?? 'No remarks provided' }}
                </div>
            </div>

        </div>
    </div>


</div>

</section>
@endsection
