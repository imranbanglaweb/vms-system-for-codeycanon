@extends('admin.dashboard.master')

@section('title', 'Admin Dashboard - ' . config('app.name'))

@php
$user = Auth::user();
@endphp

@section('main_content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    :root {
        --primary-color: #4f46e5;
        --primary-dark: #4338ca;
        --primary-light: #6366f1;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #06b6d4;
        --purple-color: #8b5cf6;
        --pink-color: #ec4899;
        --bg-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --card-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        --card-shadow-hover: 0 20px 50px rgba(0, 0, 0, 0.15);
    }
    
    body { font-family: 'Inter', sans-serif; background: #f8fafc; }
    
    /* Header Section */
    .dashboard-header {
        background: var(--bg-gradient);
        padding: 30px;
        border-radius: 16px;
        margin-bottom: 30px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.35);
    }
    
    .dashboard-header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .welcome-section h1 {
        color: white;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .welcome-section p {
        color: rgba(255,255,255,0.85);
        font-size: 14px;
        margin: 0;
    }
    
    .admin-badges {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    
    .role-badge {
        background: rgba(255,255,255,0.2);
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 13px;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .header-actions {
        display: flex;
        gap: 12px;
    }
    
    .btn-premium {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary-premium {
        background: white;
        color: var(--primary-color);
    }
    
    .btn-primary-premium:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }
    
    .btn-outline-premium {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
    }
    
    .btn-outline-premium:hover {
        background: rgba(255,255,255,0.3);
    }
    
    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
    }
    
    .stat-card.total::before { background: var(--primary-color); }
    .stat-card.pending::before { background: var(--warning-color); }
    .stat-card.approved::before { background: var(--success-color); }
    .stat-card.rejected::before { background: var(--danger-color); }
    .stat-card.vehicle::before { background: var(--purple-color); }
    .stat-card.driver::before { background: var(--info-color); }
    .stat-card.employee::before { background: var(--pink-color); }
    .stat-card.completed::before { background: #10b981; }
    
    .stat-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 15px;
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    
    .stat-card.total .stat-icon { background: #e0e7ff; color: var(--primary-color); }
    .stat-card.pending .stat-icon { background: #fef3c7; color: var(--warning-color); }
    .stat-card.approved .stat-icon { background: #d1fae5; color: var(--success-color); }
    .stat-card.rejected .stat-icon { background: #fee2e2; color: var(--danger-color); }
    .stat-card.vehicle .stat-icon { background: #ede9fe; color: var(--purple-color); }
    .stat-card.driver .stat-icon { background: #cffafe; color: var(--info-color); }
    .stat-card.employee .stat-icon { background: #fce7f3; color: var(--pink-color); }
    .stat-card.completed .stat-icon { background: #d1fae5; color: #10b981; }
    
    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    
    .stat-label {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }
    
    .stat-trend {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 20px;
        margin-top: 10px;
    }
    
    .stat-trend.up { background: #d1fae5; color: var(--success-color); }
    .stat-trend.down { background: #fee2e2; color: var(--danger-color); }
    .stat-trend.neutral { background: #f3f4f6; color: #64748b; }
    
    /* Charts Section */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .chart-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
    }
    
    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    
    .chart-title {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .chart-container {
        height: 250px;
        position: relative;
    }
    
    /* Quick Actions */
    .quick-actions {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        margin-bottom: 30px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 15px;
    }
    
    .quick-action-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 16px;
        border-radius: 12px;
        background: #f8fafc;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    
    .quick-action-item:hover {
        background: #e0e7ff;
        transform: translateX(5px);
    }
    
    .quick-action-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        background: var(--primary-color);
        color: white;
    }
    
    .quick-action-text h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        margin: 0 0 4px 0;
    }
    
    .quick-action-text p {
        font-size: 12px;
        color: #64748b;
        margin: 0;
    }
    
    /* System Overview */
    .system-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .system-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: var(--card-shadow);
        text-align: center;
    }
    
    .system-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 15px;
    }
    
    .system-value {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
    }
    
    .system-label {
        font-size: 14px;
        color: #64748b;
    }
    
    /* Table Styles */
    .table-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--card-shadow);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .table-header {
        background: linear-gradient(to right, #f8fafc, #f1f5f9);
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .table-header h4 {
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table-premium {
        width: 100%;
        border-collapse: collapse;
    }
    
    .table-premium thead th {
        background: #f8fafc;
        padding: 14px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .table-premium tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 14px;
    }
    
    .table-premium tbody tr:hover {
        background: #f8fafc;
    }
    
    .table-premium tbody tr:last-child td {
        border-bottom: none;
    }
    
    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-pending { background: #fef3c7; color: #b45309; }
    .badge-approved { background: #d1fae5; color: #047857; }
    .badge-rejected { background: #fee2e2; color: #b91c1c; }
    .badge-completed { background: #cffafe; color: #0e7490; }
    .badge-active { background: #d1fae5; color: #047857; }
    
    /* Action Buttons */
    .btn-view {
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        background: var(--primary-color);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .btn-view:hover {
        background: var(--primary-dark);
    }
    
    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
    }
    
    .empty-state-icon {
        font-size: 48px;
        color: #cbd5e1;
        margin-bottom: 15px;
    }
    
    @media (max-width: 768px) {
        .dashboard-header-content {
            flex-direction: column;
            text-align: center;
        }
        
        .header-actions {
            width: 100%;
            justify-content: center;
        }
        
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .charts-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- Dashboard Header --}}
<div class="dashboard-header">
    <div class="dashboard-header-content">
        <div class="welcome-section">
            <h1><i class="fa fa-crown"></i> Admin Dashboard</h1>
            <p>Welcome back, {{ $user->name }}! Overview of the entire system.</p>
            <div class="admin-badges">
                @if($user->hasRole('Super Admin'))
                <span class="role-badge"><i class="fa fa-star"></i> Super Admin</span>
                @endif
                @if($user->hasRole('Admin'))
                <span class="role-badge"><i class="fa fa-shield-alt"></i> Admin</span>
                @endif
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('settings.index') }}" class="btn-premium btn-primary-premium">
                <i class="fa fa-cog"></i> Settings
            </a>
            <button onclick="location.reload()" class="btn-premium btn-outline-premium">
                <i class="fa fa-sync-alt"></i> Refresh
            </button>
        </div>
    </div>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card total">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-clipboard-list"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-layer-group"></i> All Time</span>
        </div>
        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        <div class="stat-label">Total Requisitions</div>
    </div>
    
    <div class="stat-card pending">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-hourglass-half"></i>
            </div>
            <span class="stat-trend neutral"><i class="fa fa-clock"></i> Awaiting</span>
        </div>
        <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
        <div class="stat-label">Pending</div>
    </div>
    
    <div class="stat-card approved">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> Approved</span>
        </div>
        <div class="stat-value">{{ $stats['approved'] ?? 0 }}</div>
        <div class="stat-label">Approved</div>
    </div>
    
    <div class="stat-card completed">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-flag-checkered"></i>
            </div>
            <span class="stat-trend up"><i class="fa fa-arrow-up"></i> Completed</span>
        </div>
        <div class="stat-value">{{ $stats['completed'] ?? 0 }}</div>
        <div class="stat-label">Completed</div>
    </div>
    
    <div class="stat-card rejected">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-times-circle"></i>
            </div>
            <span class="stat-trend down"><i class="fa fa-arrow-down"></i> Rejected</span>
        </div>
        <div class="stat-value">{{ $stats['rejected'] ?? 0 }}</div>
        <div class="stat-label">Rejected</div>
    </div>
    
    <div class="stat-card vehicle">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-car"></i>
            </div>
        </div>
        <div class="stat-value">{{ \App\Models\Vehicle::count() }}</div>
        <div class="stat-label">Total Vehicles</div>
    </div>
    
    <div class="stat-card driver">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-id-card"></i>
            </div>
        </div>
        <div class="stat-value">{{ \App\Models\Driver::count() }}</div>
        <div class="stat-label">Total Drivers</div>
    </div>
    
    <div class="stat-card employee">
        <div class="stat-card-header">
            <div class="stat-icon">
                <i class="fa fa-users"></i>
            </div>
        </div>
        <div class="stat-value">{{ \App\Models\Employee::count() }}</div>
        <div class="stat-label">Total Employees</div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="quick-actions">
    <h4 class="section-title"><i class="fa fa-bolt" style="color: var(--primary-color);"></i> Quick Actions</h4>
    <div class="quick-actions-grid">
        <a href="{{ route('requisitions.index') }}" class="quick-action-item">
            <div class="quick-action-icon">
                <i class="fa fa-clipboard-list"></i>
            </div>
            <div class="quick-action-text">
                <h5>All Requisitions</h5>
                <p>View all requests</p>
            </div>
        </a>
        
        <a href="{{ route('vehicles.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--purple-color);">
                <i class="fa fa-car"></i>
            </div>
            <div class="quick-action-text">
                <h5>Fleet Management</h5>
                <p>Manage vehicles</p>
            </div>
        </a>
        
        <a href="{{ route('drivers.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--info-color);">
                <i class="fa fa-id-card"></i>
            </div>
            <div class="quick-action-text">
                <h5>Drivers</h5>
                <p>Manage drivers</p>
            </div>
        </a>
        
        <a href="{{ route('admin.employees.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--pink-color);">
                <i class="fa fa-users"></i>
            </div>
            <div class="quick-action-text">
                <h5>Employees</h5>
                <p>Manage employees</p>
            </div>
        </a>
        
        <a href="{{ route('admin.departments.index') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--success-color);">
                <i class="fa fa-building"></i>
            </div>
            <div class="quick-action-text">
                <h5>Departments</h5>
                <p>Manage departments</p>
            </div>
        </a>
        
        <a href="{{ route('reports.vehicle_utilization') }}" class="quick-action-item">
            <div class="quick-action-icon" style="background: var(--warning-color);">
                <i class="fa fa-chart-bar"></i>
            </div>
            <div class="quick-action-text">
                <h5>Reports</h5>
                <p>View analytics</p>
            </div>
        </a>
    </div>
</div>

{{-- System Overview --}}
<div class="system-grid">
    <div class="system-card">
        <div class="system-icon" style="background: #e0e7ff; color: var(--primary-color);">
            <i class="fa fa-building"></i>
        </div>
        <div class="system-value">{{ \App\Models\Department::count() }}</div>
        <div class="system-label">Departments</div>
    </div>
    
    <div class="system-card">
        <div class="system-icon" style="background: #d1fae5; color: var(--success-color);">
            <i class="fa fa-map-marker-alt"></i>
        </div>
        <div class="system-value">{{ \App\Models\Location::count() }}</div>
        <div class="system-label">Locations</div>
    </div>
    
    <div class="system-card">
        <div class="system-icon" style="background: #fef3c7; color: var(--warning-color);">
            <i class="fa fa-wrench"></i>
        </div>
        <div class="system-value">{{ \App\Models\VehicleMaintenence::count() }}</div>
        <div class="system-label">Maintenance Records</div>
    </div>
    
    <div class="system-card">
        <div class="system-icon" style="background: #ede9fe; color: var(--purple-color);">
            <i class="fa fa-file-alt"></i>
        </div>
        <div class="system-value">{{ \App\Models\DriverDocument::count() }}</div>
        <div class="system-label">Documents</div>
    </div>
</div>

{{-- Recent Requisitions Table --}}
<div class="table-card">
    <div class="table-header">
        <h4><i class="fa fa-history" style="color: var(--primary-color);"></i> Recent Requisitions</h4>
        <a href="{{ route('requisitions.index') }}" class="btn-view">View All <i class="fa fa-arrow-right"></i></a>
    </div>
    
    @if($latest && $latest->count() > 0)
    <table class="table-premium">
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Department</th>
                <th>Employee</th>
                <th>Travel Date</th>
                <th>Destination</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($latest as $requisition)
            <tr>
                <td><strong>#REQ-{{ str_pad($requisition->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                <td>{{ $requisition->department->department_name ?? 'N/A' }}</td>
                <td>{{ $requisition->employee->first_name ?? 'User' }} {{ $requisition->employee->last_name ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($requisition->travel_date)->format('M d, Y') }}</td>
                <td>{{ $requisition->destination }}</td>
                <td>
                    @if($requisition->status == 'Completed')
                        <span class="badge-status badge-completed"><i class="fa fa-check"></i> Completed</span>
                    @elseif($requisition->transport_status == 'Approved')
                        <span class="badge-status badge-approved"><i class="fa fa-check"></i> Approved</span>
                    @elseif($requisition->department_status == 'Rejected' || $requisition->transport_status == 'Rejected')
                        <span class="badge-status badge-rejected"><i class="fa fa-times"></i> Rejected</span>
                    @else
                        <span class="badge-status badge-pending"><i class="fa fa-clock"></i> Pending</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('requisitions.show', $requisition->id) }}" class="btn-view">
                        <i class="fa fa-eye"></i> View
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <div class="empty-state-icon">
            <i class="fa fa-clipboard"></i>
        </div>
        <h4>No Requisitions Yet</h4>
        <p>There are no requisitions in the system.</p>
    </div>
    @endif
</div>
@endsection
