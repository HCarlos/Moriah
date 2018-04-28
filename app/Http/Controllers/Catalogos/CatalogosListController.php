<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\Codigo_Lenguaje_Pais;
use App\Models\Config;
use App\Models\Editorial;
use App\Models\Ficha;
use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Medida;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Proveedor;
use App\User;
// use Illuminate\Foundation\Auth\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Yajra\DataTables\DataTables;

class CatalogosListController extends Controller
{
    protected $tableName = '';
    protected $itemPorPagina = 100;

    protected $redirectTo = '/home';
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function datatable()
    {
        return view('datatable');
    }

    public function index($id = 0, $npage = 1, $tpaginas = 0)
    {

        $page = Input::get('p');
        if ( $page != 0 ){
            $npage = $page;
        }

//        $npage = Input::get('page');


        switch ($id) {
            case 0:
            case 1:
                $this->tableName = 'almacenes';
                $items = Almacen::select('id','clave_almacen','descripcion','responsable', 'tipoinv')
                    ->orderBy('id','desc')
                    ->get()
                    ->forPage($npage,$this->itemPorPagina);
                $tpaginator = Almacen::paginate($this->itemPorPagina,['*'],'p');
                break;
            case 2:
                $this->tableName = 'medidas';
                $items = Medida::select('id','desc1','desc2','clave', 'empresa_id')
                    ->orderBy('id','desc')
                    ->get()
                    ->forPage($npage,$this->itemPorPagina);
                $tpaginator = Medida::paginate($this->itemPorPagina,['*'],'p');
                break;
            case 3:
                $this->tableName = 'productos';
                $items = Producto::select('id','clave','codigo','descripcion', 'exist')
                    ->orderBy('id','desc')
                    ->get()
                    ->forPage($npage,$this->itemPorPagina);
                $tpaginator = Producto::paginate($this->itemPorPagina,['*'],'p');
/*                $config = Config::all()->where('key','dias_apartado')->first();
                foreach ($items as $item){
                    if ($item->apartado_user_id > 0){
                        $item->usuario_apartador = User::findOrFail($item->apartado_user_id);
                        $fa = new Carbon($item->fecha_apartado);
                        $fa = $fa->addDay($config->value);
                        $item->vencimiento = $fa->format('d-m-Y');
                    }
                }*/
                break;
            case 4:
                $this->tableName = 'paquetes';
                $items = Paquete::select('id','descripcion_paquete')
                    ->orderBy('id','desc')
                    ->get()
                    ->forPage($npage,$this->itemPorPagina);
                $tpaginator = Paquete::where('prestado',true)->paginate($this->itemPorPagina,['*'],'p');
/*                $config = Config::all()->where('key','dias_prestado')->first();
                foreach ($items as $item){
                    if ($item->prestado_user_id > 0){
                        $item->usuario_prestador = User::findOrFail($item->prestado_user_id);
                        $fs = new Carbon($item->fecha_salida);
                        $fe = new Carbon($item->fecha_entrega);
                        $fn = Carbon::now();
//                        dd($fn <= $fe);
//                        dd($fe->diffInDays($fn));
                        if ($fn <= $fe){
                            $item->dias_vencidos = 0;
                        }else{
                            $item->dias_vencidos = $fn->diffInDays($fe);
                        }
                    }
                }*/
//                dd($tpaginator);
                break;
            case 5:
                $this->tableName = 'proveedores';
                $items = Proveedor::select('id','clave_proveedor','nombre_proveedor','contacto_proveedor')
                    ->orderBy('id','desc')
                    ->get()
                    ->forPage($npage,$this->itemPorPagina);
                $tpaginator = Proveedor::paginate($this->itemPorPagina,['*'],'p');
                break;
            case 10:

//                dd(app('geocoder')->geocode('Villahermosa, MX')->get());
//                dd(app('geocoder')->geocode('8.8.8.8')->get());
//                dd(app('geocoder')->reverse(43.882587,-103.454067)->get());
//                dd(app('geocoder')->geocode('Villahermosa, MX')->dump('kml'));



                if ( Auth::user()->isAdmin() || Auth::user()->hasRole('system_operator') ){
                    $this->tableName = 'usuarios';
                    $items = User::all()->sortByDesc('id')->forPage($npage,$this->itemPorPagina);
                    $tpaginator = User::paginate($this->itemPorPagina,['*'],'p');
                }else{
                    throw new AuthorizationException();
                }
                break;
            case 11:
                if ( Auth::user()->isAdmin() ){
                    $this->tableName = 'roles';
                    $items = Role::all()->sortByDesc('id')->forPage($npage,$this->itemPorPagina);
                    $tpaginator = Role::paginate($this->itemPorPagina,['*'],'p');
                }else{
                    throw new AuthorizationException();
                }
                break;
            case 12:
                if ( Auth::user()->isAdmin() ){
                    $this->tableName = 'permissions';
                    $items = Permission::all()->sortByDesc('id')->forPage($npage,$this->itemPorPagina);
                    $tpaginator = Permission::paginate($this->itemPorPagina,['*'],'p');
                }else{
                    throw new AuthorizationException();
                }
                break;
            default:
                throw new NotFoundHttpException();
                break;
        }
        //dd($items);
        // dd($npage);
        $tpaginas = $tpaginas == 0 ? $tpaginator->lastPage() : $tpaginas;
        //dd($tpaginas);
        $user = Auth::User();
        $tpaginator->withPath("/index/$id/$npage/$tpaginas");
        //$tpaginator->appends(['sort' => 'votes'])->links();
        return view ('catalogos.side_bar_right',
            [
                'items' => $items,
                'id' => $id,
                'titulo_catalogo' => "Catálogo de ".ucwords($this->tableName),
                'user' => $user,
                'tableName'=>$this->tableName,
                'npage'=> $npage,
                'tpaginas' => $tpaginas,
            ]
        )->with("paginator" , $tpaginator);
    }

