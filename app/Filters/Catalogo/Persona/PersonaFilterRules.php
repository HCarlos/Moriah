<?php


namespace App\Filters\Catalogo\Persona;


use Carbon\Carbon;
use Illuminate\Http\Request;

class PersonaFilterRules{



    /* *****************************************************************************************************************
    *                                       FILTROS DE P E R S O N A S                                                 *
    ***************************************************************************************************************** */

    public function filterRulesPersona(Request $request){
        $data = $request->all(['Id','search','IdP','ap_paterno','ap_materno','nombre','curp','curp10','calle','num_ext','localidad','cp','estado_id','municipio_id','fecha_inicial','fecha_final']);

        $fi = !is_null($data['fecha_inicial']) ? Carbon::createFromFormat('Y-m-d',$data['fecha_inicial']) : null ;
        $ff = !is_null($data['fecha_final'])   ? Carbon::createFromFormat('Y-m-d',$data['fecha_final'])   : null ;

        $data['IdP']           = $data['IdP']==null       ? "" : intval($data['IdP']);
        $data['search']        = $data['search']==null     ? "" : $data['search'];
        $data['ap_paterno']    = $data['ap_paterno']==null ? "" : $data['ap_paterno'];
        $data['ap_materno']    = $data['ap_materno']==null ? "" : $data['ap_materno'];
        $data['nombre']        = $data['nombre']==null     ? "" : $data['nombre'];
        $data['curp']          = $data['curp']==null       ? "" : $data['curp'];
        $data['curp10']        = $data['curp10']==null     ? "" : $data['curp10'];
        $data['calle']         = $data['calle']==null      ? "" : $data['calle'];
        $data['num_ext']       = $data['num_ext']==null    ? "" : $data['num_ext'];
        $data['localidad']     = $data['localidad']==null  ? "" : $data['localidad'];
        $data['cp']            = $data['cp']==null         ? "" : $data['cp'];
        $data['fecha_inicial'] = $fi ;
        $data['fecha_final']   = $ff ;
        $data['estado_id']     = $data['estado_id']=="0"    || $data['estado_id']==null    ? "" : intval($data['estado_id']);
        $data['municipio_id']  = $data['municipio_id']=="0" || $data['municipio_id']==null ? "" : intval($data['municipio_id']);

        $filters = [
            'IdP'           => $data['IdP'],
            'search'        => $data['search'],
            'ap_paterno'    => $data['ap_paterno'],
            'ap_materno'    => $data['ap_materno'],
            'nombre'        => $data['nombre'],
            'curp'          => $data['curp'],
            'curp10'        => $data['curp10'],
            'cp'            => $data['cp'],
            'calle'         => $data['calle'],
            'num_ext'       => $data['num_ext'],
            'localidad'     => $data['localidad'],
            'estado_id'     => $data['estado_id'],
            'municipio_id'  => $data['municipio_id'],
            'fecha_inicial' => $data['fecha_inicial'],
            'fecha_final'   => $data['fecha_final'],
        ];
        return $filters;
    }

    public function filterRulesPersonaOnly(Request $request){
        $data = $request->all(['Id','search','IdP','ap_paterno','ap_materno','nombre','curp','curp10','fecha_inicial','fecha_final']);

        $fi = !is_null($data['fecha_inicial']) ? Carbon::createFromFormat('Y-m-d',$data['fecha_inicial'])->toDateString() : null ;
        $ff = !is_null($data['fecha_final'])   ? Carbon::createFromFormat('Y-m-d',$data['fecha_final'])->toDateString()   : null ;

        $IdP    = $data['IdP']==null || $data['IdP']==""  ? "" : intval($data['IdP']);

        $ap_paterno    = $data['ap_paterno']==null || $data['ap_paterno']==""  ? "" : strtoupper(trim($data['ap_paterno']));
        $ap_materno    = $data['ap_materno']==null || $data['ap_materno']==""  ? "" : strtoupper(trim($data['ap_materno']));
        $nombre        = $data['nombre']==null     || $data['nombre']==""      ? "" : strtoupper(trim($data['nombre']));
        $curp          = $data['curp']==null       || $data['curp']==""        ? "" : strtoupper(trim($data['curp']));
        $curp10        = $data['curp10']==null     || $data['curp10']==""      ? "" : strtoupper(trim($data['curp10']));

        $fecha_inicial = $fi == null ? "" : $fi;
        $fecha_final   = $ff == null ? "" : $ff;

        $filters = [
            'IdP'           => $IdP,
            'ap_paterno'    => $ap_paterno,
            'ap_materno'    => $ap_materno,
            'nombre'        => $nombre,
            'curp'          => $curp,
            'curp10'        => $curp10,
            'fecha_inicial' => $fecha_inicial,
            'fecha_final'   => $fecha_final,
        ];
        return $filters;
    }

