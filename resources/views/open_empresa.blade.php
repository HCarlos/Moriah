@extends('layouts.app_open_empresa')


@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-moriah">
                    <div class="panel-heading ">Ingresar</div>

                    <div class="panel-body">

                <form name="empresa-form" id="empresa-form" method="post" action="{{url('setEmpresa')}}">
                    @csrf
                    <div class="form-group">
                        <label for="exampleInputEmail1">Seleccione una empresa</label>
                        <select name="Empresa_Id" id="Empresa_Id" class="form-control" size="1">
                            <option value="0" selected>Seleccione una empresa</option>
                        @foreach( $Empresa as $Emp )
                                <option value="{{$Emp->id}}">{{$Emp->rs}}</option>
                        @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary " style="float: right !important;">Abrir</button>
                </form>
            </div>
        </div>
    </div>

@endsection