    public function indexSearch(Request $request)
    {
        $search = trim($request->input('search'));
        $id = $request->input('id');
        $F = (new FuncionesController);
        if ($search !== ""){

            switch ($id) {
                case 0:
                    $search = $F->toMayus($search);
                    $this->tableName = 'empresas';
                    $total = Empresa::all()->count();
                    $items = Empresa::select('id','rs','ncomer')
                        ->orWhere('rs','LIKE',"%{$search}%")
                        ->orWhere('ncomer','LIKE',"%{$search}%")
                        ->get()
                        ->sortByDesc('id');
                    $items = $total == count($items) ? collect(new Empresa) : $items;
                    break;
                case 1:
                    $search = $F->toMayus($search);
                    $this->tableName = 'fichas';
                    $total = Ficha::all()->count();
                    $items = Ficha::select('id','ficha_no','isbn','titulo', 'autor')
                        ->orWhere('titulo','LIKE',"%{$search}%")
                        ->orWhere('autor','LIKE',"%{$search}%")
                        ->orWhere('isbn','LIKE',"%{$search}%")
                        ->get()
                        ->sortByDesc('id');
                    $items = $total == count($items) ? collect(new Ficha) : $items;
                    break;
                case 2:
                    //$search = $F->toMayus($search);
                    $this->tableName = 'codigo_lenguaje_paises';
                    $total = Codigo_Lenguaje_Pais::all()->count();
                    $items = Codigo_Lenguaje_Pais::select('id','idmig','codigo','lenguaje', 'tipo')
                        ->orWhere('codigo','LIKE',"%{$search}%")
                        ->orWhere('lenguaje','LIKE',"%{$search}%")
                        ->orWhere('tipo','LIKE',"%{$search}%")
                        ->get()
                        ->sortByDesc('id');
                    $items = $total == count($items) ? collect(new Ficha) : $items;
                    break;
                case 3:
                    $search = $F->toMayus($search);
                    $this->tableName = 'fichas';
                    $total = Ficha::all()->count();
                    $items = Ficha::select('id','ficha_no','isbn','titulo', 'autor',
                        'apartado','apartado_user_id','prestado_user_id')
                        ->orWhere('titulo','LIKE',"%{$search}%")
                        ->orWhere('autor','LIKE',"%{$search}%")
                        ->orWhere('isbn','LIKE',"%{$search}%")
                        ->andWhere('apartado',true)
                        ->get()
                        ->sortByDesc('id');
                    $items = $total == count($items) ? collect(new Ficha) : $items;
                    foreach ($items as $item){
                        if ($item->apartado_user_id > 0){
                            $item->usuario_apartador = User::findOrFail($item->apartado_user_id);
                        }
                    }
                    break;
                case 4:
                    $search = $F->toMayus($search);
                    $this->tableName = 'fichas';
                    $total = Ficha::all()->count();
                    $items = Ficha::select('id','ficha_no','isbn','titulo', 'autor',
                        'apartado','apartado_user_id','prestado_user_id')
                        ->orWhere('titulo','LIKE',"%{$search}%")
                        ->orWhere('autor','LIKE',"%{$search}%")
                        ->orWhere('isbn','LIKE',"%{$search}%")
                        ->andWhere('prestado',true)
                        ->get()
                        ->sortByDesc('id');
                    $items = $total == count($items) ? collect(new Ficha) : $items;
                    foreach ($items as $item){
                        if ($item->prestado_user_id > 0){
                            $item->usuario_prestador = User::findOrFail($item->prestado_user_id);
                        }
                    }
                    break;
                case 10:
                    if ( Auth::user()->isAdmin() || Auth::user()->hasRole('system_operator') ){
                        //$search = $F->toMayus($search);
                        $this->tableName = 'usuarios';
                        $total = User::all()->count();
                        $items = User::select('id','username','nombre_completo','email')
                            ->orWhere('username','LIKE',"%{$search}%")
                            ->orWhere('nombre_completo','LIKE',"%{$search}%")
                            ->orWhere('email','LIKE',"%{$search}%")
                            ->get()
                            ->sortByDesc('id');
                        $items = $total == count($items) ? collect(new User) : $items;
                    }else{
                        throw new AuthorizationException();
                    }
                    break;
                case 11:
                    if ( Auth::user()->isAdmin() ){
                        $this->tableName = 'roles';
                        $total = Role::all()->count();
                        $items = Role::select('id','name')
                            ->orWhere('name','LIKE',"%{$search}%")
                            ->get()
                            ->sortByDesc('id');
                        $items = $total == count($items) ? collect(new Role) : $items;
                    }else{
                        throw new AuthorizationException();
                    }
                    break;
                case 12:
                    if ( Auth::user()->isAdmin() ){
                        $this->tableName = 'permissions';
                        $total = Permissions::all()->count();
                        $items = Permissions::select('id','name')
                            ->orWhere('name','LIKE',"%{$search}%")
                            ->get()
                            ->sortByDesc('id');
                        $items = $total == count($items) ? collect(new Permission) : $items;
                    }else{
                        throw new AuthorizationException();
                    }
                    break;
                default:
                    throw new NotFoundHttpException();
                    break;
            }


        }else{
            $items = [];
        }

        $user = Auth::User();
        return view ('catalogos.side_bar_right',
            [
                'items' => $items,
                'id' => $id,
                'titulo_catalogo' => "Catálogo de ".ucwords($this->tableName),
                'user' => $user,
                'tableName'=>$this->tableName,
                'npage'=> 1,
                'tpaginas' => 0,
            ]
        );
    }

