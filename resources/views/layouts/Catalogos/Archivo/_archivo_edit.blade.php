<x-card-form-normal>
    @slot('titulo', $titulo)
    @slot('User',$User ?? null)
    @slot('Route',$Route ?? '')
    @slot('Method',$Method ?? '')
    @slot('IsNew',$IsNew ?? false)
    @slot('IsUpload',$IsUpload ?? false)
    @slot('ReadOnly',$ReadOnly ?? false)
    @slot('archivos',$archivos ?? false)
    @slot('items_forms')
        @include('share.Catalogos.Archivos.__archivo_new')
    @endslot
</x-card-form-normal>
