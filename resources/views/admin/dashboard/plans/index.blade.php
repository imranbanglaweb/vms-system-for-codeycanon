@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background-color: #fff;">
<div class="container-fluid">

<h4 class="fw-bold mb-3">Subscription Plans</h4>

<a href="{{ route('admin.plans.create') }}" class="btn btn-primary mb-3">
    + Add New Plan
</a>

<table class="table table-bordered table-hover align-middle">
<thead class="table-light">
<tr>
    <th>Name</th>
    <th>Price</th>
    <th>Vehicles</th>
    <th>Users</th>
    <th>Popular</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
@foreach($plans as $plan)
<tr>
    <td>{{ $plan->name }}</td>
    <td>৳{{ number_format($plan->price) }}</td>
    <td>{{ $plan->vehicle_limit ?? '∞' }}</td>
    <td>{{ $plan->user_limit ?? '∞' }}</td>
    <td>
        @if($plan->is_popular)
            <span class="badge bg-success">Yes</span>
        @endif
    </td>
    <td>
        <span class="badge {{ $plan->is_active ? 'bg-primary':'bg-secondary' }}">
            {{ $plan->is_active ? 'Active':'Inactive' }}
        </span>
    </td>
    <td>
        <a href="{{ route('admin.plans.edit',$plan) }}" class="btn btn-sm btn-warning">Edit</a>
    </td>
</tr>
@endforeach
</tbody>
</table>

</div>
</section>
@endsection
