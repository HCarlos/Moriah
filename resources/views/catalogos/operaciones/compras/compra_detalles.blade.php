@extends('layouts.app')

@section('main-content')
    <div class="panel panel-warning" id="catalogosList0">
        <div class="panel-heading ">
            <span id="titulo_catalogo">COMPRA: {{$compra_id}} </span>
            <a href="#" class="btn btn-purple btn-minier icon-only marginLeft2em btnCompraDetalle" title="Actualizar precios de paquetes" id="/form_compra_detalle_nueva_ajax/{{$compra_id}}" data-toggle="modal" data-target="#myModal">
                <i class="fa fa-plus bigger-150"></i>
            </a>
            <a  class="btn btn-info btn-minier icon-only pull-right btnCloseCompraDetalle" title="Cerrar Comprana">
                <i class="fa fa-close bigger-150"></i>
            </a>
        </div>

        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
                @if ($compra)
                    <table id="{{ $tableName}}" class="table table-striped table-bordered table-hover dataTable" style="width: 100% !important" >
                        <thead>
                        <tr role="row" style="width: 100% !important">
                            <th aria-label="id" style="width: 10% !important;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="codigo" style="width: 10% !important;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Código</th>
                            <th aria-label="descripcion" style="width: 40% !important;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Descripción</th>
                            <th aria-label="cantidad" style="width: 10% !important;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Cant</th>
                            <th aria-label="pc" style="width: 10% !important;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">PC</th>
                            <th aria-label="importe" style="width: 10% !important;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">Importe</th>
                            <th aria-label="" style="width: 10% !important;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($compra as $vd)
                            <tr>
                                <td>{{ $vd->id }}</td>
                                <td class="font_Roboto_Mono_400">{{ $vd->codigo }}</td>
                                <td>{{ $vd->producto->descripcion }}</td>
                                <td class="text-right font_Roboto_Mono_400">{{ $vd->entrada}} </td>
                                <td class="text-right font_Roboto_Mono_400">{{ $vd->cu}} </td>
                                <td class="text-right font_Roboto_Mono_400">{{ $vd->importe}} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">
                                        @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                            <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="compra_detalle-{{$vd->id}}-destroy" title="Eliminar">
                                                <i class="fa fa-trash bigger-150 red" ></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-right">
                                    <h3 class="smaller green font_Roboto_Mono_400">
                                        Total $
                                    </h3>
                                </td>
                                <td class="text-right" id="totalCompra">
                                    <h3 class=" smaller orange font_Roboto_Mono_400">
                                    {{$totalCompra}}
                                    </h3>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                @else
                    <div class="alert alert-danger" role="alert">No se encontraron datos</div>
                @endif
            </div>
        </div>
    </div>

@endsection

@include('catalogos.scripts.dataTable')

@include('catalogos.scripts.compra_detalles')
