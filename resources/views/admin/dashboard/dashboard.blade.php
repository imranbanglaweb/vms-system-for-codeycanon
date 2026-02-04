@extends('admin.dashboard.master')

@section('title', 'Dashboard - ' . config('app.name'))

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
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-success"><i class="fa fa-check"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">Your requisition <strong>#REQ-001</strong> has been approved</p>
                            <span class="activity-time">2 hours ago</span>
                        </div>
                        <div class="activity-actions">
                            <button class="activity-btn" title="View Details"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-warning"><i class="fa fa-clock"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">New requisition <strong>#REQ-002</strong> awaiting approval</p>
                            <span class="activity-time">3 hours ago</span>
                        </div>
                        <div class="activity-actions">
                            <button class="activity-btn" title="View Details"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-info"><i class="fa fa-car"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">Vehicle <strong>Toyota Camry</strong> assigned to your trip</p>
                            <span class="activity-time">5 hours ago</span>
                        </div>
                        <div class="activity-actions">
                            <button class="activity-btn" title="View Details"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-primary"><i class="fa fa-calendar-check"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">Trip scheduled for <strong>Tomorrow, 9:00 AM</strong></p>
                            <span class="activity-time">6 hours ago</span>
                        </div>
                        <div class="activity-actions">
                            <button class="activity-btn" title="View Details"><i class="fa fa-eye"></i></button>
                        </div>
                    </div>
                </div>
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

{{-- Bottom Section - Additional Info --}}
<div class="row dashboard-widgets">
    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-bell mr-2"></i>Notifications</h4>
                <span class="badge badge-danger">3 New</span>
            </div>
            <div class="card-body dashboard-card-body p-0">
                <div class="notification-list">
                    <div class="notification-item">
                        <div class="notification-icon notification-icon-danger">
                            <i class="fa fa-exclamation-triangle"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Vehicle maintenance due for Toyota Camry</p>
                            <span class="notification-time">30 minutes ago</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon notification-icon-info">
                            <i class="fa fa-info-circle"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">New policy update available</p>
                            <span class="notification-time">2 hours ago</span>
                        </div>
                    </div>
                    <div class="notification-item">
                        <div class="notification-icon notification-icon-success">
                            <i class="fa fa-check"></i>
                        </div>
                        <div class="notification-content">
                            <p class="notification-text">Your requisition #REQ-005 completed</p>
                            <span class="notification-time">Yesterday</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-star mr-2"></i>Top Vehicles</h4>
            </div>
            <div class="card-body dashboard-card-body">
                <div class="vehicle-stats-list">
                    <div class="vehicle-stat-item">
                        <div class="vehicle-rank">1</div>
                        <div class="vehicle-info">
                            <span class="vehicle-name">Toyota Camry</span>
                            <span class="vehicle-usage">45 trips this month</span>
                        </div>
                        <div class="vehicle-progress">
                            <div class="progress-bar" style="width: 85%"></div>
                        </div>
                    </div>
                    <div class="vehicle-stat-item">
                        <div class="vehicle-rank">2</div>
                        <div class="vehicle-info">
                            <span class="vehicle-name">Honda CR-V</span>
                            <span class="vehicle-usage">38 trips this month</span>
                        </div>
                        <div class="vehicle-progress">
                            <div class="progress-bar" style="width: 72%"></div>
                        </div>
                    </div>
                    <div class="vehicle-stat-item">
                        <div class="vehicle-rank">3</div>
                        <div class="vehicle-info">
                            <span class="vehicle-name">Ford Transit</span>
                            <span class="vehicle-usage">32 trips this month</span>
                        </div>
                        <div class="vehicle-progress">
                            <div class="progress-bar" style="width: 60%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-users mr-2"></i>Team Members</h4>
                <a href="#" class="card-header-link">View All</a>
            </div>
            <div class="card-body dashboard-card-body p-0">
                <div class="team-list">
                    <div class="team-member-item">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">JD</div>
                        <div class="team-info">
                            <span class="team-name">John Doe</span>
                            <span class="team-role">Transport Manager</span>
                        </div>
                        <div class="team-status online"></div>
                    </div>
                    <div class="team-member-item">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">JS</div>
                        <div class="team-info">
                            <span class="team-name">Jane Smith</span>
                            <span class="team-role">Admin Officer</span>
                        </div>
                        <div class="team-status online"></div>
                    </div>
                    <div class="team-member-item">
                        <div class="team-avatar" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">MJ</div>
                        <div class="team-info">
                            <span class="team-name">Mike Johnson</span>
                            <span class="team-role">Driver Coordinator</span>
                        </div>
                        <div class="team-status away"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Requisitions Bar Chart
    const monthlyCtx = document.getElementById('monthlyRequisitionsChart').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Requisitions',
                data: [12,19,15,25,22,30,28,35,40,38,45,50],
                backgroundColor: function(context) {
                    const chart = context.chart;
                    const {ctx, chartArea} = chart;
                    if (!chartArea) return null;
                    const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                    gradient.addColorStop(0, 'rgba(79, 70, 229, 0.6)');
                    gradient.addColorStop(1, 'rgba(79, 70, 229, 1)');
                    return gradient;
                },
                borderRadius: 8,
                borderSkipped: false,
                barThickness: 24
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b' }
                },
                y: {
                    grid: { color: 'rgba(0, 0, 0, 0.05)' },
                    ticks: { color: '#64748b' },
                    beginAtZero: true
                }
            },
            animation: {
                duration: 1500,
                easing: 'easeOutQuart'
            }
        }
    });
    
    // Status Distribution Doughnut Chart
    const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: ['Approved','Pending','Rejected'],
            datasets: [{
                data: [55,30,15],
                backgroundColor: [
                    'rgba(16, 185, 129, 0.9)',
                    'rgba(245, 158, 11, 0.9)',
                    'rgba(239, 68, 68, 0.9)'
                ],
                borderColor: [
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 2,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            },
            cutout: '65%',
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1500,
                easing: 'easeOutQuart'
            }
        }
    });
});
</script>
@endpush

