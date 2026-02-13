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
    
    .badge-success {
        background: #10b981;
        color: white;
    }
    
    .badge-warning {
        background: #f59e0b;
        color: white;
    }
    
    .badge-info {
        background: #3b82f6;
        color: white;
    }
    
    .badge-secondary {
        background: #6b7280;
        color: white;
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
        <h2><i class="fa fa-calendar-alt mr-2"></i>My Schedule</h2>
        <div class="right-wrapper">
            <ol class="breadcrumbs">
                <li>
                    <a href="{{ route('home') }}">
                        <i class="fa fa-home"></i>
                    </a>
                </li>
                <li><span>Driver Portal</span></li>
                <li><span>My Schedule</span></li>
            </ol>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @if(isset($schedules) && $schedules->count() > 0)
                <div class="table-card">
                    <div class="card-header">
                        <h3 class="card-title mb-0"><i class="fa fa-list mr-2"></i>Upcoming Trip Schedule</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Trip Date</th>
                                    <th>Vehicle</th>
                                    <th>Route</th>
                                    <th>Purpose</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                <tr>
                                    <td>{{ date('d M Y', strtotime($schedule->trip_date)) }}</td>
                                    <td>{{ $schedule->vehicle->vehicle_name ?? 'N/A' }}</td>
                                    <td>{{ $schedule->from_location ?? 'N/A' }} to {{ $schedule->to_location ?? 'N/A' }}</td>
                                    <td>{{ $schedule->purpose ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $schedule->status == 'completed' ? 'success' : ($schedule->status == 'in_progress' ? 'info' : 'warning') }}">
                                            {{ ucfirst($schedule->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="card-premium">
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle mr-2"></i>
                            No upcoming trips scheduled for you.
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
