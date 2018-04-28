@extends('home')

@section('content_form_permisions')
<div class="panel panel-primary" id="frmEdit0">
    <div class="panel-heading">
            <span><strong>{{ ucwords($titulo) }}</strong> | Editando registro {{$idItem}}
                <a class="btn btn-info btn-xs pull-right" href="#" onclick="javascript:window.close();">
                   Cerrar
                </a>
            </span>
    </div>
    <div class="panel-body">
        <div class="col-md-9">
            <form method="post" action="{{ action('Catalogos\UsuarioController@update',['usr'=>$items]) }}">
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
                    <label for = "nombre_completo" class="col-md-3 col-form-label text-md-right">Nombre Completo</label>
                    <div class="col-md-9">
                        <input type="text" name="nombre_completo" value="{{ old('nombre_completo',$items->nombre_completo) }}" class="col-md-12" required autofocus />
                    </div>
                </div>

                <div class="form-group row">
                    <label for = "email" class="col-md-3 col-form-label text-md-right">Email</label>
                    <div class="col-md-9">
                        <input type="text" name="email" value="{{ old('email',$items->email) }}" class="col-md-12" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for = "twitter" class="col-md-3 col-form-label text-md-right">Twitter</label>
                    <div class="col-md-9">
                        <input type="text" name="twitter"  value="{{ old('twitter',$items->twitter) }}" class="col-md-12"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for = "facebook" class="col-md-3 col-form-label text-md-right">Facebook</label>
                    <div class="col-md-9">
                        <input type="text" name="facebook"  value="{{ old('facebook',$items->facebook) }}" class="col-md-12"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for = "instagram" class="col-md-3 col-form-label text-md-right">Instagram</label>
                    <div class="col-md-9">
                        <input type="text" name="instagram"  value="{{ old('instagram',$items->instagram) }}" class="col-md-12"/>
                    </div>
                </div>
                <div class="form-group row disabled">
                    <label class="col-md-3 col-form-label text-md-right disabled">Roles</label>
                    <div class="col-md-9 disabled">
                        <input type="text" value="{{ $otrosDatos }}" class="col-md-12 text-muted" disabled/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for = "admin" class="col-md-3 col-form-label text-md-right">Is Admin</label>
                    <div class="col-md-9">
                            <label>
                                {{ Form::checkbox('admin', null, trim($items->admin), ['id' => 'admin','class' => 'col-md-3','disabled' => 'disabled']) }}
                            </label>
                    </div>
                </div>
                <hr>
                <div>
                    <label class="col-md-3 col-form-label text-md-right"></label>
                    <div class="col-md-7" >
                        <button type="submit" class="btn btn-primary col-md-3">
                            Guardar
                        </button>
                    </div>
                    {{--<a class="btn btn-info col-md-2 " href="{{ "/index/$id" }}">--}}
                        {{--Regresar--}}
                    <a class="btn btn-info float-md-right " href="#" onclick="javascript:window.close();">
                        Cerrar
                    </a>
                </div>

                <input type="hidden" name="user_id" value="{{$user->id}}" />
                <input type="hidden" name="cat_id" value="{{$id}}" />
                <input type="hidden" name="idItem" value="{{$idItem}}" />
                <input type="hidden" name="action" value="{{$action}}" />
                <input type="hidden" name="no" value="0{{$user->no}}" />

            </form>
        </div>
        <div class="col-md-3">
            @if($items->IsEmptyPhoto())
                <img src="{{ asset('assets/img/empty_user.png')  }}" title="{{$items->filename}}" class="col-md-12 img-polaroid"/>
            @else
                <a href="{{ asset('storage/'.$items->root.$items->filename)  }}" target="_blank" class="col-md-12" >
                    <img src="{{ asset('storage/'.$items->root.$items->filename)  }}" title="{{$items->filename}}" class="col-md-12 img-polaroid"/>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection

