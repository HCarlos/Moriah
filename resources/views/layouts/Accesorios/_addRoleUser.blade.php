<x-modals.blurred>
    @slot('TituloModal', $TituloModal ?? 'Selecciona un rol')
    @slot('RouteModal', $RouteModal ?? '#')
    @slot('Method',$Method ?? 'GET')
    @slot('IsNew',$IsNew ?? false)
    @slot('IsUpload',$IsUpload ?? false)
    @slot('CuerpoModal')
        @include('share.Catalogos.User.Modal.__addRole_modal_users')
    @endslot
</x-modals.blurred>
