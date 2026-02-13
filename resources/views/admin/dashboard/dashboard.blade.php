@extends('admin.dashboard.master')

@section('title', 'Dashboard - ' . config('app.name'))

@php
    // Define role variables if not already defined
    $isSuperAdmin = $isSuperAdmin ?? auth()->user()->hasRole('Super Admin');
    $isAdmin = $isAdmin ?? auth()->user()->hasRole('Admin');
    $isManager = $isManager ?? (auth()->user()->hasRole('Department Head') || auth()->user()->hasRole('Manager'));
    $isTransport = $isTransport ?? auth()->user()->hasRole('Transport');
    $isEmployee = $isEmployee ?? auth()->user()->hasRole('Employee');
    $isDriver = $isDriver ?? auth()->user()->hasRole('Driver');
@endphp

@section('main_content')
{{-- Page Header --}}
<div class="dashboard-header">
    <div class="dashboard-header-left">
        <div class="dashboard-header-icon">
            <i class="fa fa-tachometer-alt"></i>
        </div>
        <div class="dashboard-header-content">
            <h1>Dashboard Overview</h1>
            <p>Welcome back, {{ Auth::user()->name }}!</p>
        </div>
    </div>
    <div class="dashboard-header-right">
        <button onclick="location.reload()" class="btn-refresh">
            <i class="fa fa-sync-alt"></i> Refresh
        </button>
        <a href="{{ route('requisitions.create') }}" class="btn-new-requisition">
            <i class="fa fa-plus"></i> New Requisition
        </a>
    </div>
</div>

{{-- Role Indicator --}}
<div class="role-indicator mb-4">
    @if($isSuperAdmin)
    <div class="alert alert-danger alert-role d-flex align-items-center">
        <i class="fa fa-crown mr-2"></i>
        <div>
            <strong>Super Admin</strong>
            <p class="mb-0 small">Full system access with all privileges</p>
        </div>
    </div>
    @elseif($isAdmin)
    <div class="alert alert-primary alert-role d-flex align-items-center">
        <i class="fa fa-shield-alt mr-2"></i>
        <div>
            <strong>Admin Access</strong>
            <p class="mb-0 small">Administrative privileges</p>
        </div>
    </div>
    @elseif($isManager)
    <div class="alert alert-info alert-role d-flex align-items-center">
        <i class="fa fa-user-tie mr-2"></i>
        <div>
            <strong>Manager Dashboard</strong>
            <p class="mb-0 small">Department approval and team management access</p>
        </div>
    </div>
    @elseif($isTransport)
    <div class="alert alert-warning alert-role d-flex align-items-center">
        <i class="fa fa-truck mr-2"></i>
        <div>
            <strong>Transport Dashboard</strong>
            <p class="mb-0 small">Fleet management and transportation coordination</p>
        </div>
    </div>
    @elseif($isDriver)
    <div class="alert alert-info alert-role d-flex align-items-center">
        <i class="fa fa-id-card mr-2"></i>
        <div>
            <strong>Driver Dashboard</strong>
            <p class="mb-0 small">View your schedule, trips, and update availability</p>
        </div>
    </div>
    @else
    <div class="alert alert-success alert-role d-flex align-items-center">
        <i class="fa fa-user mr-2"></i>
        <div>
            <strong>Employee Dashboard</strong>
            <p class="mb-0 small">Submit and track your vehicle requisitions</p>
        </div>
    </div>
    @endif
</div>

