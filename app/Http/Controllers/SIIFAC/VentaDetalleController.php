<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Venta;
use App\Models\SIIFAC\VentaDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use LogicException;

//use Maatwebsite\Excel\Facades\Excel;

class VentaDetalleController extends Controller
{
    protected $Empresa_Id = 0;

    public function __construct(){
        $this->middleware('auth');
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
    }

    public function new_venta_detalle_ajax($venta_id){
        $views = 'agregar_producto_a_venta_ajax';
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
        $user  = Auth::User();
        $oView = 'catalogos.operaciones.';
//        $venta = Venta::find($venta_id);
        $Productos   = Producto::query()
            ->where('empresa_id', $this->Empresa_Id)
            ->orderBy('descripcion')
            ->pluck('descripcion', 'codigo');

        //dd($venta);
        return view ($oView.$views,
            [
                'user' => $user,
                'venta_id'    => $venta_id,
                'Productos'   => $Productos,
                'Url'         => '/store_venta_detalle_normal_ajax',
            ]
        );
    }


    public function store_normal_ajax(Request $request){
        $data        = $request->all();
        $codigo      = $data['codigo'];
        $venta_id    = $data['venta_id'];
        $cantidad    = $data['cantidad'];
        $Prod        = Producto::query()
                        ->where('codigo',$codigo)
                        ->first();
        //dd($Prod);
        if ($Prod !== null){
            $producto_id = $Prod->id;
            $ven         = Venta::findOrFail($venta_id);
            try {
                $mensaje = "OK";
                VentaDetalle::agregarProductoAVenta($ven,$producto_id,$cantidad,$Prod->pv,$Prod->cu);
            }
            catch(LogicException $e){
                $mensaje = "Error: ".$e->getMessage();
            }
        }else{
            $mensaje = "Error: PRODUCTO NO ENCONTRADO";
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function destroy($id=0){
        $vd = VentaDetalle::findOrFail($id);
        $venta_id = $vd->venta_id;
        $vd->forceDelete();

        $Mov = Movimiento::where('venta_detalle_id',$id);
        $Mov->forceDelete();

        VentaDetalle::totalVenta($venta_id);

        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }


}
