<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>PRODUCTOS DISPONIBLES</strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmCompraEditar">
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
                <label for = "almacen_id" class="col-md-2 col-form-label text-md-left">Almacen</label>
                <div class="col-md-4">
                    {{ Form::select('almacen_id', $Almacenes, $compra->almacen_id, ['id' => 'almacen_id','class' => 'form-control']) }}
                </div>
                <label for = "proveedor_id" class="col-md-2 col-form-label text-md-left">Proveedor</label>
                <div class="col-md-4">
                    {{ Form::select('proveedor_id', $Proveedores, $compra->proveedor_id, ['id' => 'proveedor_id','class' => 'form-control']) }}
                </div>
            </div>

            <div class="form-group row">
                <label for = "folio_factura" class="col-md-2 col-form-label text-md-left">Factura</label>
                <div class="col-md-2">
                    <input type="text" name="folio_factura" id="folio_factura" value="{{ old('folio_factura',$compra->folio_factura) }}" class="form-control" autofocus />
                </div>
                <label for = "nota_id" class="col-md-2 col-form-label text-md-left">Nota</label>
                <div class="col-md-2">
                    <input type="text" name="nota_id" id="nota_id" value="{{ old('nota_id',$compra->nota_id) }}" class="form-control" />
                </div>
                <div class="col-md-4"></div>
            </div>

            <div class="form-group row">
                <label for = "descripcion_compra" class="col-md-2 col-form-label text-md-left">Descripción</label>
                <div class="col-md-10">
                    <input type="text" name="descripcion_compra" id="descripcion_compra" value="{{ old('descripcion_compra',$compra->descripcion_compra) }}" class="form-control" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnVentaDetalleNormalSubmit">
                        Guardar
                    </button>
                </div>
            </div>
            <input type="hidden" name="compra_id"    id="compra_id"       value="{{ $compra->id }}" />
            <input type="hidden" name="empresa_id"   id="empresa_id"      value="{{ $empresa_id }}" />

        </form>
    </div>
</div>
<script >

    var Url = "{{$Url}}";
    // alert(Url);

    if ( $("#frmCompraEditar") ) {

        $("#frmCompraEditar").on("submit", function (event) {
            event.preventDefault();
            var frmSerialize = $("#frmCompraEditar").serialize();
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('Compra modificada con éxito');
                        $("#myModal").modal( 'hide' );
                        window.location.reload();
                    }else{
                        alert(data.mensaje);
                    }
                }
            });

        });

    }

</script>
