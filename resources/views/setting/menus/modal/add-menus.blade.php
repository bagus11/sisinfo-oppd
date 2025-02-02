<div class="modal fade" id="addMenusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Menus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <div class="row mx-2">
                    <div class="col-4 mt-2">
                        <label for="menus_name">Name</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" class="form-control" id="menus_name" aria-describedby="nameHelp">
                        <span class="message_error menus_name_error text-red d-block"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <label for="select_menus_type">Type</label>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_menus_type" id="select_menus_type" class="form-select">
                            <option value="">Choose Type</option>
                            <option value="1">Stand Alone</option>
                            <option value="2">Have a Child</option>
                        </select>
                        <input type="hidden" id="menus_type">
                        <span class="message_error menus_type_error text-red d-block"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <label for="menus_icon">Icon</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="menus_icon" class="form-control" id="menus_icon">
                        <span class="message_error menus_icon_error text-red d-block"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <label for="menus_link">Link</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="menus_link" id="menus_link" class="form-control">
                        <span class="message_error menus_link_error text-red d-block"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <label for="menus_description">Description</label>
                    </div>
                    <div class="col-8 mb-2">
                        <textarea class="form-control" id="menus_description" rows="3"></textarea>
                        <span class="message_error menus_description_error text-red d-block"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_save_menus">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
