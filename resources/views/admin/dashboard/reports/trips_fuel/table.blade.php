<table class="table table-hover align-middle">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Vehicle</th>
    <th>Driver</th>
    <th>Trip Date</th>
    <th>Distance (KM)</th>
    <th>Fuel Used (L)</th>
    <th>Fuel Avg (KM/L)</th>
</tr>
</thead>
<tbody>
@forelse($records as $r)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $r->vehicle->vehicle_no }}</td>
    <td>{{ $r->driver->driver_name }}</td>
    <td>{{ $r->trip_start_date }}</td>
    <td>{{ $r->distance_km }}</td>
    <td>{{ $r->fuel_liter }}</td>
    <td>
        {{ $r->fuel_liter > 0 ? number_format($r->distance_km / $r->fuel_liter,2) : 'N/A' }}
    </td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted">No data found</td>
</tr>
@endforelse
</tbody>
</table>


