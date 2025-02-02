<div class="modal fade" id="updateRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nestedModalLabel">Form Update Kondisi Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <fieldset>
                    <legend>General Information</legend>
                   
                    <div class="row mx-2">
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="">Asset Code</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label id="update_label_asset_code"></label>
                            <input type="hidden" id="update_asset_code">
                        </div>
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="update_label_no_un">No UN</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label id="update_label_no_un"></label>
                        </div>
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="update_label_no_rangka">No Rangka</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label id="update_label_no_rangka"></label>
                        </div>
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="update_label_no_mesin">No Mesin</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label id="update_label_no_mesin"></label>
                        </div>
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="update_label_kategori">Kategori</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label id="update_label_kategori"></label>
                        </div>
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="update_label_sub_kategori">Sub Kategori</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label id="update_label_sub_kategori"></label>
                        </div>
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="update_label_jenis">Jenis</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label id="update_label_jenis"></label>
                        </div>
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="update_label_merk">Merk</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label id="update_label_merk"></label>
                        </div>
                        <div class="col-5 col-sm-5 col-md-2">
                            <label for="">Kondisi</label>
                        </div>
                        <div class="col-7 col-sm-7 col-md-4">
                            <label for="" id="update_label_kondisi"></label>
                        </div>
                     
                    </div>
                </fieldset>
                <fieldset class="mt-4">
                    <legend>Update Kondisi</legend>
                  
                    <div class="row mt-2 mx-2">
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <label for="">Update Kondisi</label>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4 mt-2">
                            <span style="text-align:center" class="mb-1 badge rounded bg-success" style="font-size: 10px !important">DONE</span>
                        </div>
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <label for="">Attachment</label>
                        </div>
                        <div class="col-8 col-sm-8 col-md-4">
                            <input type="file" class="form-control" id="update_attachment">
                        </div>
                    </div>
                    <div class="row mt-2 mx-2">
                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                            <label for="">Catatan</label>
                        </div>
                        <div class="col-8 col-sm-8 col-md-10">
                            <textarea class="form-control" id="update_catatan" rows="3"></textarea>
                            <span class="message_error update_catatan_error text-red d-block"></span>   
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-sm btn-success" id="btn_update_asset">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
