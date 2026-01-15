@extends('admin.dashboard.master')

@section('main_content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<section role="main" class="content-body" style="background-color:#fff;">
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3 mt-2">
        <h3 class="fw-bold text-primary mb-0"><i class="bi bi-person-plus-fill me-2"></i>Edit Driver</h3>
        <a class="btn btn-outline-primary btn-sm px-3" href="{{ route('drivers.index') }}">
            <i class="bi bi-arrow-left-circle"></i> Back
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form id="driver_edit_form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" id="driver_id" name="id" value="{{ $driver->id }}">

                @include('admin.dashboard.driver.partials.driver_form') {{-- the same _form partial; it should autofill fields using $driver when present --}}

                <div class="text-center mt-4">
                   <button type="submit" id="updateDriverBtn" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-save-fill me-2"></i> Update Driver
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function(){
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    // If select2 is used, re-init for selects
    if ($.fn.select2) {
        $('.select2').not('.select2-hidden-accessible').select2({ width:'100%' });
    }

    // Hook unit->departments same as create
    $('#unit_id').change(function(){
        var id = $(this).val();
        if (!id) return;
        $.getJSON("{{ route('getDepartmentsByUnit') }}", {unit_id:id}, function(data){
            var $dept = $('#department_id').empty().append('<option value="">Select Department</option>');
            $.each(data.department_list || [], function(i,d){ $dept.append('<option value="'+d.id+'">'+d.department_name+'</option>'); });
            if ($.fn.select2) { try{ $dept.select2({ width:'100%' }); } catch(e){} }
            // pre-select if driver.department_id present
            var selected = "{{ $driver->department_id ?? '' }}";
            if(selected) $dept.val(selected).trigger('change');
        });
    });

    // submit update
    $('#driver_edit_form').submit(function(e){
        e.preventDefault();
        var id = $('#driver_id').val();
        var form = new FormData(this);
        var $btn = $('#updateDriverBtn').prop('disabled', true).text('Updating...');
        $.ajax({
            url: "{{ url('admin/drivers') }}/" + id,
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            headers: { 'X-HTTP-Method-Override': 'PUT' },
            success: function(res){
                Swal.fire({ icon:'success', title:'Updated', text:res.message, timer:1500, showConfirmButton:false })
                    .then(()=> window.location.href = "{{ route('drivers.index') }}");
            },
            error: function(xhr){
                $btn.prop('disabled', false).text('Update Driver');
                if (xhr.status === 422){
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(k,v){
                        var $el = $('[name="'+k+'"]');
                        $el.addClass('is-invalid');
                        if ($el.next('.text-danger').length === 0){
                            $el.after('<div class="text-danger small mt-1">'+v[0]+'</div>');
                        }
                    });
                    Swal.fire('Validation Error','Please correct highlighted fields','error');
                } else {
                    Swal.fire('Error','Server error','error');
                }
            }
        });
    });
});
</script>
@endpush
@endsection
