<div class="form-group row">
    <x-inputs.text-field cols="3" tipo="text" nombre="name" nombrees="rol" valor="{{old('role')}}"></x-inputs.text-field>
    <x-inputs.text-field cols="5" tipo="text" nombre="descripcion"  nombrees="descripción" valor="{{old('descripcion')}}"></x-inputs.text-field>
    <x-inputs.text-field cols="2" tipo="text" nombre="color" valor="{{old('color')}}"></x-inputs.text-field>
    <x-inputs.text-field cols="2" tipo="text" nombre="abreviatura" valor="{{old('abreviatura')}}"></x-inputs.text-field>
</div>

<input type="hidden" name="id" id="id" value="0">
