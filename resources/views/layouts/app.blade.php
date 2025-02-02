@extends('garage._dashboard')
@section('content')

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="d-md-flex align-items-center justify-content-between mb-3">
              <div>
                <h5 class="card-title">Summary Asset</h5>
                <p class="card-subtitle mb-0">Summary Asset OPPD</p>
              </div>

              <div class="hstack gap-9 mt-4 mt-md-0">
                <div class="d-flex align-items-center gap-2">
                  <span class="d-block flex-shrink-0 round-10 bg-primary rounded-circle"></span>
                  <span class="text-nowrap text-muted">2024</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                  <span class="d-block flex-shrink-0 round-10 bg-danger rounded-circle"></span>
                  <span class="text-nowrap text-muted">2023</span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-9">
                
              </div>
              <div class="col-3">
                <div class="card">
                  <div class="card-body bg-white">
                    OPPD List
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="card">
          <div class="card-body p-4 pb-0" data-simplebar="">
            <div class="row flex-nowrap">
              <div class="col">
                <div class="card primary-gradient">
                  <div class="card-body text-center px-9 pb-4">
                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-primary flex-shrink-0 mb-3 mx-auto">
                      <iconify-icon icon="solar:dollar-minimalistic-linear" class="fs-7 text-white"></iconify-icon>
                    </div>
                    <h6 class="fw-normal fs-3 mb-1">UNIFIL</h6>
                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="counting_oppd"></h4>
                    <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                      Details</a>
                  </div>
                </div>
              </div>
             
              <div class="col">
                <div class="card secondary-gradient">
                  <div class="card-body text-center px-9 pb-4">
                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-secondary flex-shrink-0 mb-3 mx-auto">
                      <iconify-icon icon="ic:outline-backpack" class="fs-7 text-white"></iconify-icon>
                    </div>
                    <h6 class="fw-normal fs-3 mb-1">KIZI MINUSCA
                    </h6>
                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="counting_kizi_minusca"></h4>
                    <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                      Details</a>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card danger-gradient">
                  <div class="card-body text-center px-9 pb-4">
                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-danger flex-shrink-0 mb-3 mx-auto">
                      <iconify-icon icon="ic:baseline-sync-problem" class="fs-7 text-white"></iconify-icon>
                    </div>
                    <h6 class="fw-normal fs-3 mb-1">KIZI MONUSCO
                    </h6>
                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="counting_kizi_monusco"></h4>
                    <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                      Details</a>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="card success-gradient">
                  <div class="card-body text-center px-9 pb-4">
                    <div class="d-flex align-items-center justify-content-center round-48 rounded text-bg-success flex-shrink-0 mb-3 mx-auto">
                      <iconify-icon icon="ic:outline-forest" class="fs-7 text-white"></iconify-icon>
                    </div>
                    <h6 class="fw-normal fs-3 mb-1">BGC MONUSCO</h6>
                    <h4 class="mb-3 d-flex align-items-center justify-content-center gap-1" id="counting_bgc_monusco"></h4>
                    <a href="javascript:void(0)" class="btn btn-white fs-2 fw-semibold text-nowrap">View
                      Details</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
 
      <!-- ----------------------------------------- -->
      <!-- Revenue Forecast -->
      <!-- ----------------------------------------- -->
      <div class="col-lg-8">
        <div class="card">
          <div class="card-body">
            <div class="d-md-flex align-items-center justify-content-between mb-3">
              <div>
                <h5 class="card-title">Revenue Forecast</h5>
                <p class="card-subtitle mb-0">Overview of Profit</p>
              </div>

              <div class="hstack gap-9 mt-4 mt-md-0">
                <div class="d-flex align-items-center gap-2">
                  <span class="d-block flex-shrink-0 round-10 bg-primary rounded-circle"></span>
                  <span class="text-nowrap text-muted">2024</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                  <span class="d-block flex-shrink-0 round-10 bg-danger rounded-circle"></span>
                  <span class="text-nowrap text-muted">2023</span>
                </div>
              </div>
            </div>
            <div style="height: 305px;" class="me-n2 rounded-bars">
              <div id="revenue-forecast"></div>
            </div>
            <div class="row mt-4 mb-2">
              <div class="col-md-4">
                <div class="hstack gap-6 mb-3 mb-md-0">
                  <span class="d-flex align-items-center justify-content-center round-48 bg-light rounded">
                    <iconify-icon icon="solar:pie-chart-2-linear" class="fs-7 text-dark"></iconify-icon>
                  </span>
                  <div>
                    <span>Total</span>
                    <h5 class="mt-1 fw-medium mb-0">$96,640</h5>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="hstack gap-6 mb-3 mb-md-0">
                  <span class="d-flex align-items-center justify-content-center round-48 bg-primary-subtle rounded">
                    <iconify-icon icon="solar:dollar-minimalistic-linear" class="fs-7 text-primary"></iconify-icon>
                  </span>
                  <div>
                    <span>Profit</span>
                    <h5 class="mt-1 fw-medium mb-0">$48,820</h5>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="hstack gap-6">
                  <span class="d-flex align-items-center justify-content-center round-48 bg-danger-subtle rounded">
                    <iconify-icon icon="solar:database-linear" class="fs-7 text-danger"></iconify-icon>
                  </span>
                  <div>
                    <span>Earnings</span>
                    <h5 class="mt-1 fw-medium mb-0">$48,820</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ----------------------------------------- -->
      <!-- Annual Profit -->
      <!-- ----------------------------------------- -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Annual Profit</h5>
            <div class="bg-primary bg-opacity-10 rounded-1 overflow-hidden mb-4">
              <div class="p-4 mb-9">
                <div class="d-flex align-items-center justify-content-between">
                  <span class="text-dark-light">Conversion Rate</span>
                  <h3 class="mb-0">18.4%</h3>
                </div>
              </div>
              <div id="annual-profit"></div>
            </div>
            <div class="d-flex align-items-center justify-content-between pb-6 border-bottom">
              <div>
                <span class="text-muted fw-medium">Added to Cart</span>
                <span class="fs-11 fw-medium d-block mt-1">5 clicks</span>
              </div>
              <div class="text-end">
                <h6 class="fw-bolder mb-1 lh-base">$21,120.70</h6>
                <span class="fs-11 fw-medium text-success">+13.2%</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between py-6 border-bottom">
              <div>
                <span class="text-muted fw-medium">Reached to Checkout</span>
                <span class="fs-11 fw-medium d-block mt-1">12 clicks</span>
              </div>
              <div class="text-end">
                <h6 class="fw-bolder mb-1 lh-base">$16,100.00</h6>
                <span class="fs-11 fw-medium text-danger">-7.4%</span>
              </div>
            </div>
            <div class="d-flex align-items-center justify-content-between pt-6">
              <div>
                <span class="text-muted fw-medium">Added to Cart</span>
                <span class="fs-11 fw-medium d-block mt-1">24 views</span>
              </div>
              <div class="text-end">
                <h6 class="fw-bolder mb-1 lh-base">$6,400.50</h6>
                <span class="fs-11 fw-medium text-success">+9.3%</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-5">

    </div>
  </div>
</div>

@endsection

@push('js')
    <script src="{{ asset('oppd/dashboard.js') }}"></script>
@endpush
