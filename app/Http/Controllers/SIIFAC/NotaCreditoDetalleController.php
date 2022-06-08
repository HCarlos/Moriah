<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\NotaCredito;
use App\Models\SIIFAC\NotaCreditoDetalle;
use App\Models\SIIFAC\VentaDetalle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;


class NotaCreditoDetalleController extends Controller
{

    protected $tableName = 'nota_credito_detalle';
    protected $redirectTo = '/home';
    protected $Empresa_Id = 0;
    protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
        $this->F = (new FuncionesController);
    }

    public function index($nota_credito_id)
    {
        if (is_null($nota_credito_id)){
            abort(500);
        }

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $user = Auth::User();
        $items = NotaCreditoDetalle::all()
            ->where('empresa_id',$this->Empresa_Id)
            ->where('nota_credito_id', $nota_credito_id)
            ->sortBy('id');
        $totalVenta = 0;
        foreach ($items as $i){
            $totalVenta += $i->importe;
        }
        // dd($nota_credito_id);
        return view ('catalogos.operaciones.notasdecredito_detalles_edit',
            [
                'tableName'       => 'Nota_de_Credito',
                'notasCredito'    => $items,
                'user'            => $user,
                'nota_credito_id' => $nota_credito_id,
                'totalVentas'     => number_format($totalVenta,2,'.',',') ,
                'message'         => null,
            ]
        );
    }

    public function destroy($id=0){
        $OK = "OK";
        try {

            $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
            if ($this->Empresa_Id <= 0){
                return redirect('openEmpresa');
            }

            $ncd = NotaCreditoDetalle::findOrFail($id);
            $notacredito_id = $ncd->nota_credito_id;
            $Ing = Ingreso::all()->where('empresa_id',$this->Empresa_Id)->where('nota_credito_id',$notacredito_id);
            if ( count($Ing) <= 0 ){
                $venta_detalle_id = $ncd->venta_detalle_id;
                $vd = VentaDetalle::find($venta_detalle_id);
                $Mov = Movimiento::quitarDesdeNotaCreditoDetalle($ncd);
                $vd->cantidad_devuelta = $vd->cantidad_devuelta - $ncd->cant;
                $vd->save();
                $ncd->forceDelete();
                $NC = NotaCredito::totalNotaCreditoFromDetalle($notacredito_id);
                if ($NC->importe <= 0){
                    $NC->forceDelete();
                }
                $msg = 'Registro eliminado con éxito';
            }else{
                $msg = 'No se puede quitar el elemento';
                $OK = $msg;
            }
        }catch (\Exception $e){
            $OK = $e->getMessage();
        }

        return Response::json(['mensaje' => $msg, 'data' => $msg, 'status' => '200'], 200);

    }




}
