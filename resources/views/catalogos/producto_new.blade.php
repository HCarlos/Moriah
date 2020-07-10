@extends('layouts.app')

@section('main-content')
    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Nuevo registro {{$idItem}}
            <a class="btn btn-info btn-minier pull-right" href="#" onclick="window.close();">
                   Cerrar
            </a>
        </span>
    </div>

    <div class="panel-body">
        <form method="post" action="{{ action('SIIFAC\ProductoController@store') }}">
            {{ csrf_field() }}

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
                <label for = "almacen_id" class="col-md-1 col-form-label text-md-left">Almacen</label>
                <div class="col-md-2">
                    {{ Form::select('almacen_id', $Almacenes, 1, ['id' => 'almacen_id','class' => 'form-control']) }}
                </div>
                <label for = "proveedor_id" class="col-md-1 col-form-label text-md-left">Proveedor</label>
                <div class="col-md-2">
                    {{ Form::select('proveedor_id', $Proveedores, null, ['id' => 'proveedor_id','class' => 'form-control']) }}
                </div>
                <label for = "familia_producto_id" class="col-md-1 col-form-label text-md-left">Categoría</label>
                <div class="col-md-2">
                    {{ Form::select('familia_producto_id', $FamProds, 1, ['id' => 'familia_producto_id','class' => 'form-control']) }}
                </div>
                <label for = "medida_id" class="col-md-1 col-form-label text-md-left">Medida</label>
                <div class="col-md-2">
                    {{ Form::select('medida_id', $Medidas, 1, ['id' => 'medida_id','class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                <label for = "clave" class="col-md-1 col-form-label text-md-left">Clave</label>
                <div class="col-md-2">
                    <input type="number" name="clave" id="clave" value="{{ old('clave') }}" min="1" max="9999999" class="form-control" />
                </div>
                <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                <div class="col-md-2">
                    <input type="number" name="codigo" id="codigo" value="{{ old('codigo') }}" min="000000000001" max="999999999999" class="form-control" />
                </div>
                <div class="col-md-7"></div>
            </div>

            <div class="form-group row">
                <label for = "descripcion" class="col-md-1 col-form-label text-md-left">Descripción</label>
                <div class="col-md-7">
                    <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}" class="form-control"/>
                </div>
                <label for = "shortdesc" class="col-md-1 col-form-label text-md-left">Corta</label>
                <div class="col-md-3">
                    <input type="text" name="shortdesc" id="shortdesc" value="{{ old('shortdesc') }}" class="form-control"/>
                </div>
            </div>

            <div class="form-group row">
                <label for = "maximo" class="col-md-1 col-form-label text-md-left">Máximo</label>
                <div class="col-md-2">
                    <input type="number" name="maximo" id="maximo" value="{{ old('maximo') }}" min="1" max="9999999999" class="form-control" />
                </div>
                <label for = "minimo" class="col-md-1 col-form-label text-md-left">Mínimo</label>
                <div class="col-md-2">
                    <input type="number" name="minimo" id="minimo" value="{{ old('minimo') }}" min="1" max="9999999999" class="form-control" />
                </div>
                <label for = "isiva" class="col-md-1 col-form-label text-md-left">Agr. IVA</label>
                <div class="col-md-2">
                    {{ Form::checkbox('isiva', null, true , ['id' => 'isiva','class' => 'ace ace-switch']) }}
                    <span class="lbl"></span>
                </div>
                <div class="col-md-3"></div>
            </div>

            <div class="form-group row">
                <label for = "cu" class="col-md-1 col-form-label text-md-left">P. Costo</label>
                <div class="col-md-2">
                    <input type="number" name="cu" id="cu" value="{{ old('cu') }}" min="0" step="0.01" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
                </div>

                <label for = "exist" class="col-md-1 col-form-label text-md-left">Exist.</label>
                <div class="col-md-2">
                    <input type="number" name="exist" id="exist" value="{{ old('exist') }}" min="0" step="1" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
                </div>

                <label for = "saldo" class="col-md-1 col-form-label text-md-left">Saldo.</label>
                <div class="col-md-2">
                    <input type="number" name="saldo" id="saldo" value="{{ old('saldo') }}" min="0" step="0.01" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" readonly/>
                </div>

                <label for = "pv" class="col-md-1 col-form-label text-md-left">P. Venta</label>
                <div class="col-md-2">
                    <input type="number" name="pv" id="pv" value="{{ old('pv') }}" min="0" step="0.01" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
                </div>

            </div>
            <div>
                <label class="col-md-2 col-form-label text-md-right"></label>
                <div class="col-md-8" >
                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>
                <a class="btn btn-info float-md-right " href="#" onclick="window.close();">
                    Cerrar
                </a>
            </div>

            <input type="hidden" name="idItem" value="{{$idItem}}" />

        </form>

    </div>
</div>
@endsection

