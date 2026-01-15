@extends('admin.dashboard.master')


@section('main_content')
<section role="main" class="content-body" style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
  <div class="row">
      <div class="col-lg-12 margin-tb">
          <div class="pull-left">
              <h2>Edit Employee</h2>
          </div>
          <div class="pull-right">
              <a class="btn btn-primary" href="{{ route('employees.index') }}"> Back</a>
          </div>
      </div>
  </div>

  @if (count($errors) > 0)
      <div class="alert alert-danger">
          <strong>Whoops!</strong> There were some problems with your input.<br><br>
          <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
          </ul>
      </div>
  @endif

    {!! Form::model($employee_edit, ['route' => ['employees.update', $employee_edit->id], 'method' => 'PUT', 'enctype'=>'multipart/form-data', 'id'=>'employee_edit']) !!}
    @include('admin.dashboard.employee._form')
    {!! Form::close() !!}

  <!-- Scripts are initialized in master layout; push page-specific scripts to the scripts stack -->
  @push('scripts')
  <script>
  (function(){
      // Initialize Select2 for selects inside this form only (master init may have run earlier)
      var $form = $('#employee_edit');
      if ($.fn.select2) {
          $form.find('.select2').each(function(){
              var $s = $(this);
              // avoid double-init
              if (!$s.data('select2')) {
                  try { $s.select2({ width: '100%' }); } catch(e) { console.warn('select2 init failed', e); }
              }
          });
      }

      // handler for unit change — populate department select scoped to this form
      $form.on('change', '[name="unit_id"]', function () {
          var unit_id = $(this).val();
          var $dept = $form.find('[name="department_id"]');

          if (!unit_id) {
              // clear departments
              if ($dept.data('select2')) { try { $dept.select2('destroy'); } catch(e){} }
              $dept.html('<option value="">Please select</option>');
              if ($.fn.select2) try { $dept.select2({ width: '100%' }); } catch(e){}
              return;
          }

          $.get("{{ route('unit-wise-department') }}", { unit_id: unit_id }, function(data){
              console.log('unit-wise-department (employee.edit) response:', data);
              if ($dept.data('select2')) { try { $dept.select2('destroy'); } catch(e){ console.warn(e); } }
              var prev = $dept.val();
              $dept.empty().append('<option value="">Please select</option>');
              $.each(data.department_list || [], function(i, d){
                  $dept.append('<option value="'+ d.id +'">'+ d.department_name +'</option>');
              });
              if (prev) { $dept.val(prev); }
              if ($.fn.select2) try { $dept.select2({ width: '100%' }); } catch(e){ console.warn(e); }
              $dept.trigger('change');
          }).fail(function(xhr){ console.error('unit-wise-department failed', xhr); });
      });

      // photo preview
      $form.on('change', '#photo-input', function(e){
          const [file] = this.files;
          if (file) {
              const url = URL.createObjectURL(file);
              $('#photo-preview').attr('src', url);
          }
      });

      // AJAX submit for edit form (mirrors create behavior)
      $form.on('submit', function(e){
          e.preventDefault();

          // clear previous validation states
          $form.find('.is-invalid').removeClass('is-invalid');
          $form.find('.invalid-feedback').addClass('d-none').text('');

          // ensure CKEditor instances update their textarea elements
          if (window._richEditors && window._richEditors.length) {
              window._richEditors.forEach(function(id){
                  if (CKEDITOR.instances[id]) {
                      CKEDITOR.instances[id].updateElement();
                  }
              });
          }

          var formData = new FormData(this);

          $.ajax({
              url: $form.attr('action'),
              type: 'POST',
              data: formData,
              contentType: false,
              processData: false,
              success: function(response){
                  Swal.fire({
                      title: 'Employee Updated',
                      html: '<span class="text-success">Information updated successfully.</span>',
                      icon: 'success',
                      timer: 1600,
                      showConfirmButton: false,
                  }).then(function(){ window.location.href = '{{ route("employees.index") }}'; });
              },
              error: function(xhr){
                  if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                      const errors = xhr.responseJSON.errors;
                      const firstKey = Object.keys(errors)[0];
                      Swal.fire({title: 'Validation error', text: errors[firstKey][0], icon: 'error'});

                      Object.keys(errors).forEach(function(field){
                          const messages = errors[field];
                          // try to find matching input/select/textarea within this form
                          const $el = $form.find('[name="'+field+'"]');
                          if ($el.length) {
                              $el.addClass('is-invalid');
                              const $fb = $form.find('.invalid-feedback[data-field="'+field+'"]');
                              if ($fb.length) {
                                  $fb.removeClass('d-none').text(messages[0]);
                              } else {
                                  $el.after('<div class="invalid-feedback d-block">'+messages[0]+'</div>');
                              }
                          }
                      });
                  } else {
                      Swal.fire({title: 'Error', text: 'An unexpected error occurred.', icon: 'error'});
                  }
              }
          });
      });
  })();
  </script>
  @endpush

@endsection