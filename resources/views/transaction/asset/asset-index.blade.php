@extends('garage._dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <strong>List Asset</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_asset" data-bs-toggle="modal" data-bs-target="#addAssetModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="asset_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                    <th>Satgas</th>
                                    <th>No UN</th>
                                    <th>Kategori</th>
                                    <th>Sub Kategori</th>
                                    <th>Jenis</th>
                                    <th>Merk</th>
                                    <th>No Mesin</th>
                                    <th>No Rangka</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  @include('transaction.asset.modal.add-asset')
@endsection

@push('js')
    <script src="{{ asset('oppd/transaction/asset.js') }}"></script>
@endpush
