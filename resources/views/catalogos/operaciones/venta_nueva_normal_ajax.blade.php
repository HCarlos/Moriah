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
                <label for = "user_id" class="col-md-2 col-form-label text-md-left">Cliente</label>
                <div class="col-md-5">
                    {{ Form::select('user_id', $User_Id, null, ['id' => 'user_id','class'=>'form-control']) }}
                </div>
                <label for = "tipoventa" class="col-md-2 col-form-label text-md-left">Contado</label>
                <div class="col-md-3">
                    <select id="tipoventa" name="tipoventa" size="1" class="form-control col-md-3">
                        <option value="0" selected>Contado</option>
                        <option value="1">Credito</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label for = "cantidad" class="col-md-2 col-form-label text-md-left">Cantidad</label>
                <div class="col-md-2">
                    <input type="number" min="1" max="1000" value="1" name="cantidad" id="cantidad" class="form-control" required/>
                </div>
                <label for = "codigo" class="col-md-2 col-form-label text-md-left">Código</label>
                <div class="col-md-6">
                    <input type="number" name="codigo" id="codigo" class="form-control" required autofocus/>
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
        $("#codigo").focus();


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
