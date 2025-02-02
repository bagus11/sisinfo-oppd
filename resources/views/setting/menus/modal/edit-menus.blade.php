<div class="modal fade" id="editMenusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Menus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" data-simplebar="">
                <div class="row mx-2">
                    <input type="hidden" name="menus_id" id="menus_id">
                    
                    <div class="col-4 mt-2">
                        <label for="menus_name_edit">Name</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" class="form-control" id="menus_name_edit" aria-describedby="menus_name_help">
                        <span class="message_error menus_name_edit_error text-red block"></span>
                    </div>
                    
                    <div class="col-4 mt-2">
                        <label for="select_menus_type_edit">Type</label>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_menus_type_edit" id="select_menus_type_edit" class="select2">
                            <option value="">Choose Type</option>
                            <option value="1">Stand Alone</option>
                            <option value="2">Have a Child</option>
                        </select>
                        <input type="hidden" class="form-control" id="menus_type_edit">
                        <span class="message_error menus_type_edit_error text-red block"></span>
                    </div>
                    
                    <div class="col-4 mt-2">
                        <label for="menus_icon_edit">Icon</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="menus_icon_edit" class="form-control" id="menus_icon_edit">
                        <span class="message_error menus_icon_edit_error text-red block"></span>
                    </div>
                    
                    <div class="col-4 mt-2">
                        <label for="menus_link_edit">Link</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="menus_link_edit" id="menus_link_edit" class="form-control" disabled readonly>
                        <span class="message_error menus_link_edit_error text-red block"></span>
                    </div>
                    
                    <div class="col-4 mt-2">
                        <label for="menus_description_edit">Description</label>
                    </div>
                    <div class="col-8 mb-2">
                        <textarea class="form-control" id="menus_description_edit" rows="3"></textarea>
                        <span style="color:red;" class="message_error text-red block menus_description_edit_error"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_update_menus">
                    <i class="fas fa-check"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
