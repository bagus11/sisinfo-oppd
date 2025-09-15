<div class="modal fade" id="editSubCategoryModal" tabindex="-1" aria-hidden="true" style="overflow-y: hidden;">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Kategori Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-4 mt-2">
                            <label for="name">Name</label>
                        </div>
                        <div class="col-8">
                            <input type="hidden" class="form-control" id="id">
                            <input type="text" class="form-control" id="edit_name">
                            <span class="message_error edit_name_error text-red d-block"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" type="button" id="btn_update_sub_category">
                        <i class="fas fa-check"></i> Save
                    </button>
                </div>
          
        </div>
    </div>
</div>
