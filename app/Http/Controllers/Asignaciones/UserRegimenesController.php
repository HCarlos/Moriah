<?php

namespace App\Http\Controllers\Asignaciones;

use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Rfc;
use App\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRegimenesController extends Controller{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function asignar($idUser, $rfcs,$cat_id)
    {
        $user = User::findOrFail($idUser);
        //dd($user->name);
        $RFCS = explode('|',$rfcs);
//        dd($RFCS);
        foreach($RFCS AS $i=>$valor) {
            if ($RFCS[$i] !== ""){
                $r = (int) $RFCS[$i];
                $rfc = Rfc::find($r);
                $rl = User::query()->whereHas('rfcs', function($q) use ($r, $idUser) {
                    return $q->where('rfc_id',$r)->where('user_id',$idUser);
                })->get();
                if ($rl->count() <= 0) {
                    $user->rfcs()->attach($r);
                }
            }
        }
        return redirect('/list_left_config/'.$cat_id.'/'.$idUser);
    }

    public function desasignar($idUser, $rfcs,$cat_id)
    {
        $user = User::findOrFail($idUser);
        $RFCS = explode('|',$rfcs);
        foreach($RFCS AS $i=>$valor) {
            if ($RFCS[$i] !== "") {
                $r = (int) $RFCS[$i];
                $rfc = Rfc::find($r);
                $rl = User::query()->whereHas('rfcs', function($q) use ($r) {
                    return $q->where('rfc_id',$r);
                })->get();
                if ($rl->count() > 0) {
                    $user->rfcs()->detach($r);
                }
            }
        }
        return redirect('/list_left_config/'.$cat_id.'/'.$idUser);
    }

}
