<div class="form-group row mt-0 mb-0">
   <x-inputs.text-field cols="4" cols1="8" tipo="text" nombre="nombre completo" class="bgc-success pl-1 pr-1 pt-1 text-right text-white font-bold text-80 border-0 " class1="bgc-orange text-80 font-bold text-white p-0 m-0 border-0 w-100 " valor="{{old('nombre completo',$item->FullName)}}" sololectura ></x-inputs.text-field>
</div>

<div class="form-group row mt-0 mb-0">
    <x-inputs.text-field cols="4" cols1="8" tipo="text" nombre="curp" class="bgc-success pl-1 pr-1 pt-1 text-right text-white font-bold text-80 border-0 " class1="bgc-orange text-80 font-bold text-white p-0 m-0 border-0 w-100 " valor="{{old('curp',$item->curp)}}" sololectura ></x-inputs.text-field>
</div>
<div class="form-group row mt-0 mb-0">
    <x-inputs.text-field cols="4" cols1="8" tipo="text" nombre="celulares" class="bgc-success pl-1 pr-1 pt-1 text-right text-white font-bold text-80 border-0 " class1="bgc-orange text-80 font-bold text-white p-0 m-0 border-0 w-100 " valor="{{old('celulares',$item->celulares)}}" sololectura ></x-inputs.text-field>
</div>
<div class="form-group row mt-0 mb-0">
    <x-inputs.text-field cols="4" cols1="8" tipo="text" nombre="telefonos" class="bgc-success pl-1 pr-1 pt-1 text-right text-white font-bold text-80 border-0 " class1="bgc-orange text-80 font-bold text-white p-0 m-0 border-0 w-100 " valor="{{old('telefonos',$item->telefonos)}}" sololectura ></x-inputs.text-field>
</div>
<div class="form-group row mt-0 mb-0">
    <x-inputs.text-field cols="4" cols1="8" tipo="text" nombre="emails" class="bgc-success pl-1 pr-1 pt-1 text-right text-white font-bold text-80 border-0 " class1="bgc-orange text-80 font-bold text-white p-0 m-0 border-0 w-100 " valor="{{old('emails',$item->emails)}}" sololectura ></x-inputs.text-field>
</div>
<div class="form-group row mt-0 mb-0">
    <x-inputs.text-field cols="4" cols1="8" tipo="text" nombre="domicilio" class="bgc-success pl-1 pr-1 pt-1 text-right text-white font-bold text-80 border-0 " class1="bgc-orange text-80 font-bold text-white p-0 m-0 border-0 w-100 " valor="{{$item->user_adress->calle.' '.$item->user_adress->num_ext.' '.$item->user_adress->num_int.' '.$item->user_adress->colonia.' '.$item->user_adress->localidad.' '.$item->user_adress->municipio.' '.$item->user_adress->estado.' '.$item->user_adress->pais.' '.$item->user_adress->cp}}" sololectura ></x-inputs.text-field>
</div>
<div class="form-group row mt-0 mb-0">
    <x-inputs.text-field cols="4" cols1="8" tipo="text" nombre="ocupacion" class="bgc-success pl-1 pr-1 pt-1 text-right text-white font-bold text-80 border-0 " class1="bgc-orange text-80 font-bold text-white p-0 m-0 border-0 w-100 " valor="{{$item->user_data_extend->lugar_nacimiento.' '.$item->user_data_extend->ocupacion.' '.$item->user_data_extend->profesion.' '.$item->user_data_extend->lugar_trabajo}}" sololectura ></x-inputs.text-field>
</div>
<div class="form-group row mt-0 mb-0">
    <x-inputs.text-field cols="4" cols1="8" tipo="text" nombre="redes sociales" class="bgc-success pl-1 pr-1 pt-1 text-right text-white font-bold text-80 border-0 " class1="bgc-orange text-80 font-bold text-white p-0 m-0 border-0 w-100 " valor="{{$item->user_data_social->red_social.' '.$item->user_data_social->username_red_social.' '.$item->user_data_social->alias_red_social}}" sololectura ></x-inputs.text-field>
</div>
<input type="hidden" name="id" id="id" value="{{$item->id}}">
<input type="hidden" name="username" id="username" value="{{$item->username}}">
<input type="hidden" name="email" id="email" value="{{$item->email}}">
