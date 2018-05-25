<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class VentaController extends Controller
{
    protected $tableName = 'ventas';
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($fecha)
    {
        $F = (new FuncionesController);
        $f = $F->getFechaFromNumeric($fecha);
        $f =  Carbon::createFromFormat('Y-m-d', $f)->toDateString().' 00:00:00';
        $items = Venta::all()->where('fecha', '>=', $f)->sortBy('id');
//        dd($items);
//        dd($f);

        return view ('catalogos.operaciones.ventas',
            [
                'tableName' => 'ventas',
                'ventas' => $items,
            ]
        );
    }

    public function new_ajax()
    {
        $views  = 'venta_nueva_ajax';
        $user = Auth::User();
        $oView = 'catalogos.operaciones.';
        $Paquetes = Paquete::all()->sortBy('FullDescription')->pluck('FullDescription', 'id');
        return view ($oView.$views,
            [
                'user' => $user,
                'Paquetes' => $Paquetes,
                'Url' => '/store_venta_ajax',
            ]
        );

    }

    public function store_ajax(Request $request)
    {
        $data = $request->all();
        $paquete_id = $data['paquete_id'];
        $tipoventa = $data['tipoventa'];
        $user = Auth::user();
        try {
            $mensaje = "OK";
            Venta::venderPaquete($user->id, $paquete_id,$tipoventa );
        }
        catch(LogicException $e){
            $mensaje = "Error: ".$e->getMessage();
        }

        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);

    }


}
