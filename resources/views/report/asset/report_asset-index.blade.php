@extends('garage._dashboard')
@section('content')
<style>
    .chart-container {
         width: 100%;
         overflow-x: auto;  
         white-space: nowrap; 
     } 
 
     #assetsChart, #assetsChartKondisi {
         width: 100% !important;
         min-height: 300px;
     }
 
     @media (max-width: 768px) {
         #assetsChart, #assetsChartKondisi {
             min-height: 400px;
         }
     }

    .tab-item {
        flex: 1;
        min-width: 50%;
        text-align: center;
        padding: 5px;
    }

    .tab-item .nav-link {
        padding: 5px 5px;
        margin: 5px;
        border-radius: 8px;
    }

    @media (max-width: 767px) {
        .tab-item {
            display: inline-block;
            width: 50%;
        }
    }

    /* Warna & Styling untuk Tab */
    .nav-pills .nav-link.active {
        background-color: #179BAE !important;
        color: white !important;
        border-color: #179BAE !important;
    }
    .nav-pills .nav-link {
        color: white !important; 
        background-color: #BCCCDC !important;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-core">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6">
                        <ul class="nav nav-pills d-flex flex-wrap justify-content-center" id="tab_1">
                            <li class="nav-item tab-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tab_chart_1">
                                    <i class="fa-solid fa-chart-simple"></i>
                                    <span style="font-size: 12px;">Summary Asset By Category</span>
                                </a>
                            </li>
                            <li class="nav-item tab-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#tab_chart_2">
                                    <i class="fa-solid fa-table"></i>
                                    <span style="font-size: 12px;">Summary Asset By Kondisi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="tab-content">
                   
                    <!-- Tab Summary Asset By Category -->
                    <div class="tab-pane active p-3" id="tab_chart_1">
                        <div class="row mt-2 mx-2">
                            <div class="col-12 col-sm-6 col-md-4">
                                <ul class="nav nav-pills d-flex flex-wrap justify-content-center">
                                    <li class="nav-item tab-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab-chart-view">
                                            <i class="fa-solid fa-chart-simple"></i>
                                            <span style="font-size: 12px;">Chart View</span>
                                        </a>
                                    </li>
                                    <li class="nav-item tab-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab-table-view">
                                            <i class="fa-solid fa-table"></i>
                                            <span style="font-size: 12px;">Table View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="row mx-2">
                                <div class="col-12">
                                    <button class="btn btn-sm btn-warning float-end" id="btn_add_asset" data-bs-toggle="modal" data-bs-target="#reportModal">
                                        <i class="fas fa-print"></i> Export Data
                                    </button>
                                </div>
                            </div>

                            <div class="tab-pane active p-3" id="tab-chart-view">
                                <div class="chart-container">
                                    <div id="assetsChart"></div>
                                </div>
                            </div>
                    
                            <div class="tab-pane p-3" id="tab-table-view">
                                <div class="table-responsive mt-2">
                                    <table id="assetsTable" class="table table-striped">
                                        <thead>
                                            <tr id="dynamic-header"></tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Summary Asset By Kondisi -->
                    <div class="tab-pane p-3" id="tab_chart_2">
                        <div class="row mt-2 mx-2">
                            <div class="col-12 col-sm-6 col-md-4">
                                <ul class="nav nav-pills d-flex flex-wrap justify-content-center">
                                    <li class="nav-item tab-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#tab_chart_kondisi">
                                            <i class="fa-solid fa-chart-simple"></i>
                                            <span style="font-size: 12px;">Chart View</span>
                                        </a>
                                    </li>
                                    <li class="nav-item tab-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#tab_table_kondisi">
                                            <i class="fa-solid fa-table"></i>
                                            <span style="font-size: 12px;">Table View</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tab-content">
                            <div class="row mx-2">
                                <div class="col-12">
                                    <button class="btn btn-sm btn-warning float-end" id="btn_add_asset_kondisi" data-bs-toggle="modal" data-bs-target="#reportModal">
                                        <i class="fas fa-print"></i> Export Data
                                    </button>
                                </div>
                            </div>

                            <div class="tab-pane active p-3" id="tab_chart_kondisi">
                                <div class="chart-container">
                                    <div id="assetsChartKondisi"></div>
                                </div>
                            </div>
                    
                            <div class="tab-pane p-3" id="tab_table_kondisi">
                                <div class="table-responsive mt-2">
                                    <table id="assetsTableKondisi" class="table table-striped">
                                        <thead>
                                            <tr id="dynamic-header_kondisi"></tr>
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

@include('report.asset.modal.option-report')

@endsection

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@push('js')
    <script src="{{ asset('oppd/report/report_asset.js') }}"></script>
@endpush
