@extends('layouts.app')

@section('main-content')
    @component('components.panel')
    @slot('titulo','Catálogos ')
    @slot('barra_menu')
        <span id="titulo_catalogo"></span> |
        <a href="{{ route('productoNew', array('idItem' => 0)) }}" class="btn bt1n-small btn-purple no-border btn-xs" target="_blank" title="Agregar nuevo producto">
            <i class="fa fa-plus-circle bigger-150"></i>
        </a>
        <a href="#" class="btn bt1n-small btn-danger no-border btn-xs btnActualizarInventario" title="Actualizar Invetario" id="/actualizar_inventario" data-toggle="modal" data-target="#myModal">
            <i class="ace-icon fa fa-adjust bigger-150 "></i>
        </a>
        <a href="{{ route('imprimirExistencias/')  }}" class="btn bt1n-small btn-cafe no-border btn-xs" title="Imprimir existencias" target="_blank">
            <i class="ace-icon fa fa-print bigger-150 "></i>
        </a>
        <a href="{{ route('productoExistenciaList')  }}" class="btn bt1n-small btn-cafe no-border btn-xs" title="Imprimir Excel" >
            <i class="ace-icon fa fa-print bigger-150 "></i>
        </a>
        <a href="{{ route('imprimirTodosCodigosBarras/')  }}" class="btn bt1n-small btn-primary no-border btn-xs" title="Imprimir Códigos de Barra" target="_blank">
            <i class="ace-icon fa fa-barcode bigger-150 "></i>
        </a>
        <a href="#" class="btn bt1n-small btn-inverse no-border btn-xs pull-right " title="Actualizar" id="btnRefreshNavigator">
            <i class="ace-icon fa fa-refresh bigger-150"></i>
        </a>
    @endslot
    @slot('contenido')
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
                        <th aria-label="pv" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting text-right ">PV</th>
                        <th aria-label="exist" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting text-right ">Existencia</th>
                        <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                    </tr>
                    </thead>
                    <tbody aria-relevant="all" aria-live="polite" role="alert">
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->clave }}</td>
                            <td class="font_Roboto_Mono_400">{{ $item->codigo }}</td>
                            <td>{{ $item->descripcion }}
                                @if( !$item->IsEmptyPhoto() )
                                    <i class="fa fa-picture-o bigger-150 orange2"></i>
                                @endif
                            </td>
                            <td class="text-right font_Roboto_Mono_400">{{ $item->pv}} </td>
                            <td class="text-right font_Roboto_Mono_400">{{ $item->exist}} </td>
                            <td >
                                <div class="visible-desktop visible-phone action-buttons">
                                @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                    <a href="{{ route('productoImagen', array('idItem' => $item->id)) }}" class="btn btn-link btn-xs pull-right " target="_blank" title="Editar">
                                        <i class="fa fa-picture-o bigger-110 orange2"></i>
                                    </a>
                                @endif
                                @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                    <a href="#" class="btn btn-link btn-xs pull-right btnAction2" id ="producto-{{$item->id}}-destroy" title="Eliminar">
                                        <i class="fa fa-trash bigger-110 red" ></i>
                                    </a>
                                @endif
                                @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                    <a href="{{ route('productoEdit', array('idItem' => $item->id)) }}" class="btn btn-link btn-xs pull-right " target="_blank" title="Editar">
                                        <i class="fa fa-pencil bigger-110 light-green"></i>
                                    </a>
                                @endif
                                @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                    <a href="{{ route('imprimirTarjetasMovto/',['producto_id'=>$item->id,'opt'=>1])  }}" class="btn btn-link bt1n-xs pull-right" title="Imprimir tarjeta de movimientos" target="_blank">
                                        <i class="fa fa-list bigger-110 cafe"></i>
                                    </a>
                                @endif
                                @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                    <a href="{{ route('imprimirCodigoBarra/',['producto_id'=>$item->id])  }}" class="btn btn-link bt1n-xs pull-right" title="Imprimir códigos de barra" target="_blank">
                                        <i class="fa fa-barcode bigger-110 purple"></i>
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
    @endslot
    @endcomponent

@endsection

@include('catalogos.scripts.dataTable')
@include('catalogos.scripts.productos')
