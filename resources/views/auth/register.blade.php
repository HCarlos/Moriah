@extends('layouts.app')

@section('contenedor')

    <div class="main-container container bgc-transparent">
        <div class="main-content minh-100 justify-content-center">
            <div class="p-2 p-md-4">
                <div class="row" id="row-1">
                    <div class="col-12 col-xl-10 offset-xl-1 bgc-white shadow radius-1 overflow-hidden">


                        <div class="row" id="row-2">

                            <div id="id-col-intro" class="col-lg-5 d-none d-lg-flex border-r-1 brc-default-l3 px-0">

                                @include('layouts.partials.info-login')

                            </div>


                            <div id="id-col-main" class="col-12 col-lg-7 py-lg-5 bgc-white px-0">


                                <div class="tab-content tab-sliding border-0 p-0" data-swipe="right">

                                    <div class="tab-pane active show mh-100 px-3 px-lg-0 pb-3" id="id-tab-login">
                                        <!-- show this in desktop -->
                                        <div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">
                                            <h4 class="text-dark-tp4 border-b-1 brc-secondary-l2 pb-1 text-130">
                                                <i class="fa fa-coffee text-orange-m1 mr-1"></i>
                                                Regístrate
                                            </h4>
                                        </div>


                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <hr class="brc-default-l2 mt-0 mb-2 w-100" />
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Registrar') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="form-row w-100">
                        <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 d-flex flex-column align-items-center justify-content-center">


                            <div class="p-0 px-md-2 text-dark-tp4 my-3 " >
                                <a class="text-blue-d1 text-600 btn-text-slide-x" href="{{ route('login') }}">
                                    <i class="btn-text-2 fa fa-arrow-left text-110 align-text-bottom mr-2"></i>Ir a Ingresar
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                                    </div><!-- .tab-content -->
                                </div>

                            </div><!-- /.row -->

                        </div><!-- /.col -->







                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
