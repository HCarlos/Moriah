@php $Nombre = str_replace(' ','_',strtolower($nombre)) @endphp
<div class="col-sm-{{$cols}}">
    <label class="col-form-label" for="{{ $Nombre }}">{{ ucwords($nombrees) }}</label>
    <select name="{{ $Nombre }}" id="{{ $Nombre }}" class="form-control {{ $Nombre  }} {{$class ? $class : ''}} " size="1" >
        <option value="0" selected>Ninguno</option>
        @foreach($arr as $id=>$value)
            <option value="{{$id}}"  @if($id == $valor) selected @endif>{{$value}} </option>
        @endforeach
    </select>
    @include('share.bars.___help_input')
</div>
