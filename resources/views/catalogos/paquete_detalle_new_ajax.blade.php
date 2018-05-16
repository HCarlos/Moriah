    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Nuevo registro {{$paquete_id}}</span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frm1Edit">
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
                <label for = "producto_id" class="col-md-2 col-form-label text-md-left">Producto</label>
                <div class="col-md-9">
                    {{ Form::select('producto_id', $Productos, null, ['id' => 'producto_id','class'=>'form-control']) }}
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnForm1">
                        Guardar
                    </button>
                </div>
                <div class="col-md-5"></div>
                <div class="col-md-2">
                    <button class="btn btn-info pull-right " data-dismiss="modal">
                        Cerrar
                    </button>
                </div>
            </div>
            <input type="hidden" name="paquete_id" id="paquete_id" value="{{$paquete_id}}" />
        </form>
    </div>
</div>
<script >
    var Url = "{{$Url}}";
    if ( $("#frm1Edit") ) {
        $("#frm1Edit").on("submit", function (event) {
            event.preventDefault();
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  $("#frm1Edit").serialize(),
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('Cambio realizado con éxito');
                        $("#myModal").modal( 'hide' );
                    }else{
                        alert(data.mensaje);
                    }
                }
            });
        });
    }
</script>
