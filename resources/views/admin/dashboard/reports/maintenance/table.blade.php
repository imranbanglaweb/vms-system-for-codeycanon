<table class="table table-hover align-middle">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Vehicle</th>
    <th>Type</th>
    <th>Vendor</th>
    <th>Date</th>
    <th>Cost</th>
    <th>Status</th>
</tr>
</thead>
<tbody>
@forelse($records as $r)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $r->vehicle->vehicle_name ?? 'N/A' }}</td>
    <td>{{ $r->maintenanceType->name ?? 'N/A' }}</td>
    <td>{{ $r->vendor->name ?? 'N/A' }}</td>
    <td>{{ $r->maintenance_date ?? 'N/A' }}</td>
    <td>{{ number_format($r->total_cost ?? 0, 2) }}</td>
    <td>
        <span class="badge bg-{{ $r->status == 'Completed' ? 'success':'warning' }}">
            {{ $r->status ?? 'N/A' }}
        </span>
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted">No records found</td>
</tr>
@endforelse
</tbody>

</table>
