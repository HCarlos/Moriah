@extends('layouts.app')

@section('main-content')

    @panel
    @slot('titulo','Archivos de configuración')
    @slot('barra_menu')

        {{--<a href="{{ route('usuarioNew', array('idItem' => 0)) }}" class="btn btn-info btn-xs" target="_blank" title="Agregar nuevo registro">--}}
            {{--<i class="fa fa-plus-circle bigger-150"></i>--}}
        {{--</a>--}}
        {{--<a href="#" class="btn btn-info btn-xs " title="Actualizar" id="btnRefreshNavigator">--}}
            {{--<i class="ace-icon fa fa-refresh bigger-150"></i>--}}
        {{--</a>--}}

    @endslot
    @slot('contenido')
        <div class="dataTables_wrapper" role="grid">

            <div class="panel panel-default">
                <div class="panel-heading">Listado de archivos en el sistema</div>
                <div class="panel-body">
                    <ul>
                    @foreach($archivos as $archivo)
                        <li><a href="{{ asset('storage/externo/'.$archivo)  }}" target="_blank">{{$archivo}}</a></li>
                    @endforeach
                    </ul>
                </div>
            </div>


            <div class="panel panel-default">
                <div class="panel-heading">Archivo Base (base.xlsx)</div>
                <div class="panel-body">
                    <form method="post" action="{{ action('Storage\StorageExternosController@subirArchivoBase') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="base_file" class="col-md-4 control-label">Nuevo Archivo</label>
                            <div class="col-md-6">
                                <input type="file" name="base_file" class="form-control {{ $errors->has('base_file') ? ' is-invalid' : '' }} altMoz" style="padding-top: 0px;" >
                                @if ($errors->has('base_file'))
                                    <span class="invalid-feedback red">
                                            <strong>{{ $errors->first('base_file') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Subir
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    @endslot
@endpanel
@endsection

@include('catalogos.scripts.dataTable')
