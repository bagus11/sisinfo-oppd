<div class="modal fade" id="editAssetModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
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
            <div class="modal-body p-0 mx-2" data-simplebar="">
             
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div class="tab-pane active p-3" id="navpill-11" role="tabpanel">
                        @can('get-except_satgas-master_asset')
                        <div class="row d-flex justify-content-end">
                            <div class="col-12">
                                <button style="float:right;margin-left:5px" title="Print PDF" class="btn btn-sm btn-danger" id="btn_print_pdf">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </button>
                                <button style="float:right" title="Edit" class="btn btn-sm btn-warning" id="btn_edit_asset">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button style="float:right" title="Cancel Edit" class="btn btn-sm btn-info" id="btn_cancel_edit_asset">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </button>
                            </div>
                        </div>
                        @endcan
                      <div class="row mt-2">
                        
                          <div class="col-md-2 mt-2">
                              <label for="asset_code">Asset Code</label>
                          </div>
                          <div class="col-md-4 mb-2">
                              <input type="text" class="form-control" readonly id="asset_code" aria-describedby="nameHelp">
                              <span class="message_error asset_code_error text-red d-block"></span>
                          </div>
                          <div class="col-md-2 mt-2">
                              <label for="edit_no_un">No UN</label>
                          </div>
                          <div class="col-md-4 mb-2">
                              <input type="text" class="form-control" readonly id="edit_no_un" aria-describedby="nameHelp">
                              <span class="message_error edit_no_un_error text-red d-block"></span>
                          </div>
                          <div class="col-md-2 mt-2">
                              <label for="edit_no_mesin">No Mesin</label>
                          </div>
                          <div class="col-md-4 mb-2">
                              <input type="text" class="form-control" readonly id="edit_no_mesin" aria-describedby="nameHelp">
                              <span class="message_error edit_no_mesin_error text-red d-block"></span>
                          </div>
                          <div class="col-md-2 mt-2">
                              <label for="edit_no_rangka">No Rangka</label>
                          </div>
                          <div class="col-md-4 mb-2">
                              <input type="text" class="form-control" readonly id="edit_no_rangka" aria-describedby="nameHelp">
                              <span class="message_error edit_no_rangka_error text-red d-block"></span>
                          </div>
                          <div class="col-md-2 mt-2">
                              <label for="edit_select_kategori">Kategori</label>
                          </div>
                          <div class="col-md-4 mb-2">
                              <select name="edit_select_kategori" id="edit_select_kategori" class="select2">
                              </select>
                              <input type="hidden" id="edit_kategori">
                              <span class="message_error edit_kategori_error text-red d-block"></span>
                          </div>
                          <div class="col-md-2 mt-2">
                              <label for="edit_select_subkategori">Sub Kategory</label>
                          </div>
                          <div class="col-md-4 mb-2">
                              <select name="edit_select_subkategori" id="edit_select_subkategori" class="select2">
                              </select>
                              <input type="hidden" id="edit_subkategori">
                              <span class="message_error edit_subkategori_error text-red d-block"></span>
                          </div>
                          <div class="col-md-2 mt-2">
                              <label for="edit_select_jenis">Jenis</label>
                          </div>
                          <div class="col-md-4 mb-2">
                              <select name="edit_select_jenis" id="edit_select_jenis" class="select2">
                              </select>
                              <input type="hidden" id="edit_jenis">
                              <span class="message_error edit_jenis_error text-red d-block"></span>
                          </div>
                          <div class="col-md-2 mt-2">
                              <label for="edit_select_brand">Merk</label>
                          </div>
                          <div class="col-md-4 mb-2">
                              <select name="edit_select_brand" id="edit_select_brand" class="select2">
                              </select>
                              <input type="hidden" id="edit_merk">
                              <span class="message_error edit_merk_error text-red d-block"></span>
                          </div>
                      </div>
                      <div class="row d-flex justify-content-end">
                       <div class="col-1 offset-11">
                        <button class="btn btn-sm btn-success" id="btn_update_asset" >
                            <i class="fas fa-check"></i>
                        </button>
                       </div>
                      </div>
                    </div>
                    <div class="tab-pane p-3" id="navpill-22" role="tabpanel">
                      <div class="row">
                            <div class="col-12">
                                <div class="table-responsive" style="overflow-y: hidden">
                                    <table id="asset_table_log" class="table table-striped table-bordered text-nowrap">
                                        <thead class="text-dark fs-1">
                                            <tr>
                                                <th>Created At</th>
                                                <th>PIC Name</th>
                                                <th>Satgas</th>
                                                <th>No UN</th>
                                                <th>Category</th>
                                                <th>Sub-category</th>
                                                <th>Type</th>
                                                <th>Merk</th>
                                                <th>No Mesin</th>
                                                <th>No Rangka</th>
                                                <th>Kondisi</th>
                                                <th>Remark</th>
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
