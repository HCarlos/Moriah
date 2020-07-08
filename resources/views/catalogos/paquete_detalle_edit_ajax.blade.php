    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Editando registro {{$paquete_id}}</span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frm1Edit">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

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
                    {{ Form::select('producto_id', $Productos, $items->producto_id, ['id' => 'producto_id','class'=>'form-control']) }}
                </div>
                <div class="col-md-1"></div>
            </div>

            <div class="form-group row">
                <label for = "cant" class="col-md-2 col-form-label text-md-left">Cantidad</label>
                <div class="col-md-2">
                    <input type="number" name="cant" id="cant" value="{{old('cant',$items->cant ?? 1 )}}" min="1" max="99" step="1" class="form-control" />
                </div>
                <div class="col-md-7"></div>
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
            <input type="hidden" name="producto_id_old" id="producto_id_old" value="{{$items->producto_id}}" />
            <input type="hidden" name="paquete_id" id="paquete_id" value="{{$items->paquete_id}}" />
            <input type="hidden" name="paquete_detalle_id" id="paquete_detalle_id" value="{{$items->id}}" />
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
                type: 'put',
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
