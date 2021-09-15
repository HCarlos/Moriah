<x-catalogo-list>
    @slot('tituloTabla',$tituloTabla)
    @slot('items',$items)
    @slot('user',$user)
    @slot('editItem',$editItem ?? null)
    @slot('removeItem',$removeItem ?? null)
    @slot('Tabla')
        @include('share.Catalogos.Profesores.__profesores_list')
    @endslot
</x-catalogo-list>
