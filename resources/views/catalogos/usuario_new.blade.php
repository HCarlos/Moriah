@extends('home')

@section('content_form_permisions')
<div class="panel panel-primary" id="frmNew0">
    <div class="panel-heading">
            <span><strong>{{ ucwords($titulo) }}</strong> | Nuevo Registro
                <a class="btn btn-info btn-xs pull-right" href="#" onclick="javascript:window.close();">
                   Cerrar
                </a>
            </span>
    </div>

    <div class="panel-body">
        <form method="post" action="{{ action('Catalogos\UsuarioController@create') }}">
            {{ csrf_field()   }}

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
                <label for = "username" class="col-md-2 col-form-label text-md-right">Username</label>
                <div class="col-md-10">
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus />
                </div>
            </div>
            <div class="form-group row">
                <label for = "email" class="col-md-2 col-form-label text-md-right">Email</label>
                <div class="col-md-10">
                    <input type="email" name="email"  value="{{ old('email') }}" class="col-md-12" required />
                </div>
            </div>
            <div class="form-group row">
                <label for = "password" class="col-md-2 col-form-label text-md-right">Password</label>
                <div class="col-md-10">
                    <input type="password" name="password"  value="" required />
                </div>
            </div>
            <div class="form-group row">
                <label for = "password_confirmation" class="col-md-2 col-form-label text-md-right">Re-password</label>
                <div class="col-md-10">
                    <input type="password" name="password_confirmation"  value="" required />
                </div>
            </div>
            <div class="form-group row">
                <label for = "role" class="col-md-2 col-form-label text-md-right">Role</label>
                <div class="col-md-10">
                    {{ Form::select('role', $otrosDatos, old('role'), ['id' => 'role','class' => 'col-md-2']) }}
                </div>
            </div>
            <div>
                <label class="col-md-2 col-form-label text-md-right"></label>
                <div class="col-md-8" >
                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>
                {{--<a class="btn btn-info float-md-right " href="{{ "/index/$id" }}">--}}
                    {{--Regresar--}}
                <a class="btn btn-info float-md-right " href="#" onclick="javascript:window.close();">
                    Cerrar
                </a>
            </div>

            <input type="hidden" name="user_id" value="{{$user->id}}" />
            <input type="hidden" name="cat_id" value="{{$id}}" />
            <input type="hidden" name="idItem" value="{{$idItem}}" />
            <input type="hidden" name="action" value="{{$action}}" />
            <input type="hidden" name="no" value="0" />

        </form>
    </div>
</div>
@endsection

