@extends('home')

@section('content_form_permisions')
<div class="panel panel-primary" id="frmEdit0">
    <div class="panel-heading">
            <span><strong>{{ ucwords($titulo) }}</strong> {{$idItem}}
                {{--<a class="btn btn-info btn-xs pull-right" href="{{ "/index/$id" }}">--}}
                    {{--Regresar--}}
                {{--</a>--}}
                <a class="btn btn-info btn-xs pull-right" href="#" onclick="javascript:window.close();">
                   Cerrar
                </a>
            </span>
    </div>

    <div class="panel-body">
                    <form method="post" action="{{ action('Catalogos\FichaController@clone',['oFicha'=>$items]) }}">
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
                            <label for = "cantidad" class="col-md-2 col-form-label text-md-right">Cantidad</label>
                            <div class="col-md-10">
                                <input type="text" id="cantidad" name="cantidad" value="{{ old('cantidad') }}" class="col-md-12"  required autofocus />
                            </div>
                        </div>
                        <div>
                            <label class="col-md-2 col-form-label text-md-right"></label>
                            <div class="col-md-8" >
                                <button type="submit" class="btn btn-primary">
                                    Clonar
                                </button>
                            </div>
                            {{--<a class="btn btn-info float-md-right " href="{{ "/index/$id" }}">--}}
                                {{--Regresar--}}
                            {{--</a>--}}
                            <a class="btn btn-info float-md-right " href="#" onclick="javascript:window.close();">
                                Cerrar
                            </a>
                        </div>

                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                        <input type="hidden" name="cat_id" value="{{$id}}" />
                        <input type="hidden" name="idItem" value="{{$idItem}}" />
                        <input type="hidden" name="action" value="{{$action}}" />

                    </form>
    </div>
</div>
@endsection

