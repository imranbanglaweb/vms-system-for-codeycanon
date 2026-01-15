<div class="modal-header">
    <h4 class="modal-title">View Document Type</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th width="30%">Name</th>
                    <td>{{ $documentType->name }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{!! $documentType->description !!}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge badge-{{ $documentType->status == 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($documentType->status) }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $documentType->created_at->format('d M Y H:i:s') }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $documentType->updated_at->format('d M Y H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div> 