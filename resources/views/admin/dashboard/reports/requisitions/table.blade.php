<table class="table table-striped align-middle">
<thead>
<tr>
    <th>#</th>
    <th>Req No</th>
    <th>Employee</th>
    <th>Department</th>
    <th>Unit</th>
    <th>Date</th>
    <th>Status</th>
</tr>
</thead>

<tbody>
@forelse($requisitions as $req)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $req->requisition_number }}</td>
    <td>{{ $req->requestedBy->name ?? '-' }}</td>
    <td>{{ $req->department->department_name ?? '-' }}</td>
    <td>{{ $req->unit->unit_name ?? '-' }}</td>
    <td>{{ $req->travel_date }}</td>
    <td>
        <span class="badge bg-info">{{ $req->status }}</span>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted">
        No records found
    </td>
</tr>
@endforelse
</tbody>
</table>

{{ $requisitions->links() }}
