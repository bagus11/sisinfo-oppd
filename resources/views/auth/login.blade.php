<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <!-- Required meta tags -->
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Favicon icon-->
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

  <!-- Core Css -->
  <link rel="stylesheet" href="../assets/css/styles.css" />

  <title>MatDash Bootstrap Admin</title>
</head>
<style>
  .auth-login .card {
    opacity: 0.9; /* Sesuaikan nilai */
}
</style>
<body>
  <!-- Preloader -->
  <div class="preloader">
    <img src="../assets/images/logos/logo.png" alt="loader" class="lds-ripple img-fluid" />
  </div>
  <div id="main-wrapper">
    <div class="position-relative overflow-hidden auth-bg min-vh-100 w-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100 my-5 my-xl-0">
          <div class="col-md-9 d-flex flex-column justify-content-center">
            <div class="card mb-0 bg-body auth-login m-auto w-100" style="opacity: 0.8 !important;">
              <div class="row gx-0">
                <div class="col-xl-6 border-end">
                  <div class="row justify-content-center py-4">
                    <div class="col-lg-11">
                      <div class="card-body" >
                        <a href="../index.html" class="text-nowrap logo-img d-block mb-4 w-100">
                          <img src="../assets/images/logos/logo.png" style="width: 50px" class="dark-logo" alt="Logo-Dark" />
                        </a> 
                          <form method="POST" action="{{ route('login') }}">
                            @csrf
        
                            <div class="row">
                                <div class="col-4 mt-2">
                                    <label for="email">{{ __('Email') }}</label>
                                </div>   
                                <div class="col-8">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4 mt-2">
                                    <label for="password">{{ __('Password') }}</label>
        
                                </div>
                                <div class="col-8">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
        
                                </div>
                            </div>
                        
                            <div class="row mt-4 mx-2">
                                <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>
                      </div>
                    </div>
                  </div>

                </div>
                <!-- ------------------------------------------------- -->
                <!-- Part 2 -->
                <!-- ------------------------------------------------- -->
                <div class="col-xl-6 d-none d-xl-block">
                  <div class="row justify-content-center align-items-center h-100 pb-5">
                    <div class="col-lg-9">
                      <div id="auth-login" class="carousel slide auth-carousel" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#auth-login" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        </div>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <div class="d-flex align-items-center justify-content-center w-100 h-100 flex-column gap-9 text-center">
                              <img src="../assets/images/logos/logo.png" alt="login-side-img" width="150" class="img-fluid mt-4" />
                              <h4 class="mb-0">SISINFO OPPD</h4>
                              <span class="opacity-75 fs-3 d-block mb-0">Sistem Informasi
                                Sistem berbasis teknologi informasi yang dirancang untuk mengelola dan mengintegrasikan berbagai kegiatan logistik, seperti perencanaan, pengadaan, penyimpanan, pendistribusian, pemeliharaan, dan pelaporan aset atau barang dalam suatu organisasi atau perusahaan.
                              </span>
                            </div>
                          </div>
                        </div>

                      </div>


                    </div>
                  </div>

                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/libs/simplebar/dist/simplebar.min.js"></script>
  <script src="../assets/js/theme/app.init.js"></script>
  <script src="../assets/js/theme/theme.js"></script>
  <script src="../assets/js/theme/app.min.js"></script>

  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>