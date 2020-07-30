<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Venta;
use App\Models\SIIFAC\VentaDetalle;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;

class VentaController extends Controller
{
    protected $tableName = 'ventas';
    protected $redirectTo = '/home';
    protected $FechaInicial = '';
    protected $FechaFinal = '';

   protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->F = (new FuncionesController);

    }

    public function index($fecha)
    {
        if (is_null($fecha)){
            abort(500);
        }
        Log::alert($fecha);
        $user = Auth::User();
        $F = (new FuncionesController);
        $f = $F->getFechaFromNumeric($fecha);
        $f1 =  Carbon::createFromFormat('Y-m-d', $f)->toDateString().' 00:00:00';
        $f2 =  Carbon::createFromFormat('Y-m-d', $f)->toDateString().' 23:59:59';

        //dd($f1.' => '.$f2.' | '.$user->id);

        $arr = array(1,$user->id);

        $items = Venta::all()
            ->where('fecha','>=', $f1)
            ->where('fecha','<=', $f2)
            ->sortBy('id');
        

            // dd($items);

        $totalVenta = 0;
        foreach ($items as $i){
            $totalVenta += $i->total;
        }

        Session::put('items', $items);
        $this->FechaInicial = $f1;
        $this->FechaFinal   = $f2;

        return view ('catalogos.operaciones.ventas',
            [
                'tableName' => 'ventas',
                'ventas' => $items,
                'items' => $items,
                'user' => $user,
                'totalVentas' => number_format($totalVenta,2,'.',',') ,
                'fecha' => $F->fechaEspanol($f),
                'FechaInicial' => $this->FechaInicial,
                'FechaFinal' => $this->FechaFinal,
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
        $Pedidos = Pedido::all()
                    ->where('isactivo',true)
                    ->sortByDesc('id')
                    ->pluck('FullDescriptionPedidoUser', 'id');
//        dd($Pedidos);
        return view ($oView.$views,
            [
                'user' => $user,
                'Pedidos' => $Pedidos,
                'Url' => '/store_venta_pedido_ajax',
            ]
        );
    }

    public function new_normal_ajax()
    {
        $views  = 'venta_nueva_normal_ajax';
        $user = Auth::User();
        $oView = 'catalogos.operaciones.';
        $clientes = User::whereHas('roles', function($q){
            $q->where('name', 'usuario_libros');
        })->get();
        $clientes->each(function ($model) { $model->setAppends(['FullName']); });
        $User_Id = $clientes->sortBy('FullName')->pluck('FullName','id');
        $Productos   = Producto::all()->sortBy('descripcion')->pluck('descripcion', 'codigo');
        $Productos->prepend('Seleccione un producto', '0');
        return view ($oView.$views,
            [
                'user' => $user,
                'User_Id' => $User_Id,
                'Productos' => $Productos,
                'Url' => '/store_venta_normal_ajax',
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
        catch(QueryException $e){
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
        catch(QueryException $e){
            $mensaje = "Error: ".$e->getMessage();
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function store_normal_ajax(Request $request)
    {
        $data = $request->all();
//        $data['tipoventa']       = isset($data['tipoventa']) ? 1 : 0;
        $tipoventa = $data['tipoventa'];
        $user_id   = $data['user_id'];
        $cantidad  = $data['cantidad'];

        $codigo    = $data['codigo'];
        $Prod      = Producto::all()->where('codigo',$codigo)->first();
        $user      = Auth::user();
        if ($Prod !== null){
            try {
                $mensaje = "OK";
                $producto_id = $Prod->id;
                Venta::venderNormal($user->id,$producto_id,$tipoventa,$user_id,$cantidad);
            }
            catch(QueryException $e){
                $mensaje = "Error: ".$e->getMessage();
            }
        }else{
            $mensaje = "Error: PRODUCTO NO ENCONTRADO";
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function edit($venta_id)
    {
        $venta = Venta::findOrFail($venta_id);
        if ($venta !== null) {
            $items = VentaDetalle::all()->where('venta_id', $venta_id);
            // dd($venta);
            $user = Auth::User();

            return view('catalogos.operaciones.venta_detalles',
                [
                    'tableName' => 'venta_detalles',
                    'venta' => $items,
                    'Venta' => $venta,
                    'user' => $user,
                    'venta_id' => $venta_id,
                    'paquete_id' => $venta->paquete_id,
                    'pedido_id' => $venta->pedido_id,
                    'totalVenta' => $venta->total,
                    'abonoVenta' => $venta->total_pagado,
                    'Url' => '/add_venta_detalle_normal_ajax',
                ]
            );
        } else {
            abort(404);
        }

    }

    public function call_pagar_venta_ajax($venta_id)
    {
        $oView  = 'catalogos.operaciones.';
        $views  = 'pagar_venta_ajax';
        $venta  = Venta::findOrFail($venta_id);
        $abono  = Ingreso::Abonos($venta_id);
        $apagar = $venta->total - $abono;
        $metodo_pagos = Venta::$metodos_pago;
        $user  = Auth::User();
        return view ($oView.$views,
            [
                'user'          => $user,
                'venta'         => $venta,
                'venta_id'      => $venta_id,
                'total'         => $venta->total,
                'total_abonos'  => $abono,
                'metodo_pagos'  => $metodo_pagos,
                'total_a_pagar' => $apagar,
                'Url'      => '/pagar_venta_ajax',
            ]
        );
    }

    public function pagar_venta_ajax(Request $request)
    {
        $data          = $request->all();
        $total         = $data['total'];
        $total_pagado  = $data['total_pagado'];
        $total_a_pagar = $data['total_a_pagar'];
        $metodo_pago   = $data['metodo_pago'];
        $referencia    = $data['referencia'];
        $venta_id      = $data['venta_id'];
        $mensaje       = "OK";
//        dd($total_pagado);
        Venta::pagarVenta($venta_id,$total_a_pagar,$total_pagado,$metodo_pago,$referencia);
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function llamar_busquedaIndividual($tipo){
        switch ($tipo){
            case 0:
                $ctipo = 'Venta ID';
                $ctype = 'Busqueda por Venta ID';
                break;
            case 1:
                $ctipo = 'Cliente';
                $ctype = 'Busqueda por Cliente';
                break;
            case 2:
                $ctipo = 'Producto';
                $ctype = 'Búsqueda de Producto';
                break;
            case 3:
                $ctipo = 'Código';
                $ctype = 'Búsqueda de Código de Producto';
                break;
        }
        return view (
            'catalogos.operaciones.busquedas.busqueda_individual_1',
            ['tipo'=>$ctipo,'type'=>$tipo,'placeholder'=>$ctype]
        );
    }

    public function busquedaIndividual(Request $request)
    {
        $data = $request->all();
        $dato = $data['dato'];
        $tipo = $data['type'];
        $user = Auth::User();
        $user = User::find($user->id);
        switch ($tipo){
            case 0:
                $items = Venta::select()
                    ->where('id',$dato)
                    ->where(function ($q) use($user) {
                        if (!$user->hasRole('administrator|sysop'))
                            $q->where('vendedor_id', $user->id);
                    })
                    ->orderBy('created_at')
                    ->get();
                break;
            case 1:
                $items = Venta::BuscarClientePorNombreCompleto($dato,$user);
                break;
            case 2:
                $items = Venta::BuscarProductoPorNombre($dato,$user);
                break;
            case 3:
                $items = Venta::BuscarProductoPorCodigo($dato,$user);
                break;
        }
        return view ('catalogos.operaciones.ventas',
            [
                'tableName' => 'ventas',
                'ventas' => $items,
                'user' => $user,
                'totalVentas' => 0,
                'fecha' => $dato,
            ]
        );
    }



    public function llamar_venta_en_fecha(){
        return view (
            'catalogos.operaciones.busquedas.busqueda_venta_en_fecha'
        );
    }

    public function ventas_rango_fechas(Request $request)
    {
        $F = (new FuncionesController);

        $data = $request->all();
        $f1 = $F->fechaDateTimeFormat($data['fecha1']);
        $f2 = $F->fechaDateTimeFormat($data['fecha2'],true);

        $dato = "Desde ".$f1." Hasta ".$f2;
        $user = Auth::User();
        $user = User::find($user->id);
        $items = Venta::select()
                    ->where('fecha','>=',$f1)
                    ->where('fecha','<=',$f2)
                    ->where(function ($q) use($user) {
                        if (!$user->hasRole('administrator|sysop'))
                            $q->where('vendedor_id', $user->id);
                    })
                    ->orderBy('created_at')
                    ->get();

        return view ('catalogos.operaciones.ventas',
            [
                'tableName' => 'ventas',
                'ventas' => $items,
                'user' => $user,
                'totalVentas' => 0,
                'fecha' => $dato,
            ]
        );
    }

    public function call_show_prop_ajax($venta_id)
    {
        $F = (new FuncionesController);

        $oView  = 'catalogos.operaciones.ficha_propiedades.';
        $views  = 'venta_propiedades';
        $venta  = Venta::findOrFail($venta_id);
        $user  = Auth::User();

        return view ($oView.$views,
            [
                'user'   => $user,
                'venta'  => $venta,
                'fecha'  => Carbon::parse($venta->fecha)->format('d-m-Y h:m:s a'),
                'Abonos' => $venta->Abonos,
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
