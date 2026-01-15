<div class="modal-header">
    <h4 class="modal-title">Edit Document Type</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
</div>
<form id="editDocumentType" action="{{ route('document-types.update', $documentType->id) }}" method="post">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Name<span class="required">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ $documentType->name }}" required>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ $documentType->description }}</textarea>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label">Status<span class="required">*</span></label>
                    <select name="status" class="form-control" required>
                        <option value="active" {{ $documentType->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $documentType->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<script>
$(document).ready(function() {
    $("#editDocumentType").on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');
        
        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(response) {
                if(response.success) {
                    location.reload();
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).after('<div class="invalid-feedback">' + value[0] + '</div>');
                });
            }
        });
    });
});
</script> 