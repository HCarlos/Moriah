<?php


namespace App\Traits\Vehiculo;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait VehiculosAttributes{


    protected $disk1 = 'vehiculo';

    public function getFullNameAttribute() {
        return trim($this->marca).' '.trim($this->linea).' '.trim($this->modelo);
    }

    public function getTipoImageProfile($tipo=""){
        switch ($tipo){
            case 'thumb':
                return $this->filename_thumb;
                break;
            case 'png':
                return $this->filename_png;
                break;
            default :
                return $this->filename;
                break;
        }
    }


}
