<div id="sidebar" class="sidebar responsive">

    <ul class="nav nav-list" id="menuPrincipal">
        <li>
            <a href="{{ route('ventasIndex', ['fecha' => \Carbon\Carbon::now()->format('ymd')]) }}">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Ventas </span>
            </a>
            <b class="arrow"></b>
        </li>
        <li>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-book"></i>
							<span class="menu-text">
								Catálogos
							</span>

                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li>
                    <a href="{{ route('empresaIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-book green"></i>
                        Empresas
                    </a>
                    <b class="arrow"></b>
                </li>
                <li>
                    <a href="{{ route('almacenIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-book orange"></i>
                        Almacenes
                    </a>
                    <b class="arrow"></b>
                </li>
                <li>
                    <a href="{{ route('productoIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-book red"></i>
                        Productos
                    </a>
                    <b class="arrow"></b>
                </li>
                <li>
                    <a href="{{ route('paqueteIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-cubes cafe"></i>
                        Paquetes
                    </a>
                    <b class="arrow"></b>
                </li>
                <li>
                    <a href="{{ route('pedidoIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-cubes purple"></i>
                        Pedidos
                    </a>
                    <b class="arrow"></b>
                </li>
                <li>
                    <a href="{{ route('compraIndex') }}">
                        <i class="menu-icon fa fa-archive green"></i>
                        Compras
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>

        <li>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-cogs"></i>
                <span class="menu-text"> Configuraciones </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                @role('administrator|sysop')
                <li>
                    <a href="{{ route('usuarioIndex', ['npage' => 1, 'tpaginas' => 0]) }}">
                        <i class="menu-icon fa fa-book red"></i>
                        Usuarios
                    </a>
                    <b class="arrow"></b>
                </li>
                @endrole
                @role('administrator')
                    <li>
                        <a href="{{ route('asignItem/', ['ida' => 0,'iduser' => 0]) }}">
                            <i class="menu-icon fa fa-cog"></i>
                            Asignar Roles a Usuarios
                        </a>

                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{ route('asignItem/', ['ida' => 1,'iduser' => 0]) }}">
                            <i class="menu-icon fa fa-cog"></i>
                            Asignar Permisos a Roles
                        </a>
                        <b class="arrow"></b>
                    </li>
                    <li>
                        <a href="{{ route('archivosConfig/') }}">
                            <i class="menu-icon fa fa-cog"></i>
                            Archivos
                        </a>
                        <b class="arrow"></b>
                    </li>
                @endrole
            </ul>
        </li>
        <li>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-info"></i>
                <span class="menu-text"> Reportes </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>

            <b class="arrow"></b>

            <ul class="submenu">
                <li>
                    <a href="{{ route('panelConsulta1') }}">
                        <i class="menu-icon fa fa-search"></i>
                        Consultas
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
</div>

