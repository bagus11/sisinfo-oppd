@extends('garage._dashboard')
@section('content')
<style>
    #inventaris_table tbody tr {
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
                        <div class="col-9">
                            <strong>List Transaksi</strong> 
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_asset" data-bs-toggle="modal" data-bs-target="#addAssetModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                   
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="inventaris_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                  <th>Tanggal</th>
                                  <th>Satgas</th>
                                  <th>Total Aset</th>
                                  <th>Kondisi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('transaction.asset.asset_inventaris.modal.add-asset_inventaris')
    @include('transaction.asset.asset_inventaris.modal.image-asset_inventaris')
    @include('transaction.asset.asset_inventaris.modal.edit-asset_inventaris')
@endsection

@push('js')
<script src="{{ asset('oppd/transaction/inventaris_asset.js') }}"></script>
@endpush
