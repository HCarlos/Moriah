@extends('layouts.app')

@section('main-content')

    @component('components.panel')
    @slot('titulo','Parámetros de la Consulta')
    @slot('barra_menu')
    @endslot
    @slot('contenido')
        <div class="dataTables_wrapper" role="grid">
            <div class="panel panel-default">
                <div class="panel-heading">Corte de Caja</div>
                <div class="panel-body">

                    <form method="post" action="{{ route('corteCaja1') }}" target="_blank" >
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="tipo_venta" class="col-md-1 control-label">Tipo:</label>
                            <div class="col-md-2">
                                <select name="tipo_venta" id="tipo_venta" class="form-control" size="1">
                                    <option value="-1" selected>Cualquiera</option>
                                    <option value="0">Contado</option>
                                    <option value="1">Credito</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                            </div>
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label for="vendedor_id" class="col-md-1 control-label">Vendedor:</label>
                            <div class="col-md-2">
                                <select name="vendedor_id" id="vendedor_id" class="form-control" size="1">
                                    <option value="0" selected>Todos</option>
                                    @foreach ($cajeros as $key => $value)
                                    <option value="{{ $key }}"@if ($key == 0) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="metodo_pago" class="col-md-1 control-label">Metodo:</label>
                            <div class="col-md-2">
                                <select name="metodo_pago" id="metodo_pago" class="form-control" size="1">
                                    <option value="999" selected>Todos</option>
                                    @foreach ($metodo_pagos as $key => $value)
                                        <option value="{{ $key }}"@if ($key == 999) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label for="fecha1" class="col-md-1 control-label has-warning">Desde:</label>
                            <div class="col-md-2 ">
                                {{ Form::date('fecha1', old("fecha1", \Carbon\Carbon::now() ), ['id'=>'fecha1','class'=> $errors->has("fecha1") ? "form-control has-error form-error" : 'col-md-2 form-control']) }}
                                @if ($errors->has('fecha1'))
                                    <span class="text-danger">{{ $errors->first('fecha1') }}</span>
                                @endif
                            </div>

                            <label for="fecha2" class="col-md-1 control-label ">Hasta:</label>
                            <div class="col-md-2 {{$errors->has("fecha2") ? "has-error form-error" : ""}}">
                                {{ Form::date('fecha2', old("fecha2", \Carbon\Carbon::now() ), ['id'=>'fecha2','class'=> $errors->has("fecha2") ? "form-control form-error" :'col-md-2 form-control']) }}
                                @if ($errors->has('fecha2'))
                                    <span class="text-danger">{{ $errors->first('fecha2') }}</span>
                                @endif
                            </div>
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label for="tipo_reporte" class="col-md-1 control-label has-warning">Reporte:</label>
                            <div class="col-md-5 ">
                                <select name="tipo_reporte" id="tipo_reporte" class="form-control" size="1">
                                    <option value="0" selected>Reporte de Ingresos</option>
                                    <option value="1">Reporte de Ventas</option>
                                    <option value="5">Reporte de Salidas a través de Ventas</option>
                                    <option value="2">Informe de Venta Consolidada por Producto</option>
                                    <option value="3">Listado Notas de Crédito (PV)</option>
                                    <option value="4">Listado Notas de Crédito (PC)</option>
                                </select>
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row" style="padding-left: 1em;">
                            <button type="submit" class="btn btn-mini btn-primary">
                                <i class="fa fa-search"></i>
                                Consultar
                            </button>
                        </div>
                    </form>

                    <hr/>

                    {{--<form method="post" action="{{ action('Externos\TwilioSMSController@send_sms_one') }}" target="_self">--}}
                        {{--{{ csrf_field() }}--}}
                        {{--<div class="form-group row">--}}
                            {{--<input name="to" id="to" type="phone" placeholder="To" class="form-inline"/>--}}
                            {{--<input name="message" id="message" type="text" placeholder="Message" class="form-inline"/>--}}
                            {{--<label class="form-label">{{$msg}}</label>--}}
                        {{--</div>--}}
                        {{--<div class="form-group row">--}}
                            {{--<button type="submit" class="btn btn-mini btn-info">--}}
                                {{--<i class="fa fa-sms"></i>--}}
                                {{--Enviar SMS--}}
                            {{--</button>--}}
                        {{--</div>--}}
                    {{--</form>--}}

                </div>

            </div>

        </div>
    @endslot
    @endcomponent
@endsection

@include('catalogos.scripts.dataTable')

