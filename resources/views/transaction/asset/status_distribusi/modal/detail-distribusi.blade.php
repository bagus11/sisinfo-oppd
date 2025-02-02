<div class="modal fade" id="detailDistribusiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                 <i class="fa-solid fa-clock-rotate-left fa-xs"></i> <span style="font-size: 12px !important"> Track Location</span>
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
                        <div class="container mt-2">
                            <input type="hidden" id="distribution_code">
        
                            <!-- General Information Section -->
                            <fieldset class="mb-2">
                                <legend>General Information</legend>
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>No Transaksi</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="edit_label_distribution_code"></label>
                                    </div>
        
                                    <div class="col-md-2">
                                        <label>Lokasi Tujuan</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="edit_label_lokasi_tujuan"></label>
                                    </div>
        
                                    <div class="col-md-2">
                                        <label>Lokasi Sekarang</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="edit_label_lokasi_sekarang"></label>
                                    </div>
        
                                    <div class="col-md-2">
                                        <label>Reporter</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="edit_label_reporter"></label>
                                    </div>
        
                                    <div class="col-md-2">
                                        <label>Status</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="edit_label_status"></label>
                                    </div>
        
                                    <div class="col-md-2">
                                        <label>Attachment</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="edit_label_attachment"></label>
                                    </div>
        
                                    <div class="col-md-2">
                                        <label>Catatan</label>
                                    </div>
                                    <div class="col-md-4">
                                        <label id="edit_label_catatan"></label>
                                    </div>
                                </div>
                            </fieldset>
        
                            <!-- Detail Asset Section -->
                            <fieldset class="mt-4 mb-2">
                                <legend>List Asset</legend>
                                <div class="row p-0">
                                    <div class="col-12">
                                        <div class="table-responsive" style="overflow-y: hidden">
                                            <table id="asset_table_detail" class="table table-striped table-bordered text-nowrap">
                                                <thead class="text-dark fs-1">
                                                    <tr>
                                                        <th>Asset Code</th>
                                                        <th>Kondisi</th>
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
                                    </div>
                                </div>
                            </fieldset>
        
                            <!-- Status 0 Actions -->
                            <div id="status-0" class="mx-2">
                                <button class="btn btn-success btn-sm mt-2" id="start_progress" style="float:right; margin-bottom:10px;">
                                    <i class="fa-solid fa-paper-plane"></i> Proses
                                </button>
                            </div>
        
                            <!-- Form Update Section -->
                            <div id="status-1" class="mx-2 mt-4 mb-4">
                                <form class="form" id="form_serialize" enctype="multipart/form-data">
                                    <fieldset>
                                        <legend>Form Update</legend>
                                        <div class="row">
                                            <div class="col-md-2 mt-2">
                                                <label>Status</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="update_select_status" id="udpate_select_status" class="select2">
                                                    <option value="">Pilih Status</option>
                                                    <option value="1">On Progress</option>
                                                    <option value="2">Delivery Confirmation</option>
                                                </select>
                                                <input type="hidden" id="update_status">
                                                <span class="message_error update_status_error text-danger d-block"></span>
                                            </div>
                                            <div class="col-md-2 mt-2">
                                                <label>Attachment</label>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="file" class="form-control" id="update_attachment">
                                                <span class="message_error update_attachment_error text-danger d-block"></span>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-2 mt-2">
                                                <label>Catatan</label>
                                            </div>
                                            <div class="col-md-10">
                                                <textarea class="form-control" id="update_catatan" rows="3"></textarea>
                                                <span class="message_error update_catatan_error text-danger d-block"></span>
                                            </div>
                                        </div>
        
                                        <div class="row mt-2">
                                            <div class="col-md-12">
                                                <button class="btn btn-success btn-sm" type="submit" id="btn_update_distribusi" style="float: right">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane p-3" id="navpill-22" role="tabpanel">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div id="map" style="height: 350px; border-radius: 20px;"></div>
                            </div>
                        </div>
                        <div class="row">
                              <div class="col-12">
                                   <div class="table-responsive" style="overflow-y: hidden">
                                      <table id="distribusi_log_table" class="table table-striped table-bordered text-nowrap">
                                          <thead class="text-dark fs-1">
                                            <tr>
                                                <th>Created At</th>
                                                <th>User Name</th>
                                                <th>Kondisi</th>
                                                <th>Status</th>
                                                <th>Attachment</th>
                                                <th>Catatan</th>
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
<style>
    #map {
    height: 400px;
    width: 100%;
}
#tablist .nav-link.active {
        background-color: #179BAE !important;
        color: white !important;
        border-color: #179BAE !important;
    }
    #tablist .nav-link {
        color: white !important; 
        background-color: #BCCCDC !important;
    }
</style>