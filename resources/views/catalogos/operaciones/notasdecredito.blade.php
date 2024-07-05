@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
            <form method="post" action="{{ route('notacreditosPostIndex') }}" class="form-inline">
                {{ csrf_field()   }}
                <div class="form-group ">
                    <div class="input-group">
                        <span id="titulo_catalogo">
                            <i class="fa fa-user default"></i>
                            NOTAS DE CREDITO
                        </span>
                        <span class="marginLeft1em">
                            <i class="fa fa-calendar default"></i>
                            <strong>{{$fecha}}</strong>
                        </span>
                    </div>
                    <div class="input-group">
                        <a href="{{ route('nueva_notacredito/',['venta_id'=>0])  }}" class="btn btn-white btn-mini btn-squared marginLeft1em" title="Nueva Nota de Crédito" >
                            <i class="fa fa-plus purple bigger-150"></i>
                        </a>
                    </div>
{{--                    <div class="input-group">--}}
{{--                        <a href="{{ route('listado_notas_credito_impreso/')  }}" class="btn btn-white btn-circle marginLeft1em" title="Listado de Notas de Crédito" >--}}
{{--                            <i class="fa fa-print cafe bigger-150 "></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}

                </div>
                <div class="form-group pull-right">
                    <div class="input-group">
                        <button type="submit" class="btn btn-xs btn-primary marginLeft1em ">
                            <i class="fa fa-search default"></i>
                        </button>
                    </div>
                </div>
                <div class="form-group pull-right ">
                    <div class="input-group">
                        {{ Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fecha','class'=>'form-control altoMoz']) }}
                    </div>
                </div>
                <div class="form-group pull-right marginRight1em">
                    <div class="dropdown ">
                        <button class="btn btn-success btn-xs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Opciones
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="{{ route('listado_notas_credito/') }}" >Listado de clientes con saldo a favor</a></li>
{{--                            <li role="separator" class="divider"></li>--}}
{{--                            <li><a href="#" class="btnBuscarVentaID" id="bvid-0" data-toggle="modal" data-target="#myModal">Buscar Venta por ID</a></li>--}}
{{--                            <li role="separator" class="divider"></li>--}}
{{--                            <li><a href="#" class="btnBuscarVentaID" id="bvid-4" data-toggle="modal" data-target="#myModal">Buscar Venta por Folio</a></li>--}}
{{--                            <li role="separator" class="divider"></li>--}}
{{--                            <li><a href="#" class="btnBuscarVentaID" id="bvid-1" data-toggle="modal" data-target="#myModal">Buscar Venta Cliente</a></li>--}}
{{--                            <li role="separator" class="divider"></li>--}}
{{--                            <li><a href="#" class="btnBuscarVentaID" id="bvid-2" data-toggle="modal" data-target="#myModal">Buscar Venta Producto</a></li>--}}
{{--                            <li><a href="#" class="btnBuscarVentaID" id="bvid-3" data-toggle="modal" data-target="#myModal">Buscar Venta Código de Producto</a></li>--}}
                        </ul>
                    </div>
                </div>
                <div class="form-group  pull-right " id="impresoraNaranja">
                    <div class="col-md-1">
                        <a id="btnPrintListado"
                           href="{{ route('listado_notas_credito_impreso/') }}"
                           class="btn btn-xs btn-cafe btnPrintListado"
                           data-togle="tooltip" data-placement="top" title="Imprime listado actual"
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
                @if ($notasCredito)
                    <table id="{{ $tableName }}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable " >
                        <thead>
                        <tr role="row">
                            <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="folio" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >Folio</th>
                            <th aria-label="venta_id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >Venta</th>
                            <th aria-label="fecha" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Fecha</th>
                            <th aria-label="cliente" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Cliente</th>
                            <th aria-label="vendedor" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Vendedor</th>
                            <th aria-label="total" style="width: 80px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Importe</th>
                            <th aria-label="saldoutiulizado" style="width: 80px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting text-right">Utilizado</th>
                            <th aria-label="saldo" style="width: 80px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="6" role="columnheader" class="sorting text-right">Saldo</th>
                            <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($notasCredito as $nc)
                            @foreach ($nc->Notas_Credito as $nc)
                            <tr>
                                <td>{{ $nc->id }}</td>
                                <td>{{ $nc->consecutivo }}</td>
                                <td>{{ $nc->venta_id }}</td>
                                <td>{{ $nc->fecha }}</td>
                                <td>{{ $nc->Venta->user->FullName }}</td>
                                <td>{{ $nc->Venta->vendedor->FullName }}</td>
                                <td class="text-right font_Roboto_Mono_400">{{ $nc->importe }} </td>
                                <td class="text-right font_Roboto_Mono_400">{{ $nc->importe_utilizado }} </td>
                                <td class="text-right font_Roboto_Mono_400">{{ $nc->saldo }} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">

                                        @if ($user->hasAnyPermission(['contadora','consultar','all','sysop']) )
{{--                                            <a href="#" class="btn btn-link pull-right btnAction2" id ="venta-{{$nc->id}}-destroy" title="Eliminar">--}}
{{--                                                <i class="fa fa-trash bigger-110 red" ></i>--}}
{{--                                            </a>--}}
                                            <a href="{{ route('printNotaCredito/', array('nota_credito_id' => $nc->id)) }}" class="btn btn-link pull-right printReg" target="_blank" title="Imprimir">
                                                <i class="fa fa-print bigger-110 cafe"></i>
                                            </a>
                                            <a href="{{ route('notaCreditoDetalleIndex', array('nota_credito_id' => $nc->id)) }}" class="btn btn-link pull-right editarReg" target="_blank" title="Editar">
                                                <i class="fa fa-cubes bigger-110 blue"></i>
                                            </a>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                            @endforeach
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
                                    {{$totalVentas}}
                                </h3>
                            </td>
                            <td colspan="3" class="text-right"></td>
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

@include('catalogos.scripts.nota_credito')
