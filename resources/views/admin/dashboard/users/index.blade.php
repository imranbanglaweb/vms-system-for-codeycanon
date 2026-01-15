@extends('admin.dashboard.master')

@section('main_content')
<section role="main" class="content-body" style="background-color: #fff; padding: 10px;">

<div class="row">
    <div class="col-md-4">
        <!-- <h4>User Upload</h4>
        <div class="form-group">
            <select class="form-control select_employee_file">
                <option>Select User Export/Import</option>
                <option value="Import">Import</option>
                <option value="Export">Export</option>
            </select>
        </div> -->

        <!-- Import -->
        <!-- <div id="showImport" class="myDiv" style="display:none;">
            <form action="{{ route('employee.importuser')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <input type="file" name="file" class="form-control-file" required>
                </div>
                <button class="btn btn-info"><i class="fa fa-download"></i> Import</button>
            </form>
        </div> -->

       
    </div>
    <div class="col-md-8 text-right">
    <br>
    <br>
        <div class="btn-group">
            <a class="btn btn-success" href="{{ route('users.create') }}">
                <i class="fa fa-plus"></i> Add New User
            </a>
        </div>
        <!-- Export -->
        <div id="showExport" class="myDiv" style="display:none;">
            <form method="POST" action="{{ route('employee.export')}}">
                @csrf
                <button class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
            </form>
        </div>
    </div>

    
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success myElem">
    <p>{{ $message }}</p>
</div>
@endif

<!-- TABLE -->
<div class="card mt-3 p-2">
    <table class="table table-bordered table-hover" id="myTable" style="width:100%;">
        <thead>
            <tr>
                <th>#</th>
                <th>User Name</th>
                <th>Name</th>
                <th>Email</th>
                <th>Image</th>
                <th width="150px">Action</th>
            </tr>
        </thead>
    </table>
</div>

<!-- Delete Modal -->
<div class="modal" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete User</h5>
                <button class="close" data-bs-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">Are you sure you want to delete this user?</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

</section>

<!-- JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {

    $(".myElem").delay(5000).fadeOut();

    $(".select_employee_file").on("change", function() {
        $(".myDiv").hide();
        $("#show" + $(this).val()).show();
    });

    // DELETE MODAL
    $(document).on("click", ".deleteUser", function() {
        let userId = $(this).data("id");
        let url = "{{ route('users.destroy', ':id') }}".replace(':id', userId);
        $("#deleteForm").attr("action", url);
        $("#deleteModal").modal("show");
    });

    // DATATABLES INITIALIZATION
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('users.getData') }}",
            type: "GET",
            error: function(xhr) {
                console.error("DataTables Error:", xhr.responseText);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'user_name', name: 'user_name' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },

            {
                data: 'user_image', 
    name: 'user_image', 
    orderable: false, 
    searchable: false, 
 render: function(data, type, full, meta) {
    var basePath = "{{ asset('public/admin_resource/assets/images/user_image') }}";
    var fallback = "{{ asset('public/admin_resource/assets/images/default.png') }}";

    var imgSrc = data ? basePath + '/' + data : fallback;

    return '<img src="' + imgSrc + '" height="50" width="50" class="rounded-circle" ' +
           'onerror="this.onerror=null;this.src=\'' + fallback + '\'"/>';
}

            },

            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    // LIVE SEARCH
    $('#search').keyup(function() {
        $('#myTable').DataTable().search($(this).val()).draw();
    });

});
</script>

@endsection
