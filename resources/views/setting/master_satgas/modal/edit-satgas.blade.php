<div class="modal fade" id="editSatgasModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Edit Satgas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <div class="modal-body p-0">
                    <div class="container mt-2">
                        <div class="row d-flex justify-content-end mb-2">
                            <div class="col-12">
                                <button class="btn btn-sm btn-warning" style="float:right" id="btn_edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-info" style="float:right" id="btn_cacel_edit">
                                    <i class="fa-regular fa-circle-xmark"></i>
                                </button>

                            </div>
                        </div>
                        <fieldset class="mb-2">
                            <legend>General Satgas</legend>
                            <div class="row">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="nama_edit">Nama</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <input type="text" class="form-control" id="nama_edit">
                                    <span class="message_error nama_error_edit text-red d-block"></span>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_tipe_edit">Type</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <select name="select_tipe_edit" class="select2" id="select_tipe_edit">
                                        <option value="">Pilih Satgas</option>
                                        <option value="UNIFIL">UNIFIL</option>
                                        <option value="KIZI MINUSCA">KIZI MINUSCA</option>
                                        <option value="BGC MONUSCO">BGC MONUSCO</option>
                                        <option value="KIZI MONUSCO">KIZI MONUSCO</option>
                                        <option value="BGC MONUSCO">BGC MONUSCO</option>
                                    </select>
                                    <input type="hidden" class="form-control" id="tipe_edit">
                                    <span class="message_error tipe_edit_error text-red d-block"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="">Negara</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <input type="text" class="form-control" id="negara_edit">
                                    <span class="message_error negara_edit_error text-red d-block"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="map_search_edit">Search</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <input type="text" id="map_search_edit" class="form-control" placeholder="Enter location">
                                    <span class="message_error search_error text-red d-block"></span>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div id="map_edit" style="height: 350px; border-radius: 20px;"></div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="x">Latitude</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <input type="text" class="form-control" id="x_edit" readonly>
                                    <span class="message_error x_edit_error text-red d-block"></span>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="y">Longitude</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <input type="text" class="form-control" id="y_edit" readonly>
                                    <span class="message_error y_edit_error text-red d-block"></span>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <div class="modal-footer container_label">
                    <button class="btn btn-sm btn-success" type="submit" id="btn_update_satgas">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            
        </div>
    </div>
</div>
<style>
    #map {
        border-radius: 20px !important;
    }
</style>