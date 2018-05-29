<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\Venta;
use App\Models\SIIFAC\VentaDetalle;
use App\User;
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
        $totalVenta = 0;
        foreach ($items as $i){
            $totalVenta += $i->total;
        }
        $user = Auth::User();

        return view ('catalogos.operaciones.ventas',
            [
                'tableName' => 'ventas',
                'ventas' => $items,
                'user' => $user,
                'totalVentas' => $totalVenta,
            ]
        );
    }

    public function new_ajax()
    {
        $views  = 'venta_nueva_ajax';
        $user = Auth::User();
        $oView = 'catalogos.operaciones.';
        $Paquetes = Paquete::all()->sortBy('FullDescription')->pluck('FullDescription', 'id');
        $clientes = User::whereHas('roles', function($q){
            $q->where('name', 'usuario_libros');
        })->get();
        $clientes->each(function ($model) { $model->setAppends(['FullName']); });
        $User_Id = $clientes->sortBy('FullName')->pluck('FullName','id');

        return view ($oView.$views,
            [
                'user' => $user,
                'Paquetes' => $Paquetes,
                'User_Id' => $User_Id,
                'Url' => '/store_venta_ajax',
            ]
        );

    }

    public function store_ajax(Request $request)
    {
        $data = $request->all();
        $paquete_id = $data['paquete_id'];
        $tipoventa  = $data['tipoventa'];
        $user_id    = $data['user_id'];
        $cantidad    = $data['cantidad'];
        $user = Auth::user();
        try {
            $mensaje = "OK";
            Venta::venderPaquete($user->id,$paquete_id,$tipoventa,$user_id,$cantidad);
        }
        catch(LogicException $e){
            $mensaje = "Error: ".$e->getMessage();
        }

        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);

    }

    public function edit($venta_id)
    {
        $venta = Venta::find($venta_id);
        $items = VentaDetalle::all()->where('venta_id',$venta_id);
        // dd($items);
        $user = Auth::User();

        return view ('catalogos.operaciones.venta_detalles',
            [
                'tableName' => 'venta_detalles',
                'venta' => $items,
                'user' => $user,
                'venta_id' => $venta_id,
                'totalVenta' => $venta->total,
            ]
        );
    }


    public function destroy($id=0){
        $venta = Venta::findOrFail($id);
        $venta->forceDelete();
        $ventaDetalle = VentaDetalle::where('venta_id',$id);
        $ventaDetalle->forceDelete();
        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }




}
