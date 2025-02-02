@extends('garage._dashboard')
@section('content')
<style>
</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <strong>Data Personalia</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-info" id="btn_add_asset" data-bs-toggle="modal" data-bs-target="#addAssetModal">
                                <i class="fas fa-upload"></i>
                            </button>
                            <button class="btn btn-sm btn-success" style="margin-left:5px" id="btn_add_asset" data-bs-toggle="modal" data-bs-target="#addAssetModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-header p-0 mx-1">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="personalia_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                 <th>NIK</th>
                                 <th>Nama</th>
                                 <th>Satgas</th>
                                 <th>Jabatan</th>
                                 <th>Tanggal Gabung</th>
                                 <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('oppd/transaction/personalia.js') }}"></script>
@endpush
