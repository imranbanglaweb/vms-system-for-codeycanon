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
        background: var(--bg-gradient);
        padding: 0px 30px;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.35);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        background-color:#000;
        /* margin-bottom: 30px; */
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
    
    .stat-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        padding: 25px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-card.pending {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }
    
    .stat-card.in-progress {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }
    
    .stat-card.completed {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .stat-card .stat-icon {
        font-size: 36px;
        margin-bottom: 10px;
    }
    
    .stat-card .stat-title {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 5px;
    }
    
    .stat-card .stat-value {
        font-size: 32px;
        font-weight: 700;
    }
    
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
    }
    
    .table-card .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 20px 25px;
        border: none;
    }
    
    .table-card .card-body {
        padding: 0;
    }
    
    .table {
        margin: 0;
    }
    
    .table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #4a5568;
        font-weight: 600;
        padding: 15px;
        text-transform: uppercase;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
    
    .table tbody td {
        padding: 15px;
        border-bottom: 1px solid #e2e8f0;
        color: #4a5568;
    }
    
    .table tbody tr:hover {
        background: #f8fafc;
    }
    
    .badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .badge-warning {
        background: #f59e0b;
        color: white;
    }
    
    .badge-info {
        background: #3b82f6;
        color: white;
    }
    
    .badge-success {
        background: #10b981;
        color: white;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        color: white;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-success:hover {
        transform: translateY(-2px);
        color: white;
    }
    
    .quick-link-card {
        background: white;
        border-radius: 12px;
        box-shadow: var(--card-shadow);
        padding: 25px 20px;
        text-align: center;
        text-decoration: none;
        color: #4a5568;
        transition: all 0.3s ease;
        display: block;
    }
    
    .quick-link-card:hover {
        transform: translateY(-5px);
        color: #667eea;
    }
    
    .quick-link-card .icon {
        font-size: 32px;
        margin-bottom: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .quick-link-card .title {
        font-weight: 600;
        font-size: 14px;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        padding: 30px;
        margin-bottom: 30px;
    }
    
    .welcome-card h3 {
        margin: 0 0 10px 0;
        font-weight: 700;
    }
    
    .welcome-card p {
        margin: 0;
        opacity: 0.9;
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
        <h2><i class="fa fa-tachometer-alt mr-2"></i>Driver Dashboard</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Driver Portal</span></li>
                <li><span>Dashboard</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h3><i class="fa fa-id-card mr-2"></i>Welcome, {{ Auth::user()->name }}!</h3>
            <p>Driver Dashboard - Manage your trips and availability</p>
        </div>

        <!-- Quick Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stat-card pending">
                    <div class="stat-icon"><i class="fa fa-clock"></i></div>
                    <div class="stat-title">My Trips (Pending)</div>
                    <div class="stat-value">{{ isset($pendingTrips) && $pendingTrips ? $pendingTrips->where('transport_status', 'Pending')->count() : (isset($todayTrips) ? $todayTrips->where('transport_status', 'Pending')->count() : 0) }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card in-progress">
                    <div class="stat-icon"><i class="fa fa-road"></i></div>
                    <div class="stat-title">In Progress</div>
                    <div class="stat-value">{{ isset($todayTrips) ? $todayTrips->where('transport_status', 'In Transit')->count() : 0 }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card completed">
                    <div class="stat-icon"><i class="fa fa-check-circle"></i></div>
                    <div class="stat-title">Completed Today</div>
                    <div class="stat-value">{{ isset($recentTrips) ? $recentTrips->count() : 0 }}</div>
                </div>
            </div>
        </div>

        <!-- Active Trips -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-road mr-2"></i>Your Active Trips</h3>
                    </div>
                    <div class="card-body">
                        @if(isset($assignedTrips) && $assignedTrips->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Requisition No.</th>
                                        <th>Date</th>
                                        <th>Vehicle</th>
                                        <th>Route</th>
                                        <th>Passengers</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignedTrips as $trip)
                                    <tr>
                                        <td>#{{ $trip->requisition_number ?? $trip->id }}</td>
                                        <td>{{ $trip->travel_date }}</td>
                                        <td>
                                            @if($trip->assignedVehicle)
                                                {{ $trip->assignedVehicle->vehicle_name ?? 'N/A' }}
                                                @if($trip->assignedVehicle->number_plate)
                                                    <br><small class="text-muted">{{ $trip->assignedVehicle->number_plate }}</small>
                                                @endif
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $trip->from_location ?? 'N/A' }} to {{ $trip->to_location ?? 'N/A' }}</td>
                                        <td>{{ $trip->number_of_passenger ?? ($trip->passengers ? $trip->passengers->count() : 0) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $trip->transport_status == 'Pending' ? 'warning' : ($trip->transport_status == 'In Transit' ? 'info' : ($trip->transport_status == 'Approved' ? 'primary' : 'success')) }}">
                                                {{ ucfirst($trip->transport_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($trip->transport_status == 'Pending')
                                                <a href="{{ route('driver.trip.status') }}" class="btn-primary" style="padding: 8px 15px; font-size: 12px;">
                                                    <i class="fa fa-play mr-1"></i>Start Trip
                                                </a>
                                            @elseif($trip->transport_status == 'In Transit')
                                                <a href="{{ route('driver.trip.status') }}" class="btn-success" style="padding: 8px 15px; font-size: 12px;">
                                                    <i class="fa fa-check mr-1"></i>Complete Trip
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                        <hr>
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle mr-2"></i>
                                No active trips assigned. Check your schedule for upcoming trips.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="row">
            <div class="col-md-3">
                <a href="{{ route('driver.schedule') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-calendar-alt"></i></div>
                    <div class="title">My Schedule</div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('driver.trips') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-route"></i></div>
                    <div class="title">My Trips</div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('driver.trip.status') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-tasks"></i></div>
                    <div class="title">Update Status</div>
                </a>
            </div>
            <div class="col-md-3">
                <a href="{{ route('driver.availability') }}" class="quick-link-card">
                    <div class="icon"><i class="fa fa-user-clock"></i></div>
                    <div class="title">Update Availability</div>
                </a>
            </div>
        </div>

    </div>
</section>
@endsection