{{-- Stats Cards Row --}}
<div class="row stats-row mb-4">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-primary">
            <div class="stat-card-icon"><i class="fa fa-clipboard-list"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Total Requisitions</span>
                <span class="stat-value">{{ $stats['total'] ?? 0 }}</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> This month</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-warning">
            <div class="stat-card-icon"><i class="fa fa-clock"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Pending</span>
                <span class="stat-value">{{ $stats['pending'] ?? 0 }}</span>
                <span class="stat-trend stat-trend-neutral"><i class="fa fa-minus"></i> Awaiting</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-success">
            <div class="stat-card-icon"><i class="fa fa-check-circle"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Approved</span>
                <span class="stat-value">{{ $stats['approved'] ?? 0 }}</span>
                <span class="stat-trend stat-trend-up"><i class="fa fa-arrow-up"></i> Completed</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 mb-3">
        <div class="stat-card stat-card-danger">
            <div class="stat-card-icon"><i class="fa fa-times-circle"></i></div>
            <div class="stat-card-content">
                <span class="stat-label">Rejected</span>
                <span class="stat-value">{{ $stats['rejected'] ?? 0 }}</span>
                <span class="stat-trend stat-trend-down"><i class="fa fa-arrow-down"></i> Declined</span>
            </div>
            <div class="stat-card-decoration"></div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row dashboard-widgets mb-4">
    <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-bar mr-2"></i>Monthly Requisitions</h4>
                <div class="card-header-actions">
                    <select class="chart-filter" id="monthFilter">
                        <option value="12">Last 12 Months</option>
                        <option value="6">Last 6 Months</option>
                        <option value="3">Last 3 Months</option>
                    </select>
                </div>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="monthlyRequisitionsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-5 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-pie mr-2"></i>Status Distribution</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="chart-container" style="position: relative; height: 300px;">
                    <canvas id="statusDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Activity and Quick Actions Row --}}
<div class="row dashboard-widgets mb-4">
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-history mr-2"></i>Recent Activity</h4>
                <a href="#" class="card-header-link">View All</a>
            </div>
            <div class="card-body dashboard-card-body p-0">
                @if($timeline && $timeline->count() > 0)
                <div class="activity-list">
                    @foreach($timeline as $activity)
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-{{ $activity->status == 'Approved' ? 'success' : ($activity->status == 'Pending' ? 'warning' : 'info') }}">
                            <i class="fa fa-{{ $activity->status == 'Approved' ? 'check' : ($activity->status == 'Pending' ? 'clock' : 'info') }}"></i>
                        </div>
                        <div class="activity-content">
                            <p class="activity-text">{!! $activity->description ?? 'Activity update' !!}</p>
                            <span class="activity-time">{{ $activity->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="activity-actions">
                            <button class="activity-btn" title="View Details"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-success"><i class="fa fa-check"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">Welcome to your dashboard!</p>
                            <span class="activity-time">Just now</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-bolt mr-2"></i>Quick Actions</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="quick-actions-grid">
                    <a href="{{ route('requisitions.create') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-primary"><i class="fa fa-plus-circle"></i></div>
                        <span>New Requisition</span>
                    </a>
                    <a href="{{ route('requisitions.index') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-info"><i class="fa fa-list"></i></div>
                        <span>My Requisitions</span>
                    </a>
                    @if($isManager || $isAdmin)
                    <a href="{{ route('department.approvals.index') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-warning"><i class="fa fa-check-double"></i></div>
                        <span>Pending Approvals</span>
                    </a>
                    @endif
                    @if($isTransport || $isAdmin)
                    <a href="{{ route('transport.approvals.index') }}" class="quick-action-item">
                        <div class="quick-action-icon bg-secondary"><i class="fa fa-truck"></i></div>
                        <span>Transport Queue</span>
                    </a>
                    @endif
                    <a href="#" class="quick-action-item">
                        <div class="quick-action-icon bg-success"><i class="fa fa-calendar-alt"></i></div>
                        <span>My Schedule</span>
                    </a>
                    <a href="#" class="quick-action-item">
                        <div class="quick-action-icon bg-danger"><i class="fa fa-file-alt"></i></div>
                        <span>Reports</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bottom Section --}}
