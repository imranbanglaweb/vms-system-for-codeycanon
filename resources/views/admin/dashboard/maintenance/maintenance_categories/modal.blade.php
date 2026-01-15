
<div class="modal " id="categoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold">Add / Edit Category</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal"></button> -->
            </div>

            <div class="modal-body">

                <div id="errorAlert" class=""></div>

                <form id="categoryForm">
                    @csrf
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Category Name</label>
                        <input type="text" name="category_name" id="category_name"
                               class="form-control form-control-lg text-dark fw-bold" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Category Type</label>
                        <input type="text" name="category_type" id="category_type"
                               class="form-control form-control-lg text-dark fw-bold">
                    </div>

                </form>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button class="btn btn-dark" id="saveBtn">Save</button>
            </div>

        </div>
    </div>
</div>
