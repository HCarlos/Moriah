<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Http\Requests\NotaCreditoRequest;
use App\Models\SIIFAC\NotaCredito;
use App\Models\SIIFAC\Venta;
use App\Models\SIIFAC\VentaDetalle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Database\Eloquent\Collection;

class NotaCreditoController extends Controller{
    protected $tableName = 'notas_credito';
    protected $redirectTo = '/home';
    protected $Empresa_Id = 0;
    protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
    }

    public function index($fecha)
    {
        if (is_null($fecha)){
            abort(500);
        }
        $user = Auth::User();
        $F = (new FuncionesController);

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $f = $F->getFechaFromNumeric($fecha);
        $f1 =  Carbon::createFromFormat('Y-m-d', $f)->toDateString();
        $f2 =  Carbon::createFromFormat('Y-m-d', $f)->toDateString();
        $items = NotaCredito::all()
            ->where('empresa_id',$this->Empresa_Id)
            ->where('fecha','>=', $f1)
            ->where('fecha','<=', $f2)
            ->sortByDesc('id');
        $totalVenta = 0;
        foreach ($items as $i){
            $totalVenta += $i->importe;
        }
//        dd($items);
        return view ('catalogos.operaciones.notasdecredito',
            [
                'tableName' => 'Nota_de_Credito',
                'notasCredito' => $items,
                'user' => $user,
                'totalVentas' => number_format($totalVenta,2,'.',',') ,
                'fecha' => $F->fechaEspanol($f),
            ]
        );
    }

    public function index_post(Request $request)
    {
        $data = $request->all();
        $fecha = $data['fecha'];
        $this->F = (new FuncionesController);
        $fecha = $this->F->setDateTo6Digit($fecha);
        return redirect('/index_notacredito/' . $fecha);

    }

    public function nueva_nota_credito($venta_id,$msg=null){
        $Ven = Venta::select(['id'])
            ->where('id',$venta_id)
            ->where('ispagado',true)
            ->get();

        if ( $Ven->count() > 0){
            $items = VentaDetalle::all()
                ->where('venta_id',$venta_id)
                ->sortBy('id');

            $Venta = Venta::find($venta_id);

            if ($msg==null)
                if ($items->count() <= 0) $msg = "Nota de Venta, NO existe";

            if ($msg==null)
                if ( !Venta::ICanCreateNotaCredito($venta_id) ) $msg = "Nota se puede crear una Nota de Crédito de este Folio de Venta.";

        }else{
            $items = new Collection();
            $msg = "La Nota no existe ó no ha sido pagada.";
            $Venta = $Ven;
        }

        $user = Auth::User();

        return view ('catalogos.operaciones.notasdecredito_detalles',
            [
                'tableName' => 'Nota_de_Credito_Detalle',
                'user' => $user,
                'items' => $items,
                'venta_id' => $venta_id,
                'venta' => $Venta,
                'id' => 0,
                'message' => $msg,
            ]
        );
    }

    public function nueva_nota_credito_put(Request $request){
        $data = $request->all();
        $venta_id = $data['venta_id'];
        return $this->nueva_nota_credito($venta_id,null);
    }

    public function guardar_notacredito(NotaCreditoRequest $request){
        $data = $request->all();

        if ( !isset($data['vd_id']) ){
            $venta_id = $data['venta_id'];

            return $this->nueva_nota_credito($venta_id,'No hay datos que guardar');
        }

        $msg = $request->manage();
        if ($msg == "OK"){
            $fecha = Carbon::now()->format('ymd');
            return redirect('index_notacredito/'. $fecha);
        }else{
            $data = $request->all();
            $venta_id = $data['venta_id'];
            return $this->nueva_nota_credito($venta_id,$msg);
        }

    }


}
