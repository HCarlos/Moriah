<?php


namespace App\Traits\Persona;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

trait PersonaAttributes
{

    protected $disk1 = 'persona';

    public function isRole($role): bool{
        return $this->hasRole($role);
    }

    public function getRoleIdStrArrayAttribute(){
        return $this->roles()->allRelatedIds('id')->implode('|','id');
    }

    public function getRoleNameStrArrayAttribute(){
        return $this->roles()->pluck('name')->implode('|','name');
    }

    public function getFullNameAttribute() {
        return trim($this->ap_paterno).' '.trim($this->ap_materno).' '.trim($this->nombre);
    }

    public function getStrGeneroAttribute() {
        $Gen = "Desconocido";
        switch ($this->genero){
            case 0:
                $Gen = "FEMENINO";
                break;
            case 1:
                $Gen = "MASCULINO";
                break;
        }
        return $Gen;
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

    // Get Image
    public function getPathImageProfileAttribute(){
        $ret = 'images/web/file-not-found.png';
        if ( $this->IsEmptyPhoto() ){
            if ( $this->IsFemale() ){
                $ret = 'images/web/empty_user_female.png';
            }else{
                $ret = 'images/web/empty_user_male.png';
            }
        }else{
            $tFile = $this->getTipoImageProfile("");
            $exists = Storage::disk($this->disk1)->exists($tFile);
            $ret = $exists
                ? "storage/".$this->disk1."/".$tFile
                : $ret;
        }
        return $ret;
    }

    // Get Image Thumbnail
    public function getPathImageThumbProfileAttribute(){
        $ret = '/images/web/file-not-found.png';
        if ( $this->IsEmptyPhoto() ){
            if ( $this->IsFemale() ){
                $ret = '/images/web/empty_user_female.png';
            }else{
                $ret = '/images/web/empty_user_male.png';
            }
        }else{
            $tFile = $this->getTipoImageProfile("thumb");
            $exists = Storage::disk($this->disk1)->exists($tFile);
            $ret = $exists
                ? "/storage/".$this->disk1."/".$tFile
                : $ret;
        }
        return $ret;
    }

    public function getHomeAttribute($withSlash=false): string {

        $slash = "/";
        if (Auth::user()->isRole('Administrator|SysOp')){
            $home = 'home';
        }  elseif (Auth::user()->isRole('DELEGADO|CIUDADANO')) {
            $home = 'home-ciudadano';
        } else {
            $home = 'home';
        }
        return $withSlash ? $slash . $home : $home;
    }

    public static function findByCURP($curp){

        return self::query()->where('curp',strtoupper(trim($curp)))->get();

    }

    public static function findByCURPFirst($curp){

        return self::query()->where('curp',strtoupper(trim($curp)))->first();

    }




}
