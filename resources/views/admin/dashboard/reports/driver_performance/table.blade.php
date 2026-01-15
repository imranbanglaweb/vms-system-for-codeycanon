<table class="table table-hover align-middle">
<thead class="table-light">
<tr>
    <th>#</th>
    <th>Driver</th>
    <th>Total Trips</th>
    <th>Total KM</th>
    <th>Total Fuel (L)</th>
    <th>Delayed Trips</th>
    <th>Incidents</th>
    <th>Efficiency (KM/L)</th>
</tr>
</thead>
<tbody>
@forelse($records as $r)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $r->driver->name }}</td>
    <td>{{ $r->total_trips }}</td>
    <td>{{ number_format($r->total_distance,2) }}</td>
    <td>{{ number_format($r->total_fuel,2) }}</td>
    <td>
        <span class="badge bg-warning">
            {{ $r->delayed_trips }}
        </span>
    </td>
    <td>
        <span class="badge bg-danger">
            {{ $r->incidents }}
        </span>
    </td>
    <td>
        {{ $r->total_fuel > 0
            ? number_format($r->total_distance / $r->total_fuel,2)
            : 'N/A' }}
    </td>
</tr>
@empty
<tr>
    <td colspan="8" class="text-center text-muted">
        No performance data found
    </td>
</tr>
@endforelse
</tbody>
</table>


