@extends('home')

@section('content_form_permisions')
<div class="panel panel-primary" id="frmNew0">
    <div class="panel-heading">
            <span><strong>{{ ucwords($titulo) }}</strong> | Nuevo Registro
                <a class="btn btn-info btn-xs pull-right" href="{{ "/index/$id/1/0" }}">
                    Regresar
                </a>
            </span>
    </div>

    <div class="panel-body">
                    <form method="post" action="{{ action('Catalogos\PermissionController@create') }}">
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
                            <label for = "name" class="col-md-2 col-form-label text-md-right">Permiso</label>
                            <div class="col-md-10">
                                <input type="text" id="name" name="name" value="" class="col-md-12" required autofocus/>
                            </div>
                        </div>
                        <div>
                            <label class="col-md-2 col-form-label text-md-right"></label>
                            <div class="col-md-8" >
                                <button type="submit" class="btn btn-primary">
                                    Guardar
                                </button>
                            </div>
                            <a class="btn btn-info float-md-right " href="{{ "/index/$id" }}">
                                Regresar
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

