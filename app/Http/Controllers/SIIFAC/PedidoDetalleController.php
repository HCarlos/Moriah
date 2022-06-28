<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\PedidoDetalle;
use App\Models\SIIFAC\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use LogicException;

class PedidoDetalleController extends Controller
{
    protected $itemPorPagina = 50;
    protected $otrosDatos;
    protected $Predeterminado = false;
    protected $redirectTo = '/home';
    protected $Empresa_Id = 0;

    public function __construct(){
        $this->middleware('auth');
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
    }

    public function index($id = 0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $this->tableName = 'pedidos';
        $paq = Pedido::find($id);

        $items = PedidoDetalle::select('id','pedido_id','user_id','producto_id','medida_id','codigo','descripcion_producto','cant','pv','comp1','empresa_id')
            ->where('empresa_id', $this->Empresa_Id)
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

    public function new_ajax($pedido_id=0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views  = 'pedido_detalle_new_ajax';
        $user = Auth::User();
        $oView = 'catalogos.';
        $Productos = Producto::all()
            ->where('empresa_id',$this->Empresa_Id)
            ->sortBy('descripcion')
            ->pluck('FullDescription','id');
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

    public function store_ajax(Request $request){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data        = $request->all();
//        dd($data);
        $pedido_id  = $data['pedido_id'];
        $producto_id = $data['producto_id'];
        $cantidad    = $data['cantidad'];

//        dd($pedido_id.', '.$producto_id);

        $ped = Pedido::find($pedido_id);
//        dd($ped);
        try {
            $mensaje = "OK";
            PedidoDetalle::findOrCreatePedidoDetalle($pedido_id,0, $ped->user_id,$ped->empresa_id, $producto_id,$cantidad);
            $dets = PedidoDetalle::all()
                ->where('empresa_id', $this->Empresa_Id)
                ->where('pedido_id', $pedido_id);
            $pq = Pedido::UpdateImporteFromPedidoDetalle($pedido_id);
//            dd($pq);
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
        $ped = Pedido::find($pd->pedido_id);
        // $dets = PedidoDetalle::all()->where('pedido_id',$pd->pedido_id);
        Pedido::UpdateImporteFromPedidoDetalle($pd->pedido_id);

        $pd->productos()->detach($prod);
        $ped->productos()->detach($prod);

        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }
}
