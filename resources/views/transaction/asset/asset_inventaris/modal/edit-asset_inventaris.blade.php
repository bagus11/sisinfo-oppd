<div class="modal fade" id="editAssetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header p-0 mx-2 pt-2">
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-pills flex-column flex-sm-row mt-4" id="tablist" role="tablist" style="margin-top: 1px !important">
                            <li class="nav-item flex-sm-fill text-sm-center">
                              <a class="nav-link active" data-bs-toggle="tab" href="#navpill-11" role="tab">
                                 <i class="fa-solid fa-circle-info fa-xs"></i> <span style="font-size: 12px !important">General Information</span>
                              </a>
                            </li>
                            <li class="nav-item flex-sm-fill text-sm-center" style="margin-left: 10px !important">
                              <a class="nav-link" data-bs-toggle="tab" href="#navpill-22" role="tab">
                                 <i class="fa-solid fa-clock-rotate-left fa-xs"></i> <span style="font-size: 12px !important"> Log Transaksi</span>
                              </a>
                            </li>
                          </ul>
                    </div>
                </div>
                <button type="button" class="btn-close" style="margin-right: 5px" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="tab-content">
                    <div class="tab-pane active p-3" id="navpill-11" role="tabpanel">
                       
                            <div class="mt-2">
                                <div class="row">
                                    <div class="col-12">
                                        <button style="float:right;margin-left:5px" title="Print PDF" class="btn btn-sm btn-danger" id="btn_print_pdf">
                                            <i class="fa-solid fa-file-pdf"></i>
                                        </button>
                                    </div>
                                </div>
                            <form class="form" id="form_serialize" enctype="multipart/form-data">
                                <fieldset class="general_asset">
                                    <legend>General Information</legend>
                                    <div class="row mx-2">
                                        <div class="col-5 col-sm-5 col-md-2">
                                            <label for="">Asset Code</label>
                                        </div>
                                        <div class="col-7 col-sm-7 col-md-4">
                                            <label id="update_label_asset_code"></label>
                                            <input type="hidden" id="update_asset_code">
                                            <input type="hidden" id="update_inventaris_code">
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
                                        <div class="col-5 col-sm-5 col-md-2 mt-2">
                                            <label for="">Kondisi</label>
                                        </div>
                                        <div class="col-7 col-sm-7 col-md-4">
                                            <select name="select_update_kondisi" class="select2" id="select_update_kondisi">
                                                <option value="">Pilih Kondisi</option>
                                                    <option value="1">BAIK</option>
                                                    <option value="2">RR OPS</option>
                                                    <option value="3">RB</option>
                                                    <option value="4">RR TDK OPS</option>
                                                    <option value="5">M</option>
                                                    <option value="6">D</option>
                                            </select>
                                            <input type="hidden" id="update_kondisi">
                                            <span class="message_error update_kondisi_error text-red d-block"></span>
                                        </div>
                                        <div class="col-5 col-sm-5 col-md-2 mt-2">
                                            <label for="">Attachment</label>
                                        </div>
                                        <div class="col-7 col-sm-7 col-md-4">
                                         <input type="file" class="form-control" id="update_attachment">
                                        </div>
                                    </div>
                                    <div class="row mx-2 mt-2">
                                        <div class="col-4 col-sm-4 col-md-2 mt-2">
                                            <label for="">Alasan</label>
                                        </div>
                                        <div class="col-8 col-sm-8 col-md-10 mt-2">
                                            <textarea class="form-control" id="update_catatan" rows="3"></textarea>
                                            <span class="message_error update_catatan_error text-red d-block"></span>
                                        </div>
                                    </div>
                                    <div class="row mt-2 mx-2 justify-item-end d-flex">
                                        <div class="col-12">
                                            <button class="btn btn-sm btn-success" id="btn_update_kondisi" style="float: right">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </div>

                                        </button>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="mt-4 p-0">
                                <fieldset>
                                    <legend>List Asset</legend>
                                    <div class="table-responsive p-0" style="overflow-y: hidden">
                                        <table id="detailTableAsset" class="table table-striped table-bordered text-nowrap">
                                            <thead class="text-dark fs-1">
                                              <tr>
                                                  <th>Action</th>
                                                  <th>Kondisi</th>
                                                  <th>Satgas</th>
                                                  <th>No UN</th>
                                                  <th>Kategori</th>
                                                  <th>Sub Kategori</th>
                                                  <th>Jenis</th>
                                                  <th>Merk</th>
                                                  <th>No Mesin</th>
                                                  <th>No Rangka</th>
                                                  <th>Catatan</th>
                                                  <th>Attachment</th>
                                              </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </fieldset>
                            </div>
                           
                        </form>
                    </div>
                    <div class="tab-pane p-3" id="navpill-22" role="tabpanel">
                        <div class="row">
                              <div class="col-12">
                                   <div class="table-responsive" style="overflow-y: hidden">
                                      <table id="inventaris_table_log" class="table table-striped table-bordered text-nowrap">
                                          <thead class="text-dark fs-1">
                                            <tr>
                                                <th>Created At</th>
                                                <th>User Name</th>
                                                <th>Satgas</th>
                                                <th>Bulan</th>
                                                <th>Asset Code</th>
                                                <th>Catatan</th>
                                                <th>Attachment</th>
                                                <th>Kondisi</th>
                                            </tr>
                                          </thead>
                                          <tbody></tbody>
                                      </table>
                                  </div>
                              </div>
                        </div>
                    </div>
                </div>
              
            </div>
        </div>
    </div>
</div>
<script>

</script>