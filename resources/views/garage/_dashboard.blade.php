<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon-->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/logo.png') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Core Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @php
    $currentPath = Request::path();
        $menusName = DB::table('view_menus')
        ->where('link', $currentPath)
        ->select('name')
        ->first();
        // dd($menusName);
        $pageName = ucwords(str_replace('_', ' ', $menusName->name));

    @endphp
    <title>{{$pageName}}</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    {{-- <link href="{{ asset('assets/vendor/select2/select2.min.css') }}" rel="stylesheet"> --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" integrity="sha512-Zcn6bjR/8RZbLEpLIeOwNtzREBAJnUKESxces60Mpoj+2okopSAcSUIUOseddDm0cxnGQzxIR7vJgsLZbdLE3w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" integrity="sha512-h9FcoyWjHcOcmEVkxOfTLnmZFWIH0iZhZT1H2TbOq55xssQGEJHEaIm+PgoUaZbRvQTNTluNOEfb1ZRy6D3BOw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
</head>
<style>
    body {
    font-family: 'Poppins', sans-serif;
}

        label{
            font-size: 10px !important
        }
        .message_error{
            color: red;
            font-size: 10px !important;
        }
        p{
            font-size: 10px !important
        }
        .card-header.bg-primary{
            color: white;
            font-weight: bold;
        }
        .card-header.bg-info{
            color: white;
            font-weight: bold;
        }
        .table-striped{
            width: 100% !important;
            overflow-y: none;
        }
        .select2{
            width: 100% !important;
            font-size:10px;
        }
        .select2-selection__rendered {
            line-height: 30px !important;
            font-size:10px;
        }
        .select2-container .select2-selection--single {
            height: 35px !important;
            font-size:10px;
        }
        .select2-selection__arrow {
            height: 34px !important;
            font-size:10px !important;
        }
        .select2-dropdown{
        font-size: 10px !important;
        }
        .selectOption2{
        font-size: 10px !important;
        }
        .select2-dropdown--below{
        font-size: 10px !important;
        }
        .select2-results__option{
        font-size: 10px !important;
        }
        .select2-search__field {
        display: block !important;
        width: 100% !important;   /* Make sure the search field takes full width */
        height: auto !important;  /* Ensure it's not too small */
        padding: 5px 10px;        /* Adjust padding for better visibility */
        font-size: 10px;          /* Adjust font size */
    }
        .select2-container{
            z-index:100000 !important;
        }
        .toast {
        font-size: 10px !important;
        
        }
        .dataTables_wrapper .dataTables_paginate {
            margin: 10px 0 !important;
        }
        .table-responsive {
            overflow-x: auto; /* Enable horizontal scrolling */
        }

        .myFont{
        font-size:10px !important
        }
        .selectOption2{
                font-size: 9px !important;
        }

        .select2_dashboard{
            width: 100% !important;
            font-size:10px;
        }
        .select2_dashboard-selection__rendered {
            line-height: 30px !important;
            font-size:10px;
        }
        .select2_dashboard-container .select2-selection--single {
            height: 35px !important;
            font-size:10px;
        }
        .select2-selection__arrow {
            height: 34px !important;
            font-size:10px !important;
        }
        .select2-dropdown{
        font-size: 10px !important;
        }
        .selectOption2{
        font-size: 10px !important;
        }
        .select2-dropdown--below{
        font-size: 10px !important;
        }
        .select2-results__option{
        font-size: 10px !important;
        }

        .select2-hidden-accessible{
            z-index:10 !important;
        }
        form-control{
            font-size: 10px !important;
        }
        label{
            font-size: 10px !important;
        }
        fieldset {
            border: 1px solid#ddd;
            font-family: Poppins !important;
            border-radius: 5px !important;
            padding: 10px;
        }
        legend {
        font-size: 12px;
        padding: 0px 20px;
        margin-top: -20px !important;
        font-weight: bold !important;
        width: auto; /* Allow the width to adjust dynamically */
        min-width: 10%; /* Ensure a minimum width of 40% */
        max-width: 100%; /* Prevent it from exceeding the parent container */
        background-color: #179BAE !important;
        color: white !important;
        /* border-color: #179BAE !important; */
        border-radius: 20px !important;
    }

        input[type="date"] {
            font-size: 10px !important;
        }
        input[type="file"] {
            font-size: 10px !important;
        }
        input[type="text"] {
            font-size: 10px !important;
        }
        textarea{
            font-size: 10px !important;
        }
        .table{
            
            font-size: 10px !important;
        }

    .open\:bg-green-200[open] {
    --tw-bg-opacity: 1;
    background-color: rgb(187 247 208 / var(--tw-bg-opacity));
    }
    .open\:bg-red-600[open] {
    --tw-bg-opacity: 1;
    background-color: rgb(220 38 38 / var(--tw-bg-opacity));
    }
    .open\:bg-red-200[open] {
    --tw-bg-opacity: 1;
    background-color: rgb(254 202 202 / var(--tw-bg-opacity));

    }
    .open\:bg-amber-200[open] {
    --tw-bg-opacity: 1;
    background-color: rgb(253 230 138 / var(--tw-bg-opacity));
    }
    th.details-control {
    background-color: #04AA6D;
    color: white;
    }
    td.details-control {
        background: url('/assets/images/details_open.png') no-repeat center center;
        cursor: alias;
    }

    tr.shown td.details-control {
        background: url('/assets/images/details_close.png') no-repeat center center;
    }



    th.subdetails-control {
    background-color: #04AA6D;
    color: white;
    }
    td.subdetails-control {
    background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
    cursor: alias;
    }
    tr.shown td.subdetails-control {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }

    td.subdetails-click {
        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: alias;
    }
    tr.shown td.subdetails-click {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
    .bg-core{
        background-color: #155E95 !important;
        color: white !important;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        display: inline-block;
        vertical-align: middle;
        margin-right: 20px;
        margin-bottom: 0 !important;
        margin-top: 5px !important;
    }

    .dataTables_wrapper .dataTables_filter {
        float: right;
    }
    .dataTables_length{
        margin-left: 20px;
    }
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        display: inline-block;
        vertical-align: middle;
    }

    .dataTables_wrapper .dataTables_paginate {
        float: right;
        margin-left: 20px; /* Adjust spacing as needed */
    }
    .dataTables_wrapper{
        margin-left: 20px;
    }
    .dataTables_paginate{
        padding-right: 20px
    }
    .simplebar-mask{
        height: 100% !important;
    }
    .select2-results__option {
        padding-left: 20 !important; /* Menghapus padding kiri */
    }

    .select2-container .select2-selection--single {
        padding-left: 10px; /* Menambahkan padding kiri pada elemen select2 */
    }
    .modal-xxl {
        max-width: 95% !important; /* Atur sesuai kebutuhan */
    }
</style>
<body>    
    @php
        $satgas = DB::table('master_satgas')::where('id',auth()->user()->satgas)->first();
    @endphp
    <div class="preloader">
        <img src="{{ asset('assets/images/logos/logo.png') }}" alt="loader" class="lds-ripple img-fluid" />
    </div>
    <div id="main-wrapper">
        <aside class="side-mini-panel with-vertical">
            <div class="iconbar">
                <div>
                    @include('components.sidebarmenu')
                </div>
            </div>
        </aside>
        <div class="page-wrapper">
            @include('components.topnavbar')
            <div class="body-wrapper">
                <div class="p-4">

                    @yield('content')
                </div>
            </div>

            @include('components.offcanvas')
        </div>
        <input type="hidden" id="user_theme" value="{{auth()->user()->theme}}">
        <input type="hidden" id="user_color_theme" value="{{auth()->user()->color_theme}}">
    </div>
    <div class="dark-transparent sidebartoggler"></div>
    <!-- Import Js Files -->
    {{-- <script src="{{ asset('vendor') }}/jquery/dist/jquery.min.js"></script> --}}
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    
    <script src="{{ asset('vendor') }}/helper.js"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.init.js') }}"></script>
    <script src="{{ asset('assets/js/theme/theme.js') }}"></script>
    <script src="{{ asset('assets/js/theme/app.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
    {{-- <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></das --}}
    <script src="{{ asset('assets/libs/fullcalendar/index.global.min.js') }}"></script>
    <script src="{{ asset('assets/sweetalert2/sweetalert.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/select2/select2.full.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js" integrity="sha512-BwHfrr4c9kmRkLw6iXFdzcdWV/PGkVgiIyIWLLlTSXzWQzxuSg4DiQUCpauz/EWjgk5TYQqX/kvn9pG1NpYfqg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
    <script>
        $('.customizer-btn').prop('hidden', true)
        function SwalLoading(html = 'Loading ...', title = '') {
                return Swal.fire({
                  title: title,
                  html: html,
                  customClass: 'swal-wide',
                  timerProgressBar: true,
                  allowOutsideClick: false,
                  didOpen: () => {
                      Swal.showLoading()
                  }
              });
          }
        //   $(document).ready(function() {
            //     $.ajaxSetup({
            //         headers: {
            //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //         }
            //     });

            //     // Initialize Select2 with custom options
            //     $(".select2").select2({
            //         placeholder: 'Please select an option',  // Optional placeholder
            //         allowClear: true,                       // Optional clear button
            //         minimumInputLength: 1,                  // Enables searching when typing at least 1 character
            //         width: '100%',                          // Full width
            //         dropdownCssClass: 'myFont bigdrop',     // Custom CSS class for dropdown
            //         // Ensures search field is editable
            //         escapeMarkup: function (markup) {
            //             return markup;
            //         }
            //     });
            // });
            $(document).ready(function(){
             $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},})
                // $(".select2").select2();
                // $('.select2').select2({ dropdownCssClass: "selectOption2" });
                // $(".select2").select2({ width: '300px', dropdownCssClass: "bigdrop" });
                // $(".select2").select2({
                //     dropdownCssClass: "selectOption2",
                //     tags: true,
                //     minimumResultsForSearch: 0
                // });
                $(".select2").each(function(){
                        $(this).select2({
                           
                     });
                });
            })
            // $(".select2").select2({ width: '300px', dropdownCssClass: "bigdrop" });
            // $(document).on('shown.bs.modal', function (e) {
            //     $(e.target).find('.select2').select2({
            //         dropdownParent: $(e.target) // Supaya dropdown tetap dalam modal yang aktif
            //     });
            // });

          toastr.options = {
              "closeButton": false,
              "debug": false,
              "newestOnTop": false,
              "progressBar": true,
              "positionClass": "toast-bottom-right",
              "preventDuplicates": false,
              "onclick": null,
              "showDuration": "300",
              "hideDuration": "1000",
              "timeOut": "5000",
              "extendedTimeOut": "1000",
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }

            $(document).ready(function() {
                $('.dropdown-menu').on('click', function(event) {
                    event.stopPropagation();
                });
            });
    </script>
    
    @stack('js')
</body>

</html>
