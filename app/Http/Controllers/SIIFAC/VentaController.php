<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\Pedido;
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
   protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->F = (new FuncionesController);
    }

    public function index($fecha)
    {
        $F = (new FuncionesController);
        $f = $F->getFechaFromNumeric($fecha);
        $f1 =  Carbon::createFromFormat('Y-m-d', $f)->toDateString().' 00:00:00';
        $f2 =  Carbon::createFromFormat('Y-m-d', $f)->toDateString().' 23:59:59';
        $items = Venta::all()
            ->where('fecha','>=', $f1)
            ->where('fecha','<=', $f2)
            ->sortBy('id');
//        dd($items);
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
                'fecha' => $F->fechaEspanol($f),
            ]
        );
    }

    public function index_post(Request $request)
    {
        $data = $request->all();
        $fecha = $data['fecha'];
        $fecha = $this->F->setDateTo6Digit($fecha);
        return $this->index($fecha);
    }


    public function new_paquete_ajax()
    {
        $views  = 'venta_nueva_paquete_ajax';
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
                'Url' => '/store_venta_paquete_ajax',
            ]
        );
    }

    public function new_pedido_ajax()
    {
        $views  = 'venta_nueva_pedido_ajax';
        $user = Auth::User();
        $oView = 'catalogos.operaciones.';
        $Pedidos = Pedido::all()->sortBy('FullDescriptionPedidoUser')->pluck('FullDescriptionPedidoUser', 'id');
//        dd($Pedidos);
        return view ($oView.$views,
            [
                'user' => $user,
                'Pedidos' => $Pedidos,
                'Url' => '/store_venta_pedido_ajax',
            ]
        );
    }

    public function store_paquete_ajax(Request $request)
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

    public function store_pedido_ajax(Request $request)
    {
        $data      = $request->all();
        $pedido_id = $data['pedido_id'];
        $Ped       = Pedido::find($pedido_id);
        $tipoventa = $data['tipoventa'];
        $user_id   = $Ped->user_id;
        $cantidad  = $data['cantidad'];
        $user = Auth::user();
        try {
            $mensaje = "OK";
            Venta::venderPedido($user->id,$pedido_id,$tipoventa,$user_id,$cantidad);
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
//        $venta->detach($id);
        $ventaDetalle = VentaDetalle::where('venta_id',$id);
        $ventaDetalle->forceDelete();
        $Mov = Movimiento::where('venta_id',$id);
        $Mov->forceDelete();

        //        $ventaDetalle->detach();
        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
    }

}
