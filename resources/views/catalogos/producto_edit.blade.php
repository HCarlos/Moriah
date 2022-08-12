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
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#home" aria-controls="home" role="tab" data-toggle="tab">
                    <i class="fa fa-home"></i>  Propiedades
                </a>
            </li>
            <li role="presentation">
                <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                    <i class="fa fa-barcode"></i>  Imagen
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="home">
                <form method="post" action="{{ action('SIIFAC\ProductoController@update',['prod'=>$items]) }}">
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
                        <label for = "almacen_id" class="col-md-1 col-form-label text-md-left">Almacen</label>
                        <div class="col-md-2">
                            {{ Form::select('almacen_id', $Almacenes, $items->almacen_id, ['id' => 'almacen_id','class' => 'form-control']) }}
                        </div>
                        <label for = "proveedor_id" class="col-md-1 col-form-label text-md-left">Proveedor</label>
                        <div class="col-md-2">
                            {{ Form::select('proveedor_id', $Proveedores, $items->proveedor_id, ['id' => 'proveedor_id','class' => 'form-control']) }}
                        </div>
                        <label for = "familia_producto_id" class="col-md-1 col-form-label text-md-left">Categoría</label>
                        <div class="col-md-2">
                            {{ Form::select('familia_producto_id', $FamProds, $items->familia_producto_id, ['id' => 'familia_producto_id','class' => 'form-control']) }}
                        </div>
                        <label for = "medida_id" class="col-md-1 col-form-label text-md-left">Medida</label>
                        <div class="col-md-2">
                            {{ Form::select('medida_id', $Medidas, $items->medida_id, ['id' => 'medida_id','class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for = "clave" class="col-md-1 col-form-label text-md-left">Clave</label>
                        <div class="col-md-2">
                            <input type="number" name="clave" id="clave" value="{{ old('clave',$items->clave) }}" min="1" max="9999999" class="form-control" />
                        </div>
                        <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                        <div class="col-md-2">
                            <input type="number" name="codigo" id="codigo" value="{{ old('codigo',$items->codigo) }}" min="000000000001" max="999999999999" class="form-control" />
                        </div>
                        <div class="col-md-7"></div>
                    </div>

                    <div class="form-group row">
                        <label for = "descripcion" class="col-md-1 col-form-label text-md-left">Descripción</label>
                        <div class="col-md-7">
                            <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion',$items->descripcion) }}" class="form-control"/>
                        </div>
                        <label for = "shortdesc" class="col-md-1 col-form-label text-md-left">Corta</label>
                        <div class="col-md-3">
                            <input type="text" name="shortdesc" id="shortdesc" value="{{ old('shortdesc',$items->shortdesc) }}" class="form-control"/>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for = "maximo" class="col-md-1 col-form-label text-md-left">Máximo</label>
                        <div class="col-md-2">
                            <input type="text" name="maximo" id="maximo" value="{{ old('maximo',$items->maximo) }}" pattern="[0-9]{1,8}([.][0-9]{0,2})?" class="form-control" />
                        </div>
                        <label for = "minimo" class="col-md-1 col-form-label text-md-left">Mínimo</label>
                        <div class="col-md-2">
                            <input type="text" name="minimo" id="minimo" value="{{ old('minimo',$items->minimo) }}" pattern="[0-9]{1,8}([.][0-9]{0,2})?" class="form-control" />
                        </div>
                        <label for = "cu" class="col-md-1 col-form-label text-md-left">P. Costo</label>
                        <div class="col-md-2">
                            <input type="text" name="cu" id="cu" value="{{ old('cu',$items->cu) }}" class="form-control" pattern="[0-9]{1,8}([.][0-9]{0,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
                        </div>
                        <label for = "status_producto" class="col-md-1 col-form-label text-md-left">Estatus</label>
                        <div class="col-md-2">
                            {{ Form::checkbox('status_producto', null, trim($items->status_producto), ['id' => 'status_producto','class' => 'ace ace-switch']) }}
                            <span class="lbl"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for = "exist" class="col-md-1 col-form-label text-md-left">Exist.</label>
                        <div class="col-md-2">
                            <input type="text" name="exist" id="exist" value="{{ old('exist',$items->exist) }}" class="form-control" pattern="[0-9]{1,8}([.][0-9]{0,2})?" placeholder="99,999.99" required/>
                        </div>

                        <label for = "saldo" class="col-md-1 col-form-label text-md-left">Saldo.</label>
                        <div class="col-md-2">
                            <input type="text" name="saldo" id="saldo" value="{{ old('saldo',$items->saldo) }}" class="form-control" pattern="[0-9]{1,8}([.][0-9]{0,2})?" placeholder="99,999.99" readonly/>
                        </div>

                        <label for = "pv" class="col-md-1 col-form-label text-md-left">P. Venta</label>
                        <div class="col-md-2">
                            <input type="text" name="pv" id="pv" value="{{ old('pv',$items->pv) }}" class="form-control" pattern="[0-9]{1,8}([.][0-9]{0,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
                        </div>
                        <label for = "isiva" class="col-md-1 col-form-label text-md-left">Tiene IVA</label>
                        <div class="col-md-2">
                            {{ Form::checkbox('isiva', null, trim($items->isiva), ['id' => 'isiva','class' => 'ace ace-switch']) }}
                            <span class="lbl"></span>
                        </div>

                    </div>
                    <div class="form-group row">
{{--                        <label class="col-md-2 col-form-label text-md-right"></label>--}}
                        <div class="col-md-3 text-center" >
                            <button type="submit" class="btn btn-primary">
                                Guardar
                            </button>
                        </div>
                        <div class="col-md-3 text-center" >
{{--                            <a href="{{ route('actualizarExistProd/',['producto_id'=>$items->id])  }}" class="btn btn-danger " title="Imprimir tarjeta de movimientos" target="_blank">--}}
{{--                                <i class="fa fa-list bigger-110 white"></i>--}}
                            <a class="btn btn-danger btnActualizarExistProd" title="Actualizar Producto" id="/actualizar_producto/{{$items->id}}" data-toggle="modal" data-target="#myModal">
                                <i class="ace-icon fa fa-adjust bigger-150 "></i>
                                Actualizar Existencias
                            </a>
                        </div>
                        <div class="col-md-3 text-center" >
                            <a href="{{ route('imprimirTarjetasMovto/',['producto_id'=>$items->id])  }}" class="btn btn-cafe " title="Imprimir tarjeta de movimientos" target="_blank">
                                <i class="fa fa-list bigger-110 white"></i>
                                Ver Tarjeta de Almacen
                            </a>
                        </div>
                        <div class="col-md-3 text-center" >
                        <a class="btn btn-info " href="#" onclick="window.close();">
                            Cerrar
                        </a>
                        </div>
                    </div>

                    <input type="hidden" name="idItem" value="{{$idItem}}" />
                    <input type="hidden" name="idItem" value="{{$idItem}}" />

                </form>
            </div>
            <div role="tabpanel" class="tab-pane fade" id="profile">
                <div class="row">
                    <div class="span6">
                        <img class="col-md-6" src="{{ asset('storage/'.$items->root.$items->filename)  }}" alt="Imagen del Producto" />
                    </div>
                    <div  class="span6">
                        <img src="data:image/png;base64, {{$img}} ">
                        <p class="col-md-6 text-center text-inverse character_justify font_PT_Sans_Narrow" >{{$items->codigo}}</p>
                    </div>
                </div>0
            </div>
        </div>
    </div>
</div>
@endsection
@include('catalogos.scripts.productos')
