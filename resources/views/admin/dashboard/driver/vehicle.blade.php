@extends('admin.dashboard.master')
@section('main_content')
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #4338ca;
        --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    body { font-family: 'Inter', sans-serif; }
    
      .page-header {
    background: #fff;
    padding: 0 25px;
    border-bottom: 1px solid var(--border-color);
    /* margin-bottom: 20px; */
    background-color:#000
}
    
    .page-header h2 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .right-wrapper {
        color: white;
    }
    
    .breadcrumbs {
        color: rgba(255,255,255,0.9);
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 5px;
    }
    
    .breadcrumbs li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumbs li + li::before {
        content: "/";
        margin: 0 8px;
        opacity: 0.7;
    }
    
    .breadcrumbs a {
        color: rgba(255,255,255,0.9);
        text-decoration: none;
        transition: opacity 0.3s ease;
    }
    
    .breadcrumbs a:hover {
        opacity: 1;
    }
    
    .breadcrumbs span {
        color: rgba(255,255,255,0.7);
    }
    
    .card-premium {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .card-premium .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .card-premium .card-body {
        padding: 25px;
    }
    
    .table-bordered {
        border: 1px solid #e2e8f0;
    }
    
    .table-bordered th,
    .table-bordered td {
        border: 1px solid #e2e8f0;
        padding: 12px 15px;
    }
    
    .table-bordered th {
        background: #f8fafc;
        font-weight: 600;
        color: #4a5568;
    }
    
    .badge-success {
        background: #10b981;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-secondary {
        background: #6b7280;
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .alert-info {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 20px 25px;
        font-size: 15px;
    }
</style>


<section role="main" class="content-body">
    <header class="page-header">
        <h2><i class="fa fa-truck mr-2"></i>My Vehicle</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Driver Portal</span></li>
                <li><span>My Vehicle</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(isset($vehicle) && $vehicle)
                <div class="card-premium">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-truck mr-2"></i>Assigned Vehicle Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Vehicle Name</th>
                                        <td>{{ $vehicle->vehicle_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vehicle Number</th>
                                        <td>{{ $vehicle->vehicle_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Vehicle Type</th>
                                        <td>{{ $vehicle->vehicle_type ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Model</th>
                                        <td>{{ $vehicle->model ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Brand</th>
                                        <td>{{ $vehicle->brand ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <th width="40%">Capacity</th>
                                        <td>{{ $vehicle->capacity ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Fuel Type</th>
                                        <td>{{ $vehicle->fuel_type ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            <span class="badge-{{ $vehicle->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($vehicle->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Last Maintenance</th>
                                        <td>{{ $vehicle->last_service_date ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Next Maintenance</th>
                                        <td>{{ $vehicle->next_service_date ?? 'N/A' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="card-premium">
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            No vehicle is currently assigned to you.
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
