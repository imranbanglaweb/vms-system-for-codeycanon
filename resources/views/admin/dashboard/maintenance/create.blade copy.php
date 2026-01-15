@extends('admin.dashboard.master')

@section('main_content')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">

<style>
  .preloader-overlay {
    position: fixed;
    inset: 0;
    background: rgba(255,255,255,0.85);
    z-index: 9999;
    display: none;
    justify-content: center;
    align-items: center;
  }
  .loader-circle {
    width: 60px;
    height: 60px;
    border: 6px solid #ddd;
    border-top-color: #4e73df;
    border-radius: 50%;
    animation: spin 1s linear infinite;
  }
  @keyframes spin { to { transform: rotate(360deg); } }

  .card-premium {
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
  }
  .form-label-premium {
    font-weight: 600;
    color: #495057;
  }
  .form-control-premium {
    border-radius: 8px;
    padding: .75rem 1rem;
    font-size: 1rem;
  }
  .btn-primary-premium {
    background: #4e73df;
    border: none;
    border-radius: 8px;
    padding: .75rem 1.5rem;
    font-size: 1.05rem;
  }
  .btn-primary-premium:hover { background: #3b5bbf; }
  .btn-secondary-premium {
    border-radius: 8px;
    padding: .75rem 1.5rem;
    font-size: 1.05rem;
  }
  .form-group-icon { position: relative; }
  .form-group-icon i {
    position: absolute;
    top: 50%;
    left: 1rem;
    transform: translateY(-50%);
    color: #6c757d;
  }
  .form-group-icon .form-control-premium { padding-left: 3rem; }
</style>
@endpush

<section role="main" class="content-body">
  <div class="preloader-overlay" id="preloader">
    <div class="loader-circle"></div>
  </div>

  <div class="container py-5">
    <h2 class="mb-4 text-primary"><i class="fa fa-tools me-2"></i> Add Maintenance Record</h2>

    <div class="card card-premium mb-5">
      <div class="card-body p-5">

        <form id="maintenanceForm" enctype="multipart/form-data">
          @csrf
          <div class="row g-4">

            {{-- Schedule --}}
            <div class="col-md-3">
              <label class="form-label-premium">Schedule</label>
              <select class="form-select form-control-premium select2" name="schedule_id" required>
                @foreach($schedules as $s)
                  <option value="{{ $s->id }}">{{ $s->title }} — {{ $s->date }}</option>
                @endforeach
              </select>
            </div>

            {{-- Vehicle --}}
            <div class="col-md-3">
              <label class="form-label-premium">Vehicle</label>
              <select class="form-select form-control-premium select2" name="vehicle_id" required>
                @foreach($vehicles as $v)
                  <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
              </select>
            </div>

            {{-- Maintenance Type --}}
            <div class="col-md-3">
              <label class="form-label-premium">Maintenance Type</label>
              <select class="form-select form-control-premium select2" name="maintenance_type_id" required>
                @foreach($types as $t)
                  <option value="{{ $t->id }}">{{ $t->name }}</option>
                @endforeach
              </select>
            </div>

            {{-- Vendor --}}
            <div class="col-md-3">
              <label class="form-label-premium">Vendor (Optional)</label>
              <select class="form-select form-control-premium select2" name="vendor_id">
                <option value="">Select Vendor</option>
                @foreach($vendors as $v)
                  <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endforeach
              </select>
            </div>

            {{-- Performed At --}}
            <div class="col-md-4">
              <label class="form-label-premium">Performed At</label>
              <div class="form-group-icon">
                <i class="fa fa-calendar-day"></i>
                <input type="text" class="form-control form-control-premium datepicker" name="performed_at" placeholder="YYYY-MM-DD" required>
              </div>
            </div>

            {{-- Start KM --}}
            <div class="col-md-4">
              <label class="form-label-premium">Start KM</label>
              <div class="form-group-icon">
                <i class="fa fa-tachometer-alt"></i>
                <input type="number" class="form-control form-control-premium" name="start_km" required>
              </div>
            </div>

            {{-- End KM --}}
            <div class="col-md-4">
              <label class="form-label-premium">End KM</label>
              <div class="form-group-icon">
                <i class="fa fa-tachometer-alt"></i>
                <input type="number" class="form-control form-control-premium" name="end_km" required>
              </div>
            </div>

            {{-- Cost --}}
            <div class="col-md-4">
              <label class="form-label-premium">Cost (BDT)</label>
              <div class="form-group-icon">
                <i class="fa fa-money-bill-wave"></i>
                <input type="number" step="0.01" class="form-control form-control-premium" name="cost" required>
              </div>
            </div>

            {{-- Notes --}}
            <div class="col-md-4">
              <label class="form-label-premium">Notes</label>
              <textarea class="form-control form-control-premium" name="notes" rows="3"></textarea>
            </div>

            {{-- Receipt --}}
            <div class="col-md-6">
              <label class="form-label-premium">Upload Receipt (Optional)</label>
              <input type="file" class="form-control form-control-premium" name="receipt_path">
            </div>

          </div>

          <div class="mt-5 d-flex gap-3">
            <button type="button" onclick="submitMaintenance()" class="btn btn-primary-premium">
              <i class="fa fa-save me-2"></i> Save Maintenance
            </button>
            <a href="{{ route('maintenance.index') }}" class="btn btn-secondary-premium">
              <i class="fa fa-arrow-left me-2"></i> Cancel
            </a>
          </div>

        </form>

      </div>
    </div>
  </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.10.0/dist/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
  $('.select2').select2({ width: '100%' });
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    todayHighlight: true
  });
});

function submitMaintenance() {
  const required = ['schedule_id','vehicle_id','maintenance_type_id','performed_at','start_km','end_km','cost'];
  for (const f of required) {
    if (!$(`[name="${f}"]`).val()) {
      Swal.fire({
        icon: 'warning',
        title: 'Missing Input',
        text: 'Please fill all required fields.',
      });
      return;
    }
  }

  $('#preloader').show();
  let fd = new FormData($('#maintenanceForm')[0]);

  $.ajax({
    url: "{{ route('maintenance.store') }}",
    method: 'POST',
    data: fd,
    contentType: false,
    processData: false,
    success: function(res) {
      $('#preloader').hide();
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: res.message || 'Record saved successfully.',
        timer: 1600,
        showConfirmButton: false
      }).then(() => window.location.href = "{{ route('maintenance.index') }}");
    },
    error: function(xhr) {
      $('#preloader').hide();
      let err = 'Something went wrong.';
      if (xhr.responseJSON && xhr.responseJSON.message) {
        err = xhr.responseJSON.message;
      }
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: err
      });
    }
  });
}
</script>
@endpush

@endsection
