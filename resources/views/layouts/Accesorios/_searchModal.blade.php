<x-modals.blurred>
    @slot('TituloModal', $TituloModal ?? 'Sin Título')
    @slot('RouteModal', $RouteModal ?? '#')
    @slot('Method',$Method ?? 'GET')
    @slot('IsNew',$IsNew ?? false)
    @slot('IsUpload',$IsUpload ?? false)
    @slot('CuerpoModal')
        @include('share.Catalogos.User.Modal.__search_modal_users')
    @endslot
</x-modals.blurred>
