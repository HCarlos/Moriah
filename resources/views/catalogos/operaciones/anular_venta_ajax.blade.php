<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>ANULAR VENTA</strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmAnularVenta1">
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
                <label for="movtos_inventario" class="col-md-1 control-label">Metodo:</label>
                <div class="col-md-4">
                    <select name="movtos_inventario" id="movtos_inventario" class="form-control" size="1">
                        @foreach ($movtos_inventario as $key => $value)
                            <option value="{{ $key }}" @if ($key == 1) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <label for = "referencia" class="col-md-1 col-form-label text-md-left">Refer.</label>
                <div class="col-md-3">
                    <input type="text" name="referencia" id="referencia" value="" class="form-control" autofocus  {{$venta->isPagado() ? 'disabled' : ''}}/>
                </div>
                <label for = "total_pagado" class="col-md-1 col-form-label text-md-left">Importe</label>
                <div class="col-md-2">
                    <input type="text" name="total_pagado" id="total_pagado" value="{{ old('total_a_pagar',$total_a_pagar) }}" class="form-control" min="1" max="{{$total_a_pagar}}" required {{$venta->isPagado() ? 'disabled' : ''}} pattern="[-+]?[0-9]*[.,]?[0-9]+" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-9"></div>
                <div class="col-md-3 ">
                    <span id="preloader_siifac"><i class="fa fa-cog fa-spin green pull-left"></i> Trabajando...</span>
                    <button type="submit" class="btn btn-primary pull-right" id="btnVentaDetalleNormalSubmit" {{$venta->isPagado() ? 'disabled' : ''}}>
                        Procesar
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

    var Url         = "{{ $Url }}";
    var Venta_Id    = "{{ $venta_id }}";
    var totalAPagar = "{{ $total_a_pagar }}";
    var mensaje     = "Error al pagar";
    var msg         = "Error";

    if ( $("#frmAnularVenta1") ) {

        $("#frmAnularVenta1").on("submit", function (event) {
            event.preventDefault();
            showPreloader();
            var frmSerialize = $("#frmAnularVenta1").serialize();
            realizarPago(Url, frmSerialize);
            hidePreloader();
            return false;

        });

        function realizarPago(Url, frmSerialize){
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.data == "OK"){
                        alert(data.mensaje);
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
            if (valor == 200 || valor == 300 || valor == 400){
                $("#total_pagado").val(0);
                $("#total_pagado").prop('readonly',true);
            }
        });


        $("#codigo").focus();

    }

</script>
