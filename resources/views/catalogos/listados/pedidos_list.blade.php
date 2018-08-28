@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
            <span id="titulo_catalogo">Catálogos </span> |
            <a href="{{ route('pedidoNew', array('idItem' => 0)) }}" class="btn btn-info btn-xs" target="_blank" title="Agregar nuevo registro">
                <i class="fa fa-plus-circle bigger-150"></i>
            </a>
            <a href="#" class="btn btn-info btn-xs " title="Actualizar" id="btnRefreshNavigator">
                <i class="ace-icon fa fa-refresh bigger-150"></i>
            </a>
            @include('catalogos.listados.paginate_list')
        </div>

        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
                @if ($items)
                    <table id="{{ $tableName}}" class="table table-striped table-bordered table-hover dataTable" >
                        <thead>
                        <tr role="row">
                            <th style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="codigo" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Código</th>
                            <th aria-label="descripcion" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Descripción</th>
                            <th aria-label="Importe" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting text-right">Importe</th>
                            <th aria-label="" style="width: 120px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->descripcion_pedido }}</td>
                                <td class="text-right">{{ $item->importe}} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">

                                        @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                            <a href="{{ route('pedidoDetalleIndex', ['id' => $item->id]) }}" class="btn btn-link btn-xs pull-right " target="_blank" title="Construir Pedido">
                                                <i class="fa fa-cubes bigger-150 purple"></i>
                                            </a>
                                        @endif

                                            {{--@if ($user->hasAnyPermission(['consultar','all','sysop']) )--}}
                                            {{--<a href="{{ route('pedidoImagen', array('idItem' => $item->id)) }}" class="btn btn-link btn-xs pull-right " target="_blank" title="Editar">--}}
                                                {{--<i class="fa fa-picture-o bigger-150 orange2"></i>--}}
                                            {{--</a>--}}
                                        {{--@endif--}}
                                        @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                            <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="pedido-{{$item->id}}-destroy" title="Eliminar">
                                                <i class="fa fa-trash bigger-150 red" ></i>
                                            </a>
                                        @endif
                                        {{--@if ($user->hasAnyPermission(['consultar','all','sysop']) )--}}
                                            {{--<a href="{{ route('pedidoEdit', ['idItem' => $item->id]) }}" class="btn btn-link btn-xs pull-right " target="_blank" title="Editar">--}}
                                                {{--<i class="fa fa-pencil bigger-150 blue"></i>--}}
                                            {{--</a>--}}
                                        {{--@endif--}}
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
