<x-catalogo-list>
    @slot('tituloTabla',$tituloTabla)
    @slot('items',$items)
    @slot('user',$user)
    @slot('newItem',$newItem ?? null)
    @slot('searchButton', $searchButton ?? '')
    @slot('excelButton', $excelButton ?? '')
    @slot('editItem',$editItem)
    @slot('removeItem',$removeItem)
    @slot('listItems',$listItems ?? '')
    @slot('Tabla')
        @include('share.Catalogos.User.__users_list')
    @endslot
</x-catalogo-list>
