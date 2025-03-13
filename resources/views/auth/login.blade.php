<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sisinfolog OPPD</title>
    
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">

    <style>
        .auth-login .card {
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/logo.png') }}" alt="loader" class="lds-ripple img-fluid">
    </div>

    <div id="main-wrapper">
        <div class="auth-bg min-vh-100 d-flex align-items-center justify-content-center">
            <div class="row w-100 justify-content-center my-5">
                <div class="col-md-9 d-flex flex-column justify-content-center">
                    <div class="card bg-body auth-login m-auto w-100" style="opacity: 0.8 !important;">
                        <div class="row gx-0">
                            <!-- Form Login -->
                            <div class="col-xl-6 border-end p-4">
                                <div class="card-body">
                                    <a href="{{ url('/') }}" class="text-nowrap logo-img d-block mb-4 w-100">
                                        <img src="{{ asset('assets/images/logos/logo.png') }}" style="width: 50px" alt="Logo">
                                    </a>
                                    <form method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" required autofocus>
                                            @error('email')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                            @error('password')
                                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                                    </form>
                                </div>
                            </div>
                            <!-- Informasi -->
                            <div class="col-xl-6 d-none d-xl-block p-4 text-center">
                                <img src="{{ asset('assets/images/logos/logo.png') }}" alt="login-side-img" width="150" class="img-fluid mt-4">
                                <h4 class="mt-3">SISINFO OPPD</h4>
                                <p class="opacity-75">Sistem berbasis teknologi informasi yang dirancang untuk mengelola dan mengintegrasikan berbagai kegiatan logistik seperti perencanaan, pengadaan, penyimpanan, distribusi, pemeliharaan, dan pelaporan aset dalam organisasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>