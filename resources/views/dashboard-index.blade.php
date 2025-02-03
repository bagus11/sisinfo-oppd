@extends('garage._dashboard')
@section('content')
<style>
.navbar {
  z-index: 90 !important; /* Remove 'px' */
}
#asset_map_track {
  width: 100%; /* Ensure full width */
  height: 300px; /* Default height for mobile */
  min-height: 200px; /* Prevent collapse */
  max-height: 570px;
  border-radius: 10px !important;
  z-index: 1 !important;
  padding-bottom: 30px !important;
}

/* Adjust for tablets and larger screens */
@media (min-width: 768px) {
  #asset_map_track {
    height: 300px; /* Medium screens */
  }
}

@media (min-width: 1024px) {
  #asset_map_track {
    height: 93vh; /* Larger screens use viewport height */
  }
}

.col-12 {
  display: flex;
  flex-direction: column;
  height: 100%;
}

  .row {
    display: flex; /* Ensure both child elements adjust to each other's height */
    align-items: stretch; /* Ensure children align to the tallest */
  }
    #radialChart{
      width: 100% !important;
    }

    .select2-container{
        z-index:0 !important;
    }
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
      }

      ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px hsla(0, 1%, 60%, 0.3);
        border-radius: 10px;
      }

      ::-webkit-scrollbar-thumb {
        background: hsla(0, 1%, 40%, 0.6); /* Slightly darker for visibility */
        border-radius: 10px;
      }

      ::-webkit-scrollbar-thumb:hover {
        background: #b2b1b0;
      }

      .header-danger {
        background-color: rgb(255, 102, 146);
        color: white;
        font-weight: bold;
        text-align: center;
      }

      .header-info {
        background-color: #7298AD;
        color: white;
        font-weight: bold;
        text-align: center;
      }

