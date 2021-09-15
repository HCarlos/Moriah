@if( ! is_null($newItem))

<a href="{{ route($newItem) }}" class="btn pt-1 btn-secondary radius-round pl-1 shadow-sm mb-1 border-1 border-white">
    <i class="w-3 h-3 bgc-white text-danger-m1 radius-round fa fa-plus-square mr-1 align-middle pt-15 text-85"></i>
    <span class="align-middle pl-1 pr-2">
        Agregar
    </span>
</a>
@endif
