<!DOCTYPE html>
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
    <link href="https://fonts.googleapis.com/css?family=Raleway|PT+Sans+Narrow|Roboto:400,400i,500,500i|Roboto+Mono|Roboto+Condensed|Kaushan+Script&effect=3d-float" rel="stylesheet">
    <link href="{{ asset('assets/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/ace-fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my_style_sheet.css') }}" rel="stylesheet">

    @yield('styles')
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand navbar-light navbar-laravel navbar-moriah">
        {{--<div class="container">--}}
        <a class="navbar-brand  pull-left"  style="margin-top: 0;" href="{{ url('/') }}">
            <span class="white font-effect-3d-float font_Kaushan_Script_700">Moriah</span>
        </a>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">

            <!-- Right Side Of Navbar -->
                <!-- Authentication Links -->
                @guest
                        <a class="init-moriah pull-right" href="{{ route('login') }}">Iniciar sesión</a>
                    {{--<li class="links-moriah"><a class="nav-link bolder-lati" href="{{ route('register') }}">Regístrate</a></li>--}}
                @else
                <ul class="navbar pull-right">
                    <li class="nav-item dropdown links-moriah " >
                        <a class="nav-link dropdown-toggle menu-principal-moriah" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if( Auth::user()->IsEmptyPhoto() )
                                <img src="{{ asset('assets/img/empty_user.png')  }}" width="40" height="40" class="img-circle border border-white border-white-moriah"/>
                            @else
                                <img src="{{ asset('archivos'.Auth::user()->root.Auth::user()->filename)  }}" width="40" height="40" class="img-circle border border-white  border-white-moriah"/>
                            @endif
                            {{ Auth::user()->username }}

                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a  class="dropdown-item" href="{{ route('edit') }}"><i class="far fa-address-card"></i> Ver Perfil</a>
                            <a  class="dropdown-item" href="{{ route('showEditProfilePhoto/') }}"><i class="fas fa-user-circle"></i> Cambiar Foto</a>
                            <a  class="dropdown-item" href="{{ route('showEditProfileEmail/') }}"><i class="fas fa-at"></i> Cambiar Email</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Cerrar sesión
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>

        </div>
        {{--</div>--}}
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>


<!-- Scripts -->
{{--<scripts src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></scripts>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-dialog.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/base.js') }}"></script>
<script src="{{ asset('js/moriah.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() { init(); });
    function init() {
        $("#preloaderGlobal").hide();
        if ( $("#titulo_catalogo") ){
                    @if ( isset($titulo_catalogo) )
            var titulo = "{{ $titulo_catalogo}}";
            $("#titulo_catalogo").html(titulo);
            @endif
        }

    }
</script>
@yield('scripts')

@yield('script_datatable')

</body>
</html>