<!-- Modal for Adding Folder -->
<div class="modal fade" id="addFileModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <form id="file-form">
                    <div class="row">
                        <div class="col-4 mt-2">
                            <label for="">Nama</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-4 mt-2">
                            <label for="type">Tipe</label>
                        </div>
                        <div class="col-8">
                            <select id="type" class="select2" name="type" required>
                                <option value="folder">Folder</option>
                                <option value="file">File</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2" id="file-upload-container" style="display: none;">
                        <div class="col-4 mt-2">
                            <label for="file">Upload File</label>
                        </div>
                        <div class="col-8">
                            <input type="file" id="file_upload_asset" name="file_upload_asset" class="form-control" accept=".xlsx,.xls,.csv,.doc,.docx,.pdf">
                        </div>
                    </div>
                    <input type="hidden" id="parent_id" name="parent_id" value="null">
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" type="submit" id="btn_save_file">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
