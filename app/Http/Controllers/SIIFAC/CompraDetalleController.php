<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Compra;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Proveedor;
use App\Models\SIIFAC\Venta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;

class CompraDetalleController extends Controller
{
    protected $Empresa_Id = 0;

    public function __construct(){
        $this->middleware('auth');
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
        $this->F = (new FuncionesController);
    }

    public function index($compra_id){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $compra = Compra::find($compra_id);

        if ($compra) {
            $items = Movimiento::all()->where('compra_id', $compra_id);
            $total = $compra->total;

            $user = Auth::User();

            return view('catalogos.operaciones.compras.compra_detalles',
                [
                    'tableName' => 'compra_detalles',
                    'compra' => $items,
                    'Compra' => $compra,
                    'user' => $user,
                    'compra_id' => $compra_id,
                    'totalCompra' => $total,
                    'Url' => '/form_compra_detalle_nueva_ajax',
                ]
            );
        }else{
            return redirect('/index_compra');
        }
    }

    public function new_compra_detalle_ajax($compra_id)
    {
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views       = 'agregar_producto_a_compra_ajax';
        $user        = Auth::User();
        $Almacenes   = Almacen::all()->where('empresa_id',$this->Empresa_Id)->sortBy('descripcion')->pluck('descripcion', 'id');
        $Proveedores = Proveedor::all()->where('empresa_id',$this->Empresa_Id)->sortBy('nombre_proveedor')->pluck('nombre_proveedor', 'id');
        $Productos   = Producto::all()->where('empresa_id',$this->Empresa_Id)->sortBy('descripcion')->pluck('descripcion', 'codigo');
        $oView = 'catalogos.operaciones.compras.';
//        dd($oView.$views);
        return view ($oView.$views,
            [
                'user'        => $user,
                'Almacenes'   => $Almacenes,
                'Proveedores' => $Proveedores,
                'Productos'   => $Productos,
                'compra_id'   => $compra_id,
                'empresa_id'  => $this->Empresa_Id,
                'Url'         => '/store_compra_detalle_ajax',
            ]
        );
    }

    public function store_compra_detalle_ajax(Request $request)
    {
        $data = $request->all();
        $codigo       = $data['codigo'];
        $Prod         = Producto::all()->where('codigo',$codigo)->first();
        $user         = Auth::user();
        if ($Prod !== null){
            try {
                $mensaje = "OK";
                $producto_id = $Prod->id;
                Producto::ActualizaDatosDesdeCompras($producto_id,$data);
            }
            catch(QueryException $e){
                $mensaje = "Error: ".$e->getMessage();
            }
        }else{
            $mensaje = "Error: PRODUCTO NO ENCONTRADO";
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function destroy($id=0){

        $mv = Movimiento::findOrFail($id);
        $Prod = Producto::find($mv->producto_id);
        $mv->forceDelete();
        Movimiento::actualizaExistenciasYSaldo($Prod);
        $Comp = Compra::find($mv->compra_id);
        Movimiento::ActualizarCompraDesdeDetalles($Comp);

        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }




}
