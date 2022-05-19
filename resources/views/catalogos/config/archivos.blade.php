@extends('layouts.app')

@section('main-content')

    @component
    @slot('titulo','Archivos de configuración')
    @slot('barra_menu')
    @endslot
    @slot('contenido')
        <div class="dataTables_wrapper" role="grid">
            <div class="panel panel-default">
                <div class="panel-heading">Archivo Base (base.xlsx)</div>
                <div class="panel-body">
                    <p class="text-danger">Listado de archivos base:</p>
                    <ul>
                        @foreach($archivos as $archivo)
                            <li>
                                <a href="{{ asset('storage/externo/'.$archivo)  }}" target="_blank">{{$archivo}}</a>
                                <a href="{{ route('quitarArchivoBase/', array('driver' => 'externo','archivo'=>$archivo)) }}" title="Eliminar archivo">
                                    <i class="fa fa-trash red"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <form method="post" action="{{ action('Storage\StorageExternosController@subirArchivoBase') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="base_file" class="col-md-2 control-label">Nuevo Archivo</label>
                            <div class="col-md-8">
                                <input type="file" name="base_file" class="form-control {{ $errors->has('base_file') ? ' is-invalid' : '' }} altMoz" style="padding-top: 0px;" >
                                @if ($errors->has('base_file'))
                                    <span class="invalid-feedback red">
                                            <strong>{{ $errors->first('base_file') }}</strong>
                                        </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-mini btn-primary">
                                Subir
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    @endslot
    @endcomponent
@endsection

@include('catalogos.scripts.dataTable')
