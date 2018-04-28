<?php

namespace App\Http\Controllers\Asignaciones;


use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermisoRoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function asignar($idRole, $namePermissions,$cat_id)
    {

        $role = Role::findOrFail($idRole);
        //dd($role->name);
        $perms = explode('|',$namePermissions);
        foreach($perms AS $i=>$valor) {
            if ($perms[$i] !== ""){
                $perm = Permission::where('name', $perms[$i])->first();
                $rl = $role->hasPermissionTo($perms[$i]); // Role::where('name',$perm)->count();
                if (!$rl) {
                    $role->givePermissionTo($perm);
                }
            }
        }
        return redirect('/list_left_config/'.$cat_id.'/'.$idRole);
    }

    public function desasignar($idRole, $namePermissions,$cat_id)
    {
        $role = Role::findOrFail($idRole);
        $perms = explode('|',$namePermissions);
        foreach($perms AS $i=>$valor) {
            if ($perms[$i] !== "") {
                $perm = Permission::where('name', $perms[$i])->first();
                $role->revokePermissionTo($perm);
            }
        }
        return redirect('/list_left_config/'.$cat_id.'/'.$idRole);
    }

}
