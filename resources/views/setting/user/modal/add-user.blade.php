<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add User</h5>
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
                        <label for="">Lokasi</label>
                    </div>
                    <div class="col-8">
                        <select name="select_location" class="select2" id="select_location"></select>
                        <input type="hidden" class="form-control" id="location" aria-describedby="location">
                        <span class="message_error location_error text-red d-block"></span>
                    
                    </div>     
                </div>
                <div class="row mx-2 mt-2">
                    <div class="col-4 mt-2">
                        <label for="">Position</label>
                    </div>
                    <div class="col-8">
                        <select name="select_position" class="select2" id="select_position"></select>
                        <input type="hidden" class="form-control" id="position" aria-describedby="nameHelp">
                        <span class="message_error position_error text-red d-block"></span>
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
