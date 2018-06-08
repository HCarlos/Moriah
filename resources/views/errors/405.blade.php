<!DOCTYPE html>
<html lang="en">
@include('partials.htmlheader')
<body class="no-skin">

@if (! Auth::guest())
    @include('partials.navbar')
@endif

<div class="main-container" id="main-container">
    @if (! Auth::guest())
        @include('partials.sidebar')
    @endif

    <div class="main-content">
        <div class="main-content-inner">
            <div class="page-content">
                <!-- #section:pages/error -->
                <div class="error-container">
                    <div class="well">
                        <h1 class="grey lighter smaller">
                <span class="blue bigger-125">
                    <i class="ace-icon fa fa-sitemap"></i>
                    405
                </span>
                            Página no encontrada
                        </h1>
                        <hr />

                        <div class="space"></div>

                        <div class="center">
                            <a href="{{ url('/') }}" class="btn btn-primary">
                                <i class="ace-icon fa fa-tachometer"></i>
                                Inicio
                            </a>
                        </div>
                    </div>
                </div>

                <!-- /section:pages/error -->
            </div>
        </div>
    </div>

    @include('partials.footer')

</div>

@include('partials.scripts')

</body>
</html>

