@extends('garage._dashboard')
@section('content')
<style>
    .chart-container {
         width: 100%;
         overflow-x: auto;  /* Aktifkan scroll horizontal */
         white-space: nowrap; /* Mencegah wrapping */
     } 
 
     /* Pastikan chart tidak terlalu kecil */
     #assetsChart {
         width: 100% !important;
         min-height: 300px; /* Ukuran minimum */
     }
 
     @media (max-width: 768px) {
         #assetsChart {
             min-height: 400px; /* Tambah tinggi di layar kecil */
         }
     }
     .tab-item {
        flex: 1; /* Agar ukuran otomatis */
        min-width: 50%; /* Membuat 2 kolom pada mobile */
        text-align: center;
        padding: 5px; /* Tambahkan padding */
    }

    /* Beri jarak antar tab di semua ukuran layar */
    .tab-item .nav-link {
        padding: 5px 5px; /* Tambahkan padding dalam tombol */
        margin: 5px; /* Tambahkan margin antar tombol */
        border-radius: 8px; /* Agar sudut membulat */
    }

    /* Mobile: Pastikan tab berada dalam satu baris dengan spasi */
    @media (max-width: 767px) {
        .tab-item {
            display: inline-block;
            width: 50%;
        }
    }

    /* Warna & Styling untuk Tab */
    #tab_summary_category .nav-link.active {
        background-color: #179BAE !important;
        color: white !important;
        border-color: #179BAE !important;
    }
    #tab_summary_category .nav-link {
        color: white !important; 
        background-color: #BCCCDC !important;
    }
     /* Warna & Styling untuk Tab */
     #tab_summary_category .nav-link.active {
         background-color: #179BAE !important;
         color: white !important;
         border-color: #179BAE !important;
     }
     #tab_summary_category .nav-link {
         color: white !important; 
         background-color: #BCCCDC !important;
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
                        <div class="col-12 col-sm-6 col-md-3">
                            <ul class="nav nav-pills d-flex flex-wrap justify-content-center" id="tab_summary_category" role="tab_summary_category">
                                <li class="nav-item tab-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab-chart-view" role="tab">
                                        <i class="fa-solid fa-chart-simple"></i>
                                        <span style="font-size: 12px;">Chart View</span>
                                    </a>
                                </li>
                                <li class="nav-item tab-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab-table-view" role="tab">
                                        <i class="fa-solid fa-table"></i>
                                        <span style="font-size: 12px;">Table View</span>
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
