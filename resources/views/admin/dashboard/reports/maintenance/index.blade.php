@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background:#fff">
<div class="container-fluid">
<br>

<div class="d-flex justify-content-between mb-3">
    <h3 class="fw-bold">Vehicle Maintenance Report</h3>
    <br>
    @if(auth()->user()->hasRole(['Super Admin','Admin']))
    <div>
        <a href="{{ route('reports.maintenance.excel') }}" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Excel</a>
        <a href="{{ route('reports.maintenance.pdf') }}" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> PDF</a>
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
        <select name="type_id" class="form-select">
            <option value="">All Maintenance Types</option>
            @foreach($types as $t)
                <option value="{{ $t->id }}">{{ $t->name }}</option>
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
    @include('admin.dashboard.reports.maintenance.table')
</div>
</div>

</div>
</section>

@endsection

@push('scripts')
<script>
$(document).ready(function(){
    loadData();

    $('#filterForm').on('submit', function(e){
        e.preventDefault();
        loadData();
    });

    function loadData(){
        $.get("{{ route('reports.maintenance.ajax') }}", $('#filterForm').serialize(), function(data){
            $('#reportTable').html(data);
        });
    }
});
</script>

@endpush
