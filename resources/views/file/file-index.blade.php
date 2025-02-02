@extends('garage._dashboard')
@section('content')
<style>
    .folder-item {
    cursor: pointer;
    margin-left: 10px;
}

.child-list {
    list-style: none;
    padding-left: 20px;
    display: none;
}
</style>
    <div class="row justify-content-center">
        <div class="col-10">
            <div class="card">
                <div class="card-header bg-core">
                    <div class="row">
                        <div class="col-6">
                            <strong>File Sharing</strong>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-sm btn-success" style="float: right" data-bs-toggle="modal" data-bs-target="#addFileModal">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="file-system">
                        <ul id="file-list">
                            <!-- Menampilkan file dan folder akan muncul di sini -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('file.modal.add-file')
@endsection
@push('js')
    <script src="{{ asset('oppd/file.js') }}"></script>
@endpush
