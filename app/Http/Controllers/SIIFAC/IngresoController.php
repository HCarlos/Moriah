<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Venta;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use mysql_xdevapi\Exception;

class IngresoController extends Controller
{

    protected $tableName = 'ingresos';
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

    public function index($fecha)
    {
        if (is_null($fecha)){
            abort(500);
        }

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $user = Auth::User();
        $F = (new FuncionesController);
        $f = $F->getFechaFromNumeric($fecha);
        // dd($f);
        $f1 =  Carbon::createFromFormat('Y-m-d', $f)->toDateString().' 00:00:00';
        $f2 =  Carbon::createFromFormat('Y-m-d', $f)->toDateString().' 23:59:59';
        $items = Ingreso::all()
            ->where('empresa_id',$this->Empresa_Id)
            ->where('f_pagado','>=', $f1)
            ->where('f_pagado','<=', $f2)
            ->sortBy('id');
    //    dd($items);
        $totalVenta = 0;
        foreach ($items as $i){
            $totalVenta += $i->total;
        }
    //    dd($totalVenta);
    //    dd($items);

        return view('catalogos.operaciones.ingresos.ingresos',
            [
                'tableName' => 'Ingresos',
                'ingresos' => $items,
                'Ingreso' => $totalVenta,
                'user' => $user,
                'totalIngresos' => number_format($totalVenta,2,'.',',') ,
                'fecha' => $F->fechaEspanol($f),
            ]
        );

    }

    public function index_post(Request $request)
    {
        $data = $request->all();
        $fecha = $data['fecha'];
        $fecha = $this->F->setDateTo6Digit($fecha);

        return redirect('/index_ingreso/' . $fecha );

    }

    public function destroy($id=0){
        $msg = "Ingreso eliminado con éxito";
        $OK = "OK";
        try {

            $Ing = Ingreso::find($id);
            if ( intval($Ing->metodos_pagos) == 5){
                $OK = "Error";
                $msg = "No se puede eliminar el ingreso de una Nota de Crédito";
            }else{
                $vID = $Ing->venta_id;
                $Ing->forceDelete();
                $Ven = Venta::find($vID);
                $Ven->ispagado = false;
                $Ven->f_pagado = null;
                $Ven->total_pagado = Venta::getTotalAbonosIngresos($vID);
                $Ven->save();
            }
        }catch (Exception $e){
            $msg = $e->getMessage();
        }
        return Response::json(['mensaje' => $msg, 'data' => $OK, 'status' => '200'], 200);
    }



}
