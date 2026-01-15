@extends('admin.dashboard.master')

@section('main_content')
<style>
    .text-secondary {
        color: #0088cc !important;
        font-size: 15px;
        font-weight: 700;
    }
    .text-dark {
        color: #000!important;
        font-size: 16px;
        font-weight: 600;
    }
    .table th,td{
        font-size: 15px!important;
        font-weight: 500!important;
    }
    .card-body p{
        font-size: 16px!important;
        font-weight: 500!important;
        color: #fff!important;
        background-color: #0088cc!important;
        padding: 8px;
    }
    .card-header {
        color: #fff !important;
        font-size: 15px;
        font-weight: 700;
        padding: 8px!important;
        display: block!important;
    }
</style>

<section role="main" class="content-body" style="background-color:#eef2f7;">
<br>
<div class="container mt-4">

    <h3 class="mb-4 fw-bold">End Trip – {{ $trip->trip_number }}</h3>

    <div class="row">

        <!-- Trip Info panel -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-dark text-white">
                    Trip Information
                </div>
                <div class="card-body">
                    <p><strong>Vehicle:</strong> {{ $trip->vehicle->vehicle_name }}</p>
                    <p><strong>Driver:</strong> {{ $trip->driver->driver_name }}</p>
                    <p><strong>Start Date:</strong> {{ $trip->start_date }}</p>
                    <p><strong>Start Meter:</strong> {{ $trip->start_meter }}</p>
                </div>
            </div>
        </div>

        <!-- End Trip Form -->
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning fw-bold">
                    End Trip Form
                </div>
                <div class="card-body">

                    <form id="endTripForm">
                        @csrf

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Time</label>
                                <input type="time" name="end_time" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Closing Meter</label>
                                <input type="number" name="closing_meter" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Location</label>
                                <input type="text" name="end_location" class="form-control" required>
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Remarks (Optional)</label>
                                <textarea name="remarks" class="form-control" rows="3"></textarea>
                            </div>

                        </div>

                        <button type="button" onclick="submitEndTrip()" class="btn btn-warning px-4">
                            End Trip
                        </button>

                        <a href="{{ route('trip-sheets.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                    </form>

                </div>
            </div>
        </div>

    </div>
</div>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function submitEndTrip() {

    let end_date = document.querySelector("input[name='end_date']").value;
    let end_time = document.querySelector("input[name='end_time']").value;

    let closing_meter = document.querySelector("input[name='closing_meter']").value;
    let start_meter = @json($trip->start_meter);

     if (!end_date) {
        return Swal.fire({
            icon: 'warning',
            title: 'Missing End Date',
            text: "Please select the trip end date.",
        });
    }

    if (!end_time) {
        return Swal.fire({
            icon: 'warning',
            title: 'Missing End Time',
            text: "Please select the trip end time.",
        });
    }
    if (Number(closing_meter) < Number(start_meter)) {
        return Swal.fire({
            icon: 'warning',
            title: 'Invalid Meter Reading',
            text: "Closing meter cannot be less than starting meter!",
        });
    }

    Swal.fire({
        title: "Confirm Trip End?",
        text: "Are you sure you want to end this trip?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#0d6efd",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, End Trip"
    }).then((result) => {

        if (result.isConfirmed) {

            $.ajax({
                url: "{{ route('trip.end.save', $trip->id) }}",
                method: "POST",
                data: $("#endTripForm").serialize(),
                success: function(res) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Trip Completed!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        window.location.href = "{{ route('trip-sheets.index') }}";
                    }, 2000);
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed!',
                        text: xhr.responseJSON?.message || "Trip end failed!",
                    });
                }
            });

        }
    });
}
</script>

@endsection
