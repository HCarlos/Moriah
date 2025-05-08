<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="tecnointel.mx" name="author">

    <link href="{{ asset('assets/img/favicon/favicon72x72.png') }}" rel="shortcut icon">
    <link href="{{ asset('assets/img/favicon/favicon32x32.png') }}" rel="apple-touch-icon">
    <link href="{{ asset('assets/img/favicon/favicon72x72.ico') }}" rel="apple-touch-icon" sizes="72x72">
    <link href="{{ asset('assets/img/favicon/favicon16x16.ico') }}" rel="shortcut icon" sizes="16x16">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300|Raleway|Roboto+Condensed|Tangerine&effect=3d-float" rel="stylesheet">
    <link href="https://moriah.mx/css/my_style_sheet.css" rel="stylesheet">

    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }
        .subtitle {
            font-size: 42px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>

</head>

<body>
    <div class="flex-center position-ref full-height">

        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    @role('alumno')
                        {{--<a href="/home_alumno">Realizar búsqueda</a>--}}
                    @else
                        <a href="{{ url('/home') }}">Entrar</a>
                    @endrole
                @else
                    <a href="{{ route('login') }}">Iniciar sesión</a>
                    {{--<a href="{{ route('register') }}">Regístrate</a>--}}
                @endauth
            </div>
        @endif

        <div class="content" style="margin-top: -12em;">
            <h1 class="text-cafe  font-effect-3d-float font_Tangerine_700" style="font-size: 10em; ">Moriah</h1>
            <h2 class="text-inverse text-center font_Roboto_Condensed_400" style="margin-top: -5em; ">Punto de Venta y Control de Inventario</h2>
            <h3 class="text-inverse text-center font_Open_Sans_Condensed_expanded_300" style="margin-top: -1em;">SOFTWARE</h3>
        </div>
        <p class="wellcome-pos-version font_Open_Sans_Condensed_300">v 1.0</p>
        <p class="wellcome-pos-twitter ">by <a href="https://twitter.com/DevCH" target="_blank" class="font_Roboto_Condensed_400">@DevCH</a></p>
    </div>
</body>
</html>
