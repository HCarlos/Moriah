@extends('layouts.app')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-moriah center-block" id="frmEditProfile1">
                    <div class="panel-heading">
                            <span><strong>Cambiar foto de perfil | {{$user->username}}</strong>
                            </span>
                    </div>

                    <div class="panel-body">
                        <form method="post" action="{{ action('Storage\StorageProfileController@subirArchivoProfile',['user'=>$user]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label for="foto" class="col-md-4 control-label">Nuevo Archivo</label>
                                <div class="col-md-6">
                                    <input type="file" name="photo" class="form-control fileSelect {{ $errors->has('photo') ? ' is-invalid' : '' }} altMoz" style="padding-top: 0px;" >
                                    @if ($errors->has('photo'))
                                        <span class="invalid-feedback">
                                            <strong>{{ $errors->first('photo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Última Imagen</label>
                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="list-group-item col-md-5" >
                                            @if($user->IsEmptyPhoto())
                                                <img src="{{ asset('assets/img/empty_user.png')  }}" width="100" height="100" title="{{$user->filename}}" class="trans-img"/>
                                            @else
                                                <a href="{{ asset('storage/'.$user->root.$user->filename)  }}" target="_blank" >
                                                    <img src="{{ asset('storage/'.$user->root.$user->filename)  }}" width="100" height="100" title="{{$user->filename}}"/>
                                                    <a href="{{ route('quitarArchivoProfile/')  }}"  class="fa fa-trash bigger-150 mi-imagen-arriba-derecha red" >
                                                        <i class="fas fa-trash-alt red"></i>
                                                    </a>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="col-md-2 col-form-label text-md-right"></label>
                                <div class="col-md-8" >
                                    <button type="submit" class="btn btn-primary">
                                        Subir
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


