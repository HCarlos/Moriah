@extends('layouts.app')

@section('main-content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-moriah center-block" id="frmEditProfile1">
                    <div class="panel-heading">
                            <span><strong>Imagen del Paquete | {{$user->username}}</strong>
                            </span>
                    </div>
                    <div class="panel-body">

                        <form method="post" action="{{ action('Storage\StoragePaqueteController@subirArchivoPaquete',['oPaquete'=>$item]) }}" accept-charset="UTF-8" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Nuevo Archivo</label>
                                <div class="col-md-6">
                                    <input type="file" name="file" class="form-control {{ $errors->has('file') ? ' is-invalid' : '' }} altMoz" style="padding-top: 0px;" >
                                    @if ($errors->has('file'))
                                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('file') }}</strong>
                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 control-label">Última Imagen</label>
                                <div class="col-md-6">

                                    <div class="row">
                                        <div class="list-group-item col-md-5" >
                                            @if($item->IsEmptyPhoto())
                                                <img src="{{ asset('assets/img/empty_user.png')  }}" width="100" height="100" title="{{$item->filename}}"/>
                                            @else
                                                <a href="{{ asset('storage/'.$item->root.$item->filename)  }}" target="_blank" >
                                                    <img src="{{ asset('storage/'.$item->root.$item->filename)  }}" width="100" height="100" title="{{$item->filename}}"/>
                                                    <a href="{{ route('storagePaqueteRemove/',array('idItem' => $item->id))  }}"  class="mi-imagen-arriba-derecha fa fa-trash bigger-150 red" >
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
                                <a class="btn btn-info float-md-right " href="#" onclick="javascript:window.close();">
                                    Cerrar
                                </a>
                            </div>

                            <input type="hidden" name="idItem" value="{{$idItem}}" />

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


