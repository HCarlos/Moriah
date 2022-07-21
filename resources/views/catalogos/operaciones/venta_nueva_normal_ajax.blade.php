<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>NUEVA VENTA</strong></span>
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
                <label for = "user_id" class="col-md-1 col-form-label text-md-left">Cliente</label>
                <div class="col-md-5">
                    {{ Form::select('user_id', $User_Id, null, ['id' => 'user_id','class'=>'form-control']) }}
                </div>
                <label for = "tipoventa" class="col-md-1 col-form-label text-md-left">Contado</label>
                <div class="col-md-5">
                    <select id="tipoventa" name="tipoventa" size="1" class="form-control col-md-3">
                        <option value="0" selected>Contado</option>
                        <option value="1">Credito</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for = "cantidad" class="col-md-1 col-form-label text-md-left">Cantidad</label>
                <div class="col-md-2">

{{--                    <input type="number" min="1" max="1000"  value="1" name="cantidad" id="cantidad" class="form-control" required/>--}}
                    <input type="text" pattern="[0-9]{1,8}([.][0-9]{0,2})?" name="cantidad" id="cantidad" class="form-control" required/>
                </div>
                <label for = "producto_id" class="col-md-1 col-form-label text-md-left">Producto</label>
                <div class="col-md-5">
                    {{ Form::select('producto_id', $Productos, null, ['id' => 'producto_id','class' => 'form-control']) }}
                </div>
                <label for = "codigo" class="col-md-1 col-form-label text-md-left">Código</label>
                <div class="col-md-2">
                    <input type="number" name="codigo" id="codigo" class="form-control" required autofocus/>
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
            event.preventDefault();
            $("#codigo").val( $(this).val() );
        });

        //$("#producto_id").append('<option value="0" selected>Selecione un producto</option>');

        // $("#codigo").val( $("#producto_id").val() );
        $("#codigo").focus();

    }

</script>
