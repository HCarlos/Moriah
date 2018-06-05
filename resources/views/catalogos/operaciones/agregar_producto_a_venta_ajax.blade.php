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
                <label for = "cantidad" class="col-md-2 col-form-label text-md-left">Cantidad</label>
                <div class="col-md-2">
                    <input type="number" min="1" max="1000" value="1" required name="cantidad" id="cantidad" class="form-control"/>
                </div>
                <label for = "codigo" class="col-md-2 col-form-label text-md-left">Código</label>
                <div class="col-md-6">
                    <input type="number" required name="codigo" id="codigo" class="form-control"/>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5"></div>
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

    }

    /*
    $('#frmVentaDetalleNormal form').validate({
        rules: {
            cantidad: {
                //money: true, // not a valid rule
                required: true
            },
            codigo: {
                required: true
            }
        },
        highlight: function (element) {
            $(element).closest('.control-group')
                .removeClass('success').addClass('error');
        },
        success: function (element) {
            element.addClass('valid').closest('.control-group')
                .removeClass('error').addClass('success');
        },
        submitHandler: function (form) {

            var frmSerialize = $(form).serialize();
            alert(frmSerialize);
            alert(Url);
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

        }

    });
*/


</script>
