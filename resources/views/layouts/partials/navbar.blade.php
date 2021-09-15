@auth()
    <nav class="navbar navbar-expand-lg navbar-fixed navbar-blue">
        <div class="navbar-inner">

            <div class="navbar-intro justify-content-xl-between">

                <button type="button" class="btn btn-burger burger-arrowed static collapsed ml-2 d-flex d-xl-none" data-toggle-mobile="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="false" aria-label="Toggle sidebar">
                    <span class="bars"></span>
                </button><!-- mobile sidebar toggler button -->

                <a class="navbar-brand text-white" href="#">
                    <i class="fa fa-cross"></i>
                    {{ config('app.name') }}
                </a><!-- /.navbar-brand -->

                <button type="button" class="btn btn-burger mr-2 d-none d-xl-flex" data-toggle="sidebar" data-target="#sidebar" aria-controls="sidebar" aria-expanded="true" aria-label="Toggle sidebar">
                    <span class="bars"></span>
                </button><!-- sidebar toggler button -->

            </div><!-- /.navbar-intro -->

            <!-- mobile #navbarMenu toggler button -->
            <button class="navbar-toggler ml-1 mr-2 px-1" type="button" data-toggle="collapse" data-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navbar menu">
            <span class="pos-rel">
                @if( Auth::user()->IsEmptyPhoto() )
                    @if( Auth::user()->IsFemale() )
                        <img class="border-2 brc-white-tp1 radius-round" width="36" src="{{ asset('assets/image/avatar/avatar1.png')  }}" alt="{{ Auth::user()->username  }}">
                    @else
                        <img class="border-2 brc-white-tp1 radius-round" width="36" src="{{ asset('assets/image/avatar/avatar.png')  }}" alt="{{ Auth::user()->username  }}">
                    @endif
                @else
                    <img src="{{ asset(env('PROFILE_ROOT').'/'. Auth::user()->filename_png)  }}?timestamp={{now()}}" class="border-2 brc-white-tp1 radius-round" width="36"   alt="{{Auth::user()->username}}"/>
                @endif
                  <span class="bgc-warning radius-round border-2 brc-white p-1 position-tr mr-n1px mt-n1px"></span>
            </span>
            </button>


            <div class="navbar-menu collapse navbar-collapse navbar-backdrop" id="navbarMenu">

                <div class="navbar-nav">
                    <ul class="nav">

                        @if (Route::has('login'))
                            <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                                @auth
                                    <a href="{{ url('/home') }}" class="text-sm text-gray-700 underline">Home</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Login</a>
                                @endif
                            </div>
                        @endif

                        @auth
                        <li class="nav-item dropdown order-first order-lg-last">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                @if( Auth::user()->IsEmptyPhoto() )
                                    @if( Auth::user()->IsFemale() )
                                        <img id="id-navbar-user-image" class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6"  src="{{ asset('assets/image/avatar/avatar1.png')  }}" alt="{{ Auth::user()->username  }}">
                                    @else
                                        <img id="id-navbar-user-image" class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6"  src="{{ asset('assets/image/avatar/avatar.png')  }}" alt="{{ Auth::user()->username  }}">
                                    @endif
                                @else
                                    <img src="{{ asset(env('PROFILE_ROOT').'/'. Auth::user()->filename_png)  }}?timestamp={{now()}}" id="id-navbar-user-image" class="d-none d-lg-inline-block radius-round border-2 brc-white-tp1 mr-2 w-6"  alt="{{Auth::user()->username}}"/>
                                @endif
                                    <span class="d-inline-block d-lg-none d-xl-inline-block">
                                        <span class="text-90" id="id-user-welcome">Bienvenid{{Auth::user()->IsFemale() ? 'a' :'o'}},</span>
                                        <span class="nav-user-name">{{Auth::user()->username}}</span>
                                    </span>
                                <i class="caret fa fa-angle-down d-none d-xl-block"></i>
                                <i class="caret fa fa-angle-left d-block d-lg-none"></i>
                            </a>

                            <div class="dropdown-menu dropdown-caret dropdown-menu-right dropdown-animated brc-primary-m3 py-1">

                                <a href="{{route('editProfile',['Id' => Auth::user()])}}" class="mt-1 dropdown-item btn btn-outline-grey bgc-h-primary-l3 btn-h-light-primary btn-a-light-primary">
                                    <i class="fa fa-user text-primary-m1 text-105 mr-1"></i>
                                    Perfil
                                </a>

                                <a href="{{ route('editFotodUser',['Id'=>Auth::user()])  }}" class="mt-1 dropdown-item btn btn-outline-grey bgc-h-primary-l3 btn-h-light-primary btn-a-light-primary">
                                    <i class="fa fa-image text-primary-m1 text-105 mr-1"></i>
                                    Foto
                                </a>

                                <a href="{{ route('editPasswordUser',['Id'=>Auth::user()])  }}" class="dropdown-item btn btn-outline-grey bgc-h-success-l3 btn-h-light-success btn-a-light-success" >
                                    <i class="fa fa-key text-success-m1 text-105 mr-1"></i>
                                    Contraseña
                                </a>

                                <div class="dropdown-divider brc-primary-l2"></div>

                                <a href="{{ route('logout') }}" class="dropdown-item btn btn-outline-grey bgc-h-secondary-l3 btn-h-light-secondary btn-a-light-secondary" onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">Cerrar Sesión
                                    <i class="fa fa-power-off text-warning-d1 text-105 mr-1"></i>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </div>
                        </li><!-- /.nav-item:last -->
                        @endif
                    </ul><!-- /.navbar-nav menu -->
                </div><!-- /.navbar-nav -->

            </div><!-- /#navbarMenu -->


        </div><!-- /.navbar-inner -->

    </nav>

@endauth
