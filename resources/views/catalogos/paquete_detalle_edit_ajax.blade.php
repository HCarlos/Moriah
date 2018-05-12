    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Editando registro {{$paquete_id}}
            <a class="btn btn-info btn-minier pull-right" href="#" onclick="window.close();">
                   Cerrar
            </a>
        </span>
    </div>|

    <div class="panel-body">
        {{--<form method="post" action="{{ action('SIIFAC\PaqueteDetalleController@update',['pd'=>$items]) }}"  id="frm1Edit">--}}
        <form method="post"  id="frm1Edit">
            {{ csrf_field() }}
            {{--{{ method_field('PUT') }}--}}

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
                <label for = "producto_id" class="col-md-1 col-form-label text-md-left">Producto</label>
                <div class="col-md-2">
                    {{ Form::select('producto_id', $Productos, $items->producto_id, ['id' => 'producto_id']) }}
                </div>
                <div class="col-md-9"></div>
            </div>

            <div>
                <label class="col-md-2 col-form-label text-md-right"></label>
                <div class="col-md-8" >
                    <button type="submit" class="btn btn-primary" id="btnForm1">
                        Guardar
                    </button>
                </div>
                <a class="btn btn-info float-md-right " href="#" data-dismiss="modal">
                    Cerrar
                </a>
            </div>

            <input type="hidden" name="producto_id_old" id="producto_id_old" value="{{$items->producto_id}}" />
            <input type="hidden" name="paquete_id" id="paquete_id" value="{{$items->paquete_id}}" />
            <input type="hidden" name="paquete_detalle_id" id="paquete_detalle_id" value="{{$items->id}}" />

        </form>
    </div>
</div>
<script >

    // $('#btnForm1').on("click", function(event) {
    //     event.preventDefault();
    //     $('#myModal').modal( 'hide' );
    // });

    if ( $("#frm1Edit") ) {
        $("#frm1Edit").on("submit", function (event) {
            event.preventDefault();

            var data = {
                        "producto_id"        : $("#producto_id").val(),
                        "producto_id_old"   : $("#producto_id_old").val(),
                        "paquete_id"        : $("#paquete_id").val(),
                        "paquete_detalle_id": $("#paquete_detalle_id").val()
                        };
            $.ajax({
                cache: false,
                type: 'get',
                url: '/update_paquete_detalle_ajax/',
                data:  data,
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
