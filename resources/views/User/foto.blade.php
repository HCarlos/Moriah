<x-card-basic >
    @slot('titulo', $titulo)
    @slot('User',$User ?? null)
    @slot('Route',$Route ?? '')
    @slot('Method',$Method ?? '')
    @slot('IsNew',$IsNew ?? false)
    @slot('IsUpload',$IsUpload ?? false)
    @slot('ReadOnly',$ReadOnly ?? false)
    @slot('items_forms')
        @include('layouts.User.__foto')
    @endslot
</x-card-basic>
