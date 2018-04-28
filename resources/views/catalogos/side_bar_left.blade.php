<div class="list-group todoloAncho" id="dvCatalogos0">
    @role('user|administrator')
    <a class="button list-group-item form-control" href="{{ route('empresaIndex', ['npage' => 1, 'tpaginas' => 0]) }}">Empresas</a>
    <a class="button list-group-item form-control" href="{{ route('almacenIndex', ['npage' => 1, 'tpaginas' => 0]) }}">Almacenes</a>
    <a class="button list-group-item form-control" href="{{ route('listItem', ['id' => 2,'npage' => 1, 'tpaginas' => 0]) }}">Medidas</a>
    <a class="button list-group-item form-control" href="{{ route('productoIndex', ['npage' => 1, 'tpaginas' => 0]) }}">Productos</a>
    <a class="button list-group-item form-control" href="{{ route('listItem', ['id' => 4,'npage' => 1, 'tpaginas' => 0]) }}">Paquetes</a>
    <a class="button list-group-item form-control" href="{{ route('listItem', ['id' => 5,'npage' => 1, 'tpaginas' => 0]) }}">Proveedores</a>
    {{--<a></a>--}}
    {{--<a class="button list-group-item form-control" href="#" id="btnPrueba">Prueba</a>--}}
    @endrole

    @role('administrator|system_operator')
    <a class="button list-group-item form-control" href="{{ route('listItem', ['id' => 10,'npage' => 1, 'tpaginas' => 0]) }}">Usuarios</a>
    @endrole
    @role('administrator')
    <a class="button list-group-item form-control" href="{{ route('listItem', ['id' => 11,'npage' => 1, 'tpaginas' => 0]) }}">Roles</a>
    <a class="button list-group-item form-control" href="{{ route('listItem', ['id' => 12,'npage' => 1, 'tpaginas' => 0]) }}">Permisos</a>
    @endrole
</div>

    {{--<a class="button list-group-item" href="{{ route('ajaxIndexCatList', ['id' => 0)) }}">Prueba</a>--}}
