<div class="modal fade" id="addAssetModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Asset</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <div class="row mx-2">
                    <div class="col-4">
                        <label  class="col-form-label" for="no_un">Lokasi</label>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_lokasi"  class="select2"  id="select_lokasi"></select>
                        <input type="hidden" class="form-control" id="lokasi" aria-describedby="nameHelp">
                        <span class="message_error lokasi_error text-red d-block"></span>
                    </div>
                    <div class="col-4">
                        <label  class="col-form-label" for="no_un">No UN</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" class="form-control" id="no_un" aria-describedby="nameHelp">
                        <span class="message_error no_un_error text-red d-block"></span>
                    </div>
                    <div class="col-4">
                        <label  class="col-form-label" for="no_mesin">No Mesin</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" class="form-control" id="no_mesin" aria-describedby="nameHelp">
                        <span class="message_error no_mesin_error text-red d-block"></span>
                    </div>
                    <div class="col-4">
                        <label  class="col-form-label" for="no_rangka">No Rangka</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" class="form-control" id="no_rangka" aria-describedby="nameHelp">
                        <span class="message_error no_rangka_error text-red d-block"></span>
                    </div>
                    <div class="col-4">
                        <label  class="col-form-label" for="select_kategori">Kategori</label>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_kategori" id="select_kategori" class="select2">
                        </select>
                        <input type="hidden" id="kategori">
                        <span class="message_error kategori_error text-red d-block"></span>
                    </div>
                    <div class="col-4">
                        <label  class="col-form-label" for="select_subkategori">Sub Kategory</label>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_subkategori" id="select_subkategori" class="select2">
                        </select>
                        <input type="hidden" id="subkategori">
                        <span class="message_error subkategori_error text-red d-block"></span>
                    </div>
                    <div class="col-4">
                        <label  class="col-form-label" for="select_jenis">Jenis</label>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_jenis" id="select_jenis" class="select2">
                        </select>
                        <input type="hidden" id="jenis">
                        <span class="message_error jenis_error text-red d-block"></span>
                    </div>
                    <div class="col-4">
                        <label  class="col-form-label" for="select_brand">Merk</label>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_brand" id="select_brand" class="select2">
                        </select>
                        <input type="hidden" id="merk">
                        <span class="message_error merk_error text-red d-block"></span>
                    </div>
                  
                    <div class="col-4">
                        <label for="th_pembuatan" class="col-form-label">Th Pembuatan</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="th_pembuatan" id="th_pembuatan" class="form-control yearpicker" required readonly>
                        <span class="message_error th_pembuatan_error text-danger d-block"></span>
                    </div>
                    
                    <div class="col-4">
                        <label for="th_operasi" class="col-form-label">Th Operasi</label>
                    </div>
                    <div class="col-8 mb-2">
                        <input type="text" name="th_operasi" id="th_operasi" class="form-control yearpicker" required readonly>
                        <span class="message_error th_operasi_error text-danger d-block"></span>
                    </div>

                    <div class="col-4">
                        <label for="kondisi" class="col-form-label">Kondisi</label>
                    </div>
                    <div class="col-8 mb-2">
                        <select name="select_kondisi" class="select2" id="select_kondisi">
                            <option value="">Pilih Kondisi</option>
                            <option value="1">BAIK</option>
                            <option value="2">RR OPS</option>
                            <option value="3">RB</option>
                            <option value="4">RR TDK OPS</option>
                            <option value="5">M</option>
                            <option value="6">D</option>
                        </select>
                        <input type="hidden" name="kondisi" id="kondisi" class="form-control yearpicker" required readonly>
                        <span class="message_error kondisi_error text-danger d-block"></span>
                    </div>
                    
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-sm btn-success" id="btn_save_asset">
                    <i class="fas fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
