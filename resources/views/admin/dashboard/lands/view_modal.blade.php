<div class="modal-header">
    <h5 class="modal-title">View Land</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">Land Name</th>
                    <td>{{ $land->name }}</td>
                </tr>
                <tr>
                    <th>Location</th>
                    <td>{{ $land->location }}</td>
                </tr>
                <tr>
                    <th>Area</th>
                    <td>{{ $land->area }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{!! $land->description !!}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge badge-{{ strtolower($land->status) === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($land->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Created By</th>
                    <td>{{ optional($land->creator)->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $land->created_at->format('d M Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Last Updated</th>
                    <td>{{ $land->updated_at->format('d M Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="editLand({{ $land->id }})">
        <i class="fa fa-pencil"></i> Edit
    </button>
</div> 