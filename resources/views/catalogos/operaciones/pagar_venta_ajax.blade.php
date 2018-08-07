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
                            <option value="{{ $key }}"@if ($key == 3) selected @endif>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <label for = "referencia" class="col-md-1 col-form-label text-md-left">Refer.</label>
                <div class="col-md-3">
                    <input type="text" name="referencia" id="referencia" value="" class="form-control" autofocus  {{$venta->isPagado() ? 'disabled' : ''}}/>
                </div>
                <label for = "total_pagado" class="col-md-1 col-form-label text-md-left">Pago</label>
                <div class="col-md-2">
                    <input type="number" name="total_pagado" id="total_pagado" value="{{ old('total_a_pagar',$total_a_pagar) }}" class="form-control" min="1" max="{{$total_a_pagar}}" required {{$venta->isPagado() ? 'disabled' : ''}} />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnVentaDetalleNormalSubmit" {{$venta->isPagado() ? 'disabled' : ''}}>
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

</script>
