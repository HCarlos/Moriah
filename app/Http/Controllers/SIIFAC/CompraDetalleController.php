<?php

namespace App\Http\Controllers\SIIFAC;

use App\Models\SIIFAC\Compra;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Venta;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CompraDetalleController extends Controller
{

    public function index($compra_id)
    {
//        dd($compra_id);
        $compra = Compra::find($compra_id);
        $items = Movimiento::all()->where('compra_id', $compra_id);
        $total =  $compra->total;

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
    }

    public function new_compra_detalle_ajax($compra_id)
    {
        $views = 'agregar_producto_a_compra_ajax';
        $user  = Auth::User();
        $oView = 'catalogos.operaciones.compras.';
        return view ($oView.$views,
            [
                'user'     => $user,
                'compra_id' => $compra_id,
                'Url'      => '/store_compra_detalle_ajax',
            ]
        );
    }

    public function store_compra_detalle_ajax(Request $request)
    {
        $data = $request->all();
//        $data['tipoventa']       = isset($data['tipoventa']) ? 1 : 0;
        $cantidad  = $data['cantidad'];
        $codigo    = $data['codigo'];
        $compra_id = $data['compra_id'];
        $Prod      = Producto::all()->where('codigo',$codigo)->first();
        $user      = Auth::user();
        if ($Prod !== null){
            try {
                $mensaje = "OK";
                $producto_id = $Prod->id;
                Compra::compra($compra_id,$producto_id,$cantidad);
            }
            catch(LogicException $e){
                $mensaje = "Error: ".$e->getMessage();
            }
        }else{
            $mensaje = "Error: PRODUCTO NO ENCONTRADO";
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

}
