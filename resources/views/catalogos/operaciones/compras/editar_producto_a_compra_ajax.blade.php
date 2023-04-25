<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>Editando el Código: {{ $item->codigo }}</strong></span>
    </div>

    <div class="panel-body">
        <form method="post" id="compraEditDetalleAjax">
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
                <label for = "almacen_id" class="col-md-1 col-form-label text-md-left">Almacén</label>
                <div class="col-md-3">
                    {{ Form::select('almacen_id', $Almacenes, $item->almacen_id, ['id' => 'almacen_id','class' => 'form-control']) }}
                </div>
                <label for = "proveedor_id" class="col-md-1 col-form-label text-md-left">Proveedor</label>
                <div class="col-md-3">
                    {{ Form::select('proveedor_id', $Proveedores, $item->proveedor_id, ['id' => 'proveedor_id','class' => 'form-control']) }}
                </div>
                <div class="col-md-4">
                </div>
            </div>


            <div class="form-group row">
                <label for = "entrada" class="col-md-1 col-form-label text-md-left">Cantidad</label>
                <div class="col-md-2">
{{--                    <input type="number" min="1" max="1000" value="1" required name="cantidad" id="cantidad" class="form-control"/>--}}
                    <input type="text" pattern="[0-9]{1,8}([.][0-9]{0,2})?" name="entrada" id="entrada" value="{{ old('cantidad',$item->entrada)  }}" class="form-control" title="Formato Decimal" required/>
                </div>
                <label for = "producto_id" class="col-md-1 col-form-label text-md-left">Producto</label>
                <div class="col-md-5">
                    {{ Form::select('producto_id', $Productos, $item->codigo, ['id' => 'producto_id','class' => 'form-control']) }}
                </div>
                <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                <div class="col-md-2">
                    <input type="text" required name="codigo" id="codigo" class="form-control" value="{{ old('codigo', $item->codigo) }}" />
                </div>
            </div>
            <div class="form-group row">
                <label for = "cu" class="col-md-1 col-form-label text-right label-sm">P. Costo</label>
                <div class="col-md-2">
                    <input type="number" name="cu" id="cu" min="0" step="0.01" value="{{ old('cu',$item->cu) }}" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
                </div>

                <label for = "pu" class="col-md-1 col-form-label text-right label-sm">P. Venta</label>
                <div class="col-md-2">
                    <input type="number" name="pu" id="pu" min="0" step="0.01" value="{{ old('pu',$item->pu) }}" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
                </div>
                <div class="col-md-6"></div>

            </div>


            <div class="form-group row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnVentaDetalleNormalSubmit">
                        Seleccionar
                    </button>
                </div>
            </div>
            <input type="hidden" name="compra_id" id="compra_id" value="{{ $item->compra_id }}" />
            <input type="hidden" name="almacen_anterior_id" id="almacen_anterior_id" value="{{ $item->almacen_id }}" />
            <input type="hidden" name="producto_anterior_id" id="producto_anterior_id" value="{{ $item->producto_id }}" />
            <input type="hidden" name="proveedor_anterior_id" id="proveedor_anterior_id" value="{{ $item->proveedor_id }}" />
            <input type="hidden" name="medida_anterior_id" id="medida_anterior_id" value="{{ $item->medida_id }}" />
            <input type="hidden" name="movimiento_id" id="movimiento_id" value="{{ $item->id }}" />
            <input type="hidden" name="empresa_id" id="empresa_id" value="{{ $empresa_id }}" />
        </form>
    </div>
</div>
<script >

    var Url = "{{ $Url }}";
    // alert(Url);

    if ( $("#compraEditDetalleAjax") ) {

        $("#compraEditDetalleAjax").on("submit", function (event) {
            event.preventDefault();
            var frmSerialize = $("#compraEditDetalleAjax").serialize();
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('Cambios efectuados con éxito');
                        $("#myModal").modal( 'hide' );
                        window.location.reload();
                    }else{
                        alert(data.mensaje);
                    }
                }
            });

        });

        $("#producto_id").on('change',function (event) {
            $("#codigo").val( $(this).val() );
        });
        // $("#codigo").val( $("#producto_id").val() );
    }

</script>
