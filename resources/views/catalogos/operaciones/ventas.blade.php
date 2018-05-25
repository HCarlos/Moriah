@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">
            <span id="titulo_catalogo">VENTAS </span>
            <a id="/select_paquete_ajax" class="btn btn-info btn-xs btnVentaPaquete" data-toggle="modal" data-target="#myModal">Paquetes</a>
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
                            <th aria-label="id" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="fecha" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Fecha</th>
                            <th aria-label="cliente" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Cliente</th>
                            <th aria-label="paquete" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Paq. / Ped.</th>
                            <th aria-label="total" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Importe</th>
                            <th aria-label="tipoventa" style="width: 200px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">T. Venta</th>
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
                                <td>{{ $venta->total}} </td>
                                <td>{{ $venta->tipoventa}} </td>
                                <td >
                                    <div class="visible-desktop action-buttons">

                                        {{--@if ($user->hasAnyPermission(['consultar','all']) )--}}
                                            {{--<a href="#" class="btn btn-link btn-xs margen-izquierdo-03em pull-right btnAction2" id ="almacen-{{$venta->id.'-'.$npage.'-'.$tpaginas}}-destroy" title="Eliminar">--}}
                                                {{--<i class="fa fa-trash bigger-150 red" ></i>--}}
                                            {{--</a>--}}
                                        {{--@endif--}}
                                        {{--@if ( $user->hasAnyPermission(['consultar','all']))--}}
                                            {{--<a href="{{ route('catalogos/', array('id' => $id,'idItem' => $venta->id,'action' => 1)) }}" class="btn btn-link btn-xs pull-right" title="Editar">--}}
                                            {{--<a href="{{ route('almacenEdit', array('idItem' => $venta->id)) }}" class="btn btn-link btn-xs pull-right editarReg" target="_blank" title="Editar">--}}
                                                {{--<i class="fa fa-pencil bigger-150 blue"></i>--}}
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
