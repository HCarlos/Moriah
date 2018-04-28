@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Editando registro {{$idItem}}
            <a class="btn btn-info btn-xs pull-right" href="#" onclick="javascript:window.close();">
                   Cerrar
            </a>
        </span>
    </div>

    <div class="panel-body">
                    <form method="post" action="{{ action('SIIFAC\ProductoController@update',['prod'=>$items]) }}">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label for = "almacen_id" class="col-md-1 col-form-label text-md-left">Almacen</label>
                            <div class="col-md-2">
                                {{ Form::select('almacen_id', $Almacenes, $items->almacen_id) }}
                            </div>
                            <label for = "familia_producto_id" class="col-md-1 col-form-label text-md-left">Categoría</label>
                            <div class="col-md-2">
                                {{ Form::select('familia_producto_id', $FamProds, $items->familia_producto_id) }}
                            </div>
                            <label for = "medida_id" class="col-md-1 col-form-label text-md-left">Medida</label>
                            <div class="col-md-2">
                                {{ Form::select('medida_id', $Medidas, $items->medida_id) }}
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="form-group row">
                            <label for = "clave" class="col-md-1 col-form-label text-md-left">Clave</label>
                            <div class="col-md-2">
                                <input type="number" name="clave" id="clave" value="{{ old('clave',$items->clave) }}" min="1" max="100" class="form-control" />
                            </div>
                            <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                            <div class="col-md-2">
                                <input type="text" name="codigo" id="codigo" value="{{ old('codigo',$items->codigo) }}" min="1" max="100" class="form-control" />
                            </div>
                            <div class="col-md-7"></div>
                        </div>

                        <div class="form-group row">
                            <label for = "descripcion" class="col-md-1 col-form-label text-md-left">Descripción</label>
                            <div class="col-md-7">
                                <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion',$items->descripcion) }}" class="form-control"/>
                            </div>
                            <label for = "shortdesc" class="col-md-1 col-form-label text-md-left">Corta</label>
                            <div class="col-md-3">
                                <input type="text" name="shortdesc" id="shortdesc" value="{{ old('shortdesc',$items->shortdesc) }}" class="form-control"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "maximo" class="col-md-1 col-form-label text-md-left">Máximo</label>
                            <div class="col-md-2">
                                <input type="number" name="maximo" id="maximo" value="{{ old('maximo',$items->maximo) }}" min="1" max="9999999999" class="form-control" />
                            </div>
                            <label for = "minimo" class="col-md-1 col-form-label text-md-left">Mínimo</label>
                            <div class="col-md-2">
                                <input type="number" name="minimo" id="minimo" value="{{ old('minimo',$items->minimo) }}" min="1" max="9999999999" class="form-control" />
                            </div>
                            <label for = "isiva" class="col-md-1 col-form-label text-md-left">Agr. IVA</label>
                            <div class="col-md-2">
                                {{ Form::checkbox('isiva', null, trim($items->isiva), ['id' => 'isiva','class' => 'ace ace-switch']) }}
                                <span class="lbl"></span>
                            </div>
                            <div class="col-md-3"></div>
                        </div>


                        {{--<div class="form-group row">--}}
                            {{--<label for = "responsable" class="col-md-2 col-form-label text-md-right">Responsable</label>--}}
                            {{--<div class="col-md-10">--}}
                                {{--<input type="text" name="responsable" id="responsable" value="{{ old('responsable',$items->responsable) }}" class="col-md-12"/>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for = "tipoinv" class="col-md-2 col-form-label text-md-right">Tipo</label>--}}
                            {{--<div class="col-md-10">--}}
                                {{--{{ Form::select('tipoinv',--}}
                                {{--array(--}}
                                    {{--'0'=>'Primeras Entradas, Primeras Salidas',--}}
                                    {{--'1'=>'Ultimas Entradas, Primeras Salidas',--}}
                                    {{--'2'=>'Costo Promedio',--}}
                                    {{--), trim($items->tipoinv), ['id' => 'tipoinv','class' => 'col-md-2']) }}--}}

                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group row">--}}
                            {{--<label for = "prefijo" class="col-md-2 col-form-label text-md-right">Prefijo</label>--}}
                            {{--<div class="col-md-1">--}}
                                {{--<input type="text" name="prefijo" id="prefijo" value="{{ old('prefijo',$items->prefijo) }}" />--}}
                            {{--</div>--}}
                            {{--<div class="col-md-9">--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for = "empresa_id" class="col-md-2 col-form-label text-md-right">Empresa</label>--}}
                            {{--<div class="col-md-10">--}}
                                {{--{{ Form::select('empresa_id', $Empresas, $items->empresa_id) }}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="form-group row">--}}
                            {{--<label for = "status_almacen" class="col-md-2 col-form-label text-md-right">Status</label>--}}
                            {{--<div class="col-md-10">--}}
                                {{--{{ Form::select('status_almacen', array('1'=>'Activo', '0'=>'Inactivo'), trim($items->status_almacen), ['id' => 'status_almacen','class' => 'col-md-2']) }}--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        <div>
                            <label class="col-md-2 col-form-label text-md-right"></label>
                            <div class="col-md-8" >
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                            <a class="btn btn-info float-md-right " href="#" onclick="javascript:window.close();">
                                Cerrar
                            </a>
                        </div>

                        <input type="hidden" name="idItem" value="{{$idItem}}" />

                    </form>
    </div>
</div>
@endsection

