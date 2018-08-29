@panel
@slot('titulo','Busqueda individual')
@slot('barra_menu')
@endslot
@slot('contenido')
    <div class="dataTables_wrapper" role="grid">
        <form method="post" action="{{ action('SIIFAC\VentaController@ventas_rango_fechas') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="fecha1" class="col-md-1 control-label has-warning">Desde:</label>
                <div class="col-md-2 ">
                    {{ Form::date('fecha1', old("fecha1", \Carbon\Carbon::now() ), ['id'=>'fecha1','class'=> $errors->has("fecha1") ? "form-control has-error form-error" : 'col-md-2 form-control']) }}
                    @if ($errors->has('fecha1'))
                        <span class="text-danger">{{ $errors->first('fecha1') }}</span>
                    @endif
                </div>
                <label for="fecha2" class="col-md-1 control-label ">Hasta:</label>
                <div class="col-md-2 {{$errors->has("fecha2") ? "has-error form-error" : ""}}">
                    {{ Form::date('fecha2', old("fecha2", \Carbon\Carbon::now() ), ['id'=>'fecha2','class'=> $errors->has("fecha2") ? "form-control form-error" :'col-md-2 form-control']) }}
                    @if ($errors->has('fecha2'))
                        <span class="text-danger">{{ $errors->first('fecha2') }}</span>
                    @endif
                </div>
            </div>
            <hr>
            <div class="form-group row">
                <button type="submit" class="btn btn-mini btn-primary pull-right marginRight2em">
                    <i class="fa fa-search"></i>
                    Buscar
                </button>
            </div>

        </form>
    </div>
@endslot
@endpanel
