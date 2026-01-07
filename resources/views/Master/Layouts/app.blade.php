<!doctype html>
<html lang="en" dir="ltr">

<?php

use App\Http\Controllers\Admin\LoginController;
use App\Models\Admin\AppreanceModel;
use App\Models\Admin\WebModel;
use Illuminate\Support\Facades\Session;

$web = WebModel::first();
$appreance = AppreanceModel::where('user_id', '=', Session::get('user')->user_id)->first();
?>

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ $web->web_deskripsi }}">
    <meta name="author" content="{{ $web->web_nama }}">
    <meta name="keywords" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- FAVICON -->
    @if ($web->web_logo == '' || $web->web_logo == 'default.png')
        <link rel="shortcut icon" type="image/x-icon" href="{{ url('/assets/default/web/default.png') }}" />
    @else
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/web/' . $web->web_logo) }}" />
    @endif

    <!-- TITLE -->
    <title>{{ $title }} | {{ $web->web_nama }}</title>

    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ url('/assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />

    <!-- STYLE CSS -->
    <link href="{{ url('/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ url('/assets/css/dark-style.css') }}" rel="stylesheet" />
    <link href="{{ url('/assets/css/transparent-style.css') }}" rel="stylesheet">
    <link href="{{ url('/assets/css/skin-modes.css') }}" rel="stylesheet" />

    <!--- FONT-ICONS CSS -->
    <link href="{{ url('/assets/css/icons.css') }}" rel="stylesheet" />

    <!-- COLOR SKIN CSS -->
    <link id="theme" rel="stylesheet" type="text/css" media="all"
        href="{{ url('/assets/colors/color1.css') }}" />
    <style>
        :root {
            --primary-bg: #4454c3;
            --primary-gradient: linear-gradient(to bottom right, #4454c3 0%, #2d3dab 100%);
            --secondary-gradient: linear-gradient(to bottom right, #c344ad 0%, #ab2d8e 100%);
            --glass-bg: rgba(255, 255, 255, 0.9);
            --sidebar-width: 270px;
        }

        .app-sidebar {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05) !important;
            border-right: none !important;
        }

        .side-menu__item.active {
            background: var(--primary-gradient) !important;
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(68, 84, 195, 0.3) !important;
            border-radius: 8px !important;
            margin: 4px 12px !important;
        }

        .side-menu__item {
            transition: all 0.3s ease !important;
            margin: 4px 12px !important;
            border-radius: 8px !important;
        }

        .side-menu__item:hover:not(.active) {
            background: rgba(68, 84, 195, 0.05) !important;
            color: var(--primary-bg) !important;
        }

        .app-header {
            background: var(--glass-bg) !important;
            backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02) !important;
        }

        .card {
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05) !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease !important;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08) !important;
        }

        .page-title {
            font-weight: 700 !important;
            letter-spacing: -0.5px !important;
        }

        .btn {
            border-radius: 8px !important;
            font-weight: 600 !important;
            padding: 8px 20px !important;
            transition: all 0.3s ease !important;
        }

        .btn-primary-light {
            background: rgba(68, 84, 195, 0.1) !important;
            color: var(--primary-bg) !important;
            border: none !important;
        }

        .btn-primary-light:hover {
            background: var(--primary-bg) !important;
            color: #fff !important;
        }

        modal.fade {
            z-index: 1050 !important;
        }

        .datepicker {
            z-index: 20000000 !important
        }

        button.cancel {
            background-color: gray !important;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #F5F5F5;
            border-radius: 10px;
        }

        ::-webkit-scrollbar {
            width: 6px;
            background-color: #F5F5F5;
        }

        .dataTables_scrollBody::-webkit-scrollbar {
            width: 6px;
            background-color: #F5F5F5;
            height: 10px !important;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #aaa;
        }
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid rgba(0,0,0,0.1) !important;
            border-radius: 8px !important;
            padding: 6px 12px !important;
            margin-left: 10px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px !important;
            border: none !important;
            margin: 0 2px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-gradient) !important;
            color: #fff !important;
            box-shadow: 0 2px 8px rgba(68, 84, 195, 0.2) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: rgba(68, 84, 195, 0.1) !important;
            color: var(--primary-bg) !important;
        }

        .table thead th {
            text-transform: uppercase !important;
            font-size: 11px !important;
            letter-spacing: 0.5px !important;
            font-weight: 700 !important;
            color: #8e9cad !important;
            border-bottom: 2px solid #f0f0f2 !important;
        }
    </style>
