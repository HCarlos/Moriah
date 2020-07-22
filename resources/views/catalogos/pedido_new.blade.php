@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="frmEdit0">
        <div class="panel-heading">
            <span><strong>{{ ucwords($titulo) }}</strong> | Nuevo registro {{$idItem}}
                <a class="btn btn-info btn-minier pull-right" href="#" onclick="window.close();">
                       Cerrar
                </a>
            </span>
        </div>

        <div class="panel-body">
            <form method="post" action="{{ action('SIIFAC\PedidoController@store') }}">
                {{ csrf_field() }}

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
                    <div class="col-md-3">
                        {{ Form::select('empresa_id', $Empresas, null, ['id' => 'empresa_id','class' => 'form-control']) }}
                    </div>
                    <label for = "paquete_id" class="col-md-1 col-form-label text-md-left">Pedido</label>
                    <div class="col-md-3">
                        {{ Form::select('paquete_id', $Paquetes, null, ['id' => 'paquete_id','class' => 'form-control']) }}
                    </div>
                    <label for = "user_id" class="col-md-1 col-form-label text-md-left">Usuario</label>
                    <div class="col-md-3">
                        {{ Form::select('user_id', $Usuarios, null, ['id' => 'user_id','class' => 'form-control']) }}
                    </div>
                </div>

                <div class="form-group row">
                    <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                    <div class="col-md-2">
                        <input type="text" name="codigo" id="codigo" value="{{ old('codigo',$codigo) }}" min="16" max="16" class="form-control" readonly />
                    </div>
                    <div class="col-md-9"></div>
                </div>

                <div class="form-group row">
                    <label for = "descripcion_pedido" class="col-md-1 col-form-label text-md-left">Descripción</label>
                    <div class="col-md-11">
                        <input type="text" name="descripcion_pedido" id="descripcion_pedido" value="{{ old('descripcion_pedido') }}" class="form-control" readonly/>
                    </div>
                </div>

                <div class="form-group row">
                    <label for = "referencia" class="col-md-1 col-form-label text-md-left">Referencia</label>
                    <div class="col-md-11">
                        <input type="text" name="referencia" id="referencia" value="{{ old('referencia') }}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for = "observaciones" class="col-md-1 col-form-label text-md-left">Observaciones</label>
                    <div class="col-md-11">
                        <input type="text" name="observaciones" id="observaciones" value="{{ old('observaciones') }}" class="form-control" />
                    </div>
                </div>

                <div class="form-group row">

                    <label for = "importe" class="col-md-1 col-form-label text-md-left">Importe</label>
                    <div class="col-md-2">
                        <input type="number" name="importe" id="importe" value="{{ old('importe') }}" min="0" step="0.01" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" readonly/>
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
    <script type="application/javascript">
        $('#descripcion_pedido').val( $('#paquete_id').text() );
    </script>
@endsection

