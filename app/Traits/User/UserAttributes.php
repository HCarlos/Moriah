<?php

namespace App\Traits\User;

use App\Models\Catalogos\Parentesco;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Integer;

trait UserAttributes
{

    protected $disk1 = 'profile';

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
//        return "{$this->ap_paterno} {$this->ap_materno} {$this->nombre}";
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

    public static function getUsernameNext( string $Abreviatura ): array{
        $Abreviatura = $Abreviatura == "0" ? "inv" : $Abreviatura;
        $next_id=DB::select("SELECT NEXTVAL('users_id_seq')");
        $Id = intval($next_id['0']->nextval);
        DB::select("SELECT SETVAL('users_id_seq',".($Id-1).")" );
        $Id = str_pad($Id,6,'0',0);
        $role = Role::query()->where('abreviatura',$Abreviatura)->first();
//        if ( is_null($role) ) {
//            return ['username'=>'error','role_id'=>0];
//        }
        return ['username'=>$role->abreviatura.$Id,'role_id'=>$role->id];
    }

    public static function findByIdUserAnterior($IdUserAnterior){
        return static::query()->where('user_id_anterior',$IdUserAnterior)->first();
    }

    public function getParentesco($Parentesco_Id) {
//        return "{$this->ap_paterno} {$this->ap_materno} {$this->nombre}";
        $Par = Parentesco::find($Parentesco_Id);
        if ( is_null($Par) == false ){
            switch ($this->genero){
                case 0:
                    return $Par->parentesco_femenino;
                    break;
                case 1:
                    return $Par->parentesco_masculino;
                    break;
                default:
                    return null;
            }
        }else{
            return null;
        }
    }

    public function getTutor($Tutor_Id) {
        $Tutor = self::find($Tutor_Id);
        return $Tutor ? $Tutor->FullName : '';
    }


}
