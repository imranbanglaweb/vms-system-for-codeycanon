@foreach($requisitions as $key => $req)
<tr>
    <td>{{ $requisitions->firstItem() + $key }}</td>

    <td>{{ $req->requestedBy->name ?? 'N/A' }}</td>

    <!-- <td>{{ $req->requestedBy->department_name ?? 'N/A' }}</td> -->
    <td>{{ $req->requestedBy->department->department_name ?? 'N/A' }}</td>

    <td>{{ $req->vehicle->vehicle_name ?? 'Not Assigned' }}</td>

    <td>{{ $req->driver->driver_name ?? 'Not Assigned' }}</td>

    <td>{{ $req->travel_date ? $req->travel_date->format('d M, Y h:i A') : 'N/A' }}</td>

    <td>{{ Str::limit($req->purpose, 25) }}</td>

    <!-- <td>
        <span class="badge 
            @if($req->status == 'Pending') bg-warning 
            @elseif($req->status == 'Approved') bg-success 
            @elseif($req->status == 'Rejected') bg-danger
            @else bg-secondary @endif
        ">
            {{ $req->status }}
        </span>
    </td> -->

    <td>
        @if($req->status == 2)
<div class="d-flex gap-2">
    <button class="btn btn-success btn-sm transportApproveBtn" 
            data-id="{{$req->id}}">
        Transport Approve
    </button>

    <button class="btn btn-danger btn-sm transportRejectBtn"  
            data-id="{{$req->id}}">
        Transport Reject
    </button>
</div>
@endif

@if($req->status == 4)
<div class="d-flex gap-2">
    <button class="btn btn-primary btn-sm adminApproveBtn" 
            data-id="{{$req->id}}">
        Final Approve
    </button>

    <button class="btn btn-warning btn-sm adminRejectBtn"  
            data-id="{{$req->id}}">
        Final Reject
    </button>
</div>
@endif

    </td>

    <td width="">
        <a href="{{ route('requisitions.show', $req->id) }}" 
           class="btn btn-sm btn-info">
            <i class="fa fa-eye"></i>
        </a>

        <a href="{{ route('requisitions.edit', $req->id) }}" 
           class="btn btn-sm btn-primary">
            <i class="fa fa-edit"></i>
        </a>

        <!-- <form action="{{ route('requisitions.destroy', $req->id) }}" 
              method="POST" 
              class="d-inline"
              onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger">
                <i class="fa fa-minus"></i>
            </button>
        </form> -->
    </td>
</tr>
@endforeach

@if($requisitions->count() == 0)
<tr>
    <td colspan="9" class="text-center text-muted py-3">
        No requisitions found.
    </td>
</tr>
@endif

<script>
    // Transport Office Approve
$(document).on('click', '.transportApproveBtn', function () {
    let id = $(this).data('id');

    $.ajax({
        url: "/requisitions/transport-approve/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (res) {
            if (res.status === "success") {
                toastr.success("Transport Office Approved!");
                setTimeout(() => location.reload(), 1000);
            }
        }
    });
});

// Transport Office Reject
$(document).on('click', '.transportRejectBtn', function () {
    let id = $(this).data('id');

    $.ajax({
        url: "/requisitions/transport-reject/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (res) {
            if (res.status === "success") {
                toastr.error("Transport Office Rejected!");
                setTimeout(() => location.reload(), 1000);
            }
        }
    });
});


// Admin Final Approve
$(document).on('click', '.adminApproveBtn', function () {
    let id = $(this).data('id');

    $.ajax({
        url: "/requisitions/admin-approve/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (res) {
            if (res.status === "success") {
                toastr.success("Requisition Fully Approved (Admin Final)");
                setTimeout(() => location.reload(), 1000);
            }
        }
    });
});

// Admin Final Reject
$(document).on('click', '.adminRejectBtn', function () {
    let id = $(this).data('id');

    $.ajax({
        url: "/requisitions/admin-reject/" + id,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (res) {
            if (res.status === "success") {
                toastr.error("Requisition Rejected by Admin");
                setTimeout(() => location.reload(), 1000);
            }
        }
    });
});

</script>
