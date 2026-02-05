@extends('admin.dashboard.master')

@section('main_content')


<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<style>
  .form-error { color: #e74a3b; font-size: 1.2rem; margin-top: .25rem; }
  .is-invalid { border-color: #e74a3b; }
  .modal-backdrop { background-color: rgba(0, 0, 0, 0.5); opacity: 1; }
  .modal-content { border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12); }
</style>


<section role="main" class="content-body" style="background-color: #f8f9fc;">
    <div class="container mt-5">
        <h3 class="fw-bold text-primary mb-4"><i class="fa fa-building me-2"></i> Maintenance Vendors</h3>

        {{-- Add / Edit Form --}}
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form id="vendorForm">
                    @csrf
                    <input type="hidden" name="vendor_id" id="vendor_id">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Vendor Name</label>
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
                            <th>Vendor Name</th>
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
                                    <i class="fa fa-minus"></i>
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

<script src="{{ asset('public/admin_resource/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
$(document).ready(function(){

    // ---------- Clear field errors ----------
    function clearErrors(){
        $('.form-error').remove();
        $('.form-control').removeClass('is-invalid');
    }

    // ---------- Reset form ----------
    $('#resetBtn').click(function(){
        $('#vendorForm')[0].reset();
        $('#vendor_id').val('');
        clearErrors();
    });

    // ---------- Create / Update ----------
    $('#vendorForm').on('submit', function(e){
        e.preventDefault();
        clearErrors();

        let vendor_id = $('#vendor_id').val();
        let url = vendor_id
            ? `{{ route('maintenance.vendors.update', ':vendor_id') }}`.replace(':vendor_id', vendor_id)
            : `{{ route('maintenance.vendors.store') }}`;

        $('#submitBtn').html('<i class="fa fa-spinner fa-spin me-2"></i> Saving...')
                       .prop('disabled', true);

        $.ajax({
            url: url,
            type: "POST",
            data: $('#vendorForm').serialize(),
            success: function(res){
                // SweetAlert2 toast for success
                Swal.fire({
                    icon: 'success',
                    title: vendor_id ? 'Vendor updated successfully!' : 'Vendor added successfully!',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    background: '#f8f9fc',
                    color: '#1e1e2f'
                });

                if(vendor_id){
                    let row = $(`#row-${vendor_id}`);
                    row.replaceWith(`
                        <tr id="row-${res.vendor.id}">
                            <td>${row.find('td:first').text()}</td>
                            <td>${res.vendor.name}</td>
                            <td>${res.vendor.contact_person || ''}</td>
                            <td>${res.vendor.email || ''}</td>
                            <td>${res.vendor.phone || ''}</td>
                            <td>${res.vendor.address || ''}</td>
                            <td>
                                <button class="btn btn-sm btn-info editBtn" data-id="${res.vendor.id}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${res.vendor.id}">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                } else {
                    let index = $('#vendorsTable tbody tr').length + 1;
                    $('#vendorsTable tbody').append(`
                        <tr id="row-${res.vendor.id}">
                            <td>${index}</td>
                            <td>${res.vendor.name}</td>
                            <td>${res.vendor.contact_person || ''}</td>
                            <td>${res.vendor.email || ''}</td>
                            <td>${res.vendor.phone || ''}</td>
                            <td>${res.vendor.address || ''}</td>
                            <td>
                                <button class="btn btn-sm btn-info editBtn" data-id="${res.vendor.id}">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger deleteBtn" data-id="${res.vendor.id}">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                }

                $('#vendorForm')[0].reset();
                $('#vendor_id').val('');
            },
            error: function(xhr){
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages){
                        let input = $(`[name="${field}"]`);
                        input.addClass('is-invalid');
                        input.after(`<div class="form-error">${messages[0]}</div>`);
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: xhr.responseJSON?.message || 'Something went wrong',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                }
            },
            complete: function(){
                $('#submitBtn').html('<i class="fa fa-save me-2"></i> Save')
                               .prop('disabled', false);
            }
        });
    });

    // ---------- Edit ----------
    $(document).on('click', '.editBtn', function(){
        clearErrors();
        let id = $(this).data('id');

        $.get(`{{ route('maintenance.vendors.edit', ':vendor') }}`.replace(':vendor', id), function(data){
            $('#vendor_id').val(data.id);
            $('#vendor_name').val(data.vendor_name);
            $('#contact_person').val(data.contact_person);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#address').val(data.address);
        });
    });

    // ---------- Delete ----------
    $(document).on('click', '.deleteBtn', function(){
        let id = $(this).data('id');

        Swal.fire({
            icon: 'warning',
            title: 'Are you sure?',
            text: "This vendor will be removed permanently!",
            showCancelButton: true,
            confirmButtonText: 'Delete',
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    url: `{{ route('maintenance.vendors.destroy', ':vendor') }}`.replace(':vendor', id),
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(res){
                        Swal.fire({
                            icon: 'success',
                            title: res.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2500,
                            timerProgressBar: true
                        });
                        $(`#row-${id}`).fadeOut(() => $(this).remove());
                    }
                });
            }
        });
    });

});
</script>
@endsection
