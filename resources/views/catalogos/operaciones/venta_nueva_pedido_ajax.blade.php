<div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>PEDIDOS DISPONIBLES</strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmVentaPed1">
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
                <label for = "pedido_id" class="col-md-2 col-form-label text-md-left">Pedido</label>
                <div class="col-md-9">
                    {{ Form::select('pedido_id', $Pedidos, null, ['id' => 'pedido_id','class'=>'form-control']) }}
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="form-group row">
                <label for = "cantidad" class="col-md-2 col-form-label text-md-left">Cant.</label>
                <div class="col-md-4">
{{--                    <input type="number" min="1" max="1000" value="1" required name="cantidad" id="cantidad"/>--}}
                    <input type="text" pattern="[0-9]{1,8}([.][0-9]{0,2})?" name="cantidad" id="cantidad" class="form-control" required/>
                </div>
                <label for = "tipoventa" class="col-md-2 col-form-label text-md-left">Tipo</label>
                <div class="col-md-4">
                    <select id="tipoventa" name="tipoventa" size="1">
                        <option value="0" selected>Contado</option>
                        <option value="1">Credito</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnForm1">
                        Seleccionar
                    </button>
                </div>
            </div>
            {{--<input type="hidden" name="pedido_id" id="pedido_id" value="{{$pedido_id}}" />--}}
        </form>
    </div>
</div>
<script >

    var Url = "{{$Url}}";

    if ( $("#frmVentaPed1") ) {
        $("#frmVentaPed1").on("submit", function (event) {
            event.preventDefault();

            var frmSerialize = $("#frmVentaPed1").serialize();

            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('Pedido agregado con éxito');
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
