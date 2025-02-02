<div class="modal fade" id="addSubmenusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                Add Submenus
            </div>
            <div class="modal-body" data-simplebar="">
              <div class="row mx-2">
                    <div class="col-4 mt-2">
                        <p>Name</p>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" class="form-control" id="submenus_name">
                        <span class="message_error submenus_name_error text-red block "></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Parent</p>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_menus" id="select_menus" class="select2">
                        </select>
                        <input type="hidden" class="form-control" id="parent">
                        <span class="message_error parent_error text-red block "></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Icon</p>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="submenus_icon" class="form-control" id="submenus_icon">
                        <span class="message_error submenus_icon_error text-red block "></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Link</p>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="submenus_link" id="submenus_link" class="form-control">
                        <span class="message_error submenus_link_error text-red block "></span>
                    </div>
                    <div class="col-4 mt-2">
                        <p>Description</p>
                    </div>
                    <div class="col-8 mb-2">
                        <textarea class="form-control" id="submenus_description" rows="3"></textarea>
                        <span  style="color:red;" class="message_error text-red block submenus_description_error"></span>
                    </div>
              </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_save_submenus">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
