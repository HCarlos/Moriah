<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Models\Medida;
use App\Models\Editorial;
use App\Models\Almacen;
use App\Models\Fichafile;
use App\Models\Config;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Proveedor;
use App\User;
use Illuminate\Auth\Access\AuthorizationException as AuthorizationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Carbon\Carbon;


class CatalogosController extends Controller
{
    protected $otrosDatos;
    protected $Predeterminado = false;
    protected $redirectTo = '/home';
    protected $fVencimiento = '';
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id=0,$idItem=0,$action=0)
    {
        $tables = ['empresas','almacenes','medidas','productos','paquetes','proveedores','6','7','8','9','users','roles','permissions'];
        if ($action == 0){
            $views  = ['empresa_new','almacen_new','medida_new','producto_new','paquete_new','proveedor_new','6','7','8','9','usuario_new','role_new','permission_new'];
        }else{
            $views  = ['empresa_edit','almacen_edit','medida_edit','producto_edit','paquete_edit','proveedor_edit','6','7','8','9','usuario_edit','role_edit','permission_edit'];
        }

        if ($action == 1) {
            switch ($id) {
                case 0;
                    $items = Empresa::findOrFail($idItem);
                    dd($items);
                    break;
                case 1;
                    $items = Almacen::findOrFail($idItem);
                    //$this->otrosDatos = Editorial::all()->sortBy('predeterminado')->sortBy('editorial')->pluck('editorial', 'id');
                    break;
                case 2;
                    $items = Medida::findOrFail($idItem);
                    break;
                case 3;
                    $items = Producto::findOrFail($idItem);
//                    $this->otrosDatos = User::findOrFail($items->apartado_user_id);
//                    $config = Config::all()->where('key','dias_apartado')->first();
//                    $fa = new Carbon($items->fecha_apartado);
//                    $fa = Carbon::now();
//                    $fa = $fa->addDay($config->value);
//                    $this->fVencimiento = $fa;
                    break;
                case 4;
                    $items = Paquete::findOrFail($idItem);
//                    $this->otrosDatos = User::findOrFail($items->prestado_user_id);
                    break;
                case 4;
                    $items = Proveedor::findOrFail($idItem);
//                    $this->otrosDatos = User::findOrFail($items->prestado_user_id);
                    break;
                case 10;
                    if ( Auth::user()->isAdmin() || Auth::user()->hasRole('system_operator') ){
                        $items = User::findOrFail($idItem);
                        foreach ($items->roles as $role) {
                            $this->otrosDatos .= $role->name . ', ';
                        }
                    }else{
                        throw new AuthorizationException();
                    }
                    break;
                case 11;
                    if ( Auth::user()->isAdmin() ){
                        $items = Role::findOrFail($idItem);
                        foreach ($items->permissions as $permision) {
                            $this->otrosDatos .= $permision->name . ', ';
                        }
                    }else{
                        throw new AuthorizationException();
                    }
                    break;
                case 12;
                    if ( Auth::user()->isAdmin() ){
                        $items = Permission::findOrFail($idItem);
                    }else{
                        throw new AuthorizationException();
                    }
                    break;
                default:
                    throw new NotFoundHttpException();
                    break;
            }
        }elseif ($action == 0){
            $items = [];
            switch ($id) {
                case 1;
                    $this->otrosDatos = Empresa::all()->sortBy('rs')->sortBy('rs')->pluck('rs', 'id');
                    $pred = Empresa::select('id')->where('rs',true)->first();
                    $this->Predeterminado = $pred->id;
                    break;
                case 10;
                    if ( Auth::user()->isAdmin() /*|| Auth::user()->hasRole('system_operator')*/ ){
                        $this->otrosDatos = Role::all()->sortByDesc('name')->pluck('name', 'name');
                    }else{
                        throw new AuthorizationException();
                    }
                    break;
                default:
                    //throw new NotFoundHttpException();
                    break;
            }
        }

        $user = Auth::User();
        //dd($items);
        $oView = 'catalogos.' ;
//        dd($items->editorial_id);

        return view ($oView.$views[$id],
            [
                'id'   => $id,
                'idItem' => $idItem,
                'titulo' => $tables[$id],
                'action' => $action,
                'items' => $items,
                'user' => $user,
                'otrosDatos' => $this->otrosDatos,
                'predeterminado' => $this->Predeterminado,
                'fVencimiento' => $this->fVencimiento,
            ]
        );

    }

    public function clone($id=0,$idItem=0,$action=0)
    {
        $items = Almacen::findOrFail($idItem);
        $user = Auth::User();

        return view ('bridge.catalogos_ficha_clone',
            [
                'id'   => $id,
                'idItem' => $idItem,
                'titulo' => 'Clonar Almacen: ',
                'action' => $action,
                'items' => $items,
                'user' => $user,
                'otrosDatos' => '',
            ]
        );

    }

    public function subirImagen($id=0,$idItem=0,$action=0)
    {
        $items = Almacen::findOrFail($idItem);
        $user = Auth::User();
        $filename = Fichafile::all()->where('isbn',$items->isbn)->sortBy('id');

        return view ('imagenes.catalogos_subir_imagen_ficha',
            [
                'id'   => $id,
                'idItem' => $idItem,
                'titulo' => 'Subir imagen a almacen: ',
                'action' => $action,
                'items' => $items,
                'user' => $user,
                'otrosDatos' => '',
                'archivo' => $filename,
            ]
        );

    }

}