    public function filterRulesPersonaDB(Request $request){
        $data = $request->all(['Id','search','IdP','ap_paterno','ap_materno','nombre','cp','curp','curp10','calle','num_ext','localidad','estado_id','municipio_id','fecha_inicial','fecha_final']);

        $fi = !is_null($data['fecha_inicial']) ? Carbon::createFromFormat('Y-m-d',$data['fecha_inicial'])->toDateString() : null ;
        $ff = !is_null($data['fecha_final'])   ? Carbon::createFromFormat('Y-m-d',$data['fecha_final'])->toDateString()   : null ;

        $data['IdP']        = $data['IdP']==null    ? "" : intval($data['IdP']);
        $data['search']     = $data['search']==null ? "" : $data['search'];

        $data['ap_paterno'] = $data['ap_paterno']==null || $data['ap_paterno']==""  ? "" : strtoupper(trim($data['ap_paterno']));
        $data['ap_materno'] = $data['ap_materno']==null || $data['ap_materno']==""  ? "" : strtoupper(trim($data['ap_materno']));
        $data['nombre']     = $data['nombre']==null     || $data['nombre']==""      ? "" : strtoupper(trim($data['nombre']));
        $data['curp']       = $data['curp']==null       || $data['curp']==""        ? "" : strtoupper(trim($data['curp']));
        $data['curp10']     = $data['curp10']==null     || $data['curp10']==""      ? "" : strtoupper(trim($data['curp10']));
        $data['cp']         = $data['cp']==null         || $data['cp']==""          ? "" : strtoupper(trim($data['cp']));
        $data['calle']      = $data['calle']==null      || $data['calle']==""       ? "" : strtoupper(trim($data['calle']));
        $data['num_ext']    = $data['num_ext']==null    || $data['num_ext']==""     ? "" : strtoupper(trim($data['num_ext']));
        $data['localidad']  = $data['localidad']==null  || $data['localidad']==""   ? "" : strtoupper(trim($data['localidad']));

        $data['fecha_inicial'] = $fi == null ? "" : $fi;
        $data['fecha_final']   = $ff == null ? "" : $ff;

        $data['estado_id']    = $data['estado_id']=="0"    || $data['estado_id']==null    ? "" : intval($data['estado_id']);
        $data['municipio_id'] = $data['municipio_id']=="0" || $data['municipio_id']==null ? "" : intval($data['municipio_id']);

        $filters = [
            'Id'            => $data['Id'],
            'IdP'           => $data['IdP'],
            'search'        => $data['search'],
            'ap_paterno'    => $data['ap_paterno'],
            'ap_materno'    => $data['ap_materno'],
            'nombre'        => $data['nombre'],
            'curp'          => $data['curp'],
            'curp10'        => $data['curp10'],
            'fecha_inicial' => $data['fecha_inicial'],
            'fecha_final'   => $data['fecha_final'],
            'cp'            => $data['cp'],
            'calle'         => $data['calle'],
            'num_ext'       => $data['num_ext'],
            'localidad'     => $data['localidad'],
            'estado_id'     => $data['estado_id'],
            'municipio_id'  => $data['municipio_id'],
        ];
        return $filters;
    }


