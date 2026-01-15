@extends('admin.dashboard.master')

@section('main_content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<section role="main" class="content-body" style="background:#f3f6f9; min-height:100vh;">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-primary mb-0">
                <i class="fa fa-file-contract me-2"></i> Trip Sheet Details
            </h1>
            <small class="text-muted">Trip #: <strong class="text-dark">{{ $trip->trip_number ?? 'TS-'.str_pad($trip->id,5,'0',STR_PAD_LEFT) }}</strong></small>
        </div>

        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" onclick="window.print()">
                <i class="fa fa-print me-1"></i> Print
            </button>

            @if($trip->status == 'in_progress')
            <a href="{{ route('trip-sheets.end.form', $trip->id) }}" class="btn btn-warning">
                <i class="fa fa-flag-checkered me-1"></i> End Trip
            </a>
            @endif

            <a href="{{ route('trip-sheets.index') }}" class="btn btn-secondary">
                <i class="fa fa-arrow-left me-1"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        <!-- LEFT: Trip + Requisition Summary -->
        <div class="col-xl-8">

            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3 fw-semibold text-secondary"><i class="fa fa-info-circle me-2"></i> Trip Summary</h5>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="p-3 bg-white rounded-3 border">
                                <small class="text-muted d-block">Start</small>
                                <div class="fw-bold fs-6">
                                    {{ optional($trip->trip_start_time)->format('d M Y, h:i A') ?? '—' }}
                                </div>
                                <small class="text-muted">Location: {{ $trip->start_location ?? '—' }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-white rounded-3 border">
                                <small class="text-muted d-block">End</small>
                                <div class="fw-bold fs-6">
                                    {{ optional($trip->trip_end_time)->format('d M Y, h:i A') ?? '—' }}
                                </div>
                                <small class="text-muted">Location: {{ $trip->end_location ?? '—' }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-white rounded-3 border">
                                <small class="text-muted d-block">KM</small>
                                <div class="fw-bold fs-6">
                                    @if(!is_null($trip->start_km) && !is_null($trip->end_km))
                                        {{ $trip->start_km }} → {{ $trip->end_km }} ({{ $trip->total_km }} km)
                                    @elseif(!is_null($trip->start_km))
                                        Start: {{ $trip->start_km }}
                                    @else
                                        —
                                    @endif
                                </div>
                                <small class="text-muted">Status: 
                                    <span class="badge bg-{{ $trip->status == 'finished' ? 'success' : 'warning' }} ms-1">
                                        {{ ucfirst($trip->status) }}
                                    </span>
                                </small>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-semibold text-dark">Linked Requisition</h6>
                    <div class="mb-2">
                        <strong>Req No:</strong> {{ $trip->requisition->requisition_number ?? '—' }}
                    </div>
                    <div class="mb-2">
                        <strong>Requested By:</strong> {{ $trip->requisition->requestedBy->name ?? '—' }} 
                        <small class="text-muted">({{ $trip->requisition->department->department_name ?? '-' }})</small>
                    </div>
                    <div class="mb-2">
                        <strong>Travel Date:</strong> {{ optional($trip->requisition->travel_date)->format('d M Y') ?? '—' }}
                    </div>

                    <div class="mt-3">
                        <h6 class="fw-semibold">Purpose & Route</h6>
                        <p class="mb-0 fs-6 text-muted">{{ $trip->requisition->purpose ?? '—' }}</p>
                        <p class="mb-0 mt-2"><i class="fa fa-map-marker-alt text-danger me-1"></i>
                            {{ $trip->requisition->from_location ?? '—' }} → {{ $trip->requisition->to_location ?? '—' }}
                        </p>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-semibold">Remarks</h6>
                    <p class="text-muted mb-0">{{ $trip->remarks ?? 'No remarks provided.' }}</p>

                </div>
            </div>

            <!-- Passenger list -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="mb-3 fw-semibold"><i class="fa fa-users me-2"></i> Passenger List</h5>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width:70px">#</th>
                                    <th>Passenger</th>
                                    <th>Designation</th>
                                    <th>Contact</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($trip->requisition->passengers ?? [] as $i => $p)
                                <tr>
                                    <td class="text-center">{{ $i+1 }}</td>
                                    <td class="fw-semibold">{{ $p->name ?? ($p->employee->name ?? '—') }}</td>
                                    <td>{{ $p->designation ?? ($p->employee->designation ?? '-') }}</td>
                                    <td>{{ $p->mobile ?? ($p->employee->mobile ?? '-') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No passengers recorded.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIGHT: Vehicle & Driver cards -->
        <div class="col-xl-4">

            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-semibold text-secondary mb-2"><i class="fa fa-car-side me-2"></i> Vehicle</h6>
                    <div class="fs-5 fw-bold">{{ $trip->vehicle->vehicle_name ?? ($trip->vehicle->vehicle_number ?? '—') }}</div>
                    <div class="text-muted mb-2">{{ $trip->vehicle->model ?? '-' }}</div>
                    <div>
                        <span class="badge bg-{{ ($trip->vehicle->availability_status ?? 'available') == 'available' ? 'success' : 'warning' }}">
                            {{ ucfirst(str_replace('_',' ', $trip->vehicle->availability_status ?? 'available')) }}
                        </span>
                    </div>

                    <hr class="my-3">

                    <p class="mb-1"><strong>Registration:</strong> {{ $trip->vehicle->registration_no ?? '-' }}</p>
                    <p class="mb-0"><strong>Owner:</strong> {{ $trip->vehicle->owner_name ?? '-' }}</p>
                </div>
            </div>

            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">
                    <h6 class="fw-semibold text-secondary mb-2"><i class="fa fa-user-tie me-2"></i> Driver</h6>
                    <div class="fs-5 fw-bold">{{ $trip->driver->name ?? '—' }}</div>
                    <div class="text-muted mb-2">{{ $trip->driver->phone ?? '-' }}</div>
                    <div>
                        <span class="badge bg-{{ ($trip->driver->availability_status ?? 'available') == 'available' ? 'success' : 'warning' }}">
                            {{ ucfirst(str_replace('_',' ', $trip->driver->availability_status ?? 'available')) }}
                        </span>
                    </div>

                    <hr class="my-3">
                    <p class="mb-1"><strong>License:</strong> {{ $trip->driver->license_no ?? '-' }}</p>
                    <p class="mb-0"><strong>Experience:</strong> {{ $trip->driver->experience_years ?? '—' }} yrs</p>
                </div>
            </div>

            <!-- Trip metadata -->
            <div class="card shadow-sm rounded-4">
                <div class="card-body p-3">
                    <h6 class="fw-semibold text-muted">Metadata</h6>
                    <ul class="list-unstyled mb-0">
                        <li><small class="text-muted">Created:</small> <div class="fw-medium">{{ optional($trip->created_at)->format('d M Y, h:i A') }}</div></li>
                        <li class="mt-2"><small class="text-muted">Last Updated:</small> <div class="fw-medium">{{ optional($trip->updated_at)->format('d M Y, h:i A') }}</div></li>
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>

</section>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmEnd() {
    Swal.fire({
        title: 'End Trip?',
        text: "This will mark the trip as completed and free the vehicle/driver.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, end it',
        confirmButtonColor: '#198754'
    }).then((res) => {
        if (res.isConfirmed) {
            window.location.href = "{{ route('trip.end.form', $trip->id) }}";
        }
    });
}
</script>

@endsection
