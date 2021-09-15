@if( ! is_null($searchButton))
<a href="{{ route($searchButton) }}" class="btn pt-1 btn-h-secondary radius-round pl-1 shadow-sm mb-1 border-1 border-white btnFullModal"  data-toggle="modal" data-target="#modalFull">
    <i class="w-3 h-3 bgc-white text-danger-m1 radius-round fa fa-search mr-1 align-middle pt-15 text-85"></i>
    <span class="align-middle pl-1 pr-2">
        Buscar
    </span>
</a>
@endif
