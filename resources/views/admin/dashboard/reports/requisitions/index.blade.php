@extends('admin.dashboard.master')

@section('main_content')
<br>
<section role="main" class="content-body" style="background:#fff">
<div class="container-fluid py-3">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">Requisition Reports</h4>
        <br>
        <div>
            <a href="{{ route('reports.requisitions.excel') }}" class="btn btn-success btn-sm">
                <i class="fa fa-file"></i> Excel
            </a>
            <a href="{{ route('reports.requisitions.pdf') }}" class="btn btn-danger btn-sm">
                <i class="fa fa-star"></i> PDF
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form id="filterForm" class="row g-2 align-items-end">

                <div class="col-md-2">
                    <label class="form-label">Department</label>
                    <select name="department_id" class="form-select">
                        <option value="">All</option>
                        @foreach($departments as $d)
                            <option value="{{ $d->id }}">{{ $d->department_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Unit</label>
                    <select name="unit_id" class="form-select">
                        <option value="">All Units</option>
                        @foreach($units as $u)
                            <option value="{{ $u->id }}">{{ $u->unit_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">From</label>
                    <input type="date" name="from_date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">To</label>
                    <input type="date" name="to_date" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Search</label>
                    <input type="text" name="keyword" class="form-control"
                           placeholder="Req No / Item / User">
                </div>

                <div class="col-md-12 text-end mt-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-filter"></i> Apply
                    </button>
                    <button type="button" id="resetBtn" class="btn btn-info btn-sm">
                        <i class="fa fa-refresh"></i>  Reset
                    </button>
                </div>

            </form> 
            

        </div>
    </div>

    <!-- Table -->
    <div class="card shadow-sm">
        <div class="card-body position-relative">

            <!-- Loader -->
            <div id="loading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
            </div>

            <div id="reportTable">
                @include('admin.dashboard.reports.requisitions.table')
            </div>

        </div>
    </div>

</div>
</section>
@endsection

@push('scripts')
<script>
$(function () {

    function fetchData(page = 1) {
        $('#loading').removeClass('d-none');

        $.ajax({
            url: "{{ route('reports.requisitions') }}",
            type: "GET",
            data: $('#filterForm').serialize() + '&page=' + page,
            success: function (res) {
                $('#reportTable').html(res);
                $('#loading').addClass('d-none');
            }
        });
    }

    // Submit filter
    $('#filterForm').on('submit', function (e) {
        e.preventDefault();
        fetchData();
    });

    // Live search (debounce)
    let timer;
    $('input[name="keyword"]').on('keyup', function () {
        clearTimeout(timer);
        timer = setTimeout(() => fetchData(), 500);
    });

    // Reset
    $('#resetBtn').on('click', function () {
        $('#filterForm')[0].reset();
        fetchData();
    });

    // Pagination
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        fetchData(page);
    });

});
</script>
@endpush
