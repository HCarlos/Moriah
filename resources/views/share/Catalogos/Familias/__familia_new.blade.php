
    <div class="form-group row">
        <x-inputs.text-field cols="3" tipo="text" nombre="familia" valor="{{old('familia')}}"></x-inputs.text-field>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="12" tipo="text" nombre="emails" valor="{{old('emails')}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-secondary brc-secondary text-white badge-lg mb-1 w-95">Otros Datos</span>
    </p>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="id familia" valor="{{old('user_id_anterior')}}" deshabilitado ></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="creado por id" valor="{{old('creado_por_id')}}" deshabilitado></x-inputs.text-field>
    </div>

    <input type="hidden" name="id" id="id" value="0">
