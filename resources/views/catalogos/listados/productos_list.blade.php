@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
            <span id="titulo_catalogo">Catálogos </span> |
            <a href="{{ route('productoNew', array('idItem' => 0)) }}" class="btn btn-info btn-sm " target="_blank" title="Agregar nuevo registro">
                <i class="fa fa-plus-circle "></i>
            </a>
            <a href="{{ route('productoIndex', array('npage' => 1, 'tpaginas' => 0, 'tpaginator' => 0)) }}" class="btn btn-info btn-sm " title="Actualizar">
                <i class="fas fa-sync-alt"></i>
            </a>
        </div>

        <div class="panel-body">
            @include('catalogos.listados.paginate_list')
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
                @if ($items)
                    <table id="{{ $tableName}}" class="table table-striped table-bordered table-hover dataTable" >
                        <thead>
                        <tr role="row">
                            <th style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="clave" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Clave</th>
                            <th aria-label="codigo" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Código</th>
                            <th aria-label="descripcion" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Descripción</th>
                            <th aria-label="pv" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">PV</th>
                            <th aria-label="exist" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">Existencia</th>
                            <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->clave }}</td>
                                <td>{{ $item->codigo }}</td>
                                <td>{{ $item->descripcion }}</td>
                                <td>{{ $item->pv}} </td>
                                <td>{{ $item->exist}} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">
                                    @if ($user->hasAnyPermission(['consultar','all']) )
                                        <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="producto-{{$item->id.'-'.$npage.'-'.$tpaginas}}-destroy" title="Eliminar">
                                            <i class="fa fa-trash bigger-150 red" ></i>
                                        </a>
                                    @endif
                                    @if ($user->hasAnyPermission(['consultar','all']) )
                                        {{--<a href="{{ route('catalogos/', array('id' => $id,'idItem' => $item->id,'action' => 1)) }}" class="btn btn-link btn-xs pull-right" title="Editar">--}}
                                        <a href="{{ route('productoEdit', array('idItem' => $item->id)) }}" class="btn btn-link btn-xs pull-right " target="_blank" title="Editar">
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