<div class="row dashboard-widgets">
    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card notifications-card">
            <div class="card-header dashboard-card-header">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <h4 class="card-title"><i class="fa fa-bell mr-2"></i>Notifications</h4>
                    @if($notifications && $notifications->count() > 0)
                    <span class="badge badge-danger animate-pulse">{{ $notifications->count() }} New</span>
                    @endif
                </div>
                <a href="#" class="card-header-link" style="font-size: 12px;">Mark all read</a>
            </div>
            <div class="card-body dashboard-card-body p-0">
                @if($notifications && $notifications->count() > 0)
                <div class="notification-list">
                    @foreach($notifications as $notification)
                    <div class="notification-item">
                        <div class="notification-icon notification-icon-{{ $notification->type == 'App\Notifications\DepartmentApproved' ? 'success' : ($notification->type == 'App\Notifications\TransportApproved' ? 'info' : 'danger') }}">
                            <i class="fa fa-{{ $notification->type == 'App\Notifications\DepartmentApproved' ? 'check' : ($notification->type == 'App\Notifications\TransportApproved' ? 'truck' : 'exclamation-triangle') }}"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">{{ $notification->data['message'] ?? 'New notification' }}</p>
                            <span class="notification-time">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="notification-close">
                            <button class="notification-close-btn" title="Dismiss"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="notification-list empty-state">
                    <div class="notification-item">
                        <div class="notification-icon notification-icon-info">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">All caught up!</p>
                            <span class="notification-time">No new notifications</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card vehicles-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-tachometer-alt mr-2"></i>Top Vehicles</h4>
                @if($isAdmin || $isTransport)<a href="{{ route('vehicles.index') }}" class="card-header-link">View All</a>@endif
            </div>
            <div class="card-body dashboard-card-body">
                @if($topVehicles && $topVehicles->count() > 0)
                <div class="vehicle-stats-list">
                    @foreach($topVehicles as $index => $vehicle)
                    <div class="vehicle-stat-item">
                        <div class="vehicle-rank medal-{{ $index === 0 ? 'gold' : ($index === 1 ? 'silver' : 'bronze') }}">
                            @if($index === 0)
                                <i class="fa fa-crown" style="color: #fbbf24;"></i>
                            @elseif($index === 1)
                                <i class="fa fa-medal" style="color: #c0c0c0;"></i>
                            @else
                                <i class="fa fa-medal" style="color: #b87333;"></i>
                            @endif
                        </div>
                        <div class="vehicle-info">
                            <span class="vehicle-name">{{ $vehicle->vehicle_name ?? 'Unknown Vehicle' }}</span>
                            <span class="vehicle-usage">📊 {{ $vehicle->requisitions_count ?? 0 }} trips</span>
                        </div>
                        <div class="vehicle-progress">
                            @php $maxTrips = $topVehicles->max('requisitions_count'); @endphp
                            <div class="progress-bar" style="width: {{ ($vehicle->requisitions_count / ($maxTrips ?: 1)) * 100 }}%"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="vehicle-stats-list empty-state">
                    <div class="vehicle-stat-item">
                        <div class="vehicle-rank">
                            <i class="fa fa-car" style="font-size: 18px;"></i>
                        </div>
                        <div class="vehicle-info">
                            <span class="vehicle-name">No data available</span>
                            <span class="vehicle-usage">Vehicle stats will appear here</span>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card team-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-users mr-2"></i>Team Members</h4>
                <a href="#" class="card-header-link" style="font-size: 12px;">See all</a>
            </div>
            <div class="card-body dashboard-card-body p-0">
                <div class="team-list">
                    <div class="team-member-item">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">JD</div>
                        <div class="team-info">
                            <span class="team-name">John Doe</span>
                            <span class="team-role">Transport Manager</span>
                        </div>
                        <div class="team-status-container">
                            <div class="team-status online" title="Online"></div>
                        </div>
                    </div>
                    <div class="team-member-item">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">JS</div>
                        <div class="team-info">
                            <span class="team-name">Jane Smith</span>
                            <span class="team-role">Admin Officer</span>
                        </div>
                        <div class="team-status-container">
                            <div class="team-status online" title="Online"></div>
                        </div>
                    </div>
                    <div class="team-member-item">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">MJ</div>
                        <div class="team-info">
                            <span class="team-name">Mike Johnson</span>
                            <span class="team-role">Driver Coordinator</span>
                        </div>
                        <div class="team-status-container">
                            <div class="team-status away" title="Away"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function initCharts() {
    // Monthly Requisitions Bar Chart
    const monthlyCtx = document.getElementById('monthlyRequisitionsChart');
    if (monthlyCtx) {
        const monthLabels = {!! json_encode($monthLabels ?: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec']) !!};
        const monthlyData = {!! json_encode($monthlyData ?: [0,0,0,0,0,0,0,0,0,0,0,0]) !!};
        const monthlyDataNumbers = monthlyData.map(function(x) { return parseInt(x) || 0; });
        
        new Chart(monthlyCtx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Requisitions',
                    data: monthlyDataNumbers,
                    backgroundColor: 'rgba(79, 70, 229, 0.8)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 1,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { color: '#64748b' } },
                    y: { grid: { color: 'rgba(0, 0, 0, 0.05)' }, ticks: { color: '#64748b' }, beginAtZero: true }
                }
            }
        });
    }
    
    // Status Distribution Doughnut Chart
    const statusCtx = document.getElementById('statusDistributionChart');
    if (statusCtx) {
        const statusCountsRaw = {!! json_encode($statusCounts ?: ['Approved' => 0, 'Pending' => 0, 'Rejected' => 0]) !!};
        const statusLabels = Object.keys(statusCountsRaw);
        const statusValues = Object.values(statusCountsRaw).map(function(x) { return parseInt(x) || 0; });
        
        new Chart(statusCtx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusValues,
                    backgroundColor: [
                        'rgba(16, 185, 129, 0.8)',
                        'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }
}

// Initialize charts when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(initCharts, 100);
    });
} else {
    setTimeout(initCharts, 100);
}
</script>


