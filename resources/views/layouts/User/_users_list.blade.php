<x-catalogo-list>
    @slot('tituloTabla',$tituloTabla)
    @slot('items',$items)
    @slot('user',$user)
    @slot('editItem',$editItem ?? null)
    @slot('removeItem',$removeItem ?? null)
    @slot('Tabla')
        @include('share.Catalogos.User.__users_list')
    @endslot
</x-catalogo-list>
