@extends('garage._dashboard')
@section('content')
    <div class="row">
     
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <div class="row">
                        <div class="col-9">
                            <strong>List Kategori</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            <button class="btn btn-sm btn-success" id="btn_add_location" data-bs-toggle="modal" data-bs-target="#addCategoryAssetModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0 mx-1">
                        <div class="table-responsive" style="overflow-y: hidden">
                            <table id="category_asset_table" class="table table-striped table-bordered text-nowrap">
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
 @include('setting.asset.category.modal.add-category_asset')
@endsection
@push('js')
    <script src="{{ asset('oppd/setting/category_asset.js') }}"></script>
@endpush
