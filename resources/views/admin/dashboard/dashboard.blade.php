@extends('admin.dashboard.master')

@section('title', 'Dashboard - ' . config('app.name'))

@section('main_content')
{{-- Page Header --}}
<div class="page-header mb-4">
    <table style="width: 100%; border-collapse: collapse;">
        <tr>
            <td style="vertical-align: middle; padding-right: 20px;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 44px; height: 44px; border-radius: 10px; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; border: 2px solid rgba(255,255,255,0.3);">
                        <i class="fa fa-tachometer-alt" style="font-size: 20px; color: #fff;"></i>
                    </div>
                    <div>
                        <h1 style="font-size: 18px; font-weight: 700; color: #fff; margin: 0;">Dashboard Overview</h1>
                        <p style="font-size: 12px; color: rgba(255,255,255,0.85); margin: 4px 0 0 0;">Welcome back, {{ Auth::user()->name }}!</p>
                    </div>
                </div>
            </td>
            <td style="vertical-align: middle; text-align: right; white-space: nowrap;">
                <button onclick="location.reload()" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 12px; background: rgba(255,255,255,0.95); border: none; color: #667eea; cursor: pointer; margin-right: 8px;">
                    <i class="fa fa-sync-alt"></i> Refresh
                </button>
                <a href="{{ route('requisitions.create') }}" style="display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 12px; background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.4); color: #fff; text-decoration: none;">
                    <i class="fa fa-plus"></i> New Requisition
                </a>
            </td>
        </tr>
    </table>
</div>

{{-- Role Indicator --}}
<div class="role-indicator mb-4">
    @if($isAdmin)
    <div class="alert alert-primary alert-role d-flex align-items-center">
        <i class="fa fa-shield-alt mr-2"></i>
        <div>
            <strong>Super Admin Access</strong>
            <p class="mb-0 small">Full system access with all administrative privileges</p>
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
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row dashboard-widgets mb-4">
    <div class="col-xl-8 col-lg-7 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-chart-bar mr-2"></i>Monthly Requisitions</h4>
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

{{-- Activity and Quick Actions --}}
<div class="row dashboard-widgets mb-4">
    <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 mb-4">
        <div class="card dashboard-card">
            <div class="card-header dashboard-card-header">
                <h4 class="card-title"><i class="fa fa-history mr-2"></i>Recent Activity</h4>
            </div>
            <div class="card-body dashboard-card-body p-0">
                <div class="activity-list">
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-success"><i class="fa fa-check"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">Your requisition <strong>#REQ-001</strong> has been approved</p>
                            <span class="activity-time">2 hours ago</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-warning"><i class="fa fa-clock"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">New requisition <strong>#REQ-002</strong> awaiting approval</p>
                            <span class="activity-time">3 hours ago</span>
                        </div>
                    </div>
                    <div class="activity-item">
                        <div class="activity-icon activity-icon-info"><i class="fa fa-car"></i></div>
                        <div class="activity-content">
                            <p class="activity-text">Vehicle <strong>Toyota Camry</strong> assigned to your trip</p>
                            <span class="activity-time">5 hours ago</span>
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
    new Chart(document.getElementById('monthlyRequisitionsChart'), {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Requisitions',
                data: [12,19,15,25,22,30,28,35,40,38,45,50],
                backgroundColor: 'rgba(79, 70, 229, 0.8)',
                borderRadius: 8
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
    });
    new Chart(document.getElementById('statusDistributionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Approved','Pending','Rejected'],
            datasets: [{
                data: [55,30,15],
                backgroundColor: ['rgba(16, 185, 129, 0.8)','rgba(245, 158, 11, 0.8)','rgba(239, 68, 68, 0.8)']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
    });
});
</script>
@endpush