</head>

@if ($appreance != '')

    <body
        class="app ltr {{ $appreance->appreance_layout }} {{ $appreance->appreance_theme }} {{ $appreance->appreance_menu }} {{ $appreance->appreance_header }} {{ $appreance->appreance_sidestyle }}">
    @else

        <body class="app sidebar-mini ltr light-mode">
@endif

<!-- GLOBAL-LOADER -->
@if ($appreance != '')
    <div id="global-loader" class="{{ $appreance->appreance_theme == 'dark-mode' ? 'bg-dark' : '' }}">
    @else
        <div id="global-loader">
@endif
<img src="{{ url('/assets/images/loader.svg') }}" class="loader-img" alt="Loader">
</div>

<!-- /GLOBAL-LOADER -->

<!-- PAGE -->
<div class="page">
    <div class="page-main">

        <!-- APP HEADER -->
        @include('Master.Layouts.header', ['web' => $web])
        <!-- END APP HEADER -->

        <!-- SIDEBAR -->
        @include('Master.Layouts.sidebar-left', ['web' => $web])
        <!-- END SIDEBAR -->

        <!--app-content open-->
        <div class="main-content app-content mt-0">
            <div class="side-app">

                <!-- CONTAINER -->
                <div class="main-container container-fluid">
                    @yield('content')
                </div>
                <!-- CONTAINER END -->
            </div>
        </div>
        <!--app-content close-->

    </div>

    <!-- SIDEBAR RIGHT -->
    <!-- (-) -->
    <!-- END SIDEBAR RIGHT -->

    <!-- FOOTER -->
    @include('Master.Layouts.footer', ['web' => $web])
    <!-- FOOTER END -->

</div>

<!-- MODAL LOGOUT -->
<div class="modal fade" data-bs-backdrop="static" id="modalLogout">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <form method="GET" action="{{ url('admin/logout') }}" name="myFormH" enctype="multipart/form-data">
                @csrf
                <div class="modal-body text-center p-4 pb-5">
                    <button type="reset" aria-label="Close" class="btn-close position-absolute"
                        data-bs-dismiss="modal"><span aria-hidden="true">×</span></button>
                    <br>
                    <i class="icon icon-exclamation fs-70 text-warning lh-1 my-5 d-inline-block"></i>
                    <h3 class="mb-5">Yakin logout ?</h3>
                    <button type="submit" class="btn btn-danger-light pd-x-25">Iya</button>
                    <button type="reset" data-bs-dismiss="modal" class="btn btn-default pd-x-25">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- BACK-TO-TOP -->
<a href="#top" id="back-to-top"><i class="fa fa-angle-up"></i></a>

<!-- JQUERY JS -->
<script src="{{ url('/assets/js/jquery.min.js') }}"></script>

<!-- BOOTSTRAP JS -->
<script src="{{ url('/assets/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ url('/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Sticky js -->
<script src="{{ url('/assets/js/sticky.js') }}"></script>

<!-- INPUT MASK JS-->
<script src="{{ url('/assets/plugins/input-mask/jquery.mask.min.js') }}"></script>

<!-- SIDE-MENU JS-->
<script src="{{ url('/assets/plugins/sidemenu/sidemenu.js') }}"></script>

<!-- SIDEBAR JS -->
<script src="{{ url('/assets/plugins/sidebar/sidebar.js') }}"></script>

<!-- Perfect SCROLLBAR JS-->
<script src="{{ url('/assets/plugins/p-scroll/perfect-scrollbar.js') }}"></script>
<script src="{{ url('/assets/plugins/p-scroll/pscroll.js') }}"></script>
<script src="{{ url('/assets/plugins/p-scroll/pscroll-1.js') }}"></script>

<!-- FILE UPLOADES JS -->
<script src="{{ url('/assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ url('/assets/plugins/fileuploads/js/file-upload.js') }}"></script>

