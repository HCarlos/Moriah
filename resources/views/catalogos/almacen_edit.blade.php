@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Editando registro {{$idItem}}
            <a class="btn btn-info btn-minier pull-right" href="#" onclick="window.close();">
                   Cerrar
            </a>
        </span>
    </div>

    <div class="panel-body">
                    <form method="post" action="{{ action('SIIFAC\AlmacenController@update',['alma'=>$items]) }}">
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
                            <label for = "clave_almacen" class="col-md-2 col-form-label text-md-right">Clave</label>
                            <div class="col-md-1">
                                <input type="number" name="clave_almacen" id="clave_almacen" value="{{ old('clave_almacen',$items->clave_almacen) }}" min="1" max="100" autofocus />
                            </div>
                            <div class="col-md-9">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for = "descripcion" class="col-md-2 col-form-label text-md-right">Descripcion</label>
                            <div class="col-md-10">
                                <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion',$items->descripcion) }}" class="col-md-12"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for = "responsable" class="col-md-2 col-form-label text-md-right">Responsable</label>
                            <div class="col-md-10">
                                <input type="text" name="responsable" id="responsable" value="{{ old('responsable',$items->responsable) }}" class="col-md-12"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for = "tipoinv" class="col-md-2 col-form-label text-md-right">Tipo</label>
                            <div class="col-md-2">
                                {{ Form::select('tipoinv',
                                array(
                                    '0'=>'Primeras Entradas, Primeras Salidas',
                                    '1'=>'Ultimas Entradas, Primeras Salidas',
                                    '2'=>'Costo Promedio',
                                    ), trim($items->tipoinv), ['id' => 'tipoinv','class' => 'form-control']) }}

                            </div>
                            <label for = "proveedor_id" class="col-md-1 col-form-label text-md-left">Proveedor</label>
                            <div class="col-md-7">
                                {{ Form::select('proveedor_id', $Proveedores, $items->proveedor_id, ['id' => 'proveedor_id','class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for = "prefijo" class="col-md-2 col-form-label text-md-right">Prefijo</label>
                            <div class="col-md-1">
                                <input type="text" name="prefijo" id="prefijo" value="{{ old('prefijo',$items->prefijo) }}" maxlength="3" />
                            </div>
                            <div class="col-md-9">
                            </div>
                        </div>

{{--                        <div class="form-group row">--}}
{{--                            <label for = "empresa_id" class="col-md-2 col-form-label text-md-right">Empresa</label>--}}
{{--                            <div class="col-md-10">--}}
{{--                                {{ Form::select('empresa_id', $Empresas, $items->empresa_id) }}--}}
{{--                            </div>--}}
{{--                        </div>--}}

                        <div class="form-group row">
                            <label for = "status_almacen" class="col-md-2 col-form-label text-md-right">Status</label>
                            <div class="col-md-10">
                                {{ Form::select('status_almacen', array('1'=>'Activo', '0'=>'Inactivo'), trim($items->status_almacen), ['id' => 'status_almacen','class' => 'col-md-2']) }}
                            </div>
                        </div>

                        <div>
                            <label class="col-md-2 col-form-label text-md-right"></label>
                            <div class="col-md-8" >
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                            <a class="btn btn-info float-md-right " href="#" onclick="window.close();">
                                Cerrar
                            </a>
                        </div>

                        <input type="hidden" name="idItem" value="{{$idItem}}" />

                    </form>
    </div>
</div>
@endsection

