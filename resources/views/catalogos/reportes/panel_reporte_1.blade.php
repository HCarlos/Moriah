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
                    <form method="post" action="{{ action('Externos\CorteCajaController@corte_de_caja_1') }}" accept-charset="UTF-8" enctype="multipart/form-data" target="_blank">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="vendedor_id" class="col-md-1 control-label">Venededor:</label>
                            <div class="col-md-2">
                                {{--{{ Form::select('vendedor_id', $cajeros, null, ['id' => 'vendedor_id','class' => 'form-control']) }}--}}
                                <select name="vendedor_id" id="vendedor_id" class="form-control" size="1">
                                    @foreach ($cajeros as $key => $value)
                                    <option value="{{ $key }}"@if ($key == 0) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br/>
                        <div class="form-group row">
                            <label for="fecha1" class="col-md-1 control-label">Desde:</label>
                            <div class="col-md-2">
                                {{ Form::date('fecha1', \Carbon\Carbon::now(), ['id'=>'fecha1','class'=>'col-md-2 form-control']) }}
                            </div>

                            <label for="fecha2" class="col-md-1 control-label">Hasta:</label>
                            <div class="col-md-2">
                                {{ Form::date('fecha2', \Carbon\Carbon::now(), ['id'=>'fecha2','class'=>'col-md-2 form-control']) }}
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
                </div>
            </div>

        </div>
    @endslot
    @endpanel
@endsection

@include('catalogos.scripts.dataTable')

