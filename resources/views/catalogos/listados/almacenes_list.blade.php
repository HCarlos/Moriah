@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
            <span id="titulo_catalogo">Catálogos </span> |
            <a href="{{ route('almacenNew', array('idItem' => 0)) }}" class="btn btn-info btn-xs " target="_blank" title="Agregar nuevo registro">
                <i class="fa fa-plus-circle bigger-150"></i>
            </a>
            <a href="#" class="btn btn-info btn-xs " title="Actualizar" id="btnRefreshNavigator">
                <i class="ace-icon fa fa-refresh bigger-150"></i>
            </a>
        </div>

        <div class="panel-body">
            @include('catalogos.listados.paginate_list')
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
            @if ($items)
                <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
                    <thead>
                    <tr role="row">
                        <th aria-label="id" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                        <th aria-label="clave_almacen" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Clave</th>
                        <th aria-label="descripcion" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Descripción</th>
                        <th aria-label="responsable" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Responsable</th>
                        <th aria-label="prefijo" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Prefijo</th>
                        <th aria-label="empresa" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Empresa</th>
                        <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                    </tr>
                    </thead>
                    <tbody aria-relevant="all" aria-live="polite" role="alert">
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->clave_almacen }}</td>
                            <td>{{ $item->descripcion }}</td>
                            <td>{{ $item->responsable }}</td>
                            <td>{{ $item->prefijo}} </td>
                            <td>{{ $item->empresa->rs}} </td>
                            <td >
                                <div class="visible-desktop action-buttons">
                                @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                    <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="almacen-{{$item->id.'-'.$npage.'-'.$tpaginas}}-destroy" title="Eliminar">
                                        <i class="fa fa-trash bigger-150 red" ></i>
                                    </a>
                                @endif
                                @if ( $user->hasAnyPermission(['consultar','all','sysop']))
                                    {{--<a href="{{ route('catalogos/', array('id' => $id,'idItem' => $item->id,'action' => 1)) }}" class="btn btn-link btn-xs pull-right" title="Editar">--}}
                                    <a href="{{ route('almacenEdit', array('idItem' => $item->id)) }}" class="btn btn-link btn-xs pull-right editarReg" target="_blank" title="Editar">
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
