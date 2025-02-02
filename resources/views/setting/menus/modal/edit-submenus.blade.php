<div class="modal fade" id="editSubmenusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Edit Submenus
            </div>
            <div class="modal-body" data-simplebar="">
              <div class="row mx-2">
                    <div class="col-4 mt-2">
                        <p>Name</p>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="hidden" class="form-control" id="submenus_id">
                        <input type="text" class="form-control" id="submenus_name_edit">
                        <span class="message_error submenus_name_edit_error text-red block "></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Parent</p>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_menus_edit" id="select_menus_edit" class="select2">
                        </select>
                        <input type="hidden" class="form-control" id="parent_edit">
                        <span class="message_error parent_edit_error text-red block "></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Icon</p>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="submenus_icon_edit" class="form-control" id="submenus_icon_edit">
                        <span class="message_error submenus_icon_edit_error text-red block "></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Link</p>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="submenus_link_edit" id="submenus_link_edit" class="form-control">
                        <span class="message_error submenus_link_edit_error text-red block "></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-8 mb-2">
                        <textarea class="form-control" id="submenus_description_edit" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block submenus_description_edit_error"></span>
                    </div>
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_update_submenus">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
