<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>PRODUCTOS DISPONIBLES</strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmVentaDetalleNormal">
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
                <label for = "cantidad" class="col-md-1 col-form-label text-md-left">Cantidad</label>
                <div class="col-md-2">
                    <input type="number" min="1" max="1000" value="1" name="cantidad" id="cantidad" class="form-control" required/>
                </div>
                <label for = "producto_id" class="col-md-1 col-form-label text-md-left">Producto</label>
                <div class="col-md-5">
                    {{ Form::select('producto_id', $Productos, null, ['id' => 'producto_id','class' => 'form-control']) }}
                </div>
                <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                <div class="col-md-2">
                    <input type="number" name="codigo" id="codigo" class="form-control" required readonly/>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnVentaDetalleNormalSubmit">
                        Seleccionar
                    </button>
                </div>
            </div>
            <input type="hidden" name="venta_id"    id="venta_id"       value="{{$venta_id}}" />
        </form>
    </div>
</div>
<script >

    var Url = "{{$Url}}";
    // alert(Url);

    if ( $("#frmVentaDetalleNormal") ) {

        $("#frmVentaDetalleNormal").on("submit", function (event) {
            event.preventDefault();
            var frmSerialize = $("#frmVentaDetalleNormal").serialize();
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