<style>
/* Dashboard Header Styles */
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

.dashboard-header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.dashboard-header-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.dashboard-header-icon i {
    font-size: 24px;
    color: #fff;
}

.dashboard-header-content h1 {
    font-size: 22px;
    font-weight: 700;
    color: #fff;
    margin: 0;
    line-height: 1.2;
}

.dashboard-header-content p {
    font-size: 14px;
    color: rgba(255, 255, 255, 0.9);
    margin: 4px 0 0 0;
}

.dashboard-header-right {
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-refresh {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    background: #fff;
    border: none;
    color: #4f46e5;
    cursor: pointer;
    transition: all 0.25s ease;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.btn-refresh:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-new-requisition {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 10px 18px;
    border-radius: 10px;
    font-weight: 600;
    font-size: 13px;
    background: rgba(255, 255, 255, 0.15);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: #fff;
    text-decoration: none;
    transition: all 0.25s ease;
    backdrop-filter: blur(10px);
}

.btn-new-requisition:hover {
    background: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
    border-color: rgba(255, 255, 255, 0.5);
}

/* Role Indicator Styles */
.alert-role {
    border-radius: 12px;
    padding: 16px 20px;
    border: none;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
}

.alert-role i {
    font-size: 20px;
}

.alert-danger.alert-role {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #991b1b;
}

.alert-primary.alert-role {
    background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    color: #1e40af;
}

.alert-info.alert-role {
    background: linear-gradient(135deg, #ecfeff 0%, #cffafe 100%);
    color: #155e75;
}

.alert-warning.alert-role {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    color: #92400e;
}

.alert-success.alert-role {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    color: #166534;
}

/* Stats Cards Styles */
.stats-row .col-xl-3 {
    padding: 12px;
}

.stat-card {
    position: relative;
    background: #fff;
    border-radius: 16px;
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stat-card-icon {
    width: 52px;
    height: 52px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}

.stat-card-primary .stat-card-icon {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.15) 0%, rgba(79, 70, 229, 0.05) 100%);
    color: #4f46e5;
}

.stat-card-warning .stat-card-icon {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: #f59e0b;
}

.stat-card-success .stat-card-icon {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: #10b981;
}

.stat-card-danger .stat-card-icon {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
    color: #ef4444;
}

.stat-card-content {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.stat-label {
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
    margin-bottom: 4px;
}

.stat-value {
    font-size: 32px;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.1;
    margin-bottom: 6px;
}

.stat-trend {
    font-size: 12px;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 4px;
}

.stat-trend-up {
    color: #10b981;
}

.stat-trend-down {
    color: #ef4444;
}

.stat-trend-neutral {
    color: #f59e0b;
}

.stat-card-decoration {
    position: absolute;
    top: -20px;
    right: -20px;
    width: 100px;
    height: 100px;
    border-radius: 50%;
    opacity: 0.1;
}

.stat-card-primary .stat-card-decoration {
    background: #4f46e5;
}

.stat-card-warning .stat-card-decoration {
    background: #f59e0b;
}

.stat-card-success .stat-card-decoration {
    background: #10b981;
}

.stat-card-danger .stat-card-decoration {
    background: #ef4444;
}

/* Dashboard Card Styles */
.dashboard-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(0, 0, 0, 0.05);
    overflow: hidden;
    transition: all 0.3s ease;
}

.dashboard-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
}

.dashboard-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 24px;
    border-bottom: 1px solid #f1f5f9;
    background: #fff;
}

