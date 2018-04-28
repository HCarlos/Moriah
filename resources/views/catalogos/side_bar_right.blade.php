@extends('home')

@section('content_catalogo')
<div class="panel panel-primary" id="catalogosList0">
    <div class="panel-heading">

        <span id="titulo_catalogo">Catálogos </span>
        @if ($user->hasAnyPermission(['consultar','all']))
            @switch($id)
                @case(0)
                @case(1)
                @case(2)
                @case(3)
                @case(4)
                @case(5)
                @case(10)
                    <a href="{{ route('catalogos/', array('id' => $id,'idItem' => 0,'action' => 0)) }}" class="btn btn-info btn-xs marginLeft2em" target="_blank" title="Agregar nuevo registro" style="margin-left: 2em;">
                    @break
                @default
                   <a href="{{ route('catalogos/', array('id' => $id,'idItem' => 0,'action' => 0)) }}" class="btn btn-info btn-xs marginLeft2em" title="Agregar nuevo registro" style="margin-left: 2em;">
            @endswitch
                <i class="fa fa-plus-circle "></i> Nuevo registro
            </a>
        @endif
        {{--<form method="get" action="{{ route('listItem',['id'=>$id,'npage'=>$npage,'tpaginas'=>$tpaginas]) }}" class="form-inline pull-right ">--}}
            {{--{{ Form::select('listEle', $listEle, $npage, ['id' => 'listEle','multiple' => 'multiple','class'=>' listEle form-control  panel-fill','onclick'=>'javascript::this.submit()']) }}--}}
        {{--</form>--}}
        <form method="post" action="{{ action('Catalogos\CatalogosListController@indexSearch') }}" class="form-inline pull-right ">
            {{ csrf_field() }}
                <input type="text" class="form-control form-control-xs altoMoz" name="search" placeholder="Buscar en la base de datos..." style="height: 2em !important; line-height: 2em !important;">
            <input type="hidden" name="id" value="{{$id}}"/>
            <button type="submit" class="btn btn-info btn-sm margen-izquierdo-03em "><i class="fas fa-search"></i></button>
        </form>
    </div>

    <div class="panel-body">
        @include('catalogos.listados.paginate_list')
        <div class="fa-2x" id="preloaderLocal">
            <i class="fa fa-cog fa-spin"></i> Cargado datos...
        </div>
        @switch($id)
            @case(0)
                @if($user->hasRole('administrator'))
                    @include('catalogos.listados.empresas_list')
                @endif
                @break;
            @case(1)
                @if($user->hasRole('consultar'))
                    @include('catalogos.listados.almacenes_list')
                @endif
                @break;
            @case(2)
                @if($user->hasRole('consultar'))
                    @include('catalogos.listados.medidas_list')
                @endif
                @break;
            @case(3)
                @if($user->hasRole('consultar'))
                    @include('catalogos.listados.productos_list')
                @endif
                @break;
            @case(4)
            @if($user->hasRole('consultar'))
                @include('catalogos.listados.prestados_list')
            @endif
            @break;
            @case(10)
                @if($user->hasRole('administrator|system_operator'))
                    @include('catalogos.listados.usuarios_list')
                @endif
                @break;
            @case(11)
            @if($user->hasRole('administrator'))
                    @include('catalogos.listados.roles_list')
                @endif
                @break;
            @case(12)
                @if($user->hasRole('administrator'))
                    @include('catalogos.listados.permisos_list')
                @endif
                @break;
        @endswitch
    </div>
</div>
    {{--@include('catalogos.editorial_edit_2')--}}

@endsection
