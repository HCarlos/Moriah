@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
                        <span id="titulo_catalogo">
                            <i class="fa fa-user default"></i>
                            COMPRAS
                        </span>
            <a id="/form_compra_nueva_ajax" class="btn btn-purple btn-minier icon-only marginLeft2em btnCompraNueva" title="Agregar Producto" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus bigger-150"></i>
            </a>

        </div>

        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
                @if ($compras)
                    <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
                        <thead>
                        <tr role="row">
                            <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="fecha" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Fecha</th>
                            <th aria-label="descripcion" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Descripción</th>
                            <th aria-label="proveedor" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Proveedor</th>
                            <th aria-label="almacen" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Almacen</th>
                            <th aria-label="empresa" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Empresa</th>
                            <th aria-label="total" style="width: 80px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Total</th>
                            <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($compras as $compra)
                            <tr>
                                <td>{{ $compra->id }}</td>
                                <td>{{ $compra->fecha }}</td>
                                <td>{{ $compra->descripcion_compra }}</td>
                                <td>{{ $compra->proveedor->nombre_proveedor }}</td>
                                <td>{{ $compra->almacen->descripcion }}</td>
                                <td>{{ $compra->empresa->rs }}</td>
                                <td class="text-right">{{ $compra->TotalCompra }} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">

                                        @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                            <a href="#" class="btn btn-link pull-right btnAction2" id ="compra-{{$compra->id}}-destroy" title="Eliminar">
                                                <i class="fa fa-trash bigger-110 red" ></i>
                                            </a>
                                            <a href="{{ route('compraDetalleIndex', array('compra_id' => $compra->id)) }}" class="btn btn-link pull-right editarReg" target="_blank" title="Editar">
                                                <i class="fa fa-cubes bigger-110 blue"></i>
                                            </a>
                                            <a  id="/form_compra_editar_ajax/{{$compra->id}}"  class="btn btn-link pull-right btnCompraEditar" title="Editar" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-pencil bigger-110 success"></i>
                                            </a>
                                            <a href="{{ route('imprimirCodigoBarraCompra/',['compra_id' => $compra->id])  }}" class="btn btn-link bt1n-xs pull-right" title="Imprimir códigos de barra" target="_blank">
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
        </div>
    </div>

@endsection

@include('catalogos.scripts.dataTable')

@include('catalogos.scripts.compras')
