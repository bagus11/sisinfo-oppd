<div class="modal fade" id="addAssetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pemutahiran Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body p-0">
                    <div class="container mt-2 mx-2">
                        <fieldset class="mb-2">
                            <legend>General Asset</legend>
                            <div class="row">
                                {{-- <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_type">Type</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="select_type" class="select2" id="select_type">
                                        <option value="">Pilih Tipe</option>
                                        <option value="1">Single Asset</option>
                                        <option value="2">Multiple Asset</option>
                                    </select>
                                    <input type="hidden" class="form-control" id="type">
                                    <span class="message_error type_error text-red d-block"></span>
                                </div> --}}
                                @can('get-except_satgas-asset_inventaris')
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_satgas">Satgas</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="select_satgas" class="select2" id="select_satgas"></select>
                                    <input type="hidden" class="form-control" id="satgas">
                                    <span class="message_error satgas_error text-red d-block"></span>
                                </div>
                                @endcan 
                            </div>
                            <div class="row">
                                {{-- <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="bulan">Bulan</label>
                                </div>
                                <div class="col-md-4">
                                    <input type="date" class="form-control" id="bulan" value="{{date('Y-m-d')}}">
                                    <span class="message_error bulan_error text-red d-block"></span>
                                </div>
                             --}}
                            </div>
                            <div class="row mt-2">
                                {{-- <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="select_reporter">Reporter</label>
                                </div>
                                <div class="col-md-4">
                                    <select name="select_reporter" class="select2" id="select_reporter"></select>
                                    <input type="hidden" class="form-control" id="reporter">
                                    <span class="message_error reporter_error text-red d-block"></span>
                                </div> --}}
                                <div class="col-5 col-sm-5 col-md-2 mt-2 select_asset_container" >
                                    <label for="select_asset">Asset Product</label>
                                </div>
                                <div class="col-md-4 select_asset_container">
                                    <select name="select_asset" class="select2" id="select_asset"></select>
                                    <input type="hidden" class="form-control" id="asset">
                                    <span class="message_error asset_error text-red d-block"></span>
                                </div>
                            </div>
                        </fieldset>
                        {{-- Multiple Asset --}}
                            <fieldset class="mt-4 multiple_asset_container">
                                <legend>Asset List</legend>
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
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2" id="array_table_asset">
                                    <div class="col-12">
                                        <div class="table-responsive" style="overflow-y: hidden">
                                            <table id="asset_array_table" class="table table-striped table-bordered text-nowrap">
                                                <thead class="text-dark fs-1">
                                                    <tr>
                                                        <th>Action</th>
                                                        <th>Asset Code</th>
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
                        {{-- Multiple Asset --}}
                        <fieldset class="mt-4 container_label">
                            <legend>Detail Asset</legend>
                            <div class="row mt-2">
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="label_asset_code">Asset Code</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label id="label_asset_code"></label>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="label_no_un">No UN</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label id="label_no_un"></label>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="label_no_rangka">No Rangka</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label id="label_no_rangka"></label>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="label_no_mesin">No Mesin</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label id="label_no_mesin"></label>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="label_kategori">Kategori</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label id="label_kategori"></label>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="label_sub_kategori">Sub Kategori</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label id="label_sub_kategori"></label>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="label_jenis">Jenis</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label id="label_jenis"></label>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="label_merk">Merk</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label id="label_merk"></label>
                                </div>
                                <div class="col-5 col-sm-5 col-md-2">
                                    <label for="">Kondisi</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <label for="" id="label_kondisi"></label>
                                </div>
                            </div>
                        </fieldset>
    
                        <fieldset class="update_container   mt-4">
                            <legend>Update Kondisi Aset</legend>
                            <div class="row">
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for=""> Kondisi</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <select name="select_kondisi" class="select2" id="select_kondisi">
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
                                <div class="col-5 col-sm-5 col-md-2 mt-2">
                                    <label for="">Attachment</label>
                                </div>
                                <div class="col-7 col-sm-7 col-md-4">
                                    <input type="file" class="form-control" id="attachment">
                                    <span class="message_error attachment_name_error text-red d-block"></span>
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
                    <button class="btn btn-sm btn-success update_container " type="submit" id="btn_save_inventaris">
                        <i class="fas fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

</script>