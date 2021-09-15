@extends('home')

@section('contenedor')
    <div class="card">

        <div class="card-header">
            <h3 class=" text-120 text-left"> {{ $titulo }} </h3>
        </div>


        <div class="card-body">
            <div class="row" id="row-1">
                <div class="col-12 col-xl-10 offset-xl-1 bgc-white shadow radius-1 overflow-hidden">
                    <div class="row" id="row-2" >
                        <div class="col-lg-4 d-none d-lg-flex border-r-1 brc-default-l3 px-0 " >
                            <div class="carousel-item active minw-100 h-100">
                            <div style="background-image: url(assets/image/login-bg-1.svg);" class="px-3 bgc-blue-l4 d-flex flex-column align-items-center ">
                                <div class="d-flex flex-column py-45 px-lg-6 align-items-center mx-auto">
                                    <div class="pos-rel ">
                                        @if( Auth::user()->IsEmptyPhoto() )
                                            @if( Auth::user()->IsFemale() )
                                                <img alt="Profile image" src="{{ asset('assets/image/avatar/avatar1.png')  }}" class="radius-round bord1er-2 brc-warning-m1">
                                            @else
                                                <img alt="Profile image" src="{{ asset('assets/image/avatar/avatar.png')  }}" class="radius-round bord1er-2 brc-warning-m1">
                                            @endif
                                        @else
                                            <img alt="Profile image" src="{{ asset(env('PROFILE_ROOT').'/'. Auth::user()->filename_png)  }}?timestamp={{now()}}" class="radius-round bord1er-2 brc-warning-m1">
                                        @endif
                                        <span class=" position-tr bgc-success p-1 radius-round border-2 brc-white mt-2px mr-2px"></span>
                                    </div>
                                    <div class="text-center mt-0">
                                        <h5 class="text-130 text-dark-m3">
                                            {{$User->FullName}}
                                        </h5>
                                        <span class="text-70 text-primary text-600">
                                            {{$User->Role()->name}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div id="id-col-main" class="col-12 col-lg-8 bgc-white px-0">
                            <div class="col-md-12">
                                @include('share.otros.___erros-forms')
                                <form method="{{$Method}}" action="{{ route($Route) }}"  accept-charset="UTF-8" @if($IsUpload) enctype="multipart/form-data" @endif class="m-0" >
                                    @csrf
                                    @if( !$IsNew )
                                        {{ method_field('PUT') }}
                                    @endif
                                    {{ $items_forms }}
                                    @include('share.bars.___foot-bar-1')

                                </form>
                            </div>


                        </div>

                    </div>
                </div>
            </div>





        </div>
    </div>
@endsection
