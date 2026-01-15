<table class="table table-hover align-middle">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Vehicle</th>
    <th>Total Trips</th>
    <th>Total Distance (KM)</th>
    <th>Total Fuel (L)</th>
    <th>Avg KM / Trip</th>
</tr>
</thead>
<tbody>
@forelse($records as $r)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $r->vehicle->vehicle_no }}</td>
    <td>{{ $r->total_trips }}</td>
    <td>{{ number_format($r->total_distance,2) }}</td>
    <td>{{ number_format($r->total_fuel,2) }}</td>
    <td>
        {{ $r->total_trips > 0
            ? number_format($r->total_distance / $r->total_trips,2)
            : 'N/A' }}
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center text-muted">
        No utilization data found
    </td>
</tr>
@endforelse
</tbody>
</table>


