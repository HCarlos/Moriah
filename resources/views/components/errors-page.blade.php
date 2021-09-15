@extends('layouts.app')

@section('contenedor')

    <div class="card m-4">
        <div class="card-header">Errorcillo!</div>
        <div class="card-body">
            <div class="py-3 px-1 py-lg-4 px-lg-5">
                <div class="text-center fa-4x">
                    <span class="text-100 text-dark-m3 d-sm-none"><!-- smaller text to fit in small devices -->
                    ¯\_(ツ)_/¯
                </span>
                <span class="text-110 text-dark-m3 d-none d-sm-inline">
                    ¯\_(ツ)_/¯
                </span>
                </div>
                <div class="text-center fa-4x text-orange-d2 letter-spacing-4">
                    {{ $code }}
                </div>
                <div class="text-center">
                    <span class="text-150 text-primary-d2">
                        {{ $mensaje }}
                    </span>
                </div>
                <div class="text-center mt-4">
                    <a class="btn btn-bgc-white btn-outline-default px-35 btn-text-slide-x" onclick="history.back()">
                        <i class="btn-text-2 fa fa-arrow-left text-110 align-text-bottom mr-2"></i>Regresar
                    </a>
                    <a href="{{ route('home')  }}" class="btn btn-bgc-white btn-outline-primary px-35">
                        <i class="fa fa-home"></i>
                        Inicio
                    </a>
                </div>
            </div>
        </div>
        @include('layouts.partials.footer')
    </div>
@endsection
