@extends('layouts.app')

@section('content')
    <div class="flex-center position-ref">
        <div class="col-md-6">
            <img src="{{asset('assets/img/biblioteca_virtual_logo_2.png')}}" width="400" height="100" /><br/>
            <div class="content ancho-busqueda-Lati text-left">
            @if( count($items) <= 0)
                <div class="alert alert-danger" role="alert">Resultado de la busqueda: <i><b>{{$tsString}}</b></i> : <strong>{{count($items)}}</strong> elementos.</div>
            @else
                <p>Resultado de la busqueda: <i><b>{{$stringBusqueda}}</b></i> : <strong>{{$paginator->total()}}</strong> elementos.</p>
            @endif
            </div>
            @include('catalogos.listados.paginate_list')
            @foreach($items as $lib)
                <div class="card">
                    <div class="card-header text-left"><b class="seagreen">{{$lib->id}}</b> <strong>{{$lib->titulo}}</strong></div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <td class="col-md-1 text-left bg-info text-white bolder-lati border border-info">AUTOR</td>
                                <td class="col-md-11 text-left border border-info">{{$lib->autor}}</td>
                                @if($lib->apartado)
                                    <td rowspan="7" class="bg-coral-lati-bib">APARTADO</td>
                                @elseif($lib->prestado)
                                    <td rowspan="7" class="bg-seagreen-lati-bib">PRESTADO</td>
                                @else
                                    <td rowspan="7" class="bg-ghostwhite-lati-bib">DISPONIBLE</td>
                                @endif
                            </tr>
                            <tr>
                                <td class="col-md-1 text-left bg-info text-white bolder-lati border border-info">ISBN</td>
                                <td class="col-md-11 text-left border-bottom border-right border-info">{{$lib->isbn}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-1 text-left bg-info text-white bolder-lati border border-info">TIPO</td>
                                <td class="col-md-11 text-left border-bottom border-right border-info">{{$lib->tipo_material}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-1 text-left bg-info text-white bolder-lati border border-info">CLASIFICACIÓN</td>
                                <td class="col-md-11 text-left border-bottom border-right border-info">{{$lib->clasificacion}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-1 text-left bg-info text-white bolder-lati border border-info">EXISTENCIA</td>
                                <td class="col-md-11 text-left border-bottom border-right border-info">{{$lib->existencia}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-1 text-left bg-info text-white bolder-lati border border-info">EDITORIAL</td>
                                <td class="col-md-11 text-left border-bottom border-right border-info">{{strtoupper($lib->editorial->editorial)}}</td>
                            </tr>
                            <tr>
                                <td class="col-md-1 text-left bg-info text-white bolder-lati border border-info"></td>
                                <td class="col-md-11 text-left border-bottom border-right border-info">
                                    @if(!$lib->prestado && !$lib->apartado)
                                        <a class="btn btn-link bolder-lati coral apartame" href="#" id="ficha-{{$lib->id.'-'.$user->id}}" >Apartar este material</a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer row-fluid">
                        @foreach($lib->imagenes as $item)
                            <a href="{{ asset('storage/'.$item->root.$item->filename)  }}" target="_blank" class="img-thumbnail pull-left">
                                <img src="{{ asset('storage/'.$item->root.$item->filename)  }}" width="100" height="80" title="{{$lib->titulo}}" class="img-responsive"/>
                            </a>
                        @endforeach
                    </div>
                </div>
                <span class="separator-lati-2em"></span>

            @endforeach
            @include('catalogos.listados.paginate_list')
        </div>
    </div>
@endsection