.dashboard-card-header .card-title {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dashboard-card-header .card-title i {
    color: #4f46e5;
}

.card-header-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.chart-filter {
    padding: 6px 12px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    font-size: 13px;
    color: #64748b;
    background: #fff;
    cursor: pointer;
}

.card-header-link {
    font-size: 13px;
    color: #4f46e5;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.card-header-link:hover {
    color: #4338ca;
}

.dashboard-card-body {
    padding: 24px;
}

/* Activity List Styles */
.activity-list {
    padding: 8px 0;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 24px;
    transition: all 0.2s ease;
    border-bottom: 1px solid #f8fafc;
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-item:hover {
    background: #f8fafc;
}

.activity-icon {
    width: 42px;
    height: 42px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.activity-icon-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: #10b981;
}

.activity-icon-warning {
    background: linear-gradient(135deg, rgba(245, 158, 11, 0.15) 0%, rgba(245, 158, 11, 0.05) 100%);
    color: #f59e0b;
}

.activity-icon-info {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.05) 100%);
    color: #06b6d4;
}

.activity-icon-primary {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.15) 0%, rgba(79, 70, 229, 0.05) 100%);
    color: #4f46e5;
}

.activity-content {
    flex: 1;
    min-width: 0;
}

.activity-text {
    font-size: 14px;
    color: #334155;
    margin: 0 0 4px 0;
    font-weight: 500;
}

.activity-text strong {
    color: #1e293b;
}

.activity-time {
    font-size: 12px;
    color: #94a3b8;
}

.activity-actions {
    opacity: 0;
    transition: opacity 0.2s ease;
}

.activity-item:hover .activity-actions {
    opacity: 1;
}

.activity-btn {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: #f1f5f9;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.activity-btn:hover {
    background: #e2e8f0;
    color: #4f46e5;
}

/* Quick Actions Styles */
.quick-actions-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.quick-action-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 20px 16px;
    border-radius: 14px;
    text-decoration: none;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    transition: all 0.25s ease;
}

.quick-action-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    border-color: transparent;
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #fff;
}

.quick-action-icon.bg-primary {
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
}

