<x-catalogo-list>
    @slot('tituloTabla',$tituloTabla)
    @slot('items',$items)
    @slot('user',$user)
    @slot('newItem',$newItem ?? null)
    @slot('searchButton', $searchButton ?? null)
    @slot('excelButton', $excelButton ?? null)
    @slot('editItem',$editItem)
    @slot('removeItem',$removeItem)
    @slot('listItems',$listItems ?? null)
    @slot('Tabla')
        @include('share.Catalogos.User.Roles.__roles_list')
    @endslot
</x-catalogo-list>
