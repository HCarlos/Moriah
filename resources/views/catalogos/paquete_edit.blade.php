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
            <form method="post" action="{{ action('SIIFAC\PaqueteController@update',['paq'=>$items]) }}">
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
                    <label for = "empresa_id" class="col-md-1 col-form-label text-md-left">Empresa</label>
                    <div class="col-md-2">
                        {{ Form::select('empresa_id', $Empresas, $items->empresa_id, ['id' => 'empresa_id']) }}
                    </div>
                    <div class="col-md-9"></div>
                </div>

                <div class="form-group row">
                    <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                    <div class="col-md-2">
                        <input type="text" name="codigo" id="codigo" value="{{ old('codigo',$items->codigo) }}" min="1" max="999999" class="form-control" />
                    </div>
                    <div class="col-md-9"></div>
                </div>

                <div class="form-group row">
                    <label for = "descripcion_paquete" class="col-md-1 col-form-label text-md-left">Descripción</label>
                    <div class="col-md-11">
                        <input type="text" name="descripcion_paquete" id="descripcion_paquete" value="{{ old('descripcion_paquete',$items->descripcion_paquete) }}" class="form-control"/>
                    </div>
                </div>

                <div class="form-group row">

                    <label for = "importe" class="col-md-1 col-form-label text-md-left">Importe</label>
                    <div class="col-md-2">
                        <input type="number" name="importe" id="importe" value="{{ old('importe',$items->importe) }}" min="0" step="0.01" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" readonly/>
                    </div>
                    <div class="col-md-9"></div>
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
