@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="bsackground-color: #fff;">
<div class="container">

    <h4 class="mb-3">Requisition Details</h4>

    <a href="{{ route('requisitions.index') }}" class="btn btn-secondary mb-3">Back</a>

    <div class="card shadow-sm p-4">
        <table class="table table-bordered">
            <tr>
                <th>Requisition ID</th>
                <td>{{ $requisition->id }}</td>
            </tr>

            <tr>
                <th>Employee</th>
                <td>{{ $requisition->requestedBy->name ?? '' }}</td>
            </tr>

            <tr>
                <th>Employee Code</th>
                <td>{{ $requisition->requestedBy->employee_code ?? '' }}</td>
            </tr>

            <tr>
                <th>Department</th>
                <td>{{ $requisition->requestedBy->department->department_name ?? '' }}</td>
            </tr>

            <tr>
                <th>Unit</th>
                <td>{{ $requisition->requestedBy->unit->unit_name ?? '' }}</td>
            </tr>

            <tr>
                <th>Vehicle</th>
                <td>{{ $requisition->vehicle->vehicle_name ?? 'Not Assigned' }}</td>
            </tr>

            <tr>
                <th>Driver</th>
                <td>{{ $requisition->driver->driver_name ?? 'Not Assigned' }}</td>
            </tr>

            <tr>
                <th>From</th>
                <td>{{ $requisition->from_location }}</td>
            </tr>

            <tr>
                <th>To</th>
                <td>{{ $requisition->to_location }}</td>
            </tr>

            <tr>
                <th>Travel Date</th>
                <td>{{ $requisition->travel_date }}</td>
            </tr>

            <tr>
                <th>Return Date</th>
                <td>{{ $requisition->return_date ?? 'N/A' }}</td>
            </tr>

            <tr>
                <th>Purpose</th>
                <td>{{ $requisition->purpose }}</td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-primary">{{ $requisition->status }}</span>
                </td>
            </tr>

            <tr>
                <th>Created At</th>
                <td>{{ $requisition->created_at }}</td>
            </tr>

        </table>
    </div>
<div class="card mb-3">
    <div class="card-header">Workflow Actions</div>
    <div class="card-body">
        <form action="{{ route('requisitions.workflow.update', $requisition->id) }}" method="POST">
            @csrf
            <label>Status</label>
            <select name="status" class="form-control mb-2">
                <option value="1" {{ $requisition->status == 1 ? 'selected' : '' }}>Requested</option>
                <option value="2" {{ $requisition->status == 2 ? 'selected' : '' }}>Transport Review</option>
                <option value="3" {{ $requisition->status == 3 ? 'selected' : '' }}>Approved</option>
                <option value="4" {{ $requisition->status == 4 ? 'selected' : '' }}>Rejected</option>
                <option value="5" {{ $requisition->status == 5 ? 'selected' : '' }}>Completed</option>
            </select>

            <textarea class="form-control mb-3" name="remarks" placeholder="Remarks (optional)"></textarea>

            <button type="submit" class="btn btn-primary">Update Workflow</button>
        </form>
    </div>
</div>

{{-- Workflow Log --}}
<div class="card">
    <div class="card-header">Workflow History</div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Old</th>
                    <th>New</th>
                    <th>By</th>
                    <th>Remarks</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requisition->workflowLogs as $log)
                <tr>
                    <td>{{ $log->old_status }}</td>
                    <td>{{ $log->new_status }}</td>
                    <td>{{ $log->user->name }}</td>
                    <td>{{ $log->remarks }}</td>
                    <td>{{ $log->created_at }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@php
  $steps = [
    1 => 'Requested',
    2 => 'Transport Review',
    3 => 'Approved',
    4 => 'Rejected',
    5 => 'Completed'
  ];
  $current = (int)$requisition->status;
@endphp

<div class="mb-4">
  <ul class="d-flex list-unstyled justify-content-between align-items-center p-0" style="gap:8px">
    @foreach($steps as $k => $label)
      @php
        $state = $k < $current ? 'completed' : ($k == $current ? 'active' : 'pending');
      @endphp
      <li class="text-center" style="flex:1">
        <div style="width:52px;height:52px;border-radius:50%;margin:0 auto;
            display:flex;align-items:center;justify-content:center;
            background: {{ $state=='completed' ? '#28a745' : ($state=='active' ? '#0d6efd' : '#e9ecef') }};
            color: {{ $state=='pending' ? '#6c757d' : '#fff' }};">
          @if($state=='completed') <i class="fa fa-check"></i> @else {{ $k }} @endif
        </div>
        <div class="mt-2" style="font-weight:600;color: #333">{{ $label }}</div>
      </li>
    @endforeach
  </ul>
</div>

<h4>Approval Timeline</h4>
<ul class="timeline">
    <li class="{{ $requisition->status=='Pending'?'active':'' }}">Employee Submitted</li>
    <li class="{{ $requisition->status=='Dept_Approved'?'active':'' }}">Department Head Approved</li>
    <li class="{{ $requisition->status=='Transport_Approved'?'active':'' }}">Transport Admin Approved</li>
    <li class="{{ $requisition->status=='GM_Approved'?'active':'' }}">GM Approved</li>
    <li class="{{ $requisition->status=='Completed'?'active':'' }}">Completed</li>
</ul>

</div>


<div class="card mt-4">
    <div class="card-header bg-dark text-white">
        <strong>Approval Timeline</strong>
    </div>

    <div class="card-body">
        @if($requisition->logs->count() == 0)
            <p class="text-muted">No actions recorded.</p>
        @else
            <ul class="timeline">
                @foreach($requisition->logs as $log)
                <li class="mb-3">
                    <strong>{{ $log->action }}</strong>  
                    <br>
                    <small>
                        {{ $log->created_at->format('d M Y - h:i A') }}  
                        by {{ $log->user->name ?? 'System' }}
                    </small>

                    @if($log->note)
                        <div class="mt-1 p-2 bg-light border rounded">
                            {{ $log->note }}
                        </div>
                    @endif
                </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

<style>

    .timeline li.active {
    font-weight: bold;
    color: green;
}

.timeline {
    list-style: none;
    padding-left: 0;
}
.timeline li {
    border-left: 3px solid #0d6efd;
    padding-left: 15px;
    position: relative;
}
.timeline li::before {
    content: "";
    width: 10px;
    height: 10px;
    background: #0d6efd;
    border-radius: 50%;
    position: absolute;
    left: -6px;
    top: 5px;
}
</style>

</section>
@endsection
