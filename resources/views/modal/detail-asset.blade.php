<div class="modal fade" id="detailAssetModal" tabindex="-1" aria-hidden="true">
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
                    <div class="row mx-2 d-flex justify-content-start">
                        <div class="col-1 mt-2">
                            <label for="">Th Operasi</label>
                        </div>
                        <div class="col-2 mt-2">
                            <select name="select_th_operasi" class="select2" id="select_th_operasi">
                                <option value="">All Condition</option>
                                <option value="1">< 5 Tahun</option>
                                <option value="2">5 - 10 Tahun</option>
                                <option value="3">> 10 Tahun</option>
                            </select>
                        </div>
                        <div class="col-1 mt-2">
                            <label for="">Th Pembuatan</label>
                        </div>
                        <div class="col-2 mt-2">
                            <select name="select_th_pembuatan" class="select2" id="select_th_pembuatan">
                                <option value="">All Condition</option>
                                <option value="1">< 5 Tahun</option>
                                <option value="2">5 - 10 Tahun</option>
                                <option value="3">> 10 Tahun</option>
                            </select>
                        </div>
                        <div class="col-1 mt-2">
                            <button class="btn btn-sm btn-danger" id="btn_filter_asset">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </div>
                </fieldset>
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
