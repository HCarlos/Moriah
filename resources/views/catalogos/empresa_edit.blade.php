@extends('layouts.app')

@section('main-content')
<div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
            <span><strong>{{ ucwords($titulo) }}</strong> | Editando registro {{$idItem}}
                <a class="btn btn-info btn-minier pull-right" href="#" onclick="window.close();">
                   Cerrar
                </a>
            </span>
    </div>

    <div class="panel-body">
                    <form method="post" action="{{ action('SIIFAC\EmpresaController@update',['emp'=>$items]) }}">
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
                            <label for = "rs" class="col-md-2 col-form-label text-md-right">Razón Social</label>
                            <div class="col-md-10">
                                <input type="text" name="rs" value="{{ old('rs',$items->rs) }}" class="col-md-12" autofocus />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for = "ncomer" class="col-md-2 col-form-label text-md-right">Contacto</label>
                            <div class="col-md-10">
                                <input type="text" name="ncomer"  value="{{ old('ncomer',$items->ncomer) }}" class="col-md-12"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for = "df" class="col-md-2 col-form-label text-md-right">Domicilio</label>
                            <div class="col-md-10">
                                <input type="text" name="df"  value="{{ old('df',$items->df) }}" class="col-md-12"/>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for = "rfc" class="col-md-2 col-form-label text-md-right">RFC</label>
                            <div class="col-md-10">
                                <input type="text" name="rfc"  value="{{ old('rfc',$items->rfc) }}" class="col-md-12"/>
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
                            <a class="btn btn-info float-md-right " href="#" onclick="window.close();">
                                Cerrar
                            </a>
                        </div>

                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                        <input type="hidden" name="idItem" value="{{$idItem}}" />

                    </form>
    </div>
</div>
@endsection

