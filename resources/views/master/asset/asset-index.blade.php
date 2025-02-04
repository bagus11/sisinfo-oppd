@extends('garage._dashboard')
@section('content')
<style>
    #asset_table tbody tr {
    cursor: pointer;
    background-color: #B1F0F7 !important; 
    color: white !important;
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-core">
                    <div class="row">
                        <div class="col-8">
                            <strong>Asset List</strong>
                        </div>
                        <div class="col-4 d-flex justify-content-end">
                            @can('get-except_satgas-master_asset')
                            <button class="btn btn-sm btn-danger ml-2"  id="deleteButton">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button class="btn btn-sm btn-info" id="btn_upload_asset" style="margin-left:5px" data-bs-toggle="modal" data-bs-target="#uploadAssetModal">
                                <i class="fas fa-upload"></i>
                            </button>
                            <button class="btn btn-sm btn-success ml-2" style="margin-left:5px" id="btn_add_asset" data-bs-toggle="modal" data-bs-target="#addAssetModal">
                                <i class="fas fa-plus"></i>
                            </button>
                            @endcan
                            <div class="btn-group" style="margin-left:5px">
                                <button type="button" id="filter" class="btn btn-sm dropdown-toggle text-white" style="margin-left:5px" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fas fa-filter"></i>
                                </button>
                                <ul class="dropdown-menu animated flipInX" style="width: 300px">
                                    @can('get-except_satgas-master_asset')
                                    <li>
                                        <div class="row mx-2">
                                            <div class="col-4 mt-2">
                                                <label style="font-size:18px" for="">Satgas</label>
                                            </div>
                                            <div class="col-8">
                                                <select name="select_satgas" class="select2" id="select_satgas"></select>
                                            </div>
                                        </div>
                                      </li>
                                    @endcan
                                  <li class="mt-2">
                                    <div class="row mx-2">
                                        <div class="col-4 mt-2">
                                            <label style="font-size:18px" for="">Kondisi</label>
                                        </div>
                                        <div class="col-8">
                                            <select name="select_filter_kondisi" class="select2" id="select_filter_kondisi">
                                                <option value="">All Kondisi</option>
                                                <option value="1">BAIK</option>
                                                <option value="2">RR OPS</option>
                                                <option value="3">RB</option>
                                                <option value="4">RR TDK OPS</option>
                                                <option value="5">M</option>
                                                <option value="6">D</option>
                                            </select>
                                        </div>
                                    </div>
                                  </li>
                                  <li>
                                    <div class="row mx-2 mt-2">
                                        <div class="col-12">
                                            <button class="btn btn-danger btn-sm" id="filterAsset" style="float: right;margin-left:5px">
                                                <i class="fas fa-filter"></i> Filter
                                            </button>
                                            <button class="btn btn-success btn-sm" id="exportAsset"style="float: right;margin-left:5px">
                                                <i class="fas fa-file-excel"></i> Export 
                                            </button>
                                        </div>
                                    </div>
                                  </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-header p-0 mx-1 ">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="asset_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                    @can('get-except_satgas-master_asset')
                                        <th>
                                        <input type="checkbox" id="checkAllAsset">
                                        </th>
                                    @endcan
                                  <th>Asset Code</th>
                                  <th>No UN</th>
                                  <th>Kategori</th>
                                  <th>Sub Kategori</th>
                                  <th>Jenis</th>
                                  <th>Merk</th>
                                  <th>No Mesin</th>
                                  <th>No Rangka</th>
                                  <th>Satgas</th>
                                  <th>Lokasi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('master.asset.modal.add-asset')
    @include('master.asset.modal.upload-asset')
    @include('master.asset.modal.edit-asset')
    <script>
        // Pass the permission flag from the controller to JS
        var userHasPermission = @json($userHasPermission);
    </script>
    
@endsection

@push('js')
    <script src="{{ asset('oppd/master/asset.js') }}"></script>
@endpush
