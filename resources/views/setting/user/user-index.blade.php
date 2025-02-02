@extends('garage._dashboard')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <strong>List User</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success"  data-bs-toggle="modal" data-bs-target="#addUserModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="user_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                    <th></th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>NIK</th>
                                    <th>Posisi</th>
                                    <th>Lokasi</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('setting.user.modal.add-user')
    @include('setting.user.modal.edit-user')
@endsection

@push('js')
    <script src="{{ asset('oppd/setting/user.js') }}"></script>
@endpush
