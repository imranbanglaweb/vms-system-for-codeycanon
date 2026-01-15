@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background:#fff">
<div class="container-fluid">
<br>

<div class="d-flex justify-content-between mb-3">
    <h4 class="fw-bold">Trip & Fuel Consumption Report</h4>

    @if(auth()->user()->hasRole(['Super Admin','Admin']))
    <div>
        <a href="{{ route('reports.trips_fuel.excel') }}" class="btn btn-success btn-sm">Excel</a>
        <a href="{{ route('reports.trips_fuel.pdf') }}" class="btn btn-danger btn-sm">PDF</a>
    </div>
    @endif
</div>

<div class="card shadow-sm mb-3">
<div class="card-body">
<form id="filterForm" class="row g-3">

    <div class="col-md-3">
        <select name="vehicle_id" class="form-select">
            <option value="">All Vehicles</option>
            @foreach($vehicles as $v)
                <option value="{{ $v->id }}">{{ $v->vehicle_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select name="driver_id" class="form-select">
            <option value="">All Drivers</option>
            @foreach($drivers as $d)
                <option value="{{ $d->id }}">{{ $d->driver_name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-2">
        <input type="date" name="from_date" class="form-control">
    </div>

    <div class="col-md-2">
        <input type="date" name="to_date" class="form-control">
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">Search</button>
    </div>

</form>
</div>
</div>

<div class="card shadow-sm">
<div class="card-body" id="reportTable">
    @include('admin.dashboard.reports.trips_fuel.table')
</div>
</div>

</div>
</section>
@endsection

@push('scripts')
<script>
$('#filterForm').on('submit', function(e){
    e.preventDefault();
    $.get("{{ route('reports.trips_fuel.ajax') }}", $(this).serialize(), function(data){
        $('#reportTable').html(data);
    });
});
</script>
@endpush
