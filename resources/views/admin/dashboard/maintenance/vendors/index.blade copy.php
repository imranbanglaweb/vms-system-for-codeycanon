@extends('admin.dashboard.master')

@section('main_content')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
  .card-premium {
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
  }
  .form-label-premium { font-weight: 600; color: #495057; }
  .form-control-premium {
    border-radius: 8px;
    padding: .75rem 1rem;
    font-size: 1.5rem;
  }
  .form-error { color: #e74a3b; font-size: 1.575rem; margin-top: .25rem; display: none; }

  .btn-primary-premium, .btn-info-premium, .btn-danger-premium, .btn-secondary-premium {
    border-radius: 8px;
    padding: .5rem 1rem;
    font-size: 1.5rem;
  }
  .btn-primary-premium { background: #4e73df; color: #fff; border: none; }
  .btn-primary-premium:hover { background: #3b5bbf; }
  .btn-info-premium { background: #36b9cc; color: #fff; border: none; }
  .btn-info-premium:hover { background: #2c97a3; }
  .btn-danger-premium { background: #e74a3b; color: #fff; border: none; }
  .btn-danger-premium:hover { background: #c43c2f; }
  .btn-secondary-premium { background: #858796; color: #fff; border: none; }
  .btn-secondary-premium:hover { background: #6c757d; }

  table.table-premium th, table.table-premium td {
    vertical-align: middle;
  }
</style>
@endpush
<section role="main" class="content-body">
<div class="container mt-5">
    <h3 class="fw-bold text-primary mb-4"><i class="fa fa-building me-2"></i> Maintenance Vendors</h3>

    <div id="notification"></div>

    {{-- Add / Edit Form --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form id="vendorForm">
                @csrf
                <input type="hidden" name="vendor_id" id="vendor_id">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" class="form-control" name="vendor_name" id="vendor_name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Contact Person</label>
                        <input type="text" class="form-control" name="contact_person" id="contact_person">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" name="email" id="email">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" class="form-control" name="phone" id="phone">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Address</label>
                        <textarea class="form-control" name="address" id="address" rows="2"></textarea>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fa fa-save me-2"></i> Save
                    </button>
                    <button type="button" class="btn btn-secondary" id="resetBtn">
                        <i class="fa fa-undo me-2"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Vendors Table --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover" id="vendorsTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Contact Person</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vendors as $vendor)
                    <tr id="row-{{ $vendor->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->contact_person }}</td>
                        <td>{{ $vendor->email }}</td>
                        <td>{{ $vendor->phone }}</td>
                        <td>{{ $vendor->address }}</td>
                        <td>
                            <button class="btn btn-sm btn-info editBtn" data-id="{{ $vendor->id }}">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $vendor->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function(){
    // ---------- AJAX Submit
    $('#vendorForm').on('submit', function(e){
        e.preventDefault();
        let vendor_id = $('#vendor_id').val();
        let url = vendor_id ? `{{ url('maintenance-vendors/update') }}/${vendor_id}` : `{{ route('maintenance.vendors.store') }}`;
        $('#submitBtn').html('<i class="fa fa-spinner fa-spin me-2"></i> Saving...').prop('disabled', true);

        $.ajax({
            url: url,
            type: 'POST',
            data: $('#vendorForm').serialize(),
            success: function(res){
                showNotification('success', res.message);
                setTimeout(()=>location.reload(), 1200);
            },
            error: function(xhr){
                let msg = xhr.responseJSON?.message || 'Validation failed';
                showNotification('danger', msg);
            },
            complete: function(){ $('#submitBtn').html('<i class="fa fa-save me-2"></i> Save').prop('disabled', false); }
        });
    });

    // ---------- Reset Form
    $('#resetBtn').click(function(){
        $('#vendorForm')[0].reset();
        $('#vendor_id').val('');
    });

    // ---------- Edit
    $('.editBtn').click(function(){
        let id = $(this).data('id');
        $.get(`{{ url('maintenance-vendors/edit') }}/${id}`, function(data){
            $('#vendor_id').val(data.id);
            $('#name').val(data.name);
            $('#contact_person').val(data.contact_person);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#address').val(data.address);
        });
    });

    // ---------- Delete
    $('.deleteBtn').click(function(){
        if(!confirm('Are you sure to delete this vendor?')) return;
        let id = $(this).data('id');
        $.ajax({
            url: `{{ url('maintenance-vendors/delete') }}/${id}`,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(res){
                showNotification('success', res.message);
                $(`#row-${id}`).fadeOut();
            }
        });
    });

    // ---------- Notification
    function showNotification(type, message){
        const html = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                      </div>`;
        $('#notification').html(html);
        setTimeout(()=>$('.alert').alert('close'), 4000);
    }
});
</script>
@endpush
@endsection
