@forelse($lands as $land)
<tr id="land-{{ $land->id }}">
    <td>{{ $land->id }}</td>
    <td>{{ $land->name }}</td>
    <td>{{ $land->location }}</td>
    <td>{{ $land->area }}</td>
    <td>
        <span class="badge badge-{{ strtolower($land->status) === 'active' ? 'success' : 'danger' }}">
            {{ ucfirst($land->status) }}
        </span>
    </td>
    <td>
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm" onclick="viewLand({{ $land->id }})">
                <i class="fa fa-eye"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" onclick="editLand({{ $land->id }})">
                <i class="fa fa-pencil"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteLand({{ $land->id }})">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="6" class="text-center">No lands found</td>
</tr>
@endforelse 