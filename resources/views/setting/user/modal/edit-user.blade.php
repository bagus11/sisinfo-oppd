<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <div class="row mx-2">
                    <div class="col-4 mt-2">
                        <label for="edit_name">Name</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="hidden" class="form-control" id="edit_id" aria-describedby="nameHelp">
                        <input type="text" class="form-control" id="edit_name" aria-describedby="nameHelp">
                        <span class="message_error edit_name_error text-red d-block"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <label for="">Lokasi</label>
                    </div>
                    <div class="col-8">
                        <select name="edit_select_location" class="select2" id="edit_select_location"></select>
                        <input type="hidden" class="form-control" id="edit_location" aria-describedby="edit_location">
                        <span class="message_error edit_location_error text-red d-block"></span>
                    
                    </div>     
                </div>
                <div class="row mx-2 mt-2">
                    <div class="col-4 mt-2">
                        <label for="">Position</label>
                    </div>
                    <div class="col-8">
                        <select name="edit_select_position" class="select2" id="edit_select_position"></select>
                        <input type="hidden" class="form-control" id="edit_position" aria-describedby="nameHelp">
                        <span class="message_error edit_position_error text-red d-block"></span>
                    </div>
                </div>
                <div class="row mx-2 mt-2">
                    <div class="col-4 mt-2">
                        <label for="edit_name">NRP</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" class="form-control" id="edit_nrp" aria-describedby="nameHelp" >
                        <span class="message_error edit_nrp_error text-red d-block"></span>
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
