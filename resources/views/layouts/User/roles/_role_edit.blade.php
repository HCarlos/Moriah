<x-card-form-normal>
    @slot('titulo', $titulo)
    @slot('User',$User ?? null)
    @slot('Route',$Route ?? '')
    @slot('Method',$Method ?? '')
    @slot('IsNew',$IsNew ?? false)
    @slot('IsUpload',$IsUpload ?? false)
    @slot('ReadOnly',$ReadOnly ?? false)
    @slot('items_forms')
        @if($IsNew)
            @include('share.Catalogos.User.Roles.__role_new')
        @else
            @include('share.Catalogos.User.Roles.__role_edit')
        @endif
    @endslot
</x-card-form-normal>
