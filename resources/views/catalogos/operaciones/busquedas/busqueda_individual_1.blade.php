@component('components.panel')
@slot('titulo','Busqueda individual')
@slot('barra_menu')
@endslot
@slot('contenido')
    <div class="dataTables_wrapper" role="grid">
        <form method="post" action="{{ action('SIIFAC\VentaController@busquedaIndividual') }}" accept-charset="UTF-8" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="dato" class="col-md-2 control-label">{{$tipo}}</label>
                <div class="col-md-8">
                    <input type="text" name="dato" id="dato" placeholder="{{$placeholder}}" class="form-control" autofocus/>
                </div>
                <button type="submit" class="btn btn-mini btn-primary">
                    <i class="fa fa-search"></i>
                    Buscar
                </button>
            </div>
            <input type="hidden" name="type" id="type" value="{{$type}}" />
        </form>
    </div>
@endslot
@endcomponent
