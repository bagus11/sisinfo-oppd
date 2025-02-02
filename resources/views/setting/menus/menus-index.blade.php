@extends('garage._dashboard')
@section('content')
    <div class="row">
        <!-- Menus Section -->
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <strong>Menus</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addMenusModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 mx-1">
                        <div class="table-responsive" style="overflow-y: hidden">
                            <table id="menus_table" class="table table-striped table-bordered text-nowrap">
                                <thead class="text-dark fs-1">
                                    <tr>
                                        <th></th>
                                        <th>status</th>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>

        <!-- Submenus Section -->
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-9">
                            <strong>Submenus</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_submenus" data-bs-toggle="modal" data-bs-target="#addSubmenusModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 mx-1">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="submenus_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                    <th></th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Parent</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('setting.menus.modal.add-menus')
    @include('setting.menus.modal.edit-menus')
    @include('setting.menus.modal.add-submenus')
    @include('setting.menus.modal.edit-submenus')
@endsection

@push('js')
    <script src="{{ asset('oppd/setting/menus/menus.js') }}"></script>
@endpush
