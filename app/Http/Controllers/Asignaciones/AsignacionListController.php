<?php

namespace App\Http\Controllers\Asignaciones;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AsignacionListController extends Controller
{
    protected $tableName = '';
    protected $lstAsigns = "";

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function datatable()
    {
        return view('datatable');
    }

    public function index($ida = 0,$iduser = 0)
    {
        $tables = ['Roles a Usuario','Permissions to Role'];
        $titlePanels = ['Roles Usuarios','Permissions Roles'];
        switch ($ida) {
            case 0:
                $view = 'roles_usuario';
                $listEle     = Role::all()->sortByDesc('name')->pluck('name','name');
                $listTarget  = User::all()->sortByDesc('username')->pluck('username','id');
                //dd($listTarget);
                if ($iduser == 0){
                    $iduser = 1;
                }
                $users = User::findOrFail($iduser);
                $this->lstAsigns = $users->roles->pluck('name','name');
//                foreach ($users->roles as $role) {
//                    $this->lstAsigns .= $role->name . ', ';
//                }
                break;
            case 1:
                $view = 'permisos_role';
                $listEle     = Permission::all()->sortByDesc('name')->pluck('name','name');
                $listTarget  = Role::all()->sortByDesc('name')->pluck('name','id');
                if ($iduser == 0){
                    $iduser = 1;
                }
                $roles = Role::findOrFail($iduser);
                $this->lstAsigns = $roles->permissions->pluck('name','name');
//                foreach ($roles->permissions as $permision) {
//                    $this->lstAsigns .= $permision->name . ', ';
//                }
                break;
            default:
                throw new NotFoundHttpException();
                break;
        }

        // dd($ida);

        $user = Auth::User();
        return view ('asignaciones.'.$view,
            [
                'listEle' => $listEle,
                'listTarget' => $listTarget,
                'lstAsigns' => $this->lstAsigns,
                'id' => $ida,
                'titulo' => "Asignación de ".$tables[$ida],
                'user' => $user,
                'iduser' => $iduser,
                'titlePanels' => $titlePanels[$ida],
            ]
        );
    }
    //
}
