<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
    <base href="../" />

    <title>{{ config('app.name')  }}</title>

{{--    @livewireStyles--}}

    <!-- include common vendor stylesheets & fontawesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/fontawesome.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/regular.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/brands.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('node_modules/@fortawesome/fontawesome-free/css/solid.css') }}">


    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/ace-font.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('dist/css/ace.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-plus/dataTables.bootstrap4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{--css para el datatable-plus--}}
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-plus/jquery.dataTables.css') }}">
    {{--css para el datatable-plus--}}
    <link rel="stylesheet" href="{{ asset('assets/css/datatable-plus/responsive.dataTables.css') }}">

    <link rel="stylesheet" href="https://code.jquery.com/jquery-3.5.1.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js">


    @yield('style-header')

    <link rel="icon" type="image/png" href="{{ asset('asset/favicon.png') }}" />



</head>

<body>
<div class="body-container">
    @auth()
        @include('layouts.partials.navbar')
        <div class="main-container bgc-white">
            @include('layouts.partials.side-bar')
            <div class="main-content ">
                <div class="page-content m-1 ">
                    @yield('contenedor')
                    @include('layouts.partials.footer')
                </div>
            </div>
        </div>
    @else
        @yield('contenedor')
    @endauth
</div>

<div class="modal fade" id="modalFull" data-backdrop-bg="bgc-grey-tp4" data-blur="true" tabindex="-1" role="dialog" aria-labelledby="modalFull" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content border-0 shadow radius-1">
            @yield('ModalBlurred')
        </div>
    </div>
</div>




{{--@livewireScripts--}}

<!-- include common vendor scripts used in demo pages -->
<script src="{{ asset('node_modules/jquery/dist/jquery.js') }}"></script>
<script src="{{ asset('node_modules/popper.js/dist/umd/popper.js') }}"></script>
<script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.js') }}"></script>

<script src="{{ asset('node_modules/sortablejs/Sortable.js') }}"></script>

<script src="{{ asset('dist/js/ace.js') }}"></script>

<script src="{{ asset('assets/js/datatable-plus/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/js/datatable-plus/dataTables.responsive.js') }}"></script>
<script src="{{ asset('/assets/js/datatable-plus/dataTables-call.js') }}"></script>
<script src="{{ asset('assets/js/datatable.js') }}"></script>

<!-- "Login" page styles, specific to this page for demo only -->
@yield('script-footer')

<script src="{{ asset('assets/js/ibt.js') }}"></script>

</body>
</html>
