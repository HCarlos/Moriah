<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>PRODUCTOS DISPONIBLES</strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmCompraDetalle">
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
                <div class="col-md-3">
                    {{ Form::select('almacen_id', $Almacenes, 1, ['id' => 'almacen_id','class' => 'form-control']) }}
                </div>
                <label for = "proveedor_id" class="col-md-1 col-form-label text-md-left">Proveedor</label>
                <div class="col-md-3">
                    {{ Form::select('proveedor_id', $Proveedores, null, ['id' => 'proveedor_id','class' => 'form-control']) }}
                </div>
                <label for = "empresa_id" class="col-md-1 col-form-label text-md-left">Empresa</label>
                <div class="col-md-3">
                    {{ Form::select('empresa_id', $Empresas, null, ['id' => 'empresa_id','class' => 'form-control']) }}
                </div>
            </div>


            <div class="form-group row">
                <label for = "cantidad" class="col-md-1 col-form-label text-md-left">Cantidad</label>
                <div class="col-md-2">
                    <input type="number" min="1" max="1000" value="1" required name="cantidad" id="cantidad" class="form-control"/>
                </div>
                <label for = "producto_id" class="col-md-1 col-form-label text-md-left">Producto</label>
                <div class="col-md-5">
                    {{ Form::select('producto_id', $Productos, null, ['id' => 'producto_id','class' => 'form-control']) }}
                </div>
                <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                <div class="col-md-2">
                    <input type="number" required name="codigo" id="codigo" class="form-control" readonly/>
                </div>
            </div>
            <div class="form-group row">
                <label for = "cu" class="col-md-1 col-form-label text-right label-sm">P. Costo</label>
                <div class="col-md-2">
                    <input type="number" name="cu" id="cu" value="{{ old('cu') }}" min="0" step="0.01" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
                </div>

                <label for = "pv" class="col-md-1 col-form-label text-right label-sm">P. Venta</label>
                <div class="col-md-2">
                    <input type="number" name="pv" id="pv" value="{{ old('pv') }}" min="0" step="0.01" class="form-control" pattern="\d{0,2}(\.\d{1,2})?" placeholder="99,999.99" required onchange="setTwoNumberDecimal"/>
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
            <input type="hidden" name="compra_id"    id="compra_id"       value="{{$compra_id}}" />
        </form>
    </div>
</div>
<script >

    var Url = "{{$Url}}";
    // alert(Url);

    if ( $("#frmCompraDetalle") ) {

        $("#frmCompraDetalle").on("submit", function (event) {
            event.preventDefault();
            var frmSerialize = $("#frmCompraDetalle").serialize();
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('Producto agregado con éxito');
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
        $("#codigo").val( $("#producto_id").val() );
    }

</script>
