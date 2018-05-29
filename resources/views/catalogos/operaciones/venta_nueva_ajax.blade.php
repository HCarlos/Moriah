<div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>PAQUETES DISPONIBLES</strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmVentaPaq1">
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
                <label for = "paquete_id" class="col-md-2 col-form-label text-md-left">Paquete</label>
                <div class="col-md-9">
                    {{ Form::select('paquete_id', $Paquetes, null, ['id' => 'paquete_id','class'=>'form-control']) }}
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="form-group row">
                <label for = "user_id" class="col-md-2 col-form-label text-md-left">Cliente</label>
                <div class="col-md-9">
                    {{ Form::select('user_id', $User_Id, null, ['id' => 'user_id','class'=>'form-control']) }}
                </div>
                <div class="col-md-1"></div>
            </div>
            <div class="form-group row">
                <label for = "cantidad" class="col-md-2 col-form-label text-md-left">Cant.</label>
                <div class="col-md-4">
                    <input type="number" min="1" max="1000" value="1" required name="cantidad" id="cantidad"/>
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
                <div class="col-md-2"></div>
                <div class="col-md-2">
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnForm1">
                        Seleccionar
                    </button>
                </div>
            </div>
            {{--<input type="hidden" name="paquete_id" id="paquete_id" value="{{$paquete_id}}" />--}}
        </form>
    </div>
</div>
<script >

    var Url = "{{$Url}}";

    if ( $("#frmVentaPaq1") ) {
        $("#frmVentaPaq1").on("submit", function (event) {
            event.preventDefault();

            var frmSerialize = $("#frmVentaPaq1").serialize();

            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('Paquete agregado con éxito');
                        $("#myModal").modal( 'hide' );
                    }else{
                        alert(data.mensaje);
                    }
                }
            });
        });
    }

</script>
