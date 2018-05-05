@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Nuevo registro {{$idItem}}
            <a class="btn btn-info btn-minier pull-right" href="#" onclick="javascript:window.close();">
                   Cerrar
            </a>
        </span>
    </div>

    <div class="panel-body">
                    <form method="post" action="{{ action('SIIFAC\UsuarioController@store') }}">
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
                            <label for = "familia_cliente_id" class="col-md-1 col-form-label text-md-left">Categoría</label>
                            <div class="col-md-2">
                                {{ Form::select('familia_cliente_id', $FamClis, 1, ['id' => 'familia_cliente_id','class'=>'form-control']) }}
                            </div>
                            <label for = "cuenta" class="col-md-1 col-form-label text-md-left">Cuenta</label>
                            <div class="col-md-2">
                                <input type="text" name="cuenta" id="cuenta" value="{{ old('cuenta') }}" min="1" max="999999" class="form-control"  />
                            </div>
                            <label for = "username" class="col-md-1 col-form-label text-md-left">Username</label>
                            <div class="col-md-2">
                                <input type="text" name="username" id="username" value="{{ old('username') }}" min="1" max="999999" class="form-control"  />
                            </div>
                            <div class="col-md-3"></div>
                        </div>

                        <div class="form-group row">
                            <label for = "ap_paterno" class="col-md-1 col-form-label text-md-left">Paterno</label>
                            <div class="col-md-2">
                                <input type="text" name="ap_paterno" id="ap_paterno" value="{{ old('ap_paterno') }}" class="form-control" />
                            </div>
                            <label for = "ap_materno" class="col-md-1 col-form-label text-md-left">Materno</label>
                            <div class="col-md-2">
                                <input type="text" name="ap_materno" id="ap_materno" value="{{ old('ap_materno') }}" class="form-control" />
                            </div>
                            <label for = "nombre" class="col-md-1 col-form-label text-md-left">Nombre</label>
                            <div class="col-md-2">
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" class="form-control" />
                            </div>
                            <label for = "email" class="col-md-1 col-form-label text-md-left">Email</label>
                            <div class="col-md-2">
                                <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "domicilio" class="col-md-1 col-form-label text-md-left">Domicilio</label>
                            <div class="col-md-11">
                                <textarea rows="4" name="domicilio" id="domicilio" class="col-md-12">{{ old('domicilio') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "celular" class="col-md-1 col-form-label text-md-left">Celular</label>
                            <div class="col-md-4">
                                <input type="text" name="celular" id="celular" value="{{ old('celular') }}" class="form-control" />
                            </div>
                            <label for = "telefono" class="col-md-1 col-form-label text-md-left">Teléfono</label>
                            <div class="col-md-4">
                                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}" class="form-control" />
                            </div>
                            <label for = "iduser_ps" class="col-md-1 col-form-label text-md-left">Id PS</label>
                            <div class="col-md-1">
                                <input type="number" name="iduser_ps" id="iduser_ps" value="0" min="0" max="999999" class="form-control" />
                            </div>
                        </div>
                        <hr>
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

