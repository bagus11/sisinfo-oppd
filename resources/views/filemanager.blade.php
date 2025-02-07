<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <title>{{ config('app.name', 'File Manager') }}</title>
    
    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="{{ asset('vendor/file-manager/css/file-manager.css') }}" rel="stylesheet">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .btn-secondary {
            background-color: #98D8EF;
            border: none;
        }

        .btn-secondary :disabled {
            background-color: #76a7b9 !important;
            border: none;
        }

        .file-manager-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 10px;
        }

        .file-manager-card {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            box-shadow: 0 4px 8px rgba(55, 86, 141, 0.1);
            border-radius: 10px;
        }

        .file-manager-card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }

        .file-manager-header {
            background: #81BFDA;
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            text-align: left;
        }

        .file-manager-body {
            flex-grow: 1;
            padding: 10px;
            overflow: auto;
            background-color: #f8f9fa;
        }
        fm-modal .modal{
            height: 100% !important;
        }

        #fm-main-block {
            border: 2px dashed #007bff;
            border-radius: 10px;
            background-color: #ffffff;
            padding: 10px;
            height: 100%;
        }

        /* Ensure #fm has correct height */
        #fm {
            height: 100%; /* Make #fm fill the available height of its container */
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .file-manager-header {
                text-align: center;
                padding: 10px;
            }

            #fm-main-block {
                height: 400px; /* Adjust height for mobile */
            }

            #fm {
                height: 100%; /* Ensure #fm inside #fm-main-block adapts to available height */
            }
        }
    </style>
</head>

<body>
    <div class="file-manager-container">
        <div class="card file-manager-card">
            <div class="file-manager-header">
             <div class="row">
                <div class="col-11">
                    <a href="{{ route('home') }}" class="text-nowrap logo-img" style="color: white; font-size: 20px; text-decoration: none;">
                        <img src="{{ asset('assets/images/logos/logo.png') }}" style="width: 50px;" alt="Logo" /> 
                        <b>SISINFO OPPD</b>
                    </a>
                  </div>
                  <div class="col-1">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-dark" title="Back To Home" style="color: white; font-size: 20px; text-decoration: none;float:right">
                        <i class="bi bi-house-door-fill"></i>
                    </a>
                  </div>
             </div>
            </div>
            <div class="file-manager-body">
                <div class="row">
                    <div class="col-12" id="fm-main-block">
                        <div id="fm"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <!-- File manager -->
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            $('button[title="About"]').css('display', 'none');
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight * 0.6 + 'px');

            fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
                window.opener.fmSetLink(fileUrl);
                window.close();
            });

            function adjustHeight() {
                let headerHeight = document.querySelector('.file-manager-header').offsetHeight;
                let windowHeight = window.innerHeight;
                let bodyHeight = windowHeight - headerHeight - 40; // 40px for padding/margin

                document.querySelector('.file-manager-body').style.height = bodyHeight + 'px';
            }

            adjustHeight();
            window.addEventListener('resize', adjustHeight);
        });
    </script>
</body>
</html>
