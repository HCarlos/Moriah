@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">

            <form method="post" action="{{ action('SIIFAC\VentaController@index_post') }}" class="form-inline">
                {{ csrf_field()   }}

                <div class="form-group">
                    <span id="titulo_catalogo">VENTAS {{$fecha}}</span>
                    <a id="/select_paquete_ajax" class="btn btn-info btn-xs btnVentaPaquete" data-toggle="modal" data-target="#myModal">Paquetes</a>
                </div>
                <div class="form-group row">
                    <label for = "fecha" class="col-md-3 col-form-label text-md-right">Fecha</label>
                    <div class="col-md-3">
                        {{ Form::date('fecha', \Carbon\Carbon::now(), ['id'=>'fecha','class'=>'col-md-3 form-control']) }}
                    </div>
                </div>
                <button type="submit" class="btn btn-mini btn-primary">Consultar</button>
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
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->fecha }}</td>
                                <td>{{ $venta->user->FullName }}</td>
                                <td>{{ $venta->paquete->FullDescription }}</td>
                                <td>{{ $venta->TipoVenta }}</td>
                                <td>{{ $venta->vendedor->FullName }}</td>
                                <td class="text-right">{{ $venta->total}} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">

                                        @if ($user->hasAnyPermission(['consultar','all']) )
                                            <a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="venta-{{$venta->id.'-0-0'}}-destroy" title="Eliminar">
                                                <i class="fa fa-trash bigger-150 red" ></i>
                                            </a>
                                        @endif
                                        @if ( $user->hasAnyPermission(['consultar','all']))
                                            <a href="{{ route('ventaDetalleEdit', array('venta_id' => $venta->id)) }}" class="btn btn-link btn-xs pull-right editarReg" target="_blank" title="Editar">
                                                <i class="fa fa-cubes bigger-150 blue"></i>
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
                                <h3 class="smaller green">
                                    Total $
                                </h3>
                            </td>
                            <td class="text-right" id="totalVenta">
                                <h3 class=" smaller orange">
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
