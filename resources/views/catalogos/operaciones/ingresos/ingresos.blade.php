@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading">

            <form method="post" action="{{ route('ingresosPostIndex') }}" class="form-inline">
                {{ csrf_field()   }}

                <div class="form-group ">
                    <div class="pull-left">
                        <span id="titulo_catalogo">
                            <i class="fa fa-user default"></i>
                            INGRESOS
                        </span>
                        <span class="marginLeft1em">
                            <i class="fa fa-calendar default"></i>
                            <strong>{{$fecha}}</strong>
                        </span>
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
            </form>

        </div>

        <div class="panel-body">
            <div class="fa-2x" id="preloaderLocal">
                <i class="fa fa-cog fa-spin"></i> Cargado datos...
            </div>
            @if ($ingresos)

            <div class="dataTables_wrapper" role="grid">
                    <table id="{{ $tableName}}" aria-describedby="sample-table-2_info"  class="table table-striped table-bordered table-hover dataTable " >
                        <thead>
                        <tr role="row">
                            <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                            <th aria-label="venta_id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >Folio</th>
                            <th aria-label="fecha" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting">Fecha</th>
                            <th aria-label="cliente" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Cliente</th>
                            <th aria-label="vendedor" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">VENDEDOR</th>
                            <th aria-label="metodo" style="width: 100px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">MÉTODO PAGO</th>
                            <th aria-label="total" style="width: 80px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Importe</th>
                            <th aria-label="" style="width: 100px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                        </tr>
                        </thead>
                            <tbody aria-relevant="all" aria-live="polite" role="alert">
                                @foreach ($ingresos as $ing)
                                    <tr>
                                        <td>{{ $ing->id }}</td>
                                        <td>{{ $ing->venta_id }}</td>
                                        <td>{{ $ing->f_pagado }}</td>
                                        <td>{{ $ing->cliente->FullName }}</td>
                                        <td>{{ $ing->vendedor->FullName }}</td>
                                        <td>{{ $ing->metodo_pago.' '.$ing->referencia }}</td>
                                        <td class="text-right font_Roboto_Mono_400">{{ $ing->total}} </td>
                                        <td >
                                            <div class="visible-desktop action-buttons">
                                                @if ( auth()->user()->can('contadora') || auth()->user()->can('all') )
                                                    <a href="#" class="btn btn-link pull-right btnAction2" id ="ingreso-{{$ing->id}}-destroy" title="Eliminar">
                                                        <i class="fa fa-trash bigger-110 red" ></i>
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
                                            {{$totalIngresos}}
                                        </h3>
                                    </td>
                                    <td></td>
                                </tr>
                            </tfoot>
                    </table>
                @endif
            </div>
        </div>
    </div>

@endsection

@include('catalogos.scripts.dataTable')
