@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading ">
            <span id="titulo_catalogo" class="bolder">
                <i class="fa fa-paperclip default"></i>
                <strong>NOTAS DE CRÉDITO</strong>
            </span>
        </div>

        <div class="widget-box">
            <div class="widget-body">
                <div class="widget-main">
                    <form id="frmNewNotaCredito" method="post" action="{{ route('nueva_notacredito_put/')  }}" class="form-inline">
                        @csrf
                        @method('PUT')
                        <div class="form-group" >
                            <div class="input-group col-xs-7">
                                <div class="input-group-addon font_Roboto_500">Folio de Venta</div>
                                <input type="number" name="venta_id" id="venta_id" value="{{$venta_id}}" class="form-control" required autofocus/>
                            </div>
                            <div class="input-group col-xs-1">
                                <button type="submit" class="btn btn-purple btn-mini "><i class="fa fa-search-plus bigger-170 icon-only"></i></button>
                            </div>
{{--                            <div class="pull-right hide" id="prealoader">--}}
{{--                                <span class="bigger-110 marginLeft2em"><i class="fa fa-spinner fa-w-16 fa-spin fa-lg orange"></i>  Buscando nota... </span>--}}
{{--                            </div>--}}
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="panel-body">
{{--            <div class="fa-2x hide" id="preloaderLocal">--}}
{{--                <i class="fa fa-cog fa-spin"></i> Cargado datos...--}}
{{--            </div>--}}
            <div class="dataTables_wrapper" role="grid">
                    <form id="frmNCTarget" method="post" action="{{ route('guardar_notacredito/')  }}">
                        @csrf
                        <table id="btlCal" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr role="row">
                                <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                                <th aria-label="cantidad" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Cantidad</th>
                                <th aria-label="descripcion" style="width: 120px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Descripción</th>
                                <th aria-label="pv" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">PV</th>
                                <th aria-label="importe" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">Importe</th>
                                <th aria-label="iva" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="6" role="columnheader" class="sorting">IVA</th>
                                <th aria-label="total" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">Total</th>
                                <th aria-label="cant" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Cant. a Devolver </th>
                                <th aria-label="cantidad_devuelta" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Devuelto</th>
                            </tr>
                            </thead>
                            <tbody aria-relevant="all" aria-live="polite" role="alert">
                            @if($items->count()> 0 && $message==null)
                                @foreach($items as $vd)
                                    <tr role="row">
                                        <td >{{$vd->id}}</td>
                                        <td class="text-right">{{$vd->cantidad}}</td>
                                        <td >{{$vd->descripcion}}</td>
                                        <td class="text-right">{{$vd->pv}}</td>
                                        <td class="text-right">{{$vd->importe}}</td>
                                        <td class="text-right">{{$vd->iva}}</td>
                                        <td class="text-right">{{$vd->total}}</td>
                                        @if($vd->cantidad>$vd->cantidad_devuelta)
                                            <td>
                                                <input type='number' name="vd_id[{{$vd->id.'_'.$vd->venta_id.'_'.$vd->producto_id.'_'.$vd->user_id.'_'.$vd->clave.'_'.$vd->cuenta.'_'.$vd->folio.'_'.$vd->empresa_id.'_'.$vd->codigo}}]" value='0' min='0' max='{{$vd->cantidad - $vd->cantidad_devuelta}}' class='form-control col-xs-2' />
                                            </td>
                                        @else
                                            <td class="text-right">{{$vd->cantidad - $vd->cantidad_devuelta}}</td>
                                        @endif
                                        <td class="text-right">{{$vd->cantidad_devuelta}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr role="row">
                                    <td colspan="9" class="text-center"><h1 class="orange">{{$message}}</h1></td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9" class="text-right">
                                        @if ( $items->count()> 0 && $venta->CanCreateNotaCredito() )
                                        <button type="submit" class="btn btn-info btn-small" id="btnVisualizarNC">
                                            <i class="fa fa-search"></i>
                                            Guardar
                                        </button>
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    <input type="hidden" name="venta_id" value="{{$venta_id}}">
                    <input type="hidden" name="id" value="{{$id}}">
                    </form>

            </div>
        </div>
    </div>

@endsection

{{--@include('catalogos.scripts.dataTable')--}}

@include('catalogos.scripts.nota_credito_detalles')
