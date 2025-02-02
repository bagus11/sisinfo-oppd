<style>
    #edit_asset_table {
    table-layout: fixed;
    width: 100%;
}
</style>

<div class="modal fade" id="editRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body p-0">
                    <div class="container mt-2">
                        <fieldset class="mb-2">
                            <legend>General Asset</legend>
                           <div class="row">
                                <div class="col-4 col-sm-4 col-md-2 mt-2">
                                    <label for="">No Transaksi</label>
                                </div>
                                <div class="col-8 col-sm-8 col-md-4">
                                    <input type="text" id="edit_request_code" class="form-control">
                                    <span class="message_error edit_request_code_error text-red d-block"></span>
                                </div>
                                <div class="col-4 col-sm-4 col-md-2 mt-2">
                                    <label for="">Jenis Pengajuan</label>
                                </div>
                                <div class="col-8 col-sm-8 col-md-4">
                                    <select class="select2" name="edit_select_type" id="edit_select_type">
                                        <option value="">Pilih Jenis Pengajuan</option>
                                        <option value="1">Pengajuan Perbaikan</option>
                                        <option value="2">Pengajuan Penggantian</option>
                                    </select>
                                    <input type="hidden" id="edit_type" class="form-control">
                                    <span class="message_error edit_type_error text-red d-block"></span>
                                </div>
                           </div>
                           <div class="row mt-2">
                            <div class="col-4 col-sm-4 col-md-2 mt-2">
                                <label for="">Reporter</label>
                            </div>
                            <div class="col-8 col-sm-8 col-md-4">
                                <select class="select2" name="edit_select_reporter" id="edit_select_reporter"></select>
                                <input type="hidden" id="edit_reporter" class="form-control">
                                <span class="message_error edit_request_code_error text-red d-block"></span>
                            </div>
                            <div class="col-4 col-sm-4 col-md-2 mt-2">
                                <label for="">Attachment</label>
                            </div>
                            <div class="col-8 col-sm-8 col-md-4 mt-3">
                                <p id="edit_attachment"></p>
                            </div>
                           </div>
                           <div class="row mt-2">
                            <div class="col-4 col-sm-4 col-md-2 mt-2">
                                <label for="remark">Catatan</label>
                            </div>
                            <div class="col-8 col-sm-8 col-md-10">
                                <textarea class="form-control" id="edit_catatan" rows="3"></textarea>
                                <span class="message_error edit_catatan_error text-red d-block"></span>
                            </div>
                           </div>
                        </fieldset>
                        
                        <fieldset class="mt-4">
                            <legend>Detail Asset</legend>
                            <div class="table-responsive" style="overflow-y: hidden">
                                <table id="edit_asset_table" class="table table-striped table-bordered text-nowrap">
                                    <thead class="text-dark fs-1">
                                        <tr>
                                            <th>Status</th>
                                            <th>Kondisi</th>
                                            <th>Attachment</th>
                                            <th>Satgas</th>
                                            <th>No UN</th>
                                            <th>Kategori</th>
                                            <th>Sub Kategori</th>
                                            <th>Jenis</th>
                                            <th>Merk</th>
                                            <th>No Mesin</th>
                                            <th>No Rangka</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer">
                  
                </div>
        </div>
    </div>
</div>