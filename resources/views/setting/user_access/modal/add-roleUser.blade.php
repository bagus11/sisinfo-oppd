
<div class="modal fade" id="addRoleUserModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Role User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <div class="row">
                    <div class="col-3 mt-2">
                        <label for="">Role</label>
                    </div>
                    <div class="col-9">
                        <select name="select_role" class="select2" id="select_role"></select>
                        <input type="hidden" class="form-control" id="role">
                        <span class="message_error role_error text-red d-block"></span>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3 mt-2">
                        <label for="">User</label>
                    </div>
                    <div class="col-9">
                        <select name="select_user" class="select2" id="select_user"></select>
                        <input type="hidden" class="form-control" id="user">
                        <span class="message_error user_error text-red d-block"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_save_role_user">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
