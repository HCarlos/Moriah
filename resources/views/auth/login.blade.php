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

                            <div id="id-col-main" class="col-12 col-lg-7 py-lg-3 bgc-white px-0">


                                <div class="tab-content tab-sliding border-0 p-0" data-swipe="right">

                                    <div class="tab-pane active show mh-100 px-3 px-lg-0 pb-3" >
                                        @include('share.otros.___erros-forms')
                                        <!-- show this in desktop -->
                                        <div class="d-none d-lg-block col-md-6 offset-md-3 mt-lg-4 px-0">
                                            <h4 class="text-dark-tp4 border-b-1 brc-secondary-l2 pb-1 text-130">
                                                <i class="fa fa-coffee text-orange-m1 mr-1"></i>
                                                Bienvenid@
                                            </h4>
                                        </div>

                                        <!-- show this in mobile device -->
                                        <div class="d-lg-none text-secondary-m1 my-4 text-center">
                                            <a href="html/dashboard.html">
                                                <i class="fa fa-leaf text-success-m2 text-200 mb-4"></i>
                                            </a>
                                            <h1 class="text-170">
                                                <span class="text-blue-d1">
                                                    Ace <span class="text-80 text-dark-tp3">Application</span>
                                                </span>
                                            </h1>

                                            Bienvenid@
                                        </div>
                                        <form  class="form-row mt-4"  method="POST" action="{{ route('login') }}">
                                            @csrf



                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
                                                    <input placeholder="Username" type="text" class="form-control form-control-lg pr-4 shadow-none  @error('username') is-invalid @enderror " name="username" id="username" />
                                                    <i class="fa fa-user text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 ml-n3" for="username">
                                                        Username
                                                    </label>
                                                </div>
                                                @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>


                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3 mt-2 mt-md-1">
                                                <div class="d-flex align-items-center input-floating-label text-blue brc-blue-m2">
                                                    <input placeholder="Password" type="password" class="form-control form-control-lg pr-4 shadow-none @error('password') is-invalid @enderror" id="password" name="password" />
                                                    <i class="fa fa-key text-grey-m2 ml-n4"></i>
                                                    <label class="floating-label text-grey-l1 ml-n3" for="password">
                                                        Password
                                                    </label>
                                                </div>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                                                <div class="mb-4 float-right">
                                                    <input type="checkbox" id="remember" name="remember" class="mr-1"
                                                        {{ old('remember') ? 'checked' : '' }}>
                                                    <label for="remember" class="d-inline-block mt-3 mb-0 text-dark-l1">
                                                        Recuérdame
                                                    </label>
                                                </div>

                                                <button type="submit" class="btn btn-primary btn-block px-4 btn-bold mt-2 mb-4">
                                                    Ingresar
                                                </button>
                                            </div>

                                        </form>
                                        @include('layouts.partials.redes_socieales')
                                    </div>

                                    <div class="tab-pane mh-100 px-3 px-lg-0 pb-3" id="id-tab-signup" data-swipe-prev="#id-tab-login">
                                        <div class="position-tl ml-3 mt-3 mt-lg-0">
                                            <a href="#" class="btn btn-light-default btn-h-light-default btn-a-light-default btn-bgc-tp" data-toggle="tab" data-target="#id-tab-login">
                                                <i class="fa fa-arrow-left"></i>
                                            </a>
                                        </div>
                                    </div><!-- .tab-content -->
                                </div>
                            </div><!-- /.row -->
                        </div>




                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('style-header')
    <script src="{{ asset('views/pages/page-login/@page-style.css') }}"></script>
@endsection
@section('script-footer')
    <script src="{{ asset('views/pages/page-login/@page-script.js') }}"></script>
@endsection
