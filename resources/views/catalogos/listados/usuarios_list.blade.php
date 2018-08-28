@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
            <span id="titulo_catalogo">Catálogos </span> |
            <a href="{{ route('usuarioNew', array('idItem' => 0)) }}" class="btn btn-info btn-xs" target="_blank" title="Agregar nuevo registro">
                <i class="fa fa-plus-circle bigger-150"></i>
            </a>
            <a href="#" class="btn btn-info btn-xs " title="Actualizar" id="btnRefreshNavigator">
                <i class="ace-icon fa fa-refresh bigger-150"></i>
            </a>
        </div>

        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            @include('catalogos.filters._filter_user_search')
            <div class="dataTables_wrapper" role="grid">
                @if ($items)
                    <table id="{{ $tableName}}" class="table table-striped table-bordered table-hover dataTable" >
                        <thead>
                        <tr role="row">
                            <th aria-label="id" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="username" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Username</th>
                            <th aria-label="ap_paterno" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Ap. Paterno</th>
                            <th aria-label="ap_paterno" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Ap. Materno</th>
                            <th aria-label="nombre" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Nombre</th>
                            <th aria-label="email" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting text-right">Email</th>
                            <th aria-label="cuenta" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="6" role="columnheader" class="sorting text-right">Cuents</th>
                            <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->username }}</td>
                                <td>{{ $item->ap_paterno }}</td>
                                <td>{{ $item->ap_materno }}</td>
                                <td>{{ $item->nombre }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->cuenta }}</td>
                                <td >
                                    <div class="visible-desktop action-buttons">
                                    @if ($user->hasAnyPermission(['all','sysop']) )
                                        <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="usuario-{{$item->id}}-destroy" title="Eliminar">
                                            <i class="fa fa-trash bigger-150 red" ></i>
                                        </a>
                                    @endif
                                    @if ($user->hasAnyPermission(['all','sysop']) )
                                        {{--<a href="{{ route('catalogos/', array('id' => $id,'idItem' => $item->id,'action' => 1)) }}" class="btn btn-link btn-xs pull-right" title="Editar">--}}
                                        <a href="{{ route('usuarioEdit', array('idItem' => $item->id)) }}" class="btn btn-link btn-xs pull-right " target="_blank" title="Editar">
                                            <i class="fa fa-pencil bigger-150 blue"></i>
                                        </a>
                                    @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-danger" role="alert">No se encontraron datos</div>
                @endif
            </div>
        </div>
    </div>


@endsection

@include('catalogos.scripts.dataTable')
