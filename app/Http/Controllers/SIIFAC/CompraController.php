<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Compra;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CompraController extends Controller
{
    protected $tableName = 'compras';
    protected $redirectTo = '/home';
    protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->F = (new FuncionesController);
    }

    public function index()
    {
        $user = Auth::User();
        $items = Compra::all()->sortByDesc('id');

        return view ('catalogos.operaciones.compras.compras',
            [
                'tableName' => 'compras',
                'compras' => $items,
                'user' => $user,
            ]
        );
    }

    public function nueva_compra_ajax(){
        $views       = 'compra_nueva_ajax';
        $user        = Auth::User();
        $oView       = 'catalogos.operaciones.compras.';
        $Empresas    = Empresa::all()->sortBy('rs')->pluck('rs', 'id');
        $Almacenes   = Almacen::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $Proveedores = Proveedor::all()->sortBy('nombre_proveedor')->pluck('nombre_proveedor', 'id');
        return view ($oView.$views,
            [
                'Empresas'    => $Empresas,
                'Almacenes'   => $Almacenes,
                'Proveedores' => $Proveedores,
                'user'        => $user,
                'Url'         => '/store_compra_nueva_ajax',
            ]
        );
    }

    public function store_compra_nueva_ajax(Request $request)
    {
        $data = $request->all();
        $data['fecha'] = now();
        try {
            $mensaje = "OK";
            Compra::create($data);
        }
        catch(LogicException $e){
            $mensaje = "Error: ".$e->getMessage();
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function editar_compra_ajax($compra_id){
        $views       = 'compra_editar_ajax';
        $user        = Auth::User();
        $oView       = 'catalogos.operaciones.compras.';
        $Compra      = Compra::find($compra_id);
        $Empresas    = Empresa::all()->sortBy('rs')->pluck('rs', 'id');
        $Almacenes   = Almacen::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $Proveedores = Proveedor::all()->sortBy('nombre_proveedor')->pluck('nombre_proveedor', 'id');
        return view ($oView.$views,
            [
                'Empresas'    => $Empresas,
                'Almacenes'   => $Almacenes,
                'Proveedores' => $Proveedores,
                'compra'      => $Compra,
                'user'        => $user,
                'Url'         => '/store_compra_editada_ajax',
            ]
        );
    }

    public function store_compra_editada_ajax(Request $request)
    {
        $data = $request->all();

        try {
            $mensaje                  = "OK";
            $Comp                     = Compra::findOrFail($data['compra_id']);
            $Comp->empresa_id         = $data['empresa_id'];
            $Comp->proveedor_id       = $data['proveedor_id'];
            $Comp->almacen_id         = $data['almacen_id'];
            $Comp->folio_factura      = $data['folio_factura'];
            $Comp->nota_id            = $data['nota_id'];
            $Comp->descripcion_compra = $data['descripcion_compra'];
            $Comp->save();
        }
        catch(LogicException $e){
            $mensaje = "Error: ".$e->getMessage();
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }




}
