@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Editando registro {{$paquete_id}}
            <a class="btn btn-info btn-minier pull-right" href="#" onclick="window.close();">
                   Cerrar
            </a>
        </span>
    </div>|

    <div class="panel-body">
        <form method="post" action="{{ action('SIIFAC\PaqueteDetalleController@store') }}">
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
                <label for = "producto_id" class="col-md-1 col-form-label text-md-left">Producto</label>
                <div class="col-md-2">
                    {{ Form::select('producto_id', $Productos, 1, ['id' => 'producto_id']) }}
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

            <input type="hidden" name="paquete_id" value="{{$paquete_id}}" />

        </form>
    </div>
</div>
@endsection

