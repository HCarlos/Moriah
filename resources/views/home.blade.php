@extends('layouts.app')

@section('contenedor')

    <div class="card">
        <div class="card-header">Bienvenid{{ Auth::user()->IsFemale() ? 'a' : 'o'  }}! </div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            {{ __('Haz ingresado correctamente al sistema!') }}
        </div>
    </div>

@endsection
