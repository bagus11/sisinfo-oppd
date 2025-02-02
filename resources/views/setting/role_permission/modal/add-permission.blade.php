
<div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Menus</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <p>Option</p>
                     </div>
                     <div class="col-md-8">
                         <select name="option" class="select2" style="width:100%"  id="option">
                             <option value="view">View</option>
                             <option value="get-dashboard_admin">Dashboard Admin</option>
                             <option value="get-except_satgas">Except Satgas</option>
                             <option value="get-only_satgas">Only Satgas</option>
                             <option value="get-only_user">Only User</option>
                             <option value="get-only_staff">Only Staff</option>
                             <option value="get-only_admin">Only Admin</option>
                             <option value="get-only_gm">Only GM</option>
                             <option value="create">Create</option>
                             <option value="update">Update</option>
                             <option value="delete">Delete</option>
                         </select>
                         <input type="hidden" class="form-control" id="permission_name" >
                         <span  style="color:red;" class="message_error text-red block permission_name_error"></span>
                     </div>
                     <div class="col-md-3 mt-2">
                       <p>Menus</p>
                      </div>
                      <div class="col-md-8">
                          <select name="menus_name" class="menus_name select2" style="width:100%" id="menus_name">
                          </select>
                      </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_save_permission">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
