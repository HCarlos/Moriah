@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="catalogosList0">
        <div class="panel-heading ">
            <span id="titulo_catalogo" class="bolder">
                <i class="fa fa-paperclip default"></i>
                <strong>NOTAS DE CRÉDITO <span class="green"> {{$nota_credito_id}}</span>  </strong>
            </span>
        </div>

        <div class="panel-body">
            <div class="dataTables_wrapper" role="grid">
                    <form id="frmNCTarget" method="post" action="{{ route('guardar_notacredito/')  }}">
                        @csrf
                        <table id="btlCal" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr role="row">
                                <th aria-label="id" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="0" role="columnheader" class="sorting" >ID</th>
                                <th aria-label="cantidad" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="1" role="columnheader" class="sorting text-right">Cant</th>
                                <th aria-label="descripcion" style="width: 120px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="2" role="columnheader" class="sorting">Descripción</th>
                                <th aria-label="pv" style="width: 10px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="3" role="columnheader" class="sorting text-right">PV</th>
                                <th aria-label="importe" style="width: 50px;" colspan="1" rowspan="1" aria-controls="{{ $tableName}}" tabindex="4" role="columnheader" class="sorting text-right">Importe</th>
                                <th aria-label="" style="width: 10px;" colspan="1" rowspan="1" role="columnheader" class="sorting_disabled"></th>
                            </tr>
                            </thead>
                            <tbody aria-relevant="all" aria-live="polite" role="alert">
                            @if($notasCredito->count()> 0 && $message==null)
                                @foreach($notasCredito as $ncd)
                                    <tr role="row">
                                        <td >{{$ncd->id}}</td>
                                        <td class="text-right">{{$ncd->cant}}</td>
                                        <td >{{$ncd->descripcion_producto}}</td>
                                        <td class="text-right">{{$ncd->pv}}</td>
                                        <td class="text-right">{{$ncd->importe}}</td>
                                        <td >
                                            <div class="visible-desktop action-buttons">
                                                <a href="#" class="btn btn-link pull-right btnAction2" id ="notacreditodetalle-{{$ncd->id}}-destroy" title="Eliminar">
                                                    <i class="fa fa-trash bigger-110 red" ></i>
                                                </a>
                                            </div>
                                        </td>
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
{{--                                    <td colspan="7" class="text-right">--}}
{{--                                        <button type="submit" class="btn btn-info btn-small" id="btnVisualizarNC">--}}
{{--                                            <i class="fa fa-search"></i>--}}
{{--                                            Guardar--}}
{{--                                        </button>--}}
{{--                                    </td>--}}
{{--                                    <td  class="text-right">--}}
{{--                                        <button type="button" class="btn btn-info btn-small" id="btnVisualizarNC">--}}
{{--                                            <i class="fa fa-search"></i>--}}
{{--                                            Preview--}}
{{--                                        </button>--}}
{{--                                    </td>--}}
                                    <td colspan="4" class="text-right">
                                        <h3 class="smaller green font_Roboto_Mono_400">
                                            Total $
                                        </h3>
                                    </td>
                                    <td class="text-right" id="totalVenta">
                                        <h3 class=" smaller orange font_Roboto_Mono_400">
                                            {{$totalVentas}}
                                        </h3>
                                    </td>

                                    <td  class="text-right">
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    <input type="hidden" name="id" value="{{$nota_credito_id}}">
                    </form>

            </div>
        </div>
    </div>

@endsection

{{--@include('catalogos.scripts.dataTable')--}}

@include('catalogos.scripts.nota_credito_detalles')