    public function wherePersonaOnly($data){

        //dd($data);

        $fi = !is_null($data['fecha_inicial']) && $data['fecha_inicial'] != "" ? $data['fecha_inicial'] : null ;
        $ff = !is_null($data['fecha_final'])   && $data['fecha_final']   != "" ? $data['fecha_final']   : null ;

        $IdP           = $data['IdP']==null         || $data['IdP']==""          ? "" : "id = ".intval($data['IdP']);

        $ap_paterno    = $data['ap_paterno']==null || $data['ap_paterno']==""  ? "" : "ap_paterno = '".$data['ap_paterno']."'";
        $ap_materno    = $data['ap_materno']==null || $data['ap_materno']==""  ? "" : "ap_materno = '".$data['ap_materno']."'";
        $nombre        = $data['nombre']==null     || $data['nombre']==""      ? "" : "nombre = '".$data['nombre']."'";
        $curp          = $data['curp']==null       || $data['curp']==""        ? "" : "curp = '".$data['curp']."'";
        $curp10        = $data['curp10']==null     || $data['curp10']==""      ? "" : "curp >= '".$data['curp10']."' AND curp <= CONCAT('".$data['curp10']."','Z')";

        $fecha_inicial = $fi == null ? "" : "fecha_nacimiento >= '".$fi."'";
        $fecha_final   = $ff == null ? "" : "fecha_nacimiento <= '".$ff."'";

        $cadena = [
            'IdP'           => $IdP,
            'ap_paterno'    => $ap_paterno,
            'ap_materno'    => $ap_materno,
            'nombre'        => $nombre,
            'curp'          => $curp,
            'curp10'        => $curp10,
            'fecha_inicial' => $fecha_inicial,
            'fecha_final'   => $fecha_final,
        ];
        return $cadena;

    }

    public function wherePersonaDB($data){

        //dd($data);

        $fi = !is_null($data['fecha_inicial']) && $data['fecha_inicial'] != "" ? $data['fecha_inicial'] : null ;
        $ff = !is_null($data['fecha_final'])   && $data['fecha_final']   != "" ? $data['fecha_final']   : null ;

        $search     = $data['search']==null ? "" : $data['search'];

        $ap_paterno = $data['ap_paterno']==null || $data['ap_paterno']==""  ? "" : "p.ap_paterno = '".$data['ap_paterno']."'";
        $ap_materno = $data['ap_materno']==null || $data['ap_materno']==""  ? "" : "p.ap_materno = '".$data['ap_materno']."'";
        $nombre     = $data['nombre']==null     || $data['nombre']==""      ? "" : "p.nombre = '".$data['nombre']."'";
        $curp       = $data['curp']==null       || $data['curp']==""        ? "" : "p.curp = '".$data['curp']."'";
        $curp10     = $data['curp10']==null     || $data['curp10']==""      ? "" : "p.curp >= '".$data['curp10']."' AND p.curp <= CONCAT('".$data['curp10']."','Z')";
        $cp         = $data['cp']==null         || $data['cp']==""          ? "" : "u.cp like ('%".$data['cp']."%')";
        $calle      = $data['calle']==null      || $data['calle']==""       ? "" : "u.calle like ('%".$data['calle']."%')";
        $num_ext    = $data['num_ext']==null    || $data['num_ext']==""     ? "" : "u.num_ext like ('%".$data['num_ext']."%')";
        $localidad  = $data['localidad']==null  || $data['localidad']==""   ? "" : "u.localidad like ('%".$data['localidad']."%')";

        $fecha_inicial = $fi == null ? "" : "p.fecha_nacimiento >= '".$fi."'";
        $fecha_final   = $ff == null ? "" : "p.fecha_nacimiento <= '".$ff."'";

        $IdP        = $data['IdP']==null    ? "" : "p.id = ".intval($data['IdP']);

        $estado_id    = $data['estado_id']=="0"    || $data['estado_id']==null    ? "" : "u.estado_id = ".$data['estado_id'];
        $municipio_id = $data['municipio_id']=="0" || $data['municipio_id']==null ? "" : "u.municipio_id = ".$data['municipio_id'];

        $cadena = [
            'IdP'            => $IdP,
            'search'        => $search,
            'ap_paterno'    => $ap_paterno,
            'ap_materno'    => $ap_materno,
            'nombre'        => $nombre,
            'curp'          => $curp,
            'curp10'        => $curp10,
            'fecha_inicial' => $fecha_inicial,
            'fecha_final'   => $fecha_final,
            'cp'            => $cp,
            'calle'         => $calle,
            'num_ext'       => $num_ext,
            'localidad'     => $localidad,
            'estado_id'     => $estado_id,
            'municipio_id'  => $municipio_id,
        ];
        return $cadena;
    }







}
