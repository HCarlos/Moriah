<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>NUEVA VENTA</strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmPagoVenta0">
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
                <label for = "total" class="col-md-3 col-form-label text-md-left">Total</label>
                <div class="col-md-3">
                    <input type="text" name="total" id="total" value="{{ old('total',$total) }}" class="form-control" required readonly  {{$venta->isPagado() ? 'disabled' : ''}}/>

                </div>
                <label for = "total_pagado" class="col-md-3 col-form-label text-md-left">Pago</label>
                <div class="col-md-3">
                    <input type="number" name="total_pagado" id="total_pagado" value="{{ old('total',$total) }}" class="form-control" required {{$venta->isPagado() ? 'disabled' : ''}} />
                </div>
            </div>
            <div class="form-group row">
                <label for = "metodo_pago" class="col-md-3 col-form-label text-md-left">Metodo Pago</label>
                <div class="col-md-9">
                    <select id="metodo_pago" name="metodo_pago" size="1" class="form-control ">
                        <option value="0">Efectivo</option>
                        <option value="1">Cheque Nominativo</option>
                        <option value="2">Transferencia Electrónica de Fondos</option>
                        <option value="3" selected>Tarjeta de Crédito</option>
                        <option value="4">Monedero Electrónico</option>
                        <option value="5">Dinero Elctrónico</option>
                        <option value="6">Vales de Despensa</option>
                        <option value="7">Tarjeta de Debito</option>
                        <option value="8">Tarjeta de Servicio</option>
                        <option value="9">Otros</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for = "referencia" class="col-md-3 col-form-label text-md-left">Referencia</label>
                <div class="col-md-9">
                    <input type="text" name="referencia" id="referencia" value="" class="form-control" autofocus  {{$venta->isPagado() ? 'disabled' : ''}}/>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnVentaDetalleNormalSubmit" {{$venta->isPagado() ? 'disabled' : ''}}>
                        Pagar
                    </button>
                </div>
            </div>
            <input type="hidden" name="venta_id"    id="venta_id"       value="{{$venta_id}}" />
        </form>
    </div>
</div>
<script >

    var Url      = "{{$Url}}";
    var Venta_Id = "{{$venta_id}}";
    // alert(Url);

    if ( $("#frmPagoVenta0") ) {

        $("#frmPagoVenta0").on("submit", function (event) {
            event.preventDefault();
            var frmSerialize = $("#frmPagoVenta0").serialize();
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('Pago realizado éxito');
                        $("#myModal").modal( 'hide' );
                        window.location.href = "/print_venta_detalle/"+Venta_Id;
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
