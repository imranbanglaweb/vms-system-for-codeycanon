@forelse($documentTypes as $documentType)
<tr id="document-type-{{ $documentType->id }}">
    <td>{{ $documentType->id }}</td>
    <td>{{ $documentType->name }}</td>
    <td>{!! $documentType->description !!}</td>
    <td>
        <span class="badge badge-{{ strtolower($documentType->status) === 'active' ? 'success' : 'danger' }}">
            {{ ucfirst($documentType->status) }}
        </span>
    </td>
    <td>
        <div class="btn-group">
            <button type="button" class="btn btn-info btn-sm" onclick="viewDocumentType({{ $documentType->id }})">
                <i class="fa fa-eye"></i>
            </button>
            <button type="button" class="btn btn-primary btn-sm" onclick="editDocumentType({{ $documentType->id }})">
                <i class="fa fa-pencil"></i>
            </button>
            <button type="button" class="btn btn-danger btn-sm" onclick="deleteDocumentType({{ $documentType->id }})">
                <i class="fa fa-trash-o"></i>
            </button>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">No document types found</td>
</tr>
@endforelse 