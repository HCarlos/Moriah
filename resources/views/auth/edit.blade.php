
@extends('layouts.app')

@section('main-content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-moriah">
                    <div class="panel-heading">Perfil | {{$user->username}}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('Edit') }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                                <label for="nombre" class="col-md-4 control-label">Nombre</label>
                                <div class="col-md-6">
                                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre',$user->nombre) }}" autofocus>
                                    @if ($errors->has('nombre'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('nombre') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('ap_paterno') ? ' has-error' : '' }}">
                                <label for="ap_paterno" class="col-md-4 control-label">Apellido Paterno</label>
                                <div class="col-md-6">
                                    <input id="ap_paterno" type="text" class="form-control" name="ap_paterno" value="{{ old('ap_paterno',$user->ap_paterno) }}" autofocus>
                                    @if ($errors->has('ap_paterno'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('ap_paterno') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('ap_materno') ? ' has-error' : '' }}">
                                <label for="ap_materno" class="col-md-4 control-label">Apellido Materno</label>
                                <div class="col-md-6">
                                    <input id="ap_materno" type="text" class="form-control" name="ap_materno" value="{{ old('ap_materno',$user->ap_materno) }}" autofocus>
                                    @if ($errors->has('ap_materno'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('ap_materno') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email_old" class="col-md-4 control-label">Email</label>
                                <div class="col-md-6">
                                    <input id="email_old" type="text" class="form-control" name="email_old" value="{{ old('email',$user->email) }}" disabled>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('celular') ? ' has-error' : '' }}">
                                <label for="celular" class="col-md-4 control-label">Celular</label>
                                <div class="col-md-6">
                                    <input id="celular" type="text" class="form-control" name="celular" id="celular" value="{{ old('celular',$user->celular) }}"  >
                                    @if ($errors->has('celular'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('celular') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('telefono') ? ' has-error' : '' }}">
                                <label for="telefono" class="col-md-4 control-label">Teléfono</label>
                                <div class="col-md-6">
                                    <input id="telefono" type="text" class="form-control" name="telefono" value="{{ old('telefono',$user->telefono) }}"  >
                                    @if ($errors->has('telefono'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('telefono') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email_old" class="col-md-4 control-label">Rol</label>
                                <div class="col-md-6">
                                    @foreach(Auth()->user()->roles()->get() as $role)
                                        <span class="label label-default">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email_old" class="col-md-4 control-label">Permisos</label>
                                <div class="col-md-6">
                                    @foreach(Auth()->user()->permissions()->get() as $permiso)
                                        <span class="label label-default">{{ $permiso->name }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id}}" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
