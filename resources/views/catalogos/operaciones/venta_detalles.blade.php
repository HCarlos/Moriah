@extends('layouts.app')

@section('main-content')
    <div class="panel panel-warning" id="catalogosList0">
        <div class="panel-heading ">
            @if( !$Venta->isPagado() )
                <a id="/form_pagar_venta/{{$venta_id}}" class="btn btn-orange btn-minier icon-only btnPagarVenta" data-toggle="modal" data-target="#myModal" title="Pagar Venta" >
                    <i class="fa fa-money bigger-150"></i>
                </a>
            @endif
            <a href="{{ route('printTicket/', ['venta_id' => $venta_id]) }}" class="btn btn-cafe btn-minier icon-only marginLeft2em " title="Imprimir" target="_blank">
                <i class="fa fa-print bigger-150"></i>
            </a>

            <a href="{{ route('printHistoryPay/', ['venta_id' => $venta_id]) }}" class="btn btn-purple btn-minier icon-only marginLeft2em " title="Imprimir historial de abonos" target="_blank">
                <i class="fa fa-history bigger-150"></i>
            </a>

            <span id="guardandoVenta" class="bigger-180 marginLeft2em" style="display: none;"><i class="fa fa-spinner fa-w-16 fa-spin fa-lg"></i>  Guardando... </span>

{{--            <a class="btn btn-info btn-minier icon-only pull-right btnCloseVentaDetalleNormal" title="Cerrar Ventana">--}}
{{--                <i class="fa fa-close bigger-150"></i>--}}
{{--            </a>--}}

            @if( !$Venta->isPagado() && $Venta->TotalAbonos <= 0 )
{{--                <a id="/form_anular_venta/{{$venta_id}}" class="btn btn-danger btn-minier icon-only btnAnularVenta marginRight2em  pull-right " data-toggle="modal" data-target="#myModal" title="Anular Venta" >--}}
{{--                    <i class="fa fa-trash bigger-150"></i>--}}
{{--                </a>--}}
            @endif
            <h4 class="btn btn-inverse btn-minier pull-right btnShowProperties" id="/show_prop_venta/{{$venta_id}}" data-toggle="modal" data-target="#myModal">
                <i class="glyphicon glyphicon-shopping-cart green3"></i>
                <strong class="orange2 font_PT_Sans_Narrow"> DETALLES DE LA VENTA</strong>
            </h4>
            <span id="titulo_catalogo" class="bigger-140 pull-right marginRight1em">
                <strong class="orange2 font_PT_Sans_Narrow">VENTA <b class="purple font_Roboto_400" >{{$venta_id}}</b></strong>
            </span>

        </div>

        <div class="widget-box">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="form-group" >
{{--                        <form method="post"  id="frmSearchProd" class="form-inline">--}}
{{--                            @csrf--}}
{{--                            <div class="input-group col-xs-3">--}}
{{--                                <div class="input-group-addon font_Roboto_500">Buscar</div>--}}
{{--                                <input type="text" name="searchProducto" id="searchProducto" value="" class="form-control"/>--}}
{{--                            </div>--}}
{{--                        </form>--}}
                        <form method="post"  id="frmSearchCode" class="form-inline" >
                            @csrf
    {{--                            <label class="sr-only" for="codigo">Código de barras</label>--}}
                                <div class="input-group col-xs-3">
                                    <div class="input-group-addon font_Roboto_500">Código</div>
                                    <input type="number" name="codigo" id="codigo" value="" class="form-control" required autofocus/>
                                    <input type="hidden" name="venta_id" value="{{$venta_id}}" >
                                </div>
                                <div class="input-group col-xs-2">
                                    <div class="input-group-addon font_Roboto_500">Cant</div>
    {{--                                <input type="number" name="cantidad" id="cantidad" value="1" min="1" max="9999999" class="form-control " required/>--}}
                                    <input type="text" pattern="[0-9]{1,8}([.][0-9]{0,2})?" name="cantidad" id="cantidad" class="form-control" title="Cantidad de Producto" required/>
                                </div>
                                <div class="input-group col-xs-1">
                                    <button type="submit" class="btn btn-purple btn-mini "><i class="fa fa-search-plus bigger-170 icon-only"></i></button>
                                </div>
                                <div class="input-group col-xs-3 pull-right">
                                    <div class="input-group-addon font_Roboto_500">Buscar</div>
                                    <input type="text" name="searchProducto" id="searchProducto" value="" class="form-control"/>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
                @if ($venta)
                    <table id="{{ $tableName }}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
                        <thead>
                        <tr role="row">
                            <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="codigo" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Código</th>
                            <th aria-label="descripcion" style="width: 120px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Descripción</th>
                            <th aria-label="cantidad" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Cant</th>
                            <th aria-label="pv" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">PV</th>
                            <th aria-label="importe" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">Importe</th>
                            <th aria-label="iva" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">IVA</th>
                            <th aria-label="total" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">Total</th>
                            <th aria-label="" style="width: 10px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($venta as $vd)
                            <tr>
                                <td>{{ $vd->id }}</td>
                                <td class="font_Roboto_Mono_400">{{ $vd->codigo }}</td>
                                <td>{{ $vd->descripcion }}</td>
                                <td class="text-right font_Roboto_Mono_400">{{ $vd->cantidad}} </td>
                                <td class="text-right font_Roboto_Mono_400">{{ $vd->pv}} </td>
                                <td class="text-right font_Roboto_Mono_400">{{ $vd->total - $vd->iva}} </td>
                                <td class="text-right font_Roboto_Mono_400">{{ $vd->iva}} </td>
                                <td class="text-right font_Roboto_Mono_400">{{ $vd->total}} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">
                                        @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                            @if( !$Venta->isPagado() )
                                            <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="ventadetalle-{{$vd->id}}-destroy" title="Eliminar">
                                                <i class="fa fa-trash bigger-150 red" ></i>
                                            </a>
                                            @endif
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
                                <td class="text-right" id="totalVenta">
                                    <h3 class=" smaller orange font_Roboto_Mono_400">
                                        {{$totalVenta}}
                                    </h3>
                                </td>
                                <td class="text-right">
                                    <h3 class="smaller green font_Roboto_Mono_400">
                                        Abonos $
                                    </h3>
                                </td>
                                <td class="text-right" id="totalVenta">
                                    <h3 class=" smaller orange font_Roboto_Mono_400">
                                    {{$abonoVenta}}
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

@include('catalogos.scripts.venta_detalles')
