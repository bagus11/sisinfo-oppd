<div class="modal fade" id="editImageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Profile Picture</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <div class="row">
                    <div class="col-3 mt-2">
                        <p>Current Image</p>
                    </div>
                    <div class="col-9">
                        <input type="file" class="form-control" id="profileImageInput" name="profile_image">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="container">
                        <div class="col-12" id="cropContainer" style="display:none;">
                            <img id="cropImage" style="max-width: 100%;">
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="cropButton" class="btn btn-success" style="font-size: 12px">
                    <i class="fas fa-check"></i> Save
                </button>
            </div>
        </div>
    </div>
</div>
