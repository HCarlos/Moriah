<!-- #section:basics/navbar.layout -->
<div id="navbar" class="navbar navbar-default">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <!-- /section:basics/sidebar.mobile.toggle -->
        <div class="navbar-header pull-left">
            <!-- #section:basics/navbar.layout.brand -->
            <a href="#" class="navbar-brand">
                <small>
                    <i class="fa fa-leaf"></i>
                    Moriah
                </small>
            </a>

        </div>

        <!-- #section:basics/navbar.dropdown -->
        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">

                <!-- #section:basics/navbar.user_menu -->
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        @if( Auth::user()->IsEmptyPhoto() )
                            <img src="{{ asset('assets/img/empty_user.png')  }}" class="nav-user-photo" alt="{{ Auth::user()->username }}">
                        @else
                            <img src="{{ asset('storage/'.Auth::user()->root.Auth::user()->filename)  }}" class="nav-user-photo" alt="{{ Auth::user()->username }}">
                        @endif
                        {{--<img class="nav-user-photo" src="{{ asset('/avatars/user.jpg') }}" alt="Jason's Photo" />--}}
								<span class="user-info">
									<small>Bienvenid@,</small>
                                    {{ Auth::user()->username }}
								</span>

                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="#">
                                <i class="ace-icon fa fa-picture-o"></i>
                                Cambiar foto
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('edit') }}">
                                <i class="ace-icon fa fa-user"></i>
                                Ver Perfil
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="{{ url('/auth/logout') }}">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                        </li>
                    </ul>

                </li>

                <!-- /section:basics/navbar.user_menu -->
            </ul>
        </div>

        <!-- /section:basics/navbar.dropdown -->
    </div><!-- /.navbar-container -->
</div>

<!-- /section:basics/navbar.layout -->