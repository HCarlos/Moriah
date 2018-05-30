<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\VentaDetalle;
use Illuminate\Support\Facades\Response;

class VentaDetalleController extends Controller
{


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
