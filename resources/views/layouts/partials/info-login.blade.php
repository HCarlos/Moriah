


<div id="loginBgCarousel" class="carousel slide minw-100 h-100">
    <ol class="d-none carousel-indicators">
        <li data-target="#loginBgCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#loginBgCarousel" data-slide-to="1"></li>
        <li data-target="#loginBgCarousel" data-slide-to="2"></li>
        <li data-target="#loginBgCarousel" data-slide-to="3"></li>
    </ol>

    <div class="carousel-inner minw-100 h-100">

        <div class="carousel-item active minw-100 h-100">


            <div style="background-image: url(assets/image/login-bg-1.svg);" class="px-3 bgc-blue-l4 d-flex flex-column align-items-center justify-content-center">
                <a class="mt-5 mb-2" href="/">
                    <img src="{{ asset('images/ibt/logo.jpg') }}" class="radius-round bord1er-4 brc-warning-m1" width="120" height="120"  >
                </a>

                <h2 class="text-primary-d1">
                    Instituto Blíblico de Tabasco
                </h2>


                <div class="mt-5 mx-4 text-dark-tp3">
                                                    <span class="text-120">
                                                        El Instituto Bíblico Cristo Rey te invita a conocer tu fe.

                                                    </span>

                    <hr class="mb-1 brc-black-tp10" />
                    <div>
                        <a id="id-fullscreen" class="text-md text-dark-l2 d-inline-block mt-3">
                            <i class="fa fa-expand text-110 text-green-m1 mr-1 w-2"></i>
                            De acuerdo a tu rol, ingresa tus datos para tener acceso a la plataforma.
                        </a>
                    </div>
                </div>
                @include('layouts.partials.derechos_autor')
            </div>

        </div>

    </div>

</div>

