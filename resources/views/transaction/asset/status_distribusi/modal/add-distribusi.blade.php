
<div class="modal fade" id="addStatusDistribusiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Distribusi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body p-0">
                    <div class="container mt-2">
                        <div class="row">
                            <div class="col-6">
                                <fieldset class="mt-4 mx-2">
                                    <legend class="bg-danger">Filter </legend>
                                    <div class="row mt-2">
                                        <div class="col-4 col-sm-4 col-md-1 mt-2">
                                            <label for="select_satgas">Satgas</label>
                                        </div>
                                        <div class="col-md-4">
                                            <select name="select_satgas_filter" class="select2" id="select_satgas_filter"></select>
                                            <input type="hidden" class="form-control" id="satgas">
                                            <span class="message_error satgas_error text-red d-block"></span>
                                        </div>
                                        <div class="col-4 col-sm-4 col-md-1 mt-2">
                                            <label for=""> Kondisi</label>
                                        </div>
                                        <div class="col-8 col-sm-8 col-md-5">
                                            <select name="select_kondisi_filter" class="select2" id="select_kondisi_filter">
                                                <option value="">Pilih Kondisi</option>
                                                <option value="1">BAIK</option>
                                                <option value="2">RR OPS</option>
                                                <option value="3">RB</option>
                                                <option value="4">RR TDK OPS</option>
                                                <option value="5">M</option>
                                                <option value="6">D</option>
                                            </select>
                                            <input type="hidden" id="kondisi">
                                            <span class="message_error kondisi_name_error text-red d-block"></span>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                        <fieldset class="mt-4">
                            <legend>List Asset</legend>
                            <div class="row p-0">
                                <div class="col-12">
                                    <div class="table-responsive" style="overflow-y: hidden">
                                        <table id="asset_table" class="table table-striped table-bordered text-nowrap">
                                            <thead class="text-dark fs-1">
                                                <tr>
                                                    <th><input type="checkbox" id="check-all"></th>
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
                        <fieldset class="mt-4">
                            <legend>Form Input</legend>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive asset_array_container" style="overflow-y: hidden">
                                        <table id="asset_array_table" class="table table-striped table-bordered text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Asset Code</th>
                                                    <th>Kondisi</th>
                                                    <th>Satgas</th>
                                                    <th>No UN</th>
                                                    <th>Category</th>
                                                    <th>Sub-Category</th>
                                                    <th>Type</th>
                                                    <th>Merk</th>
                                                    <th>No Mesin</th>
                                                    <th>No Rangka</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_tujuan">Satgas Tujuan</label>
                                </div>
                                  <div class="col-7 col-sm-7 col-md-4">
                                    <select name="select_tujuan" class="select2" id="select_tujuan"></select>
                                    <input type="hidden" class="form-control" id="tujuan">
                                    <span class="message_error tujuan_error text-red d-block"></span>
                                </div>
                                {{-- <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_reporter">Reporter</label>
                                </div>
                                  <div class="col-7 col-sm-7 col-md-4">
                                    <select name="select_reporter" class="select2" id="select_reporter"></select>
                                    <input type="hidden" class="form-control" id="reporter">
                                    <span class="message_error reporter_error text-red d-block"></span>
                                </div> --}}
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="attachment">Attachment</label>
                                </div>
                                  <div class="col-7 col-sm-7 col-md-4">
                                   <input type="file" class="form-control" id="attachment" name="attachment">
                                      <span class="message_error attachment_error text-red d-block"></span>
                                </div>
                                
                            </div>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="remark">Catatan</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-10">
                                    <textarea class="form-control" id="catatan" rows="3"></textarea>
                                    <span class="message_error catatan_error text-red d-block"></span>
                                </div>
                            </div>
                        </fieldset>
                     
                    </div>
                </div>
                <div class="modal-footer container_label">
                    <button class="btn btn-sm btn-success" type="submit" id="btn_save_distribusi">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

</script>