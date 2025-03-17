<div class="modal fade" id="editPassModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <div class="row mx-2">
                    <div class="col-4 mt-2">
                        <label for="current_pass">Current Password</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="password" class="form-control" id="current_pass" aria-describedby="nameHelp">
                        <span class="message_error current_pass_error text-red d-block"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <label for="current_pass">New Password</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="password" class="form-control" id="new_pass" aria-describedby="nameHelp">
                        <span class="message_error new_pass_error text-red d-block"></span>
                    </div>
                    <div class="col-4 mt-2">
                        <label for="current_pass">Confirm Password</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="password" class="form-control" id="new_pass_confirmation" aria-describedby="nameHelp">

                        <span class="message_error new_pass_confirmation_error text-red d-block"></span>
                    </div>
                   
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_save_pass">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
