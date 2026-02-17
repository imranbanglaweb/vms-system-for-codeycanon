@extends('admin.dashboard.master')

@section('main_content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #fff !important;
    }
    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-body {
        padding: 1.8rem;
    }
    .detail-label {
        font-weight: 600;
        color: #6c757d;
        font-size: 1.875rem;
        margin-bottom: 0.25rem;
    }
    .detail-value {
        color: #000;
        font-size: 1.4rem;
        margin-bottom: 1rem;
    }
    .detail-item {
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    h5.section-title {
        color: #0d6efd;
        font-weight: 600;
        font-size: 1rem;
        border-left: 4px solid #0d6efd;
        padding-left: 10px;
        margin-bottom: 1.5rem;
        margin-top: 1.5rem;
    }
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-active {
        background-color: #d4edda;
        color: #155724;
    }
    .status-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }
    .info-icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e7f1ff;
        border-radius: 50%;
        color: #0d6efd;
    }
</style>

<section role="main" class="content-body" style="background-color:#fff;">
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
        <h3 class="fw-bold text-primary mb-0"><i class="bi bi-car-front-fill me-2"></i>Vehicle Details</h3>
        <a class="btn btn-primary btn-lg px-3 pull-right" href="{{ route('vehicles.index') }}">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Vehicle Basic Info -->
                    <h5 class="section-title"><i class="bi bi-info-circle me-1"></i> Vehicle Information</h5>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Vehicle Name</div>
                                <div class="detail-value fw-bold">{{ $vehicle->vehicle_name }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Vehicle Number</div>
                                <div class="detail-value fw-bold">{{ $vehicle->vehicle_number }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">License Plate</div>
                                <div class="detail-value fw-bold">{{ $vehicle->license_plate }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Vehicle Type</div>
                                <div class="detail-value">{{ $vehicle->vehicleType ? $vehicle->vehicleType->name : '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Ownership</div>
                                <div class="detail-value">{{ $vehicle->ownership }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Seat Capacity</div>
                                <div class="detail-value">{{ $vehicle->seat_capacity }} seats</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Registration Date</div>
                                <div class="detail-value">{{ $vehicle->registration_date ? date('d M Y', strtotime($vehicle->registration_date)) : '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Status</div>
                                <div class="detail-value">
                                    @if($vehicle->status == 1)
                                        <span class="status-badge status-active">Active</span>
                                    @else
                                        <span class="status-badge status-inactive">Inactive</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Alert Cell Number</div>
                                <div class="detail-value">{{ $vehicle->alert_cell_number }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Department & Driver Info -->
                    <h5 class="section-title"><i class="bi bi-people me-1"></i> Department & Driver</h5>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Department</div>
                                <div class="detail-value">{{ $vehicle->department ? $vehicle->department->department_name : '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Driver</div>
                                <div class="detail-value">{{ $vehicle->driver ? $vehicle->driver->driver_name : '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Vendor</div>
                                <div class="detail-value">{{ $vehicle->vendor ? $vehicle->vendor->name : '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <h5 class="section-title"><i class="bi bi-card-text me-1"></i> Additional Information</h5>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Created At</div>
                                <div class="detail-value">{{ $vehicle->created_at ? date('d M Y H:i:s', strtotime($vehicle->created_at)) : '-' }}</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="detail-item">
                                <div class="detail-label">Updated At</div>
                                <div class="detail-value">{{ $vehicle->updated_at ? date('d M Y H:i:s', strtotime($vehicle->updated_at)) : '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-3">
                        <div class="col-md-12">
                            @can('vehicle-manage')
                            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-primary">
                                <i class="bi bi-pencil-square"></i> Edit Vehicle
                            </a>
                            @endcan
                            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
