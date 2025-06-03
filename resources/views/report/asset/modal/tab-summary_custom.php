  <!-- Tab Summary Asset By Kondisi -->
  <div class="tab-pane p-3" id="tab_chart_3">
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
    @can('get-only_staff-laporan_asset')
        <div class="row mx-4 mt-2">
            <b>{{$satgas->type}}</b>
        </div>
    @endcan

    <div class="tab-content">
        <div class="row mx-2">
            <div class="col-12">
                <button class="btn btn-sm btn-warning float-end" id="btn_add_asset_kondisi" data-bs-toggle="modal" data-bs-target="#reportKondisiModal">
                    <i class="fas fa-print"></i> Export Data
                </button>
            </div>
        </div>

        <div class="tab-pane active p-3" id="tab_chart_3">
            <div class="row mt-2">
                <div class="col-12 col-sm-12 col-md-12">
                    @can('get-only_gm-laporan_asset')
                    <fieldset>
                        <legend class="bg-danger">   <i class="fas fa-filter"></i>Filter</legend>
                        <div id="kondisi_button" class="row d-flex justify-content-between">
                        </div>
                    </fieldset>
                    @endcan
                </div>
            </div>
            <div class="chart-container">
                <div id="assetsChartKondisi"></div>
                <input type="hidden" id="chartImageInputKondisi">
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