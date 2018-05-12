    <div class="panel panel-moriah" id="frmEdit0">
    <div class="panel-heading">
        <span><strong>{{ ucwords($titulo) }}</strong> | Editando registro {{$paquete_id}}
            <a class="btn btn-info btn-minier pull-right" href="#" onclick="window.close();">
                   Cerrar
            </a>
        </span>
    </div>|

    <div class="panel-body">
        <form id="frm1Edit">
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

            <input type="hidden" name="paquete_id" value="{{$paquete_id}}" />

        </form>
    </div>
</div>
<script >

    if ( $("#frm1Edit") ) {
        $("#frm1Edit").on("submit", function (event) {
            event.preventDefault();
            alert("fff");
            var queryString = $(this).serialize();
            alert(queryString);
            var data = new FormData();
            data.append('pd', {{$items}} );
            data.append('request', queryString);

            $(function () {
                $.ajax({
                    url:"/update_paquete_detalle_ajax/",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    sync:false,
                    type: 'PUT'
                })
                .done(function (response) {
                    alert(response);
                })
                .success(function (response) {
                    alert(response);
                });
            });

        });
    }

</script>
