@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="center-block">
                <h2 class="text-center">Se ha cerrado la sesión.</h2>
                <img src="{{asset('assets/img/timeout.jpg')}}" />
            </div>
        </div>
    </div>
@endsection