<style>
/* Dashboard Container */
.content-body {
  background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
  padding: 32px 40px;
}

.mb-4 {
  margin-bottom: 32px !important;
}

.row {
  margin-left: -16px;
  margin-right: -16px;
}

.col-xl-3, .col-xl-4, .col-xl-6, .col-xl-8,
.col-lg-5, .col-lg-6, .col-lg-7,
.col-md-12 {
  padding-left: 16px;
  padding-right: 16px;
}

.stats-row {
  gap: 16px;
}

.dashboard-widgets {
  gap: 16px;
}

/* Dashboard Header */
.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
    border-radius: 16px;
    margin-bottom: 24px;
    box-shadow: 0 4px 20px rgba(79, 70, 229, 0.35);
}

.dashboard-header-left { display: flex; align-items: center; gap: 16px; }

.dashboard-header-icon {
    width: 56px; height: 56px; background: rgba(255, 255, 255, 0.2);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    font-size: 24px; color: white;
}

.dashboard-header-content h1 { color: white; font-size: 20px; font-weight: 600; margin: 0 0 4px 0; }
.dashboard-header-content p { color: rgba(255, 255, 255, 0.85); font-size: 14px; margin: 0; }

.dashboard-header-right { display: flex; gap: 12px; }

.btn-refresh, .btn-new-requisition {
    padding: 10px 18px; border-radius: 8px; font-weight: 500; font-size: 14px;
    cursor: pointer; display: inline-flex; align-items: center; gap: 8px;
    transition: all 0.2s ease; text-decoration: none;
}

.btn-refresh { background: rgba(255, 255, 255, 0.2); color: white; border: 1px solid rgba(255, 255, 255, 0.3); }
.btn-refresh:hover { background: rgba(255, 255, 255, 0.3); }

.btn-new-requisition { background: white; color: #4f46e5; border: none; }
.btn-new-requisition:hover { background: rgba(255, 255, 255, 0.9); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15); }

/* Stats Cards */
.stat-card {
    border-radius: 14px; padding: 26px 24px; position: relative; overflow: hidden;
    min-height: 140px; display: flex; justify-content: space-between; align-items: flex-start;
    transition: all 0.3s ease; box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1); color: white;
}

.stat-card:hover { transform: translateY(-6px); box-shadow: 0 12px 28px rgba(0, 0, 0, 0.18); }

.stat-card-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
.stat-card-success { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; }
.stat-card-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; }
.stat-card-danger { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; }

