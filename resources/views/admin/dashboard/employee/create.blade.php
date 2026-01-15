@extends('admin.dashboard.master')


@section('main_content')
<section role="" class="content-body" style="background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add Employee</h2>
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


<!-- Include the professional form partial -->
<section class="panel">
    <header class="panel-heading d-flex align-items-center justify-content-between">
        <div>
            <h2 class="panel-title"><i class="fa fa-user-plus mr-2"></i> Add Employee</h2>
            <p class="text-muted">Fill in employee details. Required fields are validated via AJAX.</p>
        </div>
        <div>
            <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left"></i> Back to list</a>
        </div>
    </header>

    <div class="panel-body">
        {!! Form::open(['route' => ['employees.store'], 'method' => 'POST', 'enctype' => 'multipart/form-data', 'id' => 'employee_add']) !!}
        @include('admin.dashboard.employee._form')
        {!! Form::close() !!}
    </div>
</section>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="//cdn.ckeditor.com/4.4.7/full/ckeditor.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script>
// In your Javascript (external.js resource or <script> tag)
$(document).ready(function() {
    $('.select2').select2();
    // Initialize CKEditor for any textarea marked as rich-editor
    window._richEditors = [];
    $('.rich-editor').each(function(){
        var id = $(this).attr('id');
        try {
            if (CKEDITOR.instances[id]) {
                CKEDITOR.instances[id].destroy(true);
            }
        } catch(e) { }
        CKEDITOR.replace(id, {
            // small toolbar to keep UI clean
            toolbar: [
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList' ] },
                { name: 'links', items: [ 'Link', 'Unlink' ] },
                { name: 'undo', items: [ 'Undo', 'Redo' ] }
            ],
            height: 120
        });
        window._richEditors.push(id);
    });
});
</script>
<script>

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

// unit wise company (populate companies and departments when unit changes)
$(document).ready(function() {
    $(document).on('change', '.unit_wise_company', function () {
        var unit_id = $(this).val();

     

        // populate departments
        $.ajax({
            type: 'GET',
            url: "{{ route('unit-wise-department')}}",
            data: { unit_id: unit_id},
            dataType: 'json',
            success: function (data) {
                console.log('unit-wise-department response:', data);
                // If department was previously initialized with Select2, destroy it to update options reliably
                if ($('.department_name').data('select2')) {
                    try { $('.department_name').select2('destroy'); } catch(e) { console.warn('select2 destroy failed', e); }
                }

                // preserve existing selection (useful in edit form)
                var previous = $('.department_name').val();

                $(".department_name").empty();
                // $('.department_name').append("<option value=''>Please Select</option>");
                $.each(data['department_list'] || [], function (key, department_list) {
                    $('.department_name').append("<option value='" + department_list.id + "'>" + department_list.department_name +"</option>");
                });

                // restore selection if still present
                if (previous) {
                    $('.department_name').val(previous);
                }

                // trigger normal change so any listeners update
                $('.department_name').trigger('change');
            },
            error: function (xhr, status, err) {
                console.error('Error loading departments for unit', unit_id, status, err);
            }
        });
    });
});

// photo preview
$(document).on('change', '#photo-input', function(e){
    const [file] = this.files;
    if (file) {
        const url = URL.createObjectURL(file);
        $('#photo-preview').attr('src', url);
    }
});


    $('#employee_add').submit(function(e) {

        e.preventDefault();

    // clear previous validation states
        $(this).find('.is-invalid').removeClass('is-invalid');
        $(this).find('.invalid-feedback').addClass('d-none').text('');

    // debug: inspect unit select(s) and value (helps when multiple elements share the same class)
    var $unitByClass = $('.unit_id');
    var $unitByName = $('[name="unit_id"]');
    // Read unit_id from the actual <select name="unit_id"> inside the employee form to avoid Select2 container conflicts
    var unit_id  = $('#employee_add').find('[name="unit_id"]').val() || $unitByClass.val();
    var name  = $('input[name="name"]').val();

    // detailed debug info (check in browser console)
    // console.log('DEBUG unit select count (by .unit_id):', $unitByClass.length);
    // if ($unitByClass.length) console.log('DEBUG first .unit_id outerHTML:', $unitByClass[0].outerHTML);
    // console.log('DEBUG select count (by [name="unit_id"]):', $unitByName.length);
    // if ($unitByName.length) console.log('DEBUG first [name="unit_id"] outerHTML:', $unitByName[0].outerHTML);
    // console.log('DEBUG .unit_id.val():', unit_id);
    // console.log('DEBUG option:selected val/text:', $unitByClass.find('option:selected').val(), $unitByClass.find('option:selected').text());
    // console.log('DEBUG is disabled/hidden/select2?', $unitByClass.prop('disabled'), $unitByClass.is(':hidden'), !!$unitByClass.data('select2'));

    // keep the small alert for quick visual feedback (remove after debugging)
    // alert('unit_id (debug): ' + unit_id + '\n.check console for more details');

        if (unit_id  == '') {
            Swal.fire({
                title: 'Please select a Unit',
                icon: 'warning',
                focusConfirm: true,
            })
            return;
        }

        if (name  == '') {
            Swal.fire({
                title: 'Please enter employee name',
                icon: 'warning',
                focusConfirm: true,
            })
            return;
        }

        // ensure CKEditor instances update their textarea elements
        if (window._richEditors && window._richEditors.length) {
            window._richEditors.forEach(function(id){
                if (CKEDITOR.instances[id]) {
                    CKEDITOR.instances[id].updateElement();
                }
            });
        }

        let formData = new FormData(this);

        $.ajax({
            type:'POST',
            url:"{{ route('employees.store') }}",
            data: formData,
            contentType: false,
            processData: false,
            success: (response) => {
                Swal.fire({
                    title: 'Employee Added',
                    html: '<span class="text-success">Information added successfully.</span>',
                    icon: 'success',
                    timer: 1800,
                    showConfirmButton: false,
                }).then(() => location.reload());
            },
            error: function(response){
                console.log(response);
                if (response.status === 422 && response.responseJSON && response.responseJSON.errors) {
                    const errors = response.responseJSON.errors;
                    // show a summary alert
                    const firstKey = Object.keys(errors)[0];
                    Swal.fire({title: 'Validation error', text: errors[firstKey][0], icon: 'error'});

                    // mark fields and show inline messages
                    Object.keys(errors).forEach(function(field){
                        const messages = errors[field];
                        // try to find matching input/select/textarea
                        const $el = $('[name="'+field+'"]');
                        if ($el.length) {
                            $el.addClass('is-invalid');
                            // find invalid-feedback with matching data-field
                            const $fb = $('.invalid-feedback[data-field="'+field+'"]');
                            if ($fb.length) {
                                $fb.removeClass('d-none').text(messages[0]);
                            } else {
                                // append a feedback element
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

</script>
@endsection