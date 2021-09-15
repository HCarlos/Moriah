<?php


namespace App\Traits\Domicilio;


use App\Models\Catalogos\Domicilios\Calle;
use App\Models\Catalogos\Domicilios\Ciudad;
use App\Models\Catalogos\Domicilios\Codigopostal;
use App\Models\Catalogos\Domicilios\Colonia;
use App\Models\Catalogos\Domicilios\Comunidad;
use App\Models\Catalogos\Domicilios\Estado;
use App\Models\Catalogos\Domicilios\Localidad;
use App\Models\Catalogos\Domicilios\Municipio;
use App\Models\Catalogos\Domicilios\Pais;
use App\Models\Catalogos\Domicilios\Ubicacion;
use App\User;

trait UbicacionTrait
{
    // ***************************************************
    // ******** CALLES ***********************************
    // ***************************************************
    public static function attachCalle($calle_id){
        $Calle   = Calle::find($calle_id);
        $item = [
            'calle' => strtoupper($Calle->calle),
            'calle_id' => $calle_id,
        ];
        $Ubicacion = Ubicacion::all()->where('calle_id',$calle_id);
        foreach ($Ubicacion as $ubi){
            $ubi->update($item);
            $ubi->calles()->attach($calle_id);
        }
        return true;
    }

    public static function detachCalle($calle_id){
        $Ubicacion = Ubicacion::all()->where('calle_id',$calle_id);
        foreach ($Ubicacion as $ubi){
            $ubi->calles()->detach($ubi->calle_id);
        }
        return true;
    }

    // ***************************************************
    // ******** COLONIAS ***********************************
    // ***************************************************

    // ***************************************************
    // ******** LOCALIDADES ***********************************
    // ***************************************************
    public static function attachLocalidad($localidad_id){
        $Obj   = Localidad::find($localidad_id);
        $item = [
            'localidad' => strtoupper($Obj->localidad),
            'localidad_id' => $localidad_id,
        ];
        $Ubicacion = Ubicacion::all()->where('localidad_id',$localidad_id);
        foreach ($Ubicacion as $ubi){
            $ubi->update($item);
            $ubi->localidades()->attach($localidad_id);
        }
        return true;
    }

    public static function detachLocalidad($localidad_id){
        $Ubicacion = Ubicacion::all()->where('localidad_id',$localidad_id);
        foreach ($Ubicacion as $ubi){
            $ubi->localidades()->detach($ubi->localidad_id);
        }
        return true;
    }

    // ***************************************************
    // ******** CIUDADES ***********************************
    // ***************************************************
    public static function attachCiudad($ciudad_id){
        $Obj   = Ciudad::find($ciudad_id);
        $item = [
            'ciudad' => strtoupper($Obj->ciudad),
            'ciudad_id' => $ciudad_id,
        ];
        $Ubicacion = Ubicacion::all()->where('ciudad_id',$ciudad_id);
        foreach ($Ubicacion as $ubi){
            $ubi->update($item);
            $ubi->ciudades()->attach($ciudad_id);
        }
        return true;
    }

    public static function detachCiudad($ciudad_id){
        $Ubicacion = Ubicacion::all()->where('ciudad_id',$ciudad_id);
        foreach ($Ubicacion as $ubi){
            $ubi->ciudades()->detach($ubi->ciudad_id);
        }
        return true;
    }

    // ***************************************************
    // ******** MUNICIPIOS ***********************************
    // ***************************************************
    public static function attachMunicipio($municipio_id){
        $Obj   = Municipio::find($municipio_id);
        $item = [
            'municipio' => strtoupper($Obj->municipio),
            'municipio_id' => $municipio_id,
        ];
        $Ubicacion = Ubicacion::all()->where('municipio_id',$municipio_id);
        foreach ($Ubicacion as $ubi){
            $ubi->update($item);
            $ubi->municipios()->attach($municipio_id);
        }
        return true;
    }

    public static function detachMunicipio($municipio_id){
        $Ubicacion = Ubicacion::all()->where('municipio_id',$municipio_id);
        foreach ($Ubicacion as $ubi){
            $ubi->municipios()->detach($ubi->$municipio_id);
        }
        return true;
    }

    // ***************************************************
    // ******** ESTADOS ***********************************
    // ***************************************************
    public static function attachEstado($estado_id){
        $Obj   = Estado::find($estado_id);
        $item = [
            'estado' => strtoupper($Obj->estado),
            'estado_id' => $estado_id,
        ];
        $Ubicacion = Ubicacion::all()->where('estado_id',$estado_id);
        foreach ($Ubicacion as $ubi){
            $ubi->update($item);
            $ubi->estados()->attach($estado_id);
        }
        return true;
    }

    public static function detachEstado($estado_id){
        $Ubicacion = Ubicacion::all()->where('estado_id',$estado_id);
        foreach ($Ubicacion as $ubi){
            $ubi->estados()->detach($ubi->estado_id);
        }
        return true;
    }

    // ***************************************************
    // ******** PAISES ***********************************
    // ***************************************************
    public static function attachPais($pais_id){
        $Obj   = Pais::find($pais_id);
        $item = [
            'pais' => strtoupper($Obj->pais),
            'pais_id' => $pais_id,
        ];
        $Ubicacion = Ubicacion::all()->where('pais_id',$pais_id);
        foreach ($Ubicacion as $ubi){
            $ubi->update($item);
            $ubi->paises()->attach($pais_id);
        }
        return true;
    }

    public static function detachPais($pais_id){
        $Ubicacion = Ubicacion::all()->where('pais_id',$pais_id);
        foreach ($Ubicacion as $ubi){
            $ubi->paises()->detach($ubi->pais_id);
        }
        return true;
    }

    // ***************************************************
    // ******** CP's ***********************************
    // ***************************************************
    public static function attachCP($codigopostal_id){
        $Obj   = Pais::find($codigopostal_id);
        $item = [
            'codigo_postal' => strtoupper($Obj->codigo_postal),
            'codigo_postal_id' => $codigopostal_id,
        ];
        $Ubicacion = Ubicacion::all()->where('codigo_postal_id',$codigopostal_id);
        foreach ($Ubicacion as $ubi){
            $ubi->update($item);
            $ubi->codigospostales()->attach($codigopostal_id);
        }
        return true;
    }

    public static function detachCP($codigopostal_id){
        $Ubicacion = Ubicacion::all()->where('codigo_postal_id',$codigopostal_id);
        foreach ($Ubicacion as $ubi){
            $ubi->codigospostales()->detach($ubi->codigopostal_id);
        }
        return true;
    }

    public function getUbicacionAttribute() {
        $numInt = $this->num_int == '' ? ', ' : ' '.$this->num_int.', ';
        $cd = trim($this->ciudad) === '' ? '' : trim($this->ciudad).', ';
        return trim($this->calle).', '
            .trim($this->num_ext).$numInt
            .trim($this->localidad).', '
            .$cd
            .trim($this->municipio).', '
            .trim($this->estado).', '
            .trim($this->cp);
    }

}
