@extends('layouts.app')

@section('main-content')

    @panel
    @slot('titulo','Parámetros de la Consulta')
    @slot('barra_menu')
    @endslot
    @slot('contenido')
        <div class="dataTables_wrapper" role="grid">
            <div class="panel panel-default">
                <div class="panel-heading">Corte de Caja</div>
                <div class="panel-body">

                    <form method="post" action="{{ route('corteCaja1') }}" >
                        {{ csrf_field() }}
                        {{--@if ($errors->any())--}}
                            {{--<div class="alert alert-danger">--}}
                                {{--<ul>--}}
                                    {{--@foreach ($errors->all() as $error)--}}
                                        {{--<li>{{ $error }}</li>--}}
                                    {{--@endforeach--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--@endif--}}

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
                        <div class="form-group {{$errors->has("fecha1") || $errors->has("fecha2") ? "has-error " : ""}} row">
                            <label for="fecha1" class="col-md-1 control-label has-warning">Desde:</label>
                            <div class="col-md-2">
                                {{ Form::date('fecha1', old("fecha1", \Carbon\Carbon::now() ), ['id'=>'fecha1','class'=>'col-md-2 form-control']) }}
                                @if ($errors->has('fecha1'))
                                    <span class="text-danger">{{ $errors->first('fecha1') }}</span>
                                @endif
                            </div>

                            <label for="fecha2" class="col-md-1 control-label ">Hasta:</label>
                            <div class="col-md-2">
                                {{ Form::date('fecha2', old("fecha2", \Carbon\Carbon::now() ), ['id'=>'fecha2','class'=>'col-md-2 form-control']) }}
                                @if ($errors->has('fecha2'))
                                    <span class="text-danger">{{ $errors->first('fecha2') }}</span>
                                @endif
                            </div>
                        </div>
                        <hr>

                        <div class="form-group row">
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
    @endpanel
@endsection

@include('catalogos.scripts.dataTable')

