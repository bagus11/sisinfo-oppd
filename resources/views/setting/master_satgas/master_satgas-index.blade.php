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
                            <strong>List Satgas</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_satgas" data-bs-toggle="modal" data-bs-target="#addSatgasModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="satgas_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                  <th>Nama</th>
                                  <th>Type</th>
                                  <th>Negara</th>
                                  <th>X</th>
                                  <th>Y</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('setting.master_satgas.modal.add-satgas')
    @include('setting.master_satgas.modal.edit-satgas')
@endsection
@push('js')
<script src="{{ asset('oppd/setting/master_satgas.js') }}"></script>
@endpush