.quick-action-icon.bg-info {
    background: linear-gradient(135deg, #0ea5e9 0%, #38bdf8 100%);
}

.quick-action-icon.bg-warning {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
}

.quick-action-icon.bg-secondary {
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
}

.quick-action-icon.bg-success {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
}

.quick-action-icon.bg-danger {
    background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
}

.quick-action-item span {
    font-size: 13px;
    font-weight: 600;
    color: #334155;
    text-align: center;
}

/* Notification List Styles */
.notification-list {
    padding: 8px 0;
}

.notification-item {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 14px 24px;
    border-bottom: 1px solid #f8fafc;
    transition: background 0.2s ease;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background: #f8fafc;
}

.notification-icon {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}

.notification-icon-danger {
    background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
    color: #ef4444;
}

.notification-icon-info {
    background: linear-gradient(135deg, rgba(6, 182, 212, 0.15) 0%, rgba(6, 182, 212, 0.05) 100%);
    color: #06b6d4;
}

.notification-icon-success {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
    color: #10b981;
}

.notification-content {
    flex: 1;
}

.notification-text {
    font-size: 14px;
    color: #334155;
    margin: 0 0 4px 0;
    font-weight: 500;
}

.notification-time {
    font-size: 12px;
    color: #94a3b8;
}

/* Vehicle Stats List Styles */
.vehicle-stats-list {
    padding: 8px 0;
}

.vehicle-stat-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid #f8fafc;
}

.vehicle-stat-item:last-child {
    border-bottom: none;
}

.vehicle-rank {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 700;
    flex-shrink: 0;
}

.vehicle-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.vehicle-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}

.vehicle-usage {
    font-size: 12px;
    color: #64748b;
}

.vehicle-progress {
    width: 80px;
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    overflow: hidden;
}

.vehicle-progress .progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #4f46e5 0%, #6366f1 100%);
    border-radius: 3px;
    transition: width 0.5s ease;
}

/* Team List Styles */
.team-list {
    padding: 8px 0;
}

.team-member-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 24px;
    border-bottom: 1px solid #f8fafc;
    transition: background 0.2s ease;
}

.team-member-item:last-child {
    border-bottom: none;
}

.team-member-item:hover {
    background: #f8fafc;
}

.team-avatar {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    flex-shrink: 0;
}

.team-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.team-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}

.team-role {
    font-size: 12px;
    color: #64748b;
}

.team-status {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 2px #e2e8f0;
}

.team-status.online {
    background: #10b981;
    box-shadow: 0 0 0 2px #d1fae5;
}

.team-status.away {
    background: #f59e0b;
    box-shadow: 0 0 0 2px #fef3c7;
}

/* Badge Styles */
.badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-danger {
    background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    color: #991b1b;
}

/* Responsive */
@media (max-width: 1200px) {
    .quick-actions-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 992px) {
    .quick-actions-grid {
        grid-template-columns: repeat(3, 1fr);
    }
    
    .vehicle-progress {
        width: 60px;
    }
}

@media (max-width: 768px) {
    .dashboard-header {
        flex-direction: column;
        text-align: center;
        gap: 16px;
        padding: 20px;
    }
    
    .dashboard-header-left {
        flex-direction: column;
    }
    
    .dashboard-header-right {
        width: 100%;
        justify-content: center;
        flex-wrap: wrap;
    }
    
    .stat-card {
        flex-direction: row;
        text-align: left;
    }
    
    .stat-value {
        font-size: 28px;
    }
    
    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .vehicle-progress {
        display: none;
    }
}

@media (max-width: 576px) {
    .quick-actions-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }
    
    .quick-action-item {
        padding: 16px 12px;
    }
    
    .quick-action-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    .dashboard-card-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    
    .activity-item {
        flex-wrap: wrap;
    }
    
    .activity-actions {
        width: 100%;
        opacity: 1;
        margin-top: 8px;
    }
}
</style>
