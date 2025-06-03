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
    @can('get-only_staff-laporan_asset')
        <div class="row mx-4 mt-2">
            <b>{{$satgas->type}}</b>
        </div>
    @endcan

    <div class="tab-content">
      
        <div class="row mx-2 mt-2">
           
            <div class="col-12">
                <button class="btn btn-sm btn-warning float-end" id="btn_add_asset" data-bs-toggle="modal" data-bs-target="#reportModal">
                    <i class="fas fa-print"></i> Export Data
                </button>
            </div>
        </div>
        <div class="tab-pane active p-3" id="tab-chart-view">
            <div class="row mt-2">
                <div class="col-12 col-sm-12 col-md-12">
                    @can('get-only_gm-laporan_asset')
                    <fieldset>
                        <legend class="bg-danger">   <i class="fas fa-filter"></i>Filter</legend>
                        <div id="satgas_button" class="row d-flex justify-content-between">
                        </div>
                    </fieldset>
                    @endcan
                </div>
            </div>
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
<input type="hidden" id="type_render">
<input type="hidden" id="kondisi_render">
