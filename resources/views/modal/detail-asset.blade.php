<div class="modal fade" id="detailAssetModal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xxl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <strong class="modal-title" id="modal_title"></strong>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" data-simplebar="">
                <input type="hidden" name="satgasTypeFilter" id="satgasTypeFilter">
                <input type="hidden" name="selectedKondisi" id="selectedKondisi">
                <div class="row mx-2">
                    <div class="filter-section">
                        <div class="row g-3">
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center">
                                    <label class="me-3 mb-0 fw-bold text-primary">Th Operasi</label>
                                    <select name="select_th_operasi" class="select2 form-select" id="select_th_operasi">
                                        <option value="">All Condition</option>
                                        <option value="1">< 5 Tahun</option>
                                        <option value="2">5 - 10 Tahun</option>
                                        <option value="3">> 10 Tahun</option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center">
                                    <label class="me-3 mb-0 fw-bold text-primary">Th Pembuatan</label>
                                    <select name="select_th_pembuatan" class="select2 form-select" id="select_th_pembuatan">
                                        <option value="">All Condition</option>
                                        <option value="1">< 5 Tahun</option>
                                        <option value="2">5 - 10 Tahun</option>
                                        <option value="3">> 10 Tahun</option>
                                    </select>
                                </div>
                            </div>
    
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex align-items-center">
                                    <label class="me-3 mb-0 fw-bold text-primary">Jenis</label>
                                    <select name="select_asset_jenis_filter" class="select2 form-select" id="select_asset_jenis_filter">
                                    </select>
                                </div>
                            </div>
    
                            <div class="col-md-6 col-lg-3">
                                <div class="d-flex gap-2 justify-content-end">
                                    <button class="btn btn-danger" id="btn_filter_asset">
                                        <i class="fas fa-filter me-2"></i>Filter
                                    </button>
                                    <button class="btn btn-success" id="btn_export_asset">
                                        <i class="fas fa-file me-2"></i>Export
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p style="font-size: 16px; font-weight:bold" class="mx-4 mt-2">Total Asset: <span id="totalItemAsset">0</span> item</p>
                <div class="table-responsive" style="overflow-y: hidden">
                    <table id="asset_table" class="table table-striped table-bordered text-nowrap">
                        <thead class="text-dark fs-1">
                            <tr>
                                <th>Asset Code</th>
                                <th>Satgas</th>
                                <th>Lokasi</th>
                                <th>No UN</th>
                                <th>Kategori</th>
                                <th>Sub Kategori</th>
                                <th>Jenis</th>
                                <th>Merk</th>
                                <th>No Mesin</th>
                                <th>No Rangka</th>
                                <th>Th Pembuatan</th>
                                <th>Th Operasi</th>
                                <th>Kondisi</th>
                                <th>Catatan Terkini</th>
                                <th>Last Update</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="modal-footer"> 
            </div>
        </div>
    </div>
</div>
<style>
/* 🌟 Modern Modal Styles */
#detailAssetModal .modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    background: #ffffff;
}

#detailAssetModal .modal-header {
    background: #7298AD;
    color: white;
    border: none;
    padding: 1.5rem 2rem;
    position: relative;
}

#detailAssetModal .btn-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

/* Body & Scroll */
#detailAssetModal .modal-body {
    padding: 2rem;
    max-height: 100vh;
    overflow-y: auto;
}

#detailAssetModal .modal-body::-webkit-scrollbar {
    width: 8px;
}
#detailAssetModal .modal-body::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}
#detailAssetModal .modal-body::-webkit-scrollbar-thumb {
    background: #7298AD;
    border-radius: 10px;
}
#detailAssetModal .modal-body::-webkit-scrollbar-thumb:hover {
    background: #5a7a8a;
}

/* 🎯 Filter Section */
#detailAssetModal .filter-section {
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
#detailAssetModal .filter-section .row {
    margin: 0;
}
#detailAssetModal .form-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.5rem 1rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: white;
}
#detailAssetModal .form-select:focus {
    border-color: #7298AD;
    box-shadow: 0 0 0 0.2rem rgba(114, 152, 173, 0.25);
    transform: translateY(-2px);
}
#detailAssetModal label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0;
    white-space: nowrap;
}

/* 🔘 Buttons */
#detailAssetModal .btn {
    border-radius: 25px;
    padding: 0.5rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}
#detailAssetModal .btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}
#detailAssetModal .btn:hover::before {
    left: 100%;
}
#detailAssetModal .btn-danger {
    background: #dc3545;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
}
#detailAssetModal .btn-danger:hover {
    background: #c82333;
    transform: translateY(-2px);
}
#detailAssetModal .btn-success {
    background: #28a745;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
}
#detailAssetModal .btn-success:hover {
    background: #218838;
    transform: translateY(-2px);
}

/* 🔢 Total Asset Counter */
#detailAssetModal #totalItemAsset {
    background: #7298AD;
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 700;
    display: inline-block;
    margin-left: 0.5rem;
    box-shadow: 0 4px 15px rgba(114, 152, 173, 0.3);
}

</style>
