<!-- #section:basics/sidebar -->
<div id="sidebar" class="sidebar                  responsive">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <ul class="nav nav-list">
        <li class="">
            <a href="/home">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Inicio </span>
            </a>

            <b class="arrow"></b>
        </li>

        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-book"></i>
							<span class="menu-text">
								Catálogos
							</span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="{{ route('empresaIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-book green"></i>
                        Empresas
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="{{ route('almacenIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-book orange"></i>
                        Almacenes
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="">
                    <a href="{{ route('productoIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-book red"></i>
                        Productos
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <li class="">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-cogs"></i>
                <span class="menu-text"> Configuraciones </span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li class="">
                    <a href="#">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Asignar Permisos a Roles
                    </a>

                    <b class="arrow"></b>
                </li>

                <li class="">
                    <a href="#">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Asignar Roles a Usuarios
                    </a>

                    <b class="arrow"></b>
                </li>
            </ul>
        </li>



    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>

<!-- /section:basics/sidebar -->