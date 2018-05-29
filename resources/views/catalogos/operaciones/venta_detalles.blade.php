@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
            <span id="titulo_catalogo">VENTA {{$venta_id}} </span>
            {{--<a id="/select_paquete_ajax" class="btn btn-info btn-xs btnVentaPaquete" data-toggle="modal" data-target="#myModal">Paquetes</a>--}}
        </div>

        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            <div class="dataTables_wrapper" role="grid">
                @if ($venta)
                    <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable hide" >
                        <thead>
                        <tr role="row">
                            <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="fecha" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Fecha</th>
                            <th aria-label="codigo" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Codigo</th>
                            <th aria-label="descripcion" style="width: 120px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting">Descripción</th>
                            <th aria-label="cantidad" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Cant</th>
                            <th aria-label="importe" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">Importe</th>
                            <th aria-label="iva" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="6" role="columnheader" class="sorting">IVA</th>
                            <th aria-label="total" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="5" role="columnheader" class="sorting">Total</th>
                            <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                        <tbody aria-relevant="all" aria-live="polite" role="alert">
                        @foreach ($venta as $vd)
                            <tr>
                                <td>{{ $vd->id }}</td>
                                <td>{{ $vd->fecha }}</td>
                                <td>{{ $vd->codigo }}</td>
                                <td>{{ $vd->descripcion }}</td>
                                <td class="text-right">{{ $vd->cantidad}} </td>
                                <td class="text-right">{{ $vd->importe}} </td>
                                <td class="text-right">{{ $vd->iva}} </td>
                                <td class="text-right">{{ $vd->total}} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">

                                        {{--@if ($user->hasAnyPermission(['consultar','all']) )--}}
                                            {{--<a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="venta-{{$venta->id.'-0-0'}}-destroy" title="Eliminar">--}}
                                                {{--<i class="fa fa-trash bigger-150 red" ></i>--}}
                                            {{--</a>--}}
                                        {{--@endif--}}
                                        {{--@if ( $user->hasAnyPermission(['consultar','all']))--}}
                                            {{--<a href="{{ route('catalogos/', array('id' => $id,'idItem' => $venta->id,'action' => 1)) }}" class="btn btn-link btn-xs pull-right" title="Editar">--}}
                                            {{--<a href="{{ route('ventaDetalleEdit', array('venta_id' => $venta->id)) }}" class="btn btn-link btn-xs pull-right editarReg" target="_blank" title="Editar">--}}
                                                {{--<i class="fa fa-cubes bigger-150 blue"></i>--}}
                                            {{--</a>--}}
                                        {{--@endif--}}

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

@include('catalogos.scripts.ventas')
