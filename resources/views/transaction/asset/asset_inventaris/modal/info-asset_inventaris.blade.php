<div class="modal fade" id="infoAssetModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Informasi asset yang belum diperiksa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" id="form_serialize" enctype="multipart/form-data">
                <div class="modal-body p-0">
                    <div class="container mt-2 mx-2">
                        {{-- Multiple Asset --}}
                            <fieldset class="mt-4">
                                <legend>Asset List</legend>
                                
                                @can('get-except_satgas-asset_inventaris')
                                    <div class="row">
                                        <div class="col-12  col-sm-12 col-md-8">
                                            <fieldset class="mt-4 mx-2">
                                                <legend class="bg-danger">Filter </legend>
                                                <div class="row mt-2">
                                                    @can('get-except_satgas-asset_inventaris')
                                                    <div class="col-4 col-sm-4 col-md-1 mt-2">
                                                        <label for="info_select_satgas">Satgas</label>
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-5">
                                                        <select name="info_select_satgas" class="select2" id="info_select_satgas"></select>
                                                    </div>
                                                    @endcan
                                                    <div class="col-4 col-sm-4 col-md-1 mt-2">
                                                        <label for=""> Kondisi</label>
                                                    </div>
                                                    <div class="col-8 col-sm-8 col-md-5">
                                                        <select name="info_select_kondisi_filter" class="select2 " id="info_select_kondisi_filter">
                                                            <option value="">Pilih Kondisi</option>
                                                            <option value="1">BAIK</option>
                                                            <option value="2">RR OPS</option>
                                                            <option value="3">RB</option>
                                                            <option value="4">RR TDK OPS</option>
                                                            <option value="5">M</option>
                                                            <option value="6">D</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    @endcan 
                             
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="table-responsive" style="overflow-y: hidden">
                                            <table id="info_asset_table" class="table table-striped table-bordered text-nowrap">
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
                        {{-- Multiple Asset --}}

                       
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-success " type="submit" id="btn_save_inventaris">
                        <i class="fas fa-check"></i> Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

</script>