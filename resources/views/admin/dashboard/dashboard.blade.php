@extends('admin.dashboard.master')

@section('main_content')

<style>
    /* Top Summary Cards */
.card-summary {
    background-color: transparent;        /* No background */
    border: 1px solid #666;           /* Primary border color */
    border-radius: 1rem;                  /* Rounded corners */
    padding: 1.5rem 1rem;                 /* Spacing inside */
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s, border-color 0.3s;
    cursor: pointer;
}

.card-summary:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    border-color: #6610f2;               /* Highlight border on hover */
}


.card-summary i {
    font-size: 4.2rem;
    margin-bottom: 0.7rem;
    color: #0d6efd;
    transition: color 0.3s;
}

.card-summary:hover i {
    color: #6610f2;                       /* Icon color on hover */
}


.card-summary h4 {
    font-size: 3.6rem;
    font-weight: 800;
    margin-bottom: 0.35rem;
    letter-spacing: 0.5px;
}


.card-summary p {
    font-size: 2.3rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 0;
    letter-spacing: 0.2px;
}

</style>
<section role="main" class="content-body" style="background: #fff;">
<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary"><i class="fa fa-tachometer-alt me-2"></i>
      
        {{ trans(ensure_menu_translation('dashboard_overview')) }}
        
        
    </h3>

        <!-- Notifications & Refresh -->
        <div class="d-flex align-items-center gap-2">
            <button id="refreshNow" class="btn btn-outline-primary btn-sm"><i class="fa fa-sync me-1"></i> Refresh</button>
            <div class="position-relative dropdown">
                <i class="fa fa-bell fa-lg text-secondary dropdown-toggle" data-toggle="dropdown" style="cursor:pointer;"></i>
                <span id="liveNotifCount" class="badge bg-danger position-absolute rounded-circle" style="top:-8px; right:-8px; display:none;">0</span>
                <ul class="dropdown-menu dropdown-menu-end p-2" style="width:300px;" id="notifDropdown">
                    <li class="text-center text-muted small">No new notifications</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Top Summary Cards -->
    <div class="row g-4 mb-4">

        @foreach($cards as $card)
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card card-summary shadow-sm border-0 rounded-4 text-center py-4 hover-shadow position-relative"
                 style="transition: transform 0.3s;" data-toggle="tooltip" data-placement="top"
                 title="Last 7 days trend">
                <div class="mb-2">
                    @if($card['key'] === 'total')
                        <i class="fa fa-list" style="color:#0d6efd; font-size:4.2rem;"></i>
                    @elseif($card['key'] === 'pending')
                        <i class="fa fa-lock" style="color:#ffc107; font-size:4.2rem;"></i>
                    @else
                        <i class="fa {{ $card['icon'] }}" style="color:{{ $card['color'] }}; font-size:4.2rem;"></i>
                    @endif
                </div>
                <h4 class="fw-bold mb-1" style="color: {{ $card['color'] }}; font-size: 2.6rem;">{{ $card['value'] }}</h4>
                <p class="fw-semibold mb-1" style="font-size: 1.3rem; color: #333;">{{ $card['label'] }}</p>
                <canvas id="sparkline-{{ $card['key'] }}" height="40"></canvas>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Status Progress Bars -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm rounded-4 p-3">
                <h6 class="fw-bold text-dark mb-3">{{ trans('backend.status_progress') }}</h6>
                <div class="row g-3">
                    @php
                        $statuses = [
                            ['label'=>trans('backend.pending'),'value'=>$pending ?? 0,'color'=>'#ffc107'],
                            ['label'=>trans('backend.approved'),'value'=>$approved ?? 0,'color'=>'#20c997'],
                            ['label'=>trans('backend.completed'),'value'=>$completed ?? 0,'color'=>'#0d6efd'],
                        ];
                    @endphp
                    @foreach($statuses as $status)
                    <div class="col-md-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span>{{ $status['label'] }}</span>
                            <span>{{ $status['value'] }}</span>
                        </div>
                        <div class="progress rounded-pill" style="height:8px;">
                            <div class="progress-bar" role="progressbar" style="width: {{ ($total>0)?($status['value']/$total)*100:0 }}%; background: {{ $status['color'] }}"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Analytics -->
    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Monthly Requisitions -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">{{ trans('backend.monthly_requisitions') }} (Last 12 months)</h6>
                    <small class="text-muted">Updated live</small>
                </div>
                <div class="card-body">
                    <canvas id="monthlyChart" height="120"></canvas>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0">
                            <h6 class="fw-bold mb-0 text-dark">{{ trans('backend.department_wise_requests') }}</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="deptPieChart" height="200"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm rounded-4 mb-4">
                        <div class="card-header bg-white border-0">
                            <h6 class="fw-bold mb-0 text-dark">{{ trans('backend.status_ratio') }}</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="statusDoughnut" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Users Horizontal Chart -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0 text-dark">{{ trans('backend.top_active_users') }}</h6>
                </div>
                <div class="card-body">
                    <canvas id="topUsersChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Right Column: Timeline & Latest Requisitions -->
        <div class="col-lg-4">
            <!-- Recent Workflow Timeline -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0 text-dark">{{ trans('backend.recent_workflow_activity') }}</h6>
                </div>
                <div class="card-body" id="timelineContainer" style="max-height:420px; overflow:auto;">
                    @foreach($timeline as $item)
                        <div class="mb-3 p-2 rounded-3 hover-bg-light" title="{{ $item->remarks ?? '' }}">
                            <div class="small text-muted">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y - h:i A') }} by {{ $item->user_name }}</div>
                            <div class="fw-semibold text-dark">{{ $item->action_type }}</div>
                            @if($item->remarks)<div class="small text-secondary">{{ $item->remarks }}</div>@endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Latest Requisitions Table -->
            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0">
                    <h6 class="fw-bold mb-0 text-dark">{{ trans('backend.latest_requisitions') }}</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>{{ trans('backend.employee') }}</th>
                                <th>{{ trans('backend.date') }}</th>
                                <th>{{ trans('backend.status') }}</th>
                            </tr>
                        </thead>
                        <tbody id="latestTableBody">
                            @foreach($latest as $r)
                                <tr class="align-middle">
                                    <td>{{ $r->id }}</td>
                                    <td>{{ $r->requestedBy->name ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($r->travel_date)->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $badgeClass = match($r->status) {
                                                3 => 'bg-success',
                                                4 => 'bg-danger',
                                                default => 'bg-warning',
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">{{ $r->status_text ?? $r->status }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
</section>
@endsection

@push('styles')
<style>
.hover-shadow:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.12); }
.hover-bg-light:hover { background-color: #f8f9fa; }
.card { font-family: 'Inter', sans-serif; }
h3,h4,h5,h6 { font-weight: 700; }
.badge { font-size: 0.9rem; }
</style>
@endpush

@push('scripts')
<!-- <script src="{{ asset('/js/dashboard.js') }}"></script> -->
 @vite(['resources/js/app.js', 'resources/js/dashboard.js'])

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(function(){

    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Top Summary Sparklines
    @foreach($cards as $card)
    const ctx{{ $loop->index }} = document.getElementById('sparkline-{{ $card['key'] }}').getContext('2d');
    new Chart(ctx{{ $loop->index }}, {
        type:'line',
        data:{ labels: {!! json_encode($sparklineLabels[$card['key']] ?? []) !!}, 
               datasets:[{ data:{!! json_encode($sparklineData[$card['key']] ?? []) !!}, 
                           borderColor:'{{ $card['color'] }}', tension:0.4, fill:false, pointRadius:0 }] },
        options:{ responsive:true, plugins:{legend:{display:false}}, scales:{ x:{display:false}, y:{display:false} } }
    });
    @endforeach

    // Main Charts
    const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: { labels: {!! json_encode($monthLabels) !!}, datasets:[{ label:'{{ trans('backend.requisitions') }}', data: {!! json_encode($monthlyData) !!}, backgroundColor:'#0d6efd' }] },
        options: { responsive:true, plugins:{legend:{display:false}}, scales:{ y:{ beginAtZero:true, ticks:{font:{size:14}} }, x:{ticks:{font:{size:14}}} } }
    });

    const deptPieChart = new Chart(document.getElementById('deptPieChart'), {
        type:'pie',
        data:{ labels: {!! json_encode($deptData->pluck('label')) !!}, datasets:[{ data: {!! json_encode($deptData->pluck('value')) !!}, backgroundColor:['#0d6efd','#ffc107','#20c997','#dc3545','#6c757d','#6610f2'] }]},
        options:{ responsive:true, plugins:{legend:{position:'bottom', labels:{font:{size:14}}} } }
    });

    const statusDoughnut = new Chart(document.getElementById('statusDoughnut'), {
        type:'doughnut',
        data:{ labels: {!! json_encode($statusCounts->keys()) !!}, datasets:[{ data: {!! json_encode($statusCounts->values()) !!}, backgroundColor:['#ffc107','#20c997','#dc3545','#0d6efd','#6c757d'] }] },
        options:{ responsive:true, plugins:{legend:{position:'bottom', labels:{font:{size:14}}}} }
    });

    const topUsersChart = new Chart(document.getElementById('topUsersChart'), {
        type:'bar',
        data:{ labels: {!! json_encode($topUsers->pluck('name')) !!}, datasets:[{ data: {!! json_encode($topUsers->pluck('total')) !!}, backgroundColor:'#20c997' }] },
        options:{ indexAxis:'y', responsive:true, plugins:{legend:{display:false}}, scales:{ x:{ticks:{font:{size:14}}}, y:{ticks:{font:{size:14}}} } }
    });

    // Refresh button
    $('#refreshNow').on('click', function(){ location.reload(); });

    // Auto-refresh notifications
    function fetchNotifications(){
        $.get("{{ route('admin.notifications.unread') }}")
            .done(function(res){
                let dropdown = $('#notifDropdown').empty();
                if(res.length>0){
                    res.forEach(n=>{
                        dropdown.append(`<li class="small p-2 border-bottom">${n.message}<br><span class="text-muted small">${n.time}</span></li>`);
                    });
                    $('#liveNotifCount').text(res.length).show();
                } else {
                    dropdown.append('<li class="text-center text-muted small">No new notifications</li>');
                    $('#liveNotifCount').hide();
                }
            });
    }
    fetchNotifications();
    setInterval(fetchNotifications,10000);

});
</script>
@endpush
