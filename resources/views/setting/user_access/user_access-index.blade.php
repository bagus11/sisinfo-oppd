@extends('garage._dashboard')
@section('content')
    <div class="row">
        <!-- Menus Section -->
        <div class="col-12 col-md-8">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-9">
                            <strong>Role User</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_role_user" data-bs-toggle="modal" data-bs-target="#addRoleUserModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 mx-1">
                        <div class="table-responsive" style="overflow-y: hidden">
                            <table id="role_user_table" class="table table-striped table-bordered text-nowrap">
                                <thead class="text-dark fs-1">
                                    <tr>
                                      <th>NIK</th>
                                      <th>Name</th>
                                      <th>Role</th>
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
        <div class="col-12 col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-9">
                            <strong>User Access</strong>
                        </div>
                        {{-- <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_submenus" data-bs-toggle="modal" data-bs-target="#addSubmenusModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div> --}}
                    </div>
                </div>
                <div class="card-body p-0 mx-1">
                    <div class="table-responsive" style="overflow-y: hidden">
                        <table id="role_permission_table" class="table table-striped table-bordered text-nowrap">
                            <thead class="text-dark fs-1">
                                <tr>
                                   <th>Role</th>
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
    @include('setting.user_access.modal.add-roleUser')
    @include('setting.user_access.modal.edit-roleUser')
    @include('setting.user_access.modal.add-permission')
    @include('setting.user_access.modal.edit-permission')
@endsection

@push('js')
    <script src="{{ asset('oppd/setting/user_access/user_access.js') }}"></script>
@endpush
