@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">

            <form method="post" action="{{ action('SIIFAC\VentaController@index_post') }}" class="form-inline">
                {{ csrf_field()   }}

                <div class="form-group ">
                    <div class="pull-left">
                        <span id="titulo_catalogo">
                            <i class="fa fa-user default"></i>
                            VENTAS
                        </span>
                        <span class="marginLeft1em">
                            <i class="fa fa-calendar default"></i>
                            <strong>{{$fecha}}</strong>
                        </span>
                        <div class="btn-group marginLeft1em" role="group" aria-label="...">
                            <a id="/select_paquete_ajax" class="btn btn-inverse btn-xs btnVentaPaquete" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-cube default"></i>
                                Paquetes
                            </a>
                            <a id="/select_pedido_ajax" class="btn btn-danger btn-xs btnVentaPedido" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-paperclip default"></i>
                                Pedidos
                            </a>
                            <a id="/select_normal_ajax" class="btn btn-grey btn-xs btnVentaNormal" data-toggle="modal" data-target="#myModal">
                                <i class="fa fa-book default"></i>
                                Normal
                            </a>
                        </div>
                    </div>
                </div>
                <div class="form-group  pull-right">
                    <button type="submit" class="btn btn-xs btn-primary">
                        <i class="fa fa-search default"></i>
                    </button>
                </div>
                <div class="form-group  pull-right">
                    <div class="col-md-3">
                        {{ Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fecha','class'=>'col-md-3 form-control']) }}
                    </div>
                </div>
                <div class="form-group pull-right">
                    <div class="dropdown">
                        <button class="btn btn-success btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Opciones
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="#" class="btnVentaDate" id="bvid-4" data-toggle="modal" data-target="#myModal">Venta en fecha actual</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" class="btnBuscarVentaID" id="bvid-0" data-toggle="modal" data-target="#myModal">Buscar Venta por ID</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" class="btnBuscarVentaID" id="bvid-4" data-toggle="modal" data-target="#myModal">Buscar Venta por Folio</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" class="btnBuscarVentaID" id="bvid-1" data-toggle="modal" data-target="#myModal">Buscar Venta Cliente</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" class="btnBuscarVentaID" id="bvid-2" data-toggle="modal" data-target="#myModal">Buscar Venta Producto</a></li>
                            <li><a href="#" class="btnBuscarVentaID" id="bvid-3" data-toggle="modal" data-target="#myModal">Buscar Venta Código de Producto</a></li>
                        </ul>
                    </div>
                </div>
                <div class="form-group  pull-right">
                    <div class="col-md-1">
                        <a id="btnPrintListado"
                            href="{{ route('imprimirListadoVentas/',['f1'=>$FechaInicial,'f2'=>$FechaFinal]) }}" 
                            class="btn btn-xs btn-cafe btnPrintListado"
                            data-togle="tooltip" data-placement="top" title="Imprime listado actual"
                            target="_blank"
                            >
                            <i class="fa fa-print default"></i>
                        </a>
                    </div>
                </div>
                <div class="form-group  pull-right">
                    <div class="col-md-1">
                        <a id="btnPrintListadoExcel"
                            href="{{ route('imprimirListadoVentasExcel/',['f1'=>$FechaInicial,'f2'=>$FechaFinal]) }}" 
                            class="btn btn-xs btn-verde btnPrintListadoExcel"
                            data-togle="tooltip" data-placement="top" title="Exporta listado actual a MS Excel"
                            target="_blank"
                            >
                            <i class="fa fa-print default"></i>
                        </a>
                    </div>
                </div>

            </form>


        </div>

        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
                @if ($ventas)
                    <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
                        <thead>
                        <tr role="row">
                            <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="fecha" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Fecha</th>
                            <th aria-label="cliente" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Cliente</th>
                            <th aria-label="paquete" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Paq. / Ped.</th>
                            <th aria-label="tipoventa" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">T. Venta</th>
                            <th aria-label="vendedor" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="6" role="columnheader" class="sorting">Vendedor</th>
                            <th aria-label="total" style="width: 80px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Importe</th>
                            <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($ventas as $venta)
                            <tr class="{{$venta->isPagado() ? 'dark' : 'red'}}">
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->FechaImpresa }}</td>
                                <td>{{ $venta->user->FullName }}</td>
                                @if($venta->paquete_id > 0)
                                    <td>{{ $venta->paquete->FullDescription }}</td>
                                    <td>PAQUETE {{ $venta->TipoVenta }}</td>
                                @elseif($venta->pedido_id > 0)
                                    <td>{{ $venta->pedido_id }}</td>
                                    <td>PEDIDO {{ $venta->TipoVenta }}</td>
                                @else
                                    <td>{{ $venta->user->FullName }}</td>
                                    <td>NORMAL {{ $venta->TipoVenta }}</td>
                                @endif
                                <td>{{ $venta->vendedor->FullName }}</td>
                                <td class="text-right font_Roboto_Mono_400">{{ $venta->total}} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">

                                        @if ($user->hasAnyPermission(['consultar','all','sysop']) )
                                            @if( !$venta->isPagado() )
                                            <a href="#" class="btn btn-link pull-right btnAction2" id ="venta-{{$venta->id}}-destroy" title="Eliminar">
                                                <i class="fa fa-trash bigger-110 red" ></i>
                                            </a>
                                            @endif
                                            @if($venta->isPagado())
                                            <a href="{{ route('printTicket/', array('venta_id' => $venta->id)) }}" class="btn btn-link pull-right printReg" title="Imprimir">
                                                <i class="fa fa-print bigger-110 cafe"></i>
                                            </a>
                                            @endif
                                            <a href="{{ route('ventaDetalleEdit', array('venta_id' => $venta->id)) }}" class="btn btn-link pull-right editarReg" title="Editar">
                                                <i class="fa fa-cubes bigger-110 blue"></i>
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="6" class="text-right">
                                <h3 class="smaller green font_Roboto_Mono_400">
                                    Total $
                                </h3>
                            </td>
                            <td class="text-right" id="totalVenta">
                                <h3 class=" smaller orange font_Roboto_Mono_400">
                                    {{$totalVentas}}
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

@include('catalogos.scripts.ventas')
