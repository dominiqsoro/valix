<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Tableau de bord | Valix - Optimisez vos livraisons, boostez votre business.')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Optimisez vos livraisons, boostez votre business">
    <meta name="author" content="ByDS">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style">
    <!-- Icons css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css">

    <!-- Flatpickr Timepicker css -->
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Styles additionnels -->
    @stack('styles')
</head>

<body data-menu-color="light" data-sidebar="default">

    @include('partials.alerts')
    <div id="app-layout">
        {{-- Top Bar --}}
        @include('partials.topbar')

        {{-- Navigation Bar --}}
        @include('partials.sidebar')

        <!-- ============================================================== -->
        <!-- Début du contenu de la page -->
        <!-- ============================================================== -->
        <div class="content-page">
            <div class="content">
                @yield('content')
            </div> <!-- /.content -->
        </div>
        <!-- ============================================================== -->
        <!-- Fin du contenu de la page -->
        <!-- ============================================================== -->

        {{-- Footer --}}
        @include('partials.footer')
    </div>
    <!-- END wrapper -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


    <!-- Vendor Scripts -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/waypoints/lib/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/libs/jquery.counterup/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>

    <!-- Apexcharts JS -->
    <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

    <!-- Script pour le graphique (vérifiez que le fichier est bien à cet emplacement) -->
    <script src="{{ asset('assets/libs/apexcharts/stock-prices.js') }}"></script>

    <!-- Widgets Init Js -->
    <script src="{{ asset('assets/js/pages/ecommerce-dashboard.init.js') }}"></script>
    <script src="{{ asset('assets/js/pages/crm-dashboard.init.js') }}"></script>

    <!-- Flatpickr Timepicker Plugin js -->
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-picker.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Scripts additionnels -->
    @stack('scripts')
</body>

</html>
