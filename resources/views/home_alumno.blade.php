@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref">
        <div class="row ">
            <div class="content">
                <div class="col-md-12"></div>
                <img src="{{asset('assets/img/biblioteca_virtual_logo_1.png')}}" height="100" width="200" />
                {{ Form::open(['route' => 'busquedaMultimedia/', 'method' => 'POST','class'=>'form form-inline ancho-busqueda-Lati'])}}
                    <div class="form-group col-md-12">
                    <input type="text" name="searchWords" placeholder="Realizar búsqueda por palabras: ALGEBRA TRIGONOMETRIA" class="form-control col-md-11" style="width: 92%;" required autofocus/>
                    <button type="submit" class="btn btn-info btn-sm form-actions form-control col-md-1 "><i class="fas fa-search"></i></button>
                    <span id="helpBlock" class="help-block text-left">Puede buscar: TÍTULO ó AUTOR ó ISBN</span>
                    </div>
                    <input type="hidden" name="npage" value="1"/>
                    <input type="hidden" name="tpaginas" value="0"/>
                {{ Form::close() }}
            </div>

        </div>
    </div>
@endsection
