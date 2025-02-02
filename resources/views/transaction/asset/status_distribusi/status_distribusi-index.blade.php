@extends('garage._dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-core">
                    <div class="row">
                        <div class="col-9">
                            <strong>List Distribusi</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_distribusi" data-bs-toggle="modal" data-bs-target="#addStatusDistribusiModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="status_distribusi_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                   <th></th>
                                   <th>No Transaksi</th>
                                   <th>Destinasi Lokasi</th>
                                   <th>Lokasi Asal</th>
                                   <th>Status</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('transaction.asset.status_distribusi.modal.add-distribusi')
    @include('transaction.asset.status_distribusi.modal.detail-distribusi')
@endsection
@push('js')
    <script src="{{ asset('oppd/transaction/status_distribusi.js') }}"></script>
@endpush
