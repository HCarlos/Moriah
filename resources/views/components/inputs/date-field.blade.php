@php $Nombre = str_replace(' ','_',strtolower($nombre)) @endphp
<div class="col-sm-{{$cols}}">
    <label class="col-form-label" for="{{ $Nombre }}">{{ ucwords($nombre) }}</label>
    <input type="date" class="form-control {{ $Nombre }} {{$class ? $class : ''}} " placeholder="{{ ucwords($nombre) }}" name="{{ $Nombre }}" id="{{ $Nombre }}" value="{{$valor}}" {{$deshabilitado}} min="1900-01-01" max="{{ now() }}">
    @include('share.bars.___help_input')
</div>
