
    <div class="form-group row">
        <x-inputs.text-field cols="3" tipo="text" nombre="familia" valor="{{old('familia',$item->familia)}}"></x-inputs.text-field>
    </div>

    <div class="form-group row">
        <x-inputs.text-field cols="12" tipo="text" nombre="emails" valor="{{old('emails',$item->emails)}}"></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-secondary brc-secondary text-white badge-lg mb-1 w-95">Otros Datos</span>
    </p>

    <div class="form-group row">
        <x-inputs.text-field cols="4" tipo="text" nombre="id familia" valor="{{old('idfamilia',$item->idfamilia)}}" deshabilitado ></x-inputs.text-field>
        <x-inputs.text-field cols="4" tipo="text" nombre="creado por id" valor="{{old('creado_por_id',$item->creado_por_id)}}" deshabilitado></x-inputs.text-field>
    </div>

    <p>
        <span class="badge-dot badge-success"></span>
        <span class="d-inline-block radius-round p-2 bgc-red"></span>
        <span class="badge-dot bgc-orange"></span>
        <span class="badge bgc-secondary brc-green-l1 text-white badge-lg mb-1 w-95">Familiares</span>
    </p>

    <div class="form-group pr-2 radius-1 table-responsive">
        <table class="table table-striped table-bordered table-hover brc-black-tp10 mb-0 text-grey m2-1 m2-2 w-96">
            <thead class="brc-transparent">
            <tr class="bgc-green-d2 text-white">
                <th>
                    Alumno
                </th>
                <th>
                    Parentesco
                </th>
                <th>
                    Familiar
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($item->alumnos as $Fam)
                <tr class="bgc-h-yellow-l3 w-100">
                    <td >{{$Fam->FullName}}</td>
                    <td >{{ $Fam->getParentesco($Fam->pivot->familiar_parentesco_id) }}</td>
                    <td >{{ $Fam->getTutor($Fam->pivot->familiar_id) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>




    <input type="hidden" name="id" id="id" value="{{$item->id}}">