</style>
    <div class="row mb-0">
      <div class="col-12">
        <div class="card">
          <div class="card-body pb-0 px-4 py-2  bg-opacity-8 rounded-top">
            
            <div class="d-md-flex align-items-center justify-content-between mb-3">
              <div>
                <span class="badge badge-primary w-15 mx-1" style="background-color:#7298AD;color:white;border-radius:5px !important;font-size:16px !important; font-weight:bold;">ASSET INFOGRAFIS</span>
                {{-- <h5 class="card-title">ASSET INFOGRAFIS</h5> --}}
                {{-- <p class="card-subtitle mb-0">Summary Asset OPPD</p> --}}
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-12 col-sm-12 col-md-9">
                <div id="asset_map_track"></div>
              </div>

              <div class="col-12 col-sm-12 col-md-3">
                  <div class="row">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-header header-danger p-2 bg-opacity-8 rounded-top">
                              <div class="row d-flex justify-item-start">
                                <div class="col-2">
                                      <strong style="font-size:14px;"><i class="fa-solid fa-bullhorn"></i></strong>
                                  </div>
                                  <div class="col-8">
                                    <strong style="font-size:16;font-weight:bold;text-algin:left">HOT NEWS</strong>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body rounded-2 p-0 bg-opacity-10" style="overflow-y: auto; height: 150px;">
                            <a href="javascript:void(0)" class="d-flex align-items-center dropdown-item gap-2 py-1">
                                <span class="flex-shrink-0 bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center p-1"
                                    style="width: 30px; height: 30px; font-size: 14px;margin-left:10px">
                                    <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                                </span>
                                <div class="w-75">
                                    <h6 class="mb-1 fw-semibold fs-3">Siap Tugas Misi Perdamaian</h6>
                                    <span class="d-block text-truncate fs-2">
                                        <i class="fa-solid fa-calendar-days"></i> <strong class="ms-1 fw-normal">1 Jan 2025</strong>
                                    </span>
                                </div>
                            </a>
                        
                            <a href="javascript:void(0)" class="d-flex align-items-center dropdown-item gap-2 py-1">
                                <span class="flex-shrink-0 bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center p-1"
                                    style="width: 30px; height: 30px; font-size: 14px;margin-left:10px">
                                    <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                                </span>
                                <div class="w-75">
                                    <h6 class="mb-1 fw-semibold fs-3">DANKORMAR Hadiri Pelepasan Satgas</h6>
                                    <span class="d-block text-truncate fs-2">
                                        <i class="fa-solid fa-calendar-days"></i> <strong class="ms-1 fw-normal">1 Jan 2025</strong>
                                    </span>
                                </div>
                            </a>
                        
                            <a href="javascript:void(0)" class="d-flex align-items-center dropdown-item gap-2 py-1">
                                <span class="flex-shrink-0 bg-info-subtle rounded-circle d-flex align-items-center justify-content-center p-1"
                                    style="width: 30px; height: 30px; font-size: 14px;margin-left:10px">
                                    <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                                </span>
                                <div class="w-75">
                                    <h6 class="mb-1 fw-semibold fs-3">Panglima TNI Tinjau Persiapan Satgas</h6>
                                    <span class="d-block text-truncate fs-2">
                                        <i class="fa-solid fa-calendar-days"></i> <strong class="ms-1 fw-normal">1 Jan 2025</strong>
                                    </span>
                                </div>
                            </a>
                        
                            <a href="javascript:void(0)" class="d-flex align-items-center dropdown-item gap-2 py-1">
                                <span class="flex-shrink-0 bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center p-1"
                                    style="width: 30px; height: 30px; font-size: 14px;margin-left:10px">
                                    <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                                </span>
                                <div class="w-75">
                                    <h6 class="mb-1 fw-semibold fs-3">Tuntaskan Misi di Lebanon</h6>
                                    <span class="d-block text-truncate fs-2">
                                        <i class="fa-solid fa-calendar-days"></i> <strong class="ms-1 fw-normal">2 Jan 2025</strong>
                                    </span>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center dropdown-item gap-2 py-1">
                                <span class="flex-shrink-0 bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center p-1"
                                    style="width: 30px; height: 30px; font-size: 14px;margin-left:10px">
                                    <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                                </span>
                                <div class="w-75">
                                    <h6 class="mb-1 fw-semibold fs-3">Tuntaskan Misi di Lebanon</h6>
                                    <span class="d-block text-truncate fs-2">
                                        <i class="fa-solid fa-calendar-days"></i> <strong class="ms-1 fw-normal">2 Jan 2025</strong>
                                    </span>
                                </div>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center dropdown-item gap-2 py-1">
                                <span class="flex-shrink-0 bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center p-1"
                                    style="width: 30px; height: 30px; font-size: 14px;margin-left:10px">
                                    <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                                </span>
                                <div class="w-75">
                                    <h6 class="mb-1 fw-semibold fs-3">Tuntaskan Misi di Lebanon</h6>
                                    <span class="d-block text-truncate fs-2">
                                        <i class="fa-solid fa-calendar-days"></i> <strong class="ms-1 fw-normal">2 Jan 2025</strong>
                                    </span>
                                </div>
                            </a>
                        
                            <a href="javascript:void(0)" class="d-flex align-items-center dropdown-item gap-2 py-1">
                                <span class="flex-shrink-0 bg-danger-subtle rounded-circle d-flex align-items-center justify-content-center p-1"
                                    style="width: 30px; height: 30px; font-size: 14px;margin-left:10px">
                                    <iconify-icon icon="solar:widget-3-line-duotone"></iconify-icon>
                                </span>
                                <div class="w-75">
                                    <h6 class="mb-1 fw-semibold fs-3">Launch Admin</h6>
                                    <span class="d-block text-truncate fs-2">Just see the my new admin!</span>
                                </div>
                            </a>
                        </div>
                        
                      </div>
                    </div> 
                    <div class="col-12">
                      <div class="card">
                          <div class="card-header header-info p-2 bg-opacity-8 rounded-top">
                              <div class="row">
                                  <div class="col-2">
                                      <strong style="font-size:14px;"><i class="fas fa-list"></i></strong>
                                  </div>
                                  <div class="col-8">
                                      <strong style="font-size:16px;font-weight:bold">SUMMARY OPPD</strong>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body rounded-2 p-0">
                              <div class="p-0" style="padding:0 !important" id="radialChart"></div>
                          </div>
                      </div>
                  </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="row overflow-auto flex-nowrap" id="satgas_type_container" style="white-space: nowrap; overflow-x: auto; -webkit-overflow-scrolling: touch;">
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header header-info py-1">
          <strong style="font-size:14px;font-weight:bold;text-algin:left">SUMMARY ASSET BY CATEGORY</strong>
        </div>
        <div class="card-body p-0 mx-1">
          <div id="horizontalBarChart"></div>  
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-header header-info py-1">
          <strong style="font-size:14px;font-weight:bold;text-algin:left">SUMMARY ASSET BY SATGAS</strong>
        </div>
        <div class="card-body p-0 mx-1">
          <div id="verticalBarChart"></div>  
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title mb-4">Pengajuan Aset</h5>
          <ul class="nav nav-tabs theme-tab gap-3 flex-nowrap" role="tablist">
            <li class="nav-item">
              <a class="nav-link pengajuan_filter active" data-pengajuan="1" data-bs-toggle="tab" href="#app" role="tab">
                <div class="hstack gap-2">
                  <iconify-icon icon="solar:widget-linear" class="fs-4"></iconify-icon>
                  <span>Pengajuan Perbaikan</span>
                </div>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link pengajuan_filter" data-pengajuan="2" data-bs-toggle="tab" href="#mobile" role="tab">
                <div class="hstack gap-2">
                  <iconify-icon icon="solar:smartphone-line-duotone" class="fs-4"></iconify-icon>
                  <span>Pengajuan Penggantian</span>
                </div>
              </a>
            </li>
          </ul>
         <div class="row mt-2">
          <div class="col-12">
            <div class="table-responsive" style="overflow-y: hidden">
            
              <table id="pengajuan_asset_table" class="table table-striped table-bordered text-nowrap">
                  <thead class="text-dark fs-1">
                      <tr>
                          <th>Satgas</th>
                          <th>No UN</th>
                          <th>Kategori</th>
                          <th>Sub Kategori</th>
                          <th>No Mesin</th>
                          <th>No Rangka</th>
                          <th>Status</th>
                      </tr>
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
@include('modal.detail-asset')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@push('js')
    <script src="{{ asset('oppd/dashboard.js') }}"></script>
    <script>
      function verticalBarChart(response){
        var summaryChartSatgas = response.summaryChartSatgas;
        // Prepare the data for the chart
    var satgasNames = summaryChartSatgas.map(function(item) {
        return item.satgas_name;  // Get satgas names
    });

    var totalCounts = summaryChartSatgas.map(function(item) {
        return item.total;  // Get total count of assets for each satgas
    });

    // Dynamically generate colors for each satgas_name (you can customize the colors as needed)
    var colors = [
        "#4BA4B1", "#33FF57", "#3357FF", "#F3FF33", "#FF33A6", // You can add more colors as per your requirement
        "#FF8C00", "#A52A2A", "#6A5ACD", "#20B2AA", "#D2691E"
    ];

    // Make sure the number of colors matches the number of satgas names
    if (colors.length < satgasNames.length) {
        // In case there are more satgas names than colors, repeat the colors
        while (colors.length < satgasNames.length) {
            colors.push(colors[colors.length % colors.length]);
        }
    }

    // Chart options
    var options = {
        chart: {
            type: 'bar',  // Set the chart type to vertical bar
            height: 400,
            toolbar: {
                show: false
            },
        },
        plotOptions: {
            bar: {
                columnWidth: '50%',  // Width of the bars
                endingShape: 'flat',  // Ensure bars end flat
                dataLabels: {
                    position: 'top',  // Position the data labels at the top of the bars
                },
            },
        },
        grid: {
            borderColor: 'transparent',  // Remove grid borders
        },
        colors: colors,  // Assign dynamic colors based on satgas_name
        series: [{
            name: 'Total Aset',
            data: totalCounts  // Use the total counts as the data for the bars
        }],
        xaxis: {
            categories: satgasNames,  // Use satgas names as x-axis labels
            labels: {
                style: {
                    colors: '#a1aab2',  // Label color for x-axis
                    fontSize: '12px',
                }
            }
        },
        yaxis: {
            title: {
                text: 'Jumlah Aset',
            },
            labels: {
                style: {
                    colors: '#a1aab2',  // Label color for y-axis
                    fontSize: '12px',
                }
            }
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "Total Aset: " + val;  // Show the total in tooltip
                }
            },
            theme: "dark",
        },
        title: {
            enable: false,
            text: '',  // Chart title
            align: 'center',
            style: {
                color: '#a1aab2',
            },
        },
        dataLabels: {
            enabled: true,  // Enable data labels
            style: {
                colors: ['#000'],  // Set the color of the data labels to black
                fontSize: '9px',   // Adjust font size for the labels
            },
            offsetY: -20,  // Adjust the vertical offset to move the labels up (negative value places labels above the bars)
        }
    };

    // Create the chart
    var chart = new ApexCharts(document.querySelector("#verticalBarChart"), options);
    chart.render();
      }
    </script>
@endpush
