@extends('admin.dashboard.master')

@section('main_content')

@push('styles')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endpush


<section role="main" class="content-body" style="background-color:#fff;">

<div class="d-flex justify-content-between">
	<br>
    <h3>Drivers Manage</h3>
    <div>
        <a href="{{ route('drivers.create')}}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Create Driver </a>
      
    </div>
</div>
<br>
<hr>

<table class="table table-striped" id="drivers-table">
    <thead>
        <tr>
            <th>SL</th>
			<th>Driver Name</th>
			<th>Unit</th>
			<th>Department</th>
			<th>License Number</th>
			<th>License Type</th>
			<th>Mobile</th>
			<th>Joining Date</th>
			<th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

</section>

@push('scripts')

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(function(){

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            "X-Requested-With": "XMLHttpRequest"
        }
    });

    var table = $('#drivers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('drivers.data') }}",
        columns:[
             { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable:false, searchable:false },
    { data: 'driver_name', name: 'driver_name' },
    { data: 'unit_name', name: 'unit_name' },
    { data: 'department_name', name: 'department_name' },
    { data: 'license_number', name: 'license_number' },
    { data: 'license_type', name: 'license_type' },
    { data: 'joining_date', name: 'joining_date' },
    { data: 'photo', name: 'photo', orderable:false, searchable:false },
    { data: 'action', name: 'action', orderable:false, searchable:false }
        ],
        order:[[1, 'asc']],
        responsive:true,
        pageLength:10
    });

    $('#refresh-table').click(()=> table.ajax.reload(null,false));
    $('#table-search').keyup(function(){ table.search(this.value).draw(); });

    // Clear form
    function resetForm(){
        $('#driverForm')[0].reset();
        $('#driver_id').val('');
    }

 

    // SUBMIT
    $('#driverForm').submit(function(e){
        e.preventDefault();

        let data = {
            id: $('#driver_id').val(),
            name: $('#name').val(),
            phone: $('#phone').val()
        };

        $('#saveDriverBtn').html('<i class="fa fa-spinner fa-spin"></i> Saving').prop('disabled', true);

        $.post("{{ route('drivers.store') }}", data)
        .done(res => {
            $('#driverModal').modal('hide');
            table.ajax.reload(null,false);
            showToast("Driver saved successfully","success");
        })
        .fail(xhr => {
            let msg = "Validation failed";
            if(xhr.responseJSON?.errors){
                msg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
            }
            showToast(msg, "error");
        })
        .always(()=>{
            $('#saveDriverBtn').html('<i class="fa fa-save"></i> Save').prop('disabled', false);
        });
    });

    // DELETE — WITH SWEETALERT2
    $(document).on('click','.deleteUser', function(){
        let id = $(this).data('did');

        Swal.fire({
            title:"Are you sure?",
            text:"This driver will be deleted.",
            icon:"warning",
            showCancelButton:true,
            confirmButtonText:"Yes, Delete"
        }).then(result=>{
            if(result.isConfirmed){
                $.ajax({
                    url:"{{ url('drivers') }}/" + id,
                    type:"POST",
                    data:{ _method:'DELETE' }
                })
                .done(res=>{
                    showToast("Driver deleted","success");
                    table.ajax.reload(null,false);
                })
                .fail(()=>{
                    showToast("Delete failed","error");
                });
            }
        });
    });

    // Toast helper
    function showToast(message, type="success"){
        const Toast = Swal.mixin({
            toast:true, position:'top-end', timer:3000, showConfirmButton:false
        });
        Toast.fire({ icon:type, title:message });
    }

});
</script>

@endpush


@endsection
