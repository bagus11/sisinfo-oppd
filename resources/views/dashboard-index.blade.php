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
  max-height: 700px;
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
        background-color: #B2D2DD;
        color: white;
        font-weight: bold;
        text-align: center;
      }

</style>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body p-4 bg-opacity-8 rounded-top">
            <div class="d-md-flex align-items-center justify-content-between mb-3">
              <div>
                <h5 class="card-title">Summary Asset</h5>
                <p class="card-subtitle mb-0">Summary Asset OPPD</p>
              </div>
            </div>
            <div class="row">
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
                                    <strong style="font-size:14px;font-weight:bold;text-algin:left">Hot News</strong>
                                  </div>
                              </div>
                          </div>
                          <div class="card-body rounded-2 p-0 bg-opacity-10" style="overflow-y: auto; height: 200px;">
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
                                      <strong style="font-size:14px;font-weight:bold">Summary OPPD</strong>
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
      </div>
      <div class="col-12">
        {{-- <div class="card">
            <div class="card-body p-4 pb-0">
              
            </div>
        </div> --}}
        <div class="row overflow-auto flex-nowrap" id="satgas_type_container" style="white-space: nowrap; overflow-x: auto; -webkit-overflow-scrolling: touch;">
      </div>
    </div>
    
 
      <!-- ----------------------------------------- -->
      <!-- Revenue Forecast -->
      <!-- ----------------------------------------- -->
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <div class="row mb-4">
              <div class="col-8">
                <h5 class="card-title">Kondisi Aset</h5>
              </div>
              <div class="col-4">
                <select name="select_asset_type" class="select2" id="select_asset_type"></select>
              </div>
            </div>
            <div style="height: 405px;" class="me-n2 rounded-bars mb-4">
              <div id="asset_chart"></div>
            </div>
            
          </div>
        </div>
      </div>
      <!-- ----------------------------------------- -->
      <!-- Annual Profit -->
      <!-- ----------------------------------------- -->
      <div class="col-lg-6">
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
      <div class="col-lg-5">

    </div>
  </div>
</div>
@include('modal.detail-asset')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection

@push('js')
    <script src="{{ asset('oppd/dashboard.js') }}"></script>
    <script>
     
    </script>
@endpush
