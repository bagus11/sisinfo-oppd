<div class="modal fade" id="addRequestModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pengajuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body p-0">
                    <div class="container mt-2">
                        <fieldset class="mb-2">
                            <legend>General Asset</legend>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_type">Jenis Pengajuan</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="select_type" class="select2" id="select_type">
                                        <option value="">Pilih Jenis Pengajuan</option>
                                        <option value="1">Pengajuan Perbaikan</option>
                                        <option value="2">Pengajuan Penggantian</option>
                                    </select>
                                    <input type="hidden" class="form-control" id="type">
                                    <span class="message_error type_error text-red d-block"></span>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_reporter">Reporter</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="select_reporter" class="select2" id="select_reporter"></select>
                                    <input type="hidden" class="form-control" id="reporter">
                                    <span class="message_error reporter_error text-red d-block"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="table-responsive" style="overflow-y: hidden">
                                        <table id="asset_table" class="table table-striped table-bordered text-nowrap">
                                            <thead class="text-dark fs-1">
                                                <tr>
                                                    <th></th>
                                                    <th>Kondisi</th>
                                                    <th>Satgas</th>
                                                    <th>No UN</th>
                                                    <th>Kategori</th>
                                                    <th>Sub Kategori</th>
                                                    <th>Jenis</th>
                                                    <th>Merk</th>
                                                    <th>No Mesin</th>
                                                    <th>No Rangka</th>
                                                    <th>Attachment</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2" id="array_table_request">
                                <div class="col-12">
                                    <div class="table-responsive" style="overflow-y: hidden">
                                        <table id="asset_array_table" class="table table-striped table-bordered text-nowrap">
                                            <thead class="text-dark fs-1">
                                                <tr>
                                                    <th>Asset Code</th>
                                                    <th>Satgas</th>
                                                    <th>Kondisi</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="attachment">Attachment</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <input type="file" class="form-control" id="attachment">
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
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success" type="submit" id="btn_save_request">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

</script>