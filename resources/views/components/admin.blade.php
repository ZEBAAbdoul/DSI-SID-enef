<!--
/*!
 *   AdminLTE With Laravel
 *   Author: Nihir Zala
 *   Website: https://nihirz.netlify.app
 *   License: Open source - MIT <https://opensource.org/licenses/MIT>
 */
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title', 'Admin') | {{ config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('admin/favicon/site.webmanifest') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/dist/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Custom CSS -->
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/5.5.2/collection/components/icon/icon.min.css">

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI local -->
    <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.css') }}">
    {{-- Script pour Graphique en anneau --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


    @yield('css')
</head>

<body class="hold-transition sidebar-mini layout-fixed {{ Auth::user()->mode }}-mode">

    <div class="wrapper">
        <!-- Navbar -->
        <x-navbar />
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-{{ Auth::user()->mode }}-primary elevation-4">
            <!-- Brand Logo -->

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Brand Logo -->
                <a href="{{ url('/') }}" class="brand-link d-flex align-items-center justify-content-center"
                    style="height: 90px;">

                    <div class="enef-logo">
                        <div class="enef-title">
                            <span>E</span>
                            <span>N</span>
                            <span>E</span>
                            <span>F</span>
                        </div>

                        <div class="enef-subtitle">
                            École Nationale des Eaux et Forêts
                        </div>
                    </div>

                </a>

                <style>
                    /* ================================
       LOGO ENEF
    ================================= */

                    .enef-logo {
                        text-align: center;
                        position: relative;
                        cursor: pointer;
                    }

                    /* ENEF */
                    .enef-title {
                        display: flex;
                        justify-content: center;
                        gap: 5px;
                        font-family: 'Poppins', sans-serif;
                        font-size: 2.3rem;
                        font-weight: 800;
                        letter-spacing: 5px;

                        /* Animation d'apparition */
                        animation: enefAppear 1.5s ease-out forwards;
                    }

                    .enef-title span {
                        display: inline-block;
                        position: relative;

                        /* Couleur */
                        color: #ffffff;

                        /* Ombre */
                        text-shadow:
                            0 0 5px rgba(255, 255, 255, .4),
                            0 0 15px rgba(40, 167, 69, .5);

                        /* Animation lettre par lettre */
                        animation: enefLetter 2.5s ease-in-out infinite;
                    }

                    /* Décalage des lettres */
                    .enef-title span:nth-child(1) {
                        animation-delay: 0s;
                    }

                    .enef-title span:nth-child(2) {
                        animation-delay: .15s;
                    }

                    .enef-title span:nth-child(3) {
                        animation-delay: .30s;
                    }

                    .enef-title span:nth-child(4) {
                        animation-delay: .45s;
                    }


                    /* ================================
       SOUS-TITRE
    ================================= */

                    .enef-subtitle {
                        margin-top: -2px;

                        color: rgba(255, 255, 255, .85);

                        font-family: 'Poppins', sans-serif;
                        font-size: 7px;
                        font-weight: 500;

                        letter-spacing: 1px;
                        text-transform: uppercase;

                        opacity: 0;

                        animation: subtitleAppear 1.5s ease forwards;
                        animation-delay: 1s;
                    }


                    /* ================================
       LIGNE LUMINEUSE
    ================================= */

                    .enef-logo::after {
                        content: "";

                        position: absolute;
                        left: 50%;
                        bottom: -7px;

                        width: 0;
                        height: 2px;

                        transform: translateX(-50%);

                        background: #28a745;
                        border-radius: 10px;

                        box-shadow:
                            0 0 5px #28a745,
                            0 0 12px #28a745;

                        animation: enefLine 1.5s ease forwards;
                        animation-delay: 1.2s;
                    }


                    /* ================================
       ANIMATION APPARITION
    ================================= */

                    @keyframes enefAppear {

                        0% {
                            opacity: 0;
                            transform: translateY(-20px) scale(.8);
                        }

                        60% {
                            opacity: 1;
                            transform: translateY(5px) scale(1.05);
                        }

                        100% {
                            opacity: 1;
                            transform: translateY(0) scale(1);
                        }
                    }


                    /* ================================
       ANIMATION DES LETTRES
    ================================= */

                    @keyframes enefLetter {

                        0%,
                        100% {
                            transform: translateY(0);
                            text-shadow:
                                0 0 5px rgba(255, 255, 255, .4),
                                0 0 15px rgba(40, 167, 69, .5);
                        }

                        50% {
                            transform: translateY(-3px);

                            text-shadow:
                                0 0 8px #ffffff,
                                0 0 18px #28a745,
                                0 0 28px rgba(40, 167, 69, .6);
                        }
                    }


                    /* ================================
       APPARITION SOUS-TITRE
    ================================= */

                    @keyframes subtitleAppear {

                        from {
                            opacity: 0;
                            transform: translateY(5px);
                        }

                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }


                    /* ================================
       LIGNE
    ================================= */

                    @keyframes enefLine {

                        from {
                            width: 0;
                        }

                        to {
                            width: 80%;
                        }
                    }


                    /* ================================
       HOVER
    ================================= */

                    .enef-logo:hover .enef-title span {
                        color: #28a745;

                        text-shadow:
                            0 0 5px #28a745,
                            0 0 15px #28a745,
                            0 0 30px rgba(40, 167, 69, .8);

                        transition: .3s;
                    }

                    .enef-logo:hover .enef-subtitle {
                        color: #28a745;
                        transition: .3s;
                    }
                </style>





                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        @if (Auth::user()->avatar != null)
                            <img src="{{ Auth::user()->avatar }}" class="img-circle elevation-2" alt="User Image"
                                width="100" height="100">
                        @else
                            <img src="{{ asset('admin/dist/img/user.jpg') }}" class="img-circle elevation-2"
                                alt="User Image" width="100" height="100">
                        @endif

                    </div>
                    <div class="info">
                        <a href="{{ route('admin.dashboard') }}" class="d-block text-white">{{ Auth::user()->name }}
                            {{ Auth::user()->forname }}</a>
                    </div>
                </div>
                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar bg-dark text-white" type="search"
                            placeholder="Rechercher" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar bg-dark">
                                <i class="fas fa-search fa-fw text-white"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <br>
                <!-- Sidebar Menu -->
                <x-sidebar />
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('title')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Acceuil</a></li>
                                <li class="breadcrumb-item active">@yield('title')</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">
                <!-- Default box -->
                {{ $slot }}

                <!-- /.card -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->
    <footer class="main-footer">
        <strong>Copyright &copy; <?= date('Y') ?> <a href="#">ENEF</a>.</strong>
        Tous droits réservés.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('admin/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('admin/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('admin/dist/js/pages/dashboard.js') }}"></script>
    <!-- DataTables -->
    <script src="{{ asset('admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <!-- Toast cdn -->
    <script src="{{ asset('admin/dist/js/toastr.min.js') }}"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Toastr alerts
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
        }
    </script>
    <x-alert />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('js')
</body>

</html>
