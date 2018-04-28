<?php

namespace App\Http\Controllers\Asignaciones;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleUsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function asignar($idUser, $nameRoles,$cat_id)
    {
        $user = User::findOrFail($idUser);
        //dd($user->name);
        $roles = explode('|',$nameRoles);
        foreach($roles AS $i=>$valor) {
            if ($roles[$i] !== ""){
                $role = Role::where('name', $roles[$i])->first();
                $rl = $user->hasRole($roles[$i]); // Role::where('name',$perm)->count();
                if (!$rl) {
                    $user->roles()->attach($role);
                    if ($roles[$i] === 'administrator'){
                        $user->admin = true;
                        $user->save();
                    }
                }
            }
        }
        return redirect('/list_left_config/'.$cat_id.'/'.$idUser);
    }

    public function desasignar($idUser, $nameRoles,$cat_id)
    {
        $user = User::findOrFail($idUser);
        $roles = explode('|',$nameRoles);
        foreach($roles AS $i=>$valor) {
            if ($roles[$i] !== "") {
                $role = Role::where('name', $roles[$i])->first();
                $user->removeRole($role);
                if ($roles[$i] === 'administrator'){
                    $user->admin = false;
                    $user->save();
                }

            }
        }
        return redirect('/list_left_config/'.$cat_id.'/'.$idUser);
    }

}
