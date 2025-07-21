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
@php
$satgas = DB::table('master_satgas')->where('id',auth()->user()->satgas)->first();
@endphp
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header p-0 mx-2 bg-core">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex overflow-auto">
                            <ul class="nav nav-pills flex-nowrap" id="tab_1">
                                <li class="nav-item tab-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#tab_chart_1">
                                        <i class="fa-solid fa-chart-simple"></i>
                                        <span style="font-size: 12px;">Summary Asset By Category</span>
                                    </a>
                                </li>
                                <li class="nav-item tab-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_chart_2" id="tab_2">
                                        <i class="fa-solid fa-table"></i>
                                        <span style="font-size: 12px;">Summary Asset By Kondisi</span>
                                    </a>
                                </li>
                                <li class="nav-item tab-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#tab_chart_3" id="tab_3">
                                        <i class="fa-solid fa-layer-group"></i>
                                        <span style="font-size: 12px;">Custom Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="card-body p-0">
                <div class="tab-content">
                    @include('report.asset.modal.tab-summary_asset')
                    @include('report.asset.modal.tab-summary_kondisi')
                    @include('report.asset.modal.tab-summary_custom')
                </div>  
            </div>
        </div>
    </div>
</div>

@include('report.asset.modal.detail-master_asset')
@include('report.asset.modal.option_kondisi-report')
@include('report.asset.modal.option-report')

@endsection

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@push('js')
    <script src="{{ asset('oppd/report/report_asset.js') }}"></script>
@endpush
