<div class="modal fade" id="uploadAssetModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <form id="uploadAssetForm" method="POST" action="{{ route('uploadAsset') }}" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Asset</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <fieldset>
                        <legend>Form Upload Master Asset</legend>
                        <div class="row mx-2 mt-2">
                            <label>Download format upload data:
                                <a href="{{ asset('docs/ImportDataInventory.xlsx') }}" style="color: green">
                                    <i class="fa-solid fa-file-excel"></i> Master Inventory.xlsx
                                </a>
                            </label>
                        </div>
                        <div class="row mx-2 mt-4 mb-2">
                            <div class="col-4 mt-2">
                                <label for="file_upload_asset">Attachment</label>
                            </div>
                            <div class="col-8">
                                <input type="file" name="file_upload_asset" class="form-control" id="file_upload_asset" required>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-success" id="btn_save_asset">
                        <i class="fas fa-check"></i> Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
