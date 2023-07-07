<?php

namespace App\Http\Controllers\Asignaciones;

use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Rfc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $tables = ['Roles a Usuario','Permissions to Role','Registros Fiscales a Usuario'];
        $titlePanels = ['Roles Usuarios','Permissions Roles','Registros_Fiscales Usuarios'];
        switch ($ida) {
            case 0:
                $view = 'roles_usuario';
                $listEle     = Role::all()->sortBy('name')->pluck('name','name');
                $listTarget  = User::all()->sortBy('NombreCompletoCFDI40')->pluck('NombreCompletoCFDI40','id');
                // dd($listTarget);
                if ($iduser == 0){
                    $iduser = 1;
                }
                $users = User::findOrFail($iduser);
                $this->lstAsigns = $users->roles->pluck('name','name');
                break;
            case 1:
                $view = 'permisos_role';
                $listEle     = Permission::all()->sortBy('name')->pluck('name','name');
                $listTarget  = Role::all()->sortBy('name')->pluck('name','id');
                if ($iduser == 0){
                    $iduser = 1;
                }
                $roles = Role::findOrFail($iduser);
                $this->lstAsigns = $roles->permissions->pluck('name','name');
                break;
            case 2:
                $view = 'add_rfc_ajax';
                $listEle     = Rfc::select(DB::raw("CONCAT(id,' - ',rfc) AS rfcs"),'id')->orderByDesc('id')->pluck('rfcs', 'id');
                $listTarget  = User::all()->sortBy('NombreCompletoCFDI40')->pluck('NombreCompletoCFDI40','id');
//                $listTarget  = User::select(DB::raw("CONCAT(id,' - ',nombre,' ',ap_paterno,' ',ap_materno) AS nombres"),'id')->orderBy('nombres')->pluck('nombres', 'id');
                if ($iduser == 0){
                    $iduser = 1;
                }
                $users = User::findOrFail($iduser);
                $this->lstAsigns = $users->rfcs->pluck('rfc','id');
//                $this->lstAsigns = $users->rfcs->pluck(DB::raw("CONCAT(id,' - ',rfc) AS name"),'id');

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