    public function ajaxIndex($id=0){
        switch ($id) {
            case 0:
                $items = Editorial::all()->sortByDesc('id',1);
                break;
            case 1:
                $items = Ficha::select('id','titulo', 'autor')
                    ->orderBy('id','desc')
                    ->get();
                break;
            case 2:
                $items = Codigo_Lenguaje_Pais::select('id','idmig','codigo','lenguaje', 'tipo')
                    ->orderBy('id','desc')
                    ->get();
                break;
            case 10:
                if ( Auth::user()->isAdmin() || Auth::user()->hasRole('system_operator') ){
                    $items = User::select('id','username', 'nombre_completo','email')
                        ->orderBy('id','desc')
                        ->get();
                }else{
                    throw new AuthorizationException();
                }
                break;
            case 11:
                if ( Auth::user()->isAdmin() ){
                    $items = Role::select('id','name')
                        ->orderBy('id','desc')
                        ->get();
                }else{
                    throw new AuthorizationException();
                }
                break;
            case 12:
                if ( Auth::user()->isAdmin() ){
                    $items = Permissions::select('id','name')
                        ->orderBy('id','desc')
                        ->get();
                }else{
                    throw new AuthorizationException();
                }
                break;
            default:
                throw new NotFoundHttpException();
                break;
        }
        $dataTable = Datatables::of($items)->make(true);
        return Response::json(['data' => $items, 'dataTable'=>$dataTable, 'status' => '200'], 200);
    }

}
