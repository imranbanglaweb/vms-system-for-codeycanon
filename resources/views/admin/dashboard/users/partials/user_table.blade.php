<table class="table table-bordered table-striped table-hover mb-none" id="myTable">
    <thead class="thead-dark">
        <tr>
            <th>No</th>
            <th width="15%">EMP ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th>User Type</th>
            <th>Image</th>
            <th width="280px">Action</th>
        </tr>
    </thead>
    <tbody>
        @isset($users)
            @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                    <td>{{ $user->user_type }}</td>
                    <td>
                        @if($user->user_image)
                            <img class="rounded-circle border" src="{{ asset('storage/app/users/' . $user->user_image) }}" alt="User Image" width="50" height="50">
                        @else
                            <i class="fa fa-user fa-3x"></i>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="edit btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                        <button type="button" onclick="confirmDelete({{ $user->id }})" class="deleteUser btn btn-danger btn-sm" data-qid="{{ $user->id }}"><i class="fa fa-minus"></i></button>
                    </td>
                </tr>
            @endforeach
        @endisset
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $users instanceof \Illuminate\Pagination\LengthAwarePaginator ? $users->links() : '' }}
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function() {
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('users.data') }}',
            type: 'GET',
            error: function(xhr, error, code) {
                console.error('DataTable AJAX Error:', error);
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'user_name', name: 'user_name' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            // { data: 'roles', name: 'roles' },
            { data: 'user_type', name: 'user_type' },
            { 
                data: 'user_image', 
                name: 'user_image', 
                orderable: true, 
                searchable: true, 
                render: function(data, type, full, meta) {
                    return data ? '<img class="rounded-circle border" src="{{ asset('storage/app/users') }}/' + data + '" height="50"/>' : '<i class="fa fa-user fa-3x"></i>';
                } 
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        pageLength: 5
    });
  });

function confirmDelete(userId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteUser(userId);
        }
    });
}

function deleteUser(userId) {
    $.ajax({
         url: '{{ route('users.destroy', '') }}/' + userId,
        type: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            showAlert(response.success);
            location.reload();
        },
        error: function(xhr) {
            alert('Error deleting user.');
        }
    });
}

// Add this function to show success alert
function showAlert(message) {
    $('<div class="alert alert-success alert-dismissible fade show" role="alert">' + 
      message + 
      '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>')
      .appendTo('body').delay(3000).fadeOut(500, function() {
        $(this).remove();
    });
}
</script>