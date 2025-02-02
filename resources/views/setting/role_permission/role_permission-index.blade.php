@extends('garage._dashboard')
@section('content')
    <div class="row">
        <!-- Menus Section -->
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-9">
                            <strong>Role</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 mx-1">
                        <div class="table-responsive" style="overflow-y: hidden">
                            <table id="roles_table" class="table table-striped table-bordered text-nowrap">
                                <thead class="text-dark fs-1">
                                    <tr>
                                      <th>Name</th>
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
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-9">
                            <strong>Permission</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_permission" data-bs-toggle="modal" data-bs-target="#addPermissionModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 mx-1">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="permission_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                   <th>Name</th>
                                   <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="card-footer"></div>
            </div>
        </div>
    </div>

    @include('setting.role_permission.modal.add-role')
    @include('setting.role_permission.modal.add-permission')
    @include('setting.role_permission.modal.edit-role')
@endsection

@push('js')
    <script src="{{ asset('oppd/setting/role_permission/role_permission.js') }}"></script>
@endpush
