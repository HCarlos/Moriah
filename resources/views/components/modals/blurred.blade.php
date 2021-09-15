<!-- Blurred background/backdrop -->
{{--<form action="{{ route($RouteModal) }}" method="GET"  accept-charset="UTF-8" >--}}
{{--    @csrf--}}
@include('share.otros.___erros-forms')
<form method="{{$Method}}" action="{{ route($RouteModal) }}"  accept-charset="UTF-8" @if($IsUpload) enctype="multipart/form-data" @endif >
    @csrf
    @if( !$IsNew )
        {{ method_field('PUT') }}
    @endif

    <div class="modal-header bgc-orange-tp1 shadow-md">
        <h5 class="modal-title text-white-tp1 " >
            {{$TituloModal}}
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body modal-scroll bgc-orange-l3 shadow-md">
        {{$CuerpoModal}}
    </div>

    <div class="modal-footer bgc-dark-m1">
        <button type="submit" class="btn btn-green">
            <i class="fas fa-search"></i>
            Aceptar
        </button>
    </div>

</form>
