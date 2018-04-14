@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">Perfil | {{$user->username}}</div>

                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('Edit') }}">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="form-group{{ $errors->has('nombre_completo') ? ' has-error' : '' }}">
                                <label for="nombre_completo" class="col-md-4 control-label">Nombre Completo</label>
                                <div class="col-md-6">
                                    <input id="nombre_completo" type="text" class="form-control" name="nombre_completo" value="{{ old('nombre_completo',$user->nombre_completo) }}" autofocus>
                                    @if ($errors->has('nombre_completo'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('nombre_completo') }}</strong>
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

                            <div class="form-group{{ $errors->has('twitter') ? ' has-error' : '' }}">
                                <label for="twitter" class="col-md-4 control-label">Twitter</label>
                                <div class="col-md-6">
                                    <input id="twitter" type="text" class="form-control" name="twitter" id="twitter" value="{{ old('twitter',$user->twitter) }}"  >
                                    @if ($errors->has('twitter'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('twitter') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('facebook') ? ' has-error' : '' }}">
                                <label for="facebook" class="col-md-4 control-label">Facebook</label>
                                <div class="col-md-6">
                                    <input id="facebook" type="text" class="form-control" name="facebook" value="{{ old('facebook',$user->facebook) }}"  >
                                    @if ($errors->has('facebook'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('facebook') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('instagram') ? ' has-error' : '' }}">
                                <label for="instagram" class="col-md-4 control-label">Instagram</label>
                                <div class="col-md-6">
                                    <input id="instagram" type="text" class="form-control" name="instagram" value="{{ old('instagram',$user->instagram) }}"  >
                                    @if ($errors->has('instagram'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('instagram') }}</strong>
                                    </span>
                                    @endif
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
