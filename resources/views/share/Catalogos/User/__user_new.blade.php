    <div class="form-group row">
        <x-inputs.select-form cols="4" nombre="list username" nombrees="Roles" :arr="$Roles"></x-inputs.select-form>
        <x-inputs.text-field cols="8" tipo="text" nombre="email" valor="{{old('email')}}" ></x-inputs.text-field>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="3" tipo="text" nombre="ap paterno" valor="{{old('ap_paterno')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="3" tipo="text" nombre="ap materno" valor="{{old('ap_materno')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="nombre" valor="{{old('nombre')}}"></x-inputs.text-field>
        <x-inputs.date-field cols="2" nombre="fecha nacimiento" valor="{{old('fecha_nacimiento')}}"></x-inputs.date-field>
        <x-inputs.select-form cols="2" nombre="genero" :arr="['1'=>'Hombre', '0'=>'Mujer', '2'=>'Otro']" valor="-1" ></x-inputs.select-form>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="curp" valor="{{old('curp')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="celulares" valor="{{old('celulares')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="telefonos" valor="{{old('telefonos')}}"></x-inputs.text-field>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="12" tipo="text" nombre="emails" valor="{{old('emails')}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-primary brc-primary text-white badge-lg mb-1 w-95">Domicilio</span>
    </p>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="calle" valor="{{old('calle')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="num ext" valor="{{old('num_ext')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="num int" valor="{{old('num_int')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="colonia" valor="{{old('colonia')}}"></x-inputs.text-field>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="localidad" valor="{{old('localidad')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="municipio" valor="{{old('municipio')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="estado" valor="{{old('estado')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="pais" valor="{{old('pais')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="cp" valor="{{old('cp')}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-warning brc-warning text-white badge-lg mb-1 w-95">Ocupación</span>
    </p>

    <div class="form-group row">
        <x-inputs.text-field cols="3" tipo="text" nombre="lugar nacimiento" valor="{{old('lugar_nacimiento')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="3" tipo="text" nombre="ocupacion" valor="{{old('ocupacion')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="3" tipo="text" nombre="profesion" valor="{{old('profesion')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="3" tipo="text" nombre="lugar trabajo" valor="{{old('lugar_trabajo')}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-purple brc-purple text-white badge-lg mb-1 w-95">Redes Sociales</span>
    </p>
    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="red social" valor="{{old('red_social')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="username red social" valor="{{old('username_red_social')}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="alias red social" valor="{{old('alias_red_social')}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-secondary brc-secondary text-white badge-lg mb-1 w-95">Otros Datos</span>
    </p>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="user id anterior" valor="{{old('user_id_anterior')}}" deshabilitado ></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="creado por id" valor="{{old('creado_por_id')}}" deshabilitado></x-inputs.text-field>
    </div>

    <input type="hidden" name="id" id="id" value="0">
    <input type="hidden" name="username" id="username" value="{{ old('username') }}">
