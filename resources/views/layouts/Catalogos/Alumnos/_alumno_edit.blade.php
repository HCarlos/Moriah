<x-card-form-normal>
    @slot('titulo', $titulo)
    @slot('User',$User ?? null)
    @slot('Route',$Route ?? '')
    @slot('Method',$Method ?? '')
    @slot('IsNew',$IsNew ?? false)
    @slot('IsUpload',$IsUpload ?? false)
    @slot('items_forms')
        @include('layouts.User.__profile')
    @endslot
</x-card-form-normal>
