@extends('layouts.app')

@section('main-content')
<div class="panel panel-moriah" id="frmNew0">
    <div class="panel-heading">
            <span><strong>{{ ucwords($titulo) }}</strong> | Nuevo Registro
                <a class="btn btn-info btn-minier pull-right" href="#" onclick="window.close();">
                   Cerrar
                </a>
            </span>
    </div>

    <div class="panel-body">
        <form method="post" action="{{ action('SIIFAC\ProveedorController@store') }}">
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
                <label for = "nombre_proveedor" class="col-md-2 col-form-label text-md-right">Nombre</label>
                <div class="col-md-10">
                    <input type="text" name="nombre_proveedor" value="{{old('nombre_proveedor')}}" class="col-md-12" autofocus/>
                </div>
            </div>
            <div class="form-group row">
                <label for = "contacto_proveedor" class="col-md-2 col-form-label text-md-right">Contacto</label>
                <div class="col-md-10">
                    <input type="text" name="contacto_proveedor"  value="{{old('contacto_proveedor')}}" class="col-md-12"/>
                </div>
            </div>
            <div class="form-group row">
                <label for = "domicilio_fiscal_proveedor" class="col-md-2 col-form-label text-md-right">Domicilio</label>
                <div class="col-md-10">
                    <input type="text" name="domicilio_fiscal_proveedor"  value="{{old('domicilio_fiscal_proveedor')}}" class="col-md-12"/>
                </div>
            </div>

            <div class="form-group row">
                <label for = "clave_proveedor" class="col-md-2 col-form-label text-md-right">Clave</label>
                <div class="col-md-10">
                    <input type="text" name="clave_proveedor"  value="{{old('clave_proveedor')}}" class="col-md-12"/>
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
            <input type="hidden" name="no" value="0" />

        </form>
    </div>
</div>
@endsection