.stat-card-icon { 
  font-size: 40px; width: 60px; height: 60px; border-radius: 14px;
  display: flex; align-items: center; justify-content: center;
  background: rgba(255, 255, 255, 0.25); backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
}
.stat-card-content { position: relative; z-index: 1; }
.stat-label { display: block; font-size: 13px; opacity: 0.92; margin-bottom: 8px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
.stat-value { font-size: 36px; font-weight: 800; display: block; margin-bottom: 10px; }
.stat-trend { font-size: 13px; opacity: 0.88; display: inline-flex; align-items: center; gap: 4px; font-weight: 600; }
.stat-trend-up { color: #a7f3d0; }
.stat-trend-down { color: #fecaca; }
.stat-trend-neutral { color: #fde68a; }
.stat-card-decoration { position: absolute; bottom: -30px; right: -20px; width: 120px; height: 120px; background: rgba(255, 255, 255, 0.12); border-radius: 50%; }

/* Dashboard Cards */
.dashboard-card {
  border-radius: 12px;
  border: 1px solid #e5e7eb;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
  height: 100%;
  transition: all 0.3s ease;
  background: #ffffff;
}
.dashboard-card:hover {
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
  transform: translateY(-2px);
}
.dashboard-card-header {
  padding: 18px 22px;
  border-bottom: 2px solid #f3f4f6;
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: linear-gradient(135deg, #f9fafb 0%, #ffffff 100%);
  border-radius: 12px 12px 0 0;
}
.dashboard-card-title { font-size: 16px; font-weight: 700; color: #1f2937; margin: 0; }
.card-header-link { font-size: 13px; color: #4f46e5; text-decoration: none; font-weight: 600; transition: all 0.2s ease; }
.card-header-link:hover { color: #4338ca; text-decoration: underline; }
.dashboard-card-body { padding: 22px; }

/* Activity List */
.activity-list { 
  max-height: 400px; 
  overflow-y: auto;
  padding: 4px;
}
.activity-list::-webkit-scrollbar { width: 4px; }
.activity-list::-webkit-scrollbar-track { background: transparent; }
.activity-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }
.activity-list::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

.activity-item { 
  display: flex; align-items: flex-start; 
  padding: 14px 16px; 
  border-left: 3px solid transparent;
  gap: 12px;
  transition: all 0.3s ease;
  border-radius: 6px;
  margin-bottom: 6px;
}
.activity-item:last-child { margin-bottom: 0; }
.activity-item:hover {
  background: #f9fafb;
  border-left-color: #4f46e5;
}

.activity-icon { 
  width: 40px; height: 40px; border-radius: 10px; 
  display: flex; align-items: center; justify-content: center; 
  font-size: 16px; flex-shrink: 0;
  transition: all 0.3s ease;
}
.activity-icon-success { background: #dcfce7; color: #16a34a; }
.activity-icon-warning { background: #fef3c7; color: #d97706; }
.activity-icon-info { background: #dbeafe; color: #2563eb; }
.activity-icon-danger { background: #fee2e2; color: #dc2626; }

.activity-item:hover .activity-icon { transform: scale(1.05); }

.activity-content { flex: 1; min-width: 0; }
.activity-text { font-size: 14px; color: #334155; margin: 0 0 4px 0; line-height: 1.5; font-weight: 500; }
.activity-time { font-size: 12px; color: #9ca3af; }

.activity-btn { 
  width: 32px; height: 32px; border-radius: 6px; 
  border: 1px solid #e5e7eb; background: white; color: #64748b; 
  cursor: pointer; display: flex; align-items: center; justify-content: center; 
  transition: all 0.2s;
}
.activity-btn:hover { 
  background: #f3f4f6; 
  color: #334155;
  border-color: #d1d5db;
}

/* Quick Actions */
.quick-actions-grid { 
  display: grid; 
  grid-template-columns: repeat(3, 1fr); 
  gap: 16px;
}
.quick-action-item { 
  display: flex; flex-direction: column; align-items: center; justify-content: center; 
  padding: 20px 16px; border-radius: 12px; text-decoration: none; 
  transition: all 0.3s ease;
  border: 2px solid #f3f4f6;
  background: white;
}
.quick-action-item:hover { 
  transform: translateY(-4px); 
  border-color: #4f46e5;
  box-shadow: 0 6px 20px rgba(79, 70, 229, 0.15);
  background: #f9f5ff;
}
.quick-action-icon { 
  width: 50px; height: 50px; border-radius: 12px; 
  display: flex; align-items: center; justify-content: center; 
  font-size: 24px; color: white; margin-bottom: 12px;
  transition: all 0.3s ease;
}
.quick-action-item:hover .quick-action-icon {
  transform: scale(1.1) rotate(-5deg);
}
.quick-action-item span { font-size: 14px; font-weight: 600; color: #334155; text-align: center; }

/* Notification List */
.notification-list { 
  max-height: 400px; 
  overflow-y: auto;
  padding: 4px;
}
.notification-list::-webkit-scrollbar { width: 4px; }
.notification-list::-webkit-scrollbar-track { background: transparent; }
.notification-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }

.notification-item { 
  display: flex; align-items: flex-start; 
  padding: 14px 16px; 
  border-left: 3px solid transparent;
  gap: 12px;
  transition: all 0.3s ease;
  border-radius: 6px;
  margin-bottom: 6px;
}
.notification-item:last-child { margin-bottom: 0; }
.notification-item:hover {
  background: #f9fafb;
  border-left-color: #4f46e5;
}

.notification-icon { 
  width: 40px; height: 40px; border-radius: 10px; 
  display: flex; align-items: center; justify-content: center; 
  font-size: 16px; flex-shrink: 0;
}
.notification-icon-success { background: #dcfce7; color: #16a34a; }
.notification-icon-warning { background: #fef3c7; color: #d97706; }
.notification-icon-info { background: #dbeafe; color: #2563eb; }
.notification-icon-danger { background: #fee2e2; color: #dc2626; }

.notification-content { flex: 1; min-width: 0; }
.notification-text { font-size: 14px; color: #334155; margin: 0 0 4px 0; line-height: 1.5; font-weight: 500; }
.notification-time { font-size: 12px; color: #9ca3af; }

/* Team Members */
.team-list { 
  max-height: 400px; 
  overflow-y: auto;
  padding: 4px;
}
.team-list::-webkit-scrollbar { width: 4px; }
.team-list::-webkit-scrollbar-track { background: transparent; }
.team-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }

.team-member-item { 
  display: flex; align-items: center; 
  padding: 14px 16px; 
  border-left: 3px solid transparent;
  gap: 12px;
  transition: all 0.3s ease;
  border-radius: 6px;
  margin-bottom: 6px;
}
.team-member-item:last-child { margin-bottom: 0; }
.team-member-item:hover {
  background: #f9fafb;
  border-left-color: #4f46e5;
  transform: translateX(4px);
}

.team-avatar { 
  width: 44px; height: 44px; border-radius: 10px; 
  display: flex; align-items: center; justify-content: center; 
  font-size: 14px; font-weight: 700; color: white; 
  flex-shrink: 0;
  transition: all 0.3s ease;
}
.team-member-item:hover .team-avatar { transform: scale(1.1); }

.team-info { flex: 1; min-width: 0; }
.team-name { display: block; font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 2px; }
.team-role { font-size: 12px; color: #9ca3af; }
.team-status { width: 12px; height: 12px; border-radius: 50%; flex-shrink: 0; box-shadow: 0 0 6px rgba(0,0,0,0.15); }
.team-status.online { background: #10b981; box-shadow: 0 0 8px rgba(16, 185, 129, 0.4); }
.team-status.away { background: #f59e0b; box-shadow: 0 0 8px rgba(245, 158, 11, 0.4); }

/* Vehicle Stats */
.vehicle-stats-list { 
  max-height: 400px; 
  overflow-y: auto;
  padding: 4px;
}
.vehicle-stats-list::-webkit-scrollbar { width: 4px; }
.vehicle-stats-list::-webkit-scrollbar-track { background: transparent; }
.vehicle-stats-list::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }

.vehicle-stat-item { 
  display: flex; align-items: center; 
  padding: 14px 0; 
  gap: 12px;
  border-bottom: 1px solid #f3f4f6;
  transition: all 0.3s ease;
}
.vehicle-stat-item:last-child { border-bottom: none; }
.vehicle-stat-item:hover .vehicle-rank {
  background: #4f46e5;
  color: white;
  transform: scale(1.05);
}

.vehicle-rank { 
  width: 32px; height: 32px; border-radius: 8px; 
  background: #f3f4f6; display: flex; align-items: center; 
  justify-content: center; font-size: 13px; font-weight: 700; 
  color: #667eea; flex-shrink: 0;
  transition: all 0.3s ease;
}

.vehicle-info { flex: 1; min-width: 0; }
.vehicle-name { display: block; font-size: 14px; font-weight: 600; color: #1f2937; margin-bottom: 4px; }
.vehicle-usage { font-size: 12px; color: #9ca3af; margin-bottom: 4px; }

.vehicle-progress { 
  width: 100%; height: 6px; 
  background: #f3f4f6; 
  border-radius: 3px; 
  overflow: hidden; 
  flex-shrink: 0;
}
.vehicle-progress .progress-bar { 
  height: 100%; 
  background: linear-gradient(90deg, #667eea, #764ba2); 
  border-radius: 3px; 
  transition: width 0.5s ease;
}

/* Badge Styling */
.badge {
  display: inline-block;
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 11px;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}
.badge-danger {
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
  color: white;
  box-shadow: 0 2px 8px rgba(255, 107, 107, 0.3);
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.badge-danger:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 16px rgba(255, 107, 107, 0.4);
}

@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.7;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Enhanced Notification Icon Styling */
.notification-icon { 
  width: 44px; height: 44px; border-radius: 50%; 
  display: flex; align-items: center; justify-content: center; 
  font-size: 18px; flex-shrink: 0;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
}

.notification-icon-success { 
  background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(17, 153, 142, 0.3);
}
.notification-icon-warning { 
  background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
}
.notification-icon-info { 
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}
.notification-icon-danger { 
  background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
  color: white;
  box-shadow: 0 4px 12px rgba(255, 107, 107, 0.3);
}

/* Enhanced Notification Item */
.notification-item {
  display: flex;
  align-items: flex-start;
  gap: 12px;
  padding: 16px 20px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  position: relative;
  border-left: 3px solid transparent;
}

.notification-item:last-child { 
  border-bottom: none; 
}

.notification-item:hover {
  background: rgba(102, 126, 234, 0.05);
  border-left-color: #667eea;
  padding-left: 24px;
}

.notification-item:hover .notification-icon {
  transform: scale(1.08) rotateY(5deg);
}

.notification-content { 
  flex: 1; 
  min-width: 0; 
}

.notification-text { 
  font-size: 13px; 
  color: #333; 
  margin: 0 0 4px 0; 
  line-height: 1.5; 
  font-weight: 600;
}

.notification-time { 
  font-size: 11px; 
  color: #999;
}

.notification-close {
  display: flex;
  align-items: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.notification-item:hover .notification-close {
  opacity: 1;
}

.notification-close-btn {
  background: none;
  border: none;
  color: #ccc;
  cursor: pointer;
  font-size: 14px;
  padding: 4px;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-close-btn:hover {
  color: #ff6b6b;
  transform: scale(1.2) rotate(90deg);
}

/* Notifications List */
.notification-list { 
  max-height: 400px; 
  overflow-y: auto;
  padding: 0;
}

.notification-list::-webkit-scrollbar { 
  width: 6px; 
}

.notification-list::-webkit-scrollbar-track { 
  background: transparent; 
}

.notification-list::-webkit-scrollbar-thumb { 
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 3px;
  transition: all 0.3s ease;
}

.notification-list::-webkit-scrollbar-thumb:hover { 
  background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
}

.notification-list.empty-state .notification-item {
  justify-content: center;
  text-align: center;
  padding: 40px 20px;
  border: none;
}

/* Enhanced Vehicle Stats */
.vehicle-stats-list { 
  max-height: 400px; 
  overflow-y: auto;
}

.vehicle-stats-list::-webkit-scrollbar { 
  width: 6px; 
}

.vehicle-stats-list::-webkit-scrollbar-track { 
  background: transparent; 
}

.vehicle-stats-list::-webkit-scrollbar-thumb { 
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 3px;
}

.vehicle-stat-item { 
  display: flex; 
  align-items: center; 
  padding: 16px 0; 
  gap: 12px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  position: relative;
  padding-left: 8px;
  padding-right: 8px;
}

.vehicle-stat-item:last-child { 
  border-bottom: none; 
}

.vehicle-stat-item:hover {
  background: rgba(102, 126, 234, 0.05);
  border-radius: 6px;
  padding-left: 16px;
}

.vehicle-stat-item:hover .vehicle-rank {
  transform: scale(1.1) rotateZ(3deg);
}

.vehicle-stat-item:hover .vehicle-progress .progress-bar {
  background: linear-gradient(90deg, #764ba2 0%, #667eea 100%);
}

.vehicle-rank { 
  width: 40px; 
  height: 40px; 
  border-radius: 50%;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  display: flex; 
  align-items: center; 
  justify-content: center; 
  font-size: 16px; 
  font-weight: 700; 
  color: white;
  flex-shrink: 0;
  transition: all 0.3s ease;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.vehicle-rank.medal-gold {
  background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
  box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
}

.vehicle-rank.medal-silver {
  background: linear-gradient(135deg, #e5e7eb 0%, #d1d5db 100%);
  color: #666;
  box-shadow: 0 4px 12px rgba(209, 213, 219, 0.3);
}

.vehicle-rank.medal-bronze {
  background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
  box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
}

.vehicle-info { 
  flex: 1; 
  min-width: 0; 
}

.vehicle-name { 
  display: block; 
  font-size: 13px; 
  font-weight: 600; 
  color: #333; 
  margin-bottom: 4px;
}

.vehicle-usage { 
  font-size: 11px; 
  color: #999;
}

.vehicle-progress { 
  width: 80px;
  height: 6px; 
  background: rgba(0, 0, 0, 0.08); 
  border-radius: 3px; 
  overflow: hidden; 
  flex-shrink: 0;
}

.vehicle-progress .progress-bar { 
  height: 100%; 
  background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
  border-radius: 3px; 
  transition: all 0.3s ease;
}

.vehicle-stats-list.empty-state .vehicle-stat-item {
  justify-content: center;
  text-align: center;
  padding: 40px 0;
  border: none;
}

/* Enhanced Team Members */
.team-list { 
  max-height: 400px; 
  overflow-y: auto;
}

.team-list::-webkit-scrollbar { 
  width: 6px; 
}

.team-list::-webkit-scrollbar-track { 
  background: transparent; 
}

.team-list::-webkit-scrollbar-thumb { 
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border-radius: 3px;
}

.team-member-item { 
  display: flex; 
  align-items: center; 
  padding: 16px 20px; 
  gap: 12px;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  border-left: 3px solid transparent;
  position: relative;
}

.team-member-item:last-child { 
  border-bottom: none; 
}

.team-member-item:hover {
  background: rgba(102, 126, 234, 0.05);
  border-left-color: #667eea;
  padding-left: 24px;
}

.team-avatar { 
  width: 44px; 
  height: 44px; 
  border-radius: 50%; 
  display: flex; 
  align-items: center; 
  justify-content: center; 
  font-size: 13px; 
  font-weight: 700; 
  color: white; 
  flex-shrink: 0;
  transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.team-member-item:hover .team-avatar { 
  transform: scale(1.15) rotateZ(-5deg);
  box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
}

.team-info { 
  flex: 1; 
  min-width: 0; 
}

.team-name { 
  display: block; 
  font-size: 13px; 
  font-weight: 600; 
  color: #333; 
  margin-bottom: 4px;
}

.team-role { 
  font-size: 11px; 
  color: #999;
}

.team-status-container {
  display: flex;
  align-items: center;
}

.team-status { 
  width: 10px; 
  height: 10px; 
  border-radius: 50%; 
  flex-shrink: 0; 
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

.team-status.online { 
  background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
  animation: pulse-dot 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

.team-status.away { 
  background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
  box-shadow: 0 2px 6px rgba(245, 158, 11, 0.3);
}

.team-status.offline {
  background: #d1d5db;
}

@keyframes pulse-dot {
  0%, 100% {
    box-shadow: 0 2px 6px rgba(17, 153, 142, 0.4);
  }
  50% {
    box-shadow: 0 2px 10px rgba(17, 153, 142, 0.2);
  }
}

/* Chart Container */
.chart-container {
  background: white;
  border-radius: 8px;
  padding: 16px 0;
}

/* Dashboard Card Classes */
.notifications-card,
.vehicles-card,
.team-card {
  border: 1px solid rgba(102, 126, 234, 0.1);
  background: white;
  transition: all 0.3s ease;
}

.notifications-card:hover,
.vehicles-card:hover,
.team-card:hover {
  border-color: rgba(102, 126, 234, 0.3);
  box-shadow: 0 8px 24px rgba(102, 126, 234, 0.08);
}

@media (max-width: 768px) {
    .dashboard-header { 
        flex-direction: column; 
        gap: 20px; 
        text-align: center;
        padding: 24px 20px;
    }
    .dashboard-header-left { 
        flex-direction: column;
        justify-content: center;
    }
    .dashboard-header-content h1 { font-size: 24px; }
    .dashboard-header-right { 
        flex-wrap: wrap; 
        justify-content: center;
        width: 100%;
    }
    .quick-actions-grid { grid-template-columns: repeat(2, 1fr); }
    .stats-row { gap: 12px; }
    .stat-card { min-height: 120px; padding: 18px 16px; }
}
</style>
@endsection
