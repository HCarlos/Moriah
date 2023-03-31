<div class="panel panel-moriah" >
    <div class="panel-heading">
        <span><strong>Registros Fiscales (Nuevo) </strong></span>
    </div>

    <div class="panel-body">
        <form method="post"  id="frmRFCNuevo">
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
                <div class="col-md-2">
                    <label for = "rfc" class="col-form-label text-md-left">RFC</label>
                    <input type="text" name="rfc" id="rfc" value="{{ old('rfc') }}" class="form-control" autofocus />
                </div>
                <div class="col-md-5">
                    <label for = "razon_social" class=" col-form-label text-md-left">Razón Social</label>
                    <input type="text" name="razon_social" id="razon_social" value="{{ old('razon_social') }}" class="form-control" />
                </div>
                <div class="col-md-5">
                    <label for = "razon_social_cfdi_40" class=" col-form-label text-md-left">Razón Social CFDI 4.0</label>
                    <input type="text" name="razon_social_cfdi_40" id="razon_social_cfdi_40" value="{{ old('razon_social_cfdi_40') }}" class="form-control" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-8">
                    <label for = "calle" class="col-form-label text-md-left">Calle</label>
                    <input type="text" name="calle" id="calle" value="{{ old('calle') }}" class="form-control" autofocus />
                </div>
                <div class="col-md-2">
                    <label for = "num_ext" class=" col-form-label text-md-left">Num. Ext</label>
                    <input type="text" name="num_ext" id="num_ext" value="{{ old('num_ext') }}" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label for = "num_int" class=" col-form-label text-md-left">Num. Int</label>
                    <input type="text" name="num_int" id="num_int" value="{{ old('num_int') }}" class="form-control" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for = "colonia" class="col-form-label text-md-left">Colonia</label>
                    <input type="text" name="colonia" id="colonia" value="{{ old('colonia') }}" class="form-control" autofocus />
                </div>
                <div class="col-md-6">
                    <label for = "localidad" class=" col-form-label text-md-left">Localidad</label>
                    <input type="text" name="localidad" id="localidad" value="{{ old('localidad') }}" class="form-control" />
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-5">
                    <label for = "municipio" class="col-form-label text-md-left">Municipio</label>
                    <input type="text" name="municipio" id="municipio" value="{{ old('municipio') }}" class="form-control" autofocus />
                </div>
                <div class="col-md-3">
                    <label for = "estado" class=" col-form-label text-md-left">Estado</label>
                    <input type="text" name="estado" id="estado" value="Tabasco" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label for = "pais" class=" col-form-label text-md-left">Pais</label>
                    <input type="text" name="pais" id="pais" value="México" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label for = "cp" class=" col-form-label text-md-left">Cod. Postal</label>
                    <input type="text" name="cp" id="cp" value="{{ old('cp') }}" class="form-control" />
                </div>
            </div>

            <hr>

            <div class="form-group row">
                <div class="col-md-10"></div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary" id="btnVentaDetalleNormalSubmit">
                        Guardar
                    </button>
                </div>
            </div>
            {{--<input type="hidden" name="RFC_id"    id="RFC_id"       value="{{$RFC_id}}" />--}}
            <input type="hidden" name="empresa_id"   id="empresa_id"      value="{{ $empresa_id }}" />
        </form>
    </div>
</div>
<script >

    var Url = "{{$Url}}";
    // alert(Url);

    if ( $("#frmRFCNuevo") ) {

        $("#frmRFCNuevo").on("submit", function (event) {
            event.preventDefault();
            var frmSerialize = $("#frmRFCNuevo").serialize();
            $.ajax({
                cache: false,
                type: 'post',
                url: Url,
                data:  frmSerialize,
                dataType: 'json',
                success: function(data) {
                    if (data.mensaje == "OK"){
                        alert('RFC creado con éxito');
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
