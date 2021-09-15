    <div class="form-group row">
        <x-inputs.text-field  cols="4" tipo="text" nombre="username" valor="{{old('username',$item->username)}}" sololectura ></x-inputs.text-field>
        <x-inputs.text-field  cols="4" tipo="password" nombre="password" valor="{{old('password',$item->password)}}" sololectura ></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="email" valor="{{old('email',$item->email)}}" sololectura ></x-inputs.text-field>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="3" tipo="text" nombre="ap paterno" valor="{{old('ap_paterno',$item->ap_paterno)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="3" tipo="text" nombre="ap materno" valor="{{old('ap_materno',$item->ap_materno)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="nombre" valor="{{old('nombre',$item->nombre)}}"></x-inputs.text-field>
        <x-inputs.date-field cols="2" nombre="fecha nacimiento" valor="{{old('fecha_nacimiento',$item->fecha_nacimiento)}}"></x-inputs.date-field>
        <x-inputs.select-form cols="2" nombre="genero" :arr="['1'=>'Hombre', '0'=>'Mujer', '2'=>'Otro']" valor="{{ $item->genero }}" ></x-inputs.select-form>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="curp" valor="{{old('curp',$item->curp)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="celulares" valor="{{old('celulares',$item->celulares)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="telefonos" valor="{{old('telefonos',$item->telefonos)}}"></x-inputs.text-field>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="12" tipo="text" nombre="emails" valor="{{old('emails',$item->emails)}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-primary brc-primary text-white badge-lg mb-1 w-95">Domicilio</span>
    </p>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="calle" valor="{{old('calle',$item->user_adress->calle)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="num ext" valor="{{old('num_ext',$item->user_adress->num_ext)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="num int" valor="{{old('num_int',$item->user_adress->num_int)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="colonia" valor="{{old('colonia',$item->user_adress->colonia)}}"></x-inputs.text-field>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="localidad" valor="{{old('localidad',$item->user_adress->localidad)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="municipio" valor="{{old('municipio',$item->user_adress->municipio)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="estado" valor="{{old('estado',$item->user_adress->estado)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="pais" valor="{{old('pais',$item->user_adress->pais)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="2" tipo="text" nombre="cp" valor="{{old('cp',$item->user_adress->cp)}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-warning brc-warning text-white badge-lg mb-1 w-95">Ocupación</span>
    </p>

    <div class="form-group row">
        <x-inputs.text-field cols="3" tipo="text" nombre="lugar nacimiento" valor="{{old('lugar_nacimiento',$item->user_data_extend->lugar_nacimiento)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="3" tipo="text" nombre="ocupacion" valor="{{old('ocupacion',$item->user_data_extend->ocupacion)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="3" tipo="text" nombre="profesion" valor="{{old('profesion',$item->user_data_extend->profesion)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="3" tipo="text" nombre="lugar trabajo" valor="{{old('lugar_trabajo',$item->user_data_extend->lugar_trabajo)}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-purple brc-purple text-white badge-lg mb-1 w-95">Redes Sociales</span>
    </p>
    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="red social" valor="{{old('red_social',$item->user_data_social->red_social)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="username red social" valor="{{old('username_red_social',$item->user_data_social->username_red_social)}}"></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="alias red social" valor="{{old('alias_red_social',$item->user_data_social->alias_red_social)}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-secondary brc-secondary text-white badge-lg mb-1 w-95">Otros Datos</span>
    </p>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="user id anterior" valor="{{old('user_id_anterior',$item->user_id_anterior)}}" deshabilitado ></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="creado por id" valor="{{old('creado_por_id',$item->creado_por_id)}}" deshabilitado></x-inputs.text-field>
    </div>

            <div class="card bgc-yellow-m3 shadow-sm" id="card-7" draggable="false">
                <div class="card-header card-header-sm">
                    <h5 class="card-title text-dark-tp3 text-600 text-90 align-self-center">
                        Roles
                    </h5>

                    <div class="card-toolbar">
                        <a href="{{ route($createItem,['User'=>$item]) }}" class="card-toolbar-btn text-info-d1 d-style btnFullModal" draggable="false" data-toggle="modal" data-target="#modalFull">
                            <i class="fa fa-plus"></i>
                        </a>
                        <a href="#" class="card-toolbar-btn text-purple-d1 d-style" draggable="false">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body bgc-white p-0 collapse show" style="">
                    <div class="p-3">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Role</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($item->roles as $role )
                                    <tr>
                                        <td>{{$Dato1 =  $role->id}}</td>
                                        <td>{{$role->name}}</td>
                                        <td> @include("share.bars.___removeItem") </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- /.card-body -->
            </div>


    <input type="hidden" name="id" id="id" value="{{$item->id}}">
