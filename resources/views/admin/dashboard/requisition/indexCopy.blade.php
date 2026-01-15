@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body">

    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="fw-bold">Requisition List</h2>
            <a href="{{ route('requisitions.create') }}" class="btn btn-primary">
                + Add Requisition
            </a>
        </div>

        {{-- Search + Filter --}}
        <div class="card mb-3">
            <div class="card-body">
                <form id="searchForm">
                    <div class="row g-3">

                        <div class="col-md-3">
                            <input type="text" name="keyword" id="keyword"
                                   class="form-control"
                                   placeholder="Search employee name...">
                        </div>

                        <div class="col-md-3">
                            <select name="status" id="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="0">Pending</option>
                                <option value="1">Approved</option>
                                <option value="2">Rejected</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">Search</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="card-body table-responsive">

                {{-- Preloader --}}
                <div id="loader" class="text-center py-5" style="display: none;">
                    <img src="/admin/loader.gif" width="60" alt="Loading">
                    <p class="mt-2 text-muted">Loading...</p>
                </div>

                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Vehicle</th>
                            <th>Travel Date</th>
                            <th>Return Date</th>
                            <th>Status</th>
                            <th>Approval</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="tableData">
                         @include('admin.dashboard.requisition.table')
                    </tbody>
                </table>

            </div>
        </div>

    </div>

</section>

<script>
    // Search with AJAX
    $('#searchForm').on('submit', function (e) {
        e.preventDefault();
        fetchData();
    });

    // Approve
    $(document).on('click', '.approveRequest', function () {
        updateStatus($(this).data('id'), 1);
    });

    // Reject
    $(document).on('click', '.rejectRequest', function () {
        updateStatus($(this).data('id'), 2);
    });

    // Delete
    $(document).on('click', '.deleteItem', function () {
        let id = $(this).data('id');
        if(confirm("Are you sure you want to delete this requisition?")) {
            $.ajax({
                url: route('requisitions.destroy')" + id,
                type: "DELETE",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    fetchData();
                }
            });
        }
    });

    // Fetch data
    function fetchData() {
        $('#loader').show();

        $.ajax({
            url: "{{ route('requisitions.index') }}",
            data: $('#searchForm').serialize(),
            success: function (data) {
                $('#tableData').html(data.html);
                $('#loader').hide();
            }
        });
    }

    
    // Update status
    function updateStatus(id, status) {
        $.ajax({
           url: "{{ route('requisitions.updateStatus', '') }}/" + id,
            type: "POST",
            data: {
                id: id,
                status: status,
                _token: "{{ csrf_token() }}"
            },
            success: function () {
                fetchData();
            }
        });
    }


</script>
@endsection