<!-- INTERNAL Bootstrap-Datepicker js-->
<script src="{{ url('/assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<!-- SELECT2 JS -->
<script src="{{ url('/assets/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ url('/assets/js/select2.js') }}"></script>

<!-- BOOTSTRAP-DATERANGEPICKER JS -->
<script src="{{ url('/assets/plugins/bootstrap-daterangepicker/moment.min.js') }}"></script>
<script src="{{ url('/assets/plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<!-- INTERNAL Bootstrap-Datepicker js-->
<script src="{{ url('/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>

<!-- INTERNAL Sumoselect js-->
<script src="{{ url('/assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>

<!-- TIMEPICKER JS -->
<script src="{{ url('/assets/plugins/time-picker/jquery.timepicker.js') }}"></script>
<script src="{{ url('/assets/plugins/time-picker/toggles.min.js') }}"></script>

<!-- INTERNAL intlTelInput js-->
<script src="{{ url('/assets/plugins/intl-tel-input-master/intlTelInput.js') }}"></script>
<script src="{{ url('/assets/plugins/intl-tel-input-master/country-select.js') }}"></script>
<script src="{{ url('/assets/plugins/intl-tel-input-master/utils.js') }}"></script>

<!-- INTERNAL jquery transfer js-->
<script src="{{ url('/assets/plugins/jQuerytransfer/jquery.transfer.js') }}"></script>

<!-- INTERNAL multi js-->
<script src="{{ url('/assets/plugins/multi/multi.min.js') }}"></script>

<!-- DATEPICKER JS -->
<script src="{{ url('/assets/plugins/date-picker/date-picker.js') }}"></script>
<script src="{{ url('/assets/plugins/date-picker/jquery-ui.js') }}"></script>
<script src="{{ url('/assets/plugins/input-mask/jquery.maskedinput.js') }}"></script>

<!-- COLOR PICKER JS -->
<script src="{{ url('/assets/plugins/pickr-master/pickr.es5.min.js') }}"></script>
<script src="{{ url('/assets/js/picker.js') }}"></script>

<!-- MULTI SELECT JS-->
<script src="{{ url('/assets/plugins/multipleselect/multiple-select.js') }}"></script>
<script src="{{ url('/assets/plugins/multipleselect/multi-select.js') }}"></script>

<!-- SWEET-ALERT JS -->
<script src="{{ url('/assets/plugins/sweet-alert/sweetalert.min.js') }}"></script>
<script src="{{ url('/assets/js/sweet-alert.js') }}"></script>

<!-- INTERNAL CHARTJS CHART JS-->
<script src="{{ url('/assets/plugins/chart/Chart.bundle.js') }}"></script>
<script src="{{ url('/assets/plugins/chart/rounded-barchart.js') }}"></script>
<script src="{{ url('/assets/plugins/chart/utils.js') }}"></script>

<!-- DATA TABLE JS-->
<script src="{{ url('/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('/assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
<script src="{{ url('/assets/js/table-data.js') }}"></script>


<!-- INTERNAL INDEX JS -->
<script src="{{ url('/assets/js/index1.js') }}"></script>

<!-- Color Theme js -->
<script src="{{ url('/assets/js/themeColors.js') }}"></script>

<!-- CUSTOM JS -->
<script src="{{ url('/assets/js/custom.js') }}"></script>

<script>
    $(document).ready(function() {
        // BOOTSTRAP DATEPICKER
        $('.datepicker-date').bootstrapdatepicker({
            format: "yyyy-mm-dd",
            viewMode: "date",
            autoclose: true,
        })
    })
</script>

@if (Session::get('status') == 'success')
    <script>
        $(document).ready(function() {
            swal({
                title: "{{ Session::get('msg') }}",
                type: "success"
            });
        });
    </script>
@elseif(Session::get('status') == 'error')
    <script>
        $(document).ready(function() {
            swal({
                title: "{{ Session::get('msg') }}",
                type: "error"
            });
        });
    </script>
@endif

@yield('scripts')
@yield('formTambahJS')
@yield('formEditJS')
@yield('formHapusJS')
@yield('formOtherJS')

</body>

</html>
