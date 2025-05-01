<div class="modal fade" id="detailAssetModal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xxl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title" id="modal_title"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <input type="hidden" name="satgasTypeFilter" id="satgasTypeFilter">
                <input type="hidden" name="selectedKondisi" id="selectedKondisi">
                <fieldset class="mx-2">
                    <legend>Filter</legend>
                    <div class="row mx-2">
                        <div class="col-md-6 col-lg-5 d-flex align-items-center mt-2">
                            <label class="me-5 mb-0">Th Operasi</label>
                            <select name="select_th_operasi" class="select2 form-select w-100" id="select_th_operasi">
                                <option value="">All Condition</option>
                                <option value="1">< 5 Tahun</option>
                                <option value="2">5 - 10 Tahun</option>
                                <option value="3">> 10 Tahun</option>
                            </select>
                        </div>
                    
                        <div class="col-md-6 col-lg-5 d-flex align-items-center mt-2">
                            <label class="me-5 mb-0">Th Pembuatan</label>
                            <select name="select_th_pembuatan" class="select2 form-select w-100" id="select_th_pembuatan">
                                <option value="">All Condition</option>
                                <option value="1">< 5 Tahun</option>
                                <option value="2">5 - 10 Tahun</option>
                                <option value="3">> 10 Tahun</option>
                            </select>
                        </div>
                    
                        <div class="col-md-12 px-2 col-lg-2 d-flex justify-content-md-start justify-content-lg-end mt-2">
                            <button class="btn btn-danger mr-4 btn-sm" id="btn_filter_asset">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                            <button class="btn btn-success btn-sm" id="btn_export_asset">
                                <i class="fas fa-file"></i> Export
                            </button>
                        </div>
                    </div>
                    
                    
                    
                </fieldset>
                <p style="font-size: 16px; font-weight:bold" class="mx-4 mt-2">Total Asset: <span id="totalItemAsset">0</span> item</p>
                <div class="table-responsive" style="overflow-y: hidden">
                    <table id="asset_table" class="table table-striped table-bordered text-nowrap">
                        <thead class="text-dark fs-1">
                            <tr>
                                <th>Satgas</th>
                                <th>Lokasi</th>
                                <th>No UN</th>
                                <th>Kategori</th>
                                <th>Sub Kategori</th>
                                <th>Jenis</th>
                                <th>Merk</th>
                                <th>No Mesin</th>
                                <th>No Rangka</th>
                                <th>Th Pembuatan</th>
                                <th>Th Operasi</th>
                                <th>Kondisi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer"> 
            </div>
        </div>
    </div>
</div>
