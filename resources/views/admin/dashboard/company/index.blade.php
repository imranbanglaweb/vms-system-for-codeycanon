@extends('admin.dashboard.master')

@section('main_content')

<style>
  .modal-modern .modal-content {
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.12);
  }
  .invalid-feedback i { margin-right:6px; color:#c0392b; }
  .action-btns .btn { margin-right: 4px; }
  #companies-table thead th { font-weight:600; }

  .modal-body label {
    font-size: 15px;
}

.modal-content {
    border-radius: 14px;
    overflow: hidden;
}

.btn-light {
    background: #f8f9fa;
    transition: 0.3s;
}

.btn-light:hover {
    background: #e2e6ea;
}

#companyForm input {
    height: 45px;
    font-size: 15px;
}
.close {
    background-color:#f6f6f6;
    border: none;
    font-size: 24px;
    line-height: 1;
    color: #000;
    opacity: 0.5;
    transition: opacity 0.2s;
}

</style>

<section role="main" class="content-body" style="background:#ffffff; padding:20px; border-radius:8px;">

    @can('unit-create')
      <button id="openCreateModal" class="btn btn-success">
          <i class="fa fa-plus"></i> Create Company
      </button>
    @endcan

  <div class="row mb-2">
      <div class="col-lg-12 d-flex justify-content-between align-items-center">
          <h2>Company Manage</h2>
      </div>
  </div>

  <div class="card">
      <div class="card-body">
          <table class="table table-striped table-hover" id="companies-table" width="100%">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>Company Name</th>
                      <th>Company Code</th>
                      <th>Action</th>
                  </tr>
              </thead>
              <tbody></tbody>
          </table>
      </div>
  </div>

</section>

{{-- Create/Edit Modal --}}

<div id="companyModal" class="modal modal-modern" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

          <div class="modal-header">
              <h5 class="modal-title" id="companyModalTitle">Create Company</h5>
              <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>

          <form id="companyForm">
        <div class="modal-body px-4">

            <div id="formAlert" class="alert alert-danger d-none"></div>

            <input type="hidden" name="id" id="company_id">

            <div class="form-group mb-4">
                <label class="font-weight-bold">Company Name <span class="text-danger">*</span></label>
                <input type="text" id="company_name" name="company_name" class="form-control form-control-lg" placeholder="Enter company name">
                <div class="invalid-feedback" id="err_company_name"></div>
            </div>

            <div class="form-group mb-4">
                <label class="font-weight-bold">Company Code <span class="text-danger">*</span></label>
                <input type="text" id="company_code" name="company_code" class="form-control form-control-lg" placeholder="Enter company code">
                <div class="invalid-feedback" id="err_company_code"></div>
            </div>

        </div>

        <div class="modal-footer d-flex justify-content-between align-items-center px-4">

            <button type="submit" id="saveCompanyBtn" class="btn btn-primary rounded-pill px-4 py-2">
                <i class="fa fa-save mr-1"></i> Save
            </button>

        </div>
    </form>


      </div>

  </div>
</div>

@endsection

@push('styles')

<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('public/admin_resource/plugins/sweetalert2/sweetalert2.min.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<style>
    .table th, .table td {
        vertical-align: middle !important;
        font-size: 15px;
    }
</style>
@endpush

@push('scripts')

<script>
$(function(){

  $.ajaxSetup({
     headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
         'X-Requested-With': 'XMLHttpRequest'
     }
  });

  $('.modal .close').on('click', function () {
    $(this).closest('.modal').modal('hide');
  });

  // =============================
  //   DATATABLE SERVER-SIDE
  // =============================
  var table = $('#companies-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('admin.company.data') }}",
      columns: [
          { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
          { data: 'company_name', name: 'company_name' },
          { data: 'company_code', name: 'company_code' },
          { data: 'action', name: 'action', orderable:false, searchable:false }
      ],
      order: [[1,'asc']],
      responsive: true,
      pageLength: 10
  });

  $('#refresh-table').on('click', () => table.ajax.reload(null,false));

  // =============================
  //   OPEN CREATE MODAL
  // =============================
  $('#openCreateModal').on('click', function(){
      clearForm();
      $('#companyModalTitle').text('Create Company');
      $('#companyModal').modal('show');
  });

  // =============================
  //   OPEN EDIT MODAL
  // =============================
  $(document).on('click', '.editCompany', function(){
      clearForm();

      $('#company_id').val($(this).data('id'));
      $('#company_name').val($(this).data('name'));
      $('#company_code').val($(this).data('code'));

      $('#companyModalTitle').text('Edit Company');
      $('#companyModal').modal('show');
  });

  // =============================
  //   SAVE (CREATE/UPDATE)
  // =============================
  $('#companyForm').on('submit', function(e){
      e.preventDefault();
      clearErrors();

      var formData = {
          id: $('#company_id').val(),
          company_name: $('#company_name').val(),
          company_code: $('#company_code').val()
      };

      $('#saveCompanyBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving');

      $.ajax({
          url: "{{ route('company.store') }}",
          type: "POST",
          data: formData,
          success: function(res){
              $('#companyModal').modal('hide');
              $('#saveCompanyBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Save');

              Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: 'Company saved successfully',
                  timer: 1800,
                  showConfirmButton: false
              });

              table.ajax.reload(null,false);
          },
          error: function(xhr){
              $('#saveCompanyBtn').prop('disabled', false).html('<i class="fa fa-save"></i> Save');

              if(xhr.status === 422){
                  let errors = xhr.responseJSON.errors;
                  $.each(errors, function(key,value){
                      $('#err_'+key).html('<i class="fa fa-times-circle"></i> '+value).show();
                      $('#'+key).addClass('is-invalid');
                  });
              } else {
                  Swal.fire('Error','Something went wrong','error');
              }
          }
      });

  });

  // =============================
  //   DELETE (SWEETALERT)
  // =============================
  $(document).on('click','.deleteCompany', function(){
      let id = $(this).data('id');
      let url = "{{ url('company') }}/" + id;

      Swal.fire({
          title: 'Are you sure?',
          text: 'This company will be permanently deleted!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Yes, delete it!'
      }).then((result)=>{
          if(result.isConfirmed){
              $.ajax({
                  url: url,
                  type: "DELETE",
                  success: function(res){
                      Swal.fire({
                          icon: 'success',
                          title: 'Deleted!',
                          text: res.message || 'Company deleted successfully',
                          timer: 1800,
                          showConfirmButton: false
                      });

                      table.ajax.reload(null,false);
                  },
                  error: function(){
                      Swal.fire('Error','Delete failed','error');
                  }
              });
          }
      });
  });

  // =============================
  //   HELPERS
  // =============================
  function clearForm(){
      $('#companyForm')[0].reset();
      $('#company_id').val('');
      clearErrors();
      $('#formAlert').hide().empty();
  }

  function clearErrors(){
      $('.invalid-feedback').hide().empty();
      $('.form-control').removeClass('is-invalid');
  }

});
</script>

@endpush
