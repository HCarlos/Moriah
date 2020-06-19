<?php

namespace App\Http\Controllers\SIIFAC;

use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\PedidoDetalle;
use App\Models\SIIFAC\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use LogicException;

class PedidoDetalleController extends Controller
{
    protected $itemPorPagina = 50;
    protected $otrosDatos;
    protected $Predeterminado = false;
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($id = 0)
    {

        $this->tableName = 'pedidos';
        $paq = Pedido::find($id);

        $items = PedidoDetalle::select('id','pedido_id','user_id','producto_id','medida_id','codigo','descripcion_producto','cant','pv','comp1','empresa_id')
            ->where('pedido_id',$id)
            ->orderBy('id','desc')
            ->paginate();

        $user = Auth::User();

        $items->appends(request(['search']))->fragment('table');
        $items->links();

        return view ('catalogos.listados.pedido_detalles_list',
            [
                'idItem' => $id,
                'items' => $items,
                'titulo_catalogo' => "Elementos de ".$paq->descripcion_pedido,
                'user' => $user,
                'tableName'=>$this->tableName,
            ]
        );

    }

    public function new_ajax($pedido_id=0)
    {
        $views  = 'pedido_detalle_new_ajax';
        $user = Auth::User();
        $oView = 'catalogos.';
        $Productos = Producto::all()->sortBy('descripcion')->pluck('FullDescription','id');
        return view ($oView.$views,
            [
                'pedido_id' => $pedido_id,
                'titulo' => 'detalles pedido',
                'user' => $user,
                'Productos' => $Productos,
                'Url' => '/store_pedido_detalle_ajax',
            ]
        );
    }

    public function store_ajax(Request $request)
    {
        $data        = $request->all();
        $pedido_id  = $data['pedido_id'];
        $producto_id = $data['producto_id'];

//        dd($pedido_id.', '.$producto_id);

        $ped = Pedido::find($pedido_id);
        try {
            $mensaje = "OK";
            PedidoDetalle::findOrCreatePedidoDetalle($pedido_id,0, $ped->user_id,$ped->empresa_id, $producto_id);
            $dets = PedidoDetalle::all()->where('pedido_id',$pedido_id);
            Pedido::UpdateImporteFromPedidoDetalle($dets);
        }
        catch(LogicException $e){
            $mensaje = "Error: ".$e->getMessage();
        }

        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function destroy($id=0){

        $pd = PedidoDetalle::findOrFail($id);
        $pd->forceDelete();

        $prod = Producto::find($pd->producto_id);
        $paq = Pedido::find($pd->pedido_id);
        $dets = PedidoDetalle::all()->where('pedido_id',$pd->pedido_id);
        $paq::UpdateImporteFromPedidoDetalle($dets);

        $pd->productos()->detach($prod);
        $paq->productos()->detach($prod);

        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }
}
