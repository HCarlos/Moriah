@extends('layouts.app')

@section('contenedor')

    <div class="card bcard">
        <div class="card-header bgc-primary-d1 text-white border-0">
            <h4 class="text-120">
                <h3>{{$titulo}}</h3>
            </h4>
        </div>

        <div class="card-body p-0 border-x-1 border-b-1 brc-default-m4 radius-0 overflow-hidden p-2">

            @include('share.otros.___erros-forms')
            <form method="{{$Method}}" action="{{ route($Route) }}"  accept-charset="UTF-8" @if($IsUpload) enctype="multipart/form-data" @endif >
                @csrf
                @if( !$IsNew )
                    {{ method_field('PUT') }}
                @endif
                {{ $items_forms }}
                @include('share.bars.___foot-bar-1')
            </form>

        </div>



    </div>
@endsection
