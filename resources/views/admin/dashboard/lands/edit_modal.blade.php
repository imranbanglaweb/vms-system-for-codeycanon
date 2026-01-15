<div class="modal-header">
    <h5 class="modal-title">Edit Land</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<form action="{{ route('lands.update', $land->id) }}" method="POST" class="ajax-form">
    @csrf
    @method('PUT')
    <div class="modal-body">
        <div id="modal-alert-container"></div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="name">Land Name<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $land->name) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="location">Location<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                           id="location" name="location" value="{{ old('location', $land->location) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="area">Area<span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('area') is-invalid @enderror" 
                           id="area" name="area" value="{{ old('area', $land->area) }}">
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control summernote @error('description') is-invalid @enderror" 
                              id="description" name="description">{{ old('description', $land->description) }}</textarea>
                    <div class="invalid-feedback"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="status">Status<span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                        <option value="active" {{ old('status', $land->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $land->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-save"></i> Update Land
        </button>
    </div>
</form>

<script>
$(function() {
    // Initialize form validation
    $('.ajax-form').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        clearFormErrors(form);
        
        // Validate required fields
        var isValid = true;
        
        // Validate Land Name
        if (!$('#name').val()) {
            isValid = false;
            $('#name').addClass('is-invalid');
            $('#name').siblings('.invalid-feedback').html('Land name is required');
        }

        // Validate Location
        if (!$('#location').val()) {
            isValid = false;
            $('#location').addClass('is-invalid');
            $('#location').siblings('.invalid-feedback').html('Location is required');
        }

        // Validate Area
        if (!$('#area').val()) {
            isValid = false;
            $('#area').addClass('is-invalid');
            $('#area').siblings('.invalid-feedback').html('Area is required');
        }

        // Validate Status
        if (!$('#status').val()) {
            isValid = false;
            $('#status').addClass('is-invalid');
            $('#status').siblings('.invalid-feedback').html('Please select a status');
        }

        if (!isValid) {
            showModalAlert('error', 'Please correct the errors below.');
            return false;
        }

        // Submit form if validation passes
        submitForm(form);
    });

    // Clear validation on input change
    $('.ajax-form').find('input, select, textarea').on('change', function() {
        $(this).removeClass('is-invalid');
        $(this).siblings('.invalid-feedback').html('');
        $('#modal-alert-container').empty();
    });
});
</script> 