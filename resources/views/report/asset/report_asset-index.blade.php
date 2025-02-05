@extends('garage._dashboard')
@section('content')
<style>
   .tab-item {
        flex: 1; /* Menyesuaikan ukuran otomatis */
    }

    /* Mobile: 2 kolom */
    @media (max-width: 767px) {
        .tab-item {
            width: 50%; /* Setiap tab mengambil 50% layar */
        }
    }
    #assetsChart {
        width: 100% !important;
        height: auto !important;
        min-height: 300px; /* Ukuran minimum untuk mobile */
    }
    @media (max-width: 768px) {
        #assetsChart {
            min-height: 400px; /* Tambah tinggi di layar kecil */
        }
    }
    .chart-container {
        width: 100%;
        overflow-x: auto;  /* Aktifkan scroll horizontal */
        white-space: nowrap; /* Mencegah wrapping */
    }
</style>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-core">
                    <div class="row">
                        <div class="col-9">
                            <strong>Summary Asset by Category</strong>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row mt-2 mx-2">
                        <div class="col-12">
                            <ul class="nav nav-pills d-flex flex-sm-row flex-wrap justify-content-center" id="tablist" role="tablist">
                                <li class="nav-item flex-fill text-center tab-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-chart-view" role="tab">
                                        <i class="fa-solid fa-chart-simple"></i>
                                        <span>Chart View</span>
                                    </a>
                                </li>
                                <li class="nav-item flex-fill text-center tab-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab-table-view" role="tab">
                                        <i class="fa-solid fa-table"></i>
                                        <span>Table View</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                
                    <div class="tab-content">
                        <!-- Chart View -->
                        <div class="tab-pane active p-3" id="tab-chart-view" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="chart-container">
                                        <div id="assetsChart"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                
                        <!-- Table View -->
                        <div class="tab-pane p-3" id="tab-table-view" role="tabpanel">
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive mt-2" style="overflow-y: hidden">
                                        <table id="assetsTable" class="table table-striped">
                                            <thead>
                                                <tr id="dynamic-header"></tr> <!-- Dynamic column headers -->
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
   
@endsection
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@push('js')
    <script src="{{ asset('oppd/report/report_asset.js') }}"></script>
@endpush
