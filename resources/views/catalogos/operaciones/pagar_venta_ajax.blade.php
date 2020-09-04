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
                <label for = "total" class="col-md-1 col-form-label text-md-left">Total</label>
                <div class="col-md-2">
                    <input type="text" name="total" id="total" value="{{ old('total',$total) }}" class="form-control" readonly  {{$venta->isPagado() ? 'disabled' : ''}}/>
                </div>
                <label for = "total_abonos" class="col-md-1 col-form-label text-md-left">Abonos</label>
                <div class="col-md-2">
                    <input type="number" name="total_abonos" id="total_abonos" value="{{ old('total_abonos',$total_abonos) }}" class="form-control" min="1" max="{{$total_abonos}}" readonly  {{$venta->isPagado() ? 'disabled' : ''}} />
                </div>
                <label for = "tipoventa" class="col-md-1 col-form-label text-md-left">Tipo</label>
                <div class="col-md-2">
                    <input type="text" name="tipoventa" id="tipoventa" value="{{ old('tipoventa',$venta->tipoventa) }}" class="form-control" readonly  {{$venta->isPagado() ? 'disabled' : ''}}/>

                </div>
                <label for = "fechaventa" class="col-md-1 col-form-label text-md-left">Fecha</label>
                <div class="col-sm-2">
                    <input type="text" name="fechaventa" id="fechaventa" value="{{ old('fechaventa',$venta->FechaVenta) }}" class="form-control col-sm-2 " readonly  {{$venta->isPagado() ? 'disabled' : ''}}/>
                </div>
            </div>
            <div class="form-group row">
                <label for="metodo_pago" class="col-md-1 control-label">Metodo:</label>
                <div class="col-md-4">
                    <select name="metodo_pago" id="metodo_pago" class="form-control" size="1">
                        @foreach ($metodo_pagos as $key => $value)
                            @if ($value!=="-")
                            <option value="{{ $key }}" @if ($key == 1) selected @endif>{{ $value }}</option>
                            @else
                                <option disabled>────────────────────</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <label for = "referencia" class="col-md-1 col-form-label text-md-left">Refer.</label>
                <div class="col-md-3">
                    <input type="text" name="referencia" id="referencia" value="" class="form-control" autofocus  {{$venta->isPagado() ? 'disabled' : ''}}/>
                </div>
                <label for = "total_pagado" class="col-md-1 col-form-label text-md-left">Pago</label>
                <div class="col-md-2">
                    <input type="text" name="total_pagado" id="total_pagado" value="{{ old('total_a_pagar',$total_a_pagar) }}" class="form-control" min="1" max="{{$total_a_pagar}}" required {{$venta->isPagado() ? 'disabled' : ''}} pattern="[-+]?[0-9]*[.,]?[0-9]+" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-9"></div>
                <div class="col-md-3 ">
                    <span id="preloader_siifac"><i class="fa fa-cog fa-spin green pull-left"></i> Pagando...</span>
                    <button type="submit" class="btn btn-primary pull-right" id="btnVentaDetalleNormalSubmit" {{$venta->isPagado() ? 'disabled' : ''}}>
                        Pagar
                    </button>
                </div>
            </div>
            <input type="hidden" name="total_a_pagar" id="total_a_pagar" value="{{$total_a_pagar}}" />
            <input type="hidden" name="venta_id" id="venta_id" value="{{$venta_id}}" />
        </form>
    </div>
</div>
<script >
    $("#preloader_siifac").hide();

    var Url         = "{{$Url}}";
    var Venta_Id    = "{{$venta_id}}";
    var totalAPagar = "{{$total_a_pagar}}";
    var mensaje     = "Error al pagar";
    var msg         = "Error";

    if ( $("#frmPagoVenta0") ) {

        $("#frmPagoVenta0").on("submit", function (event) {
            event.preventDefault();
            showPreloader();
            var frmSerialize = $("#frmPagoVenta0").serialize();
            var metodo_pago = $("#metodo_pago").val();
            var referencia = $("#referencia").val();
            msg = validMetodoPago(metodo_pago, referencia, frmSerialize);
            if ( msg == "OK" ){
                realizarPago(Url, frmSerialize);
            }else{
                 if ( !isNaN(msg) )
                    alert(msg);
            }
            hidePreloader();
            return false;

        });

        function validMetodoPago(metodoPago,referencia,frmSerialize){
            var mP = parseInt(metodoPago);
            var ref = Number.parseInt(referencia,10);
            var total_pagado = parseFloat($("#total_pagado").val());
            msg = "OK";
            switch(mP){
                case 0:
                    msg = validIsPago(total_pagado,totalAPagar, mP);
                    break;
                case 1:
                case 2:
                case 3:
                case 4:
                case 6:
                case 7:
                case 8:
                case 9:
                    if ( $.trim(referencia) == "" ) msg = "Falta la referencia";
                    else msg = validIsPago(total_pagado,totalAPagar, mP);
                    break;
                case 5:
                    if ( isNaN(ref) ) msg = "Falta la referencia";
                    else msg = yaSeUtilizoLaNotaDeCredito(frmSerialize);
                    break;
                default:
                    break;
            }
            return msg;
        }

        function yaSeUtilizoLaNotaDeCredito(frmSerialize){
            $.ajax({
                cache: false,
                type: 'post',
                url: '/ya_se_utilizo_nota_credito_ajax',
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    msg = data.mensaje;
                    hidePreloader();
                    if (msg != "OK") alert(msg);
                    else realizarPago(Url, frmSerialize);
                    return msg;
                }
            });

        }

        function realizarPago(Url, frmSerialize){
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.data == "OK"){
                        //alert(data.mensaje);
                        window.open(
                            '/print_venta_detalle/'+Venta_Id,
                            '_blank'
                        );
                        document.location.reload();
                    }
                    return data.data;
                }
            });

        }

        function showPreloader(){
            $("#preloader_siifac").show();
            $("#btnVentaDetalleNormalSubmit").prop('disabled',true);
        }

        function hidePreloader(){
            $("#preloader_siifac").hide();
            $("#btnVentaDetalleNormalSubmit").prop('disabled',false);
        }

        $("#metodo_pago").on("change",function(event){
            event.preventDefault();
            var valor = Number.parseFloat($(this).val());
            if (valor == 0 || valor == 1 || valor == 2 || valor == 3 || valor == 4 || valor == 6 || valor == 7 || valor == 8 || valor == 9 ){
                var total_pagado = parseFloat( $("#total_pagado").val() );
                $("#total_pagado").val(total_pagado);
                $("#total_pagado").prop('readonly',false);
            }
        });


        function validIsPago(total_pagado,totalAPagar, mP){
            var msg = "OK";
            switch(mP){
                case 0:
                case 1:
                case 2:
                case 3:
                case 4:
                case 5:
                case 6:
                case 7:
                case 8:
                case 9:
                    if (total_pagado <= 0 || total_pagado > totalAPagar){
                        msg = "Hay un problema con el pago";
                    }
                    break;
            }
            return msg;
        }

        $("#codigo").focus();

        // alert("Entro bien")

    }

</script>
