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
    .modal-backdrop {
        z-index: 1040 !important;
    }
    .modal {
        z-index: 1050 !important;
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
                            <button class="btn btn-sm btn-success" id="btn_add_request" data-bs-toggle="modal" data-bs-target="#addRequestModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="laporan_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>No Transaksi</th>
                                    <th>Tipe Pengajuan</th>
                                    <th>Satgas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('transaction.asset.laporan.modal.add-request')
    @include('transaction.asset.laporan.modal.edit-request')
    @include('transaction.asset.laporan.modal.update-asset')
@endsection

@push('js')
<script src="{{ asset('oppd/transaction/laporan.js') }}"></script>
@endpush
