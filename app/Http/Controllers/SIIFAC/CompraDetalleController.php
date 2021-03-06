<?php

namespace App\Http\Controllers\SIIFAC;

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

class CompraDetalleController extends Controller
{

    public function index($compra_id)
    {
//        dd($compra_id);
        $compra = Compra::find($compra_id);

        if ($compra) {
            $items = Movimiento::all()->where('compra_id', $compra_id);
            $total = $compra->total;

            //dd($items);
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
        $views       = 'agregar_producto_a_compra_ajax';
        $user        = Auth::User();
        $Empresas    = Empresa::all()->sortBy('rs')->pluck('rs', 'id');
        $Almacenes   = Almacen::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $Proveedores = Proveedor::all()->sortBy('nombre_proveedor')->pluck('nombre_proveedor', 'id');
        $Productos   = Producto::all()->sortBy('descripcion')->pluck('descripcion', 'codigo');
        $oView = 'catalogos.operaciones.compras.';
        return view ($oView.$views,
            [
                'user'        => $user,
                'Empresas'    => $Empresas,
                'Almacenes'   => $Almacenes,
                'Proveedores' => $Proveedores,
                'Productos'   => $Productos,
                'compra_id'   => $compra_id,
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

        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }




}
