<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Medida;
use App\Models\SIIFAC\PaqueteDetalle;
use App\Models\SIIFAC\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Paquete;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use PhpParser\Node\Expr\AssignOp\Concat;


class PaqueteDetalleController extends Controller
{
    protected $tableName = 'paquetes';
    protected $itemPorPagina = 50;
    protected $otrosDatos;
    protected $Predeterminado = false;
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($npage = 1, $tpaginas = 0, $id = 0)
    {
        $page = Input::get('p');
        if ( $page ) $npage = $page;

        $this->tableName = 'paquetes';
        $paq = Paquete::find($id);
        $items = PaqueteDetalle::select('id','paquete_id', 'producto_id', 'medida_id', 'codigo', 'descripcion', 'cant','pv','comp1','empresa_id')
            ->where('paquete_id',$id)
            ->orderBy('id','desc')
            ->forPage($npage,$this->itemPorPagina)
            ->get();
        $tpaginator = Paquete::paginate($this->itemPorPagina,['*'],'p');
        $user = Auth::User();
        $tpaginas = $tpaginas == 0 ? $tpaginator->lastPage() : $tpaginas;
        $tpaginator->withPath("/index_paquete_detalle/$npage/$tpaginas");
        return view ('catalogos.listados.paquete_detalles_list',
            [
                'idItem' => $id,
                'items' => $items,
                'titulo_catalogo' => "Elementos de ".$paq->descripcion_paquete,
                'user' => $user,
                'tableName'=>$this->tableName,
                'npage'=> $npage,
                'tpaginas' => $tpaginas,
            ]
        )->with("paginator" , $tpaginator);

    }

    public function new($paquete_id=0)
    {
        $views  = 'paquete_detalle_new';
        $user = Auth::User();
        $oView = 'catalogos.';
        $Productos = Producto::with('medidas')->orderBy('descripcion')->get();
        foreach($Productos as $prod){
            $prod['descripcion'] = $prod->descripcion.' '.$prod->medida->desc1;
        }

        return view ($oView.$views,
            [
                'paquete_id' => $paquete_id,
                'titulo' => 'detalles paquete',
                'user' => $user,
                'Productos' => $Productos->pluck('descripcion','id'),
            ]
        );

    }

    public function edit($paquete_id=0,$paquete_detalle_id=0)
    {
        $views  = 'paquete_detalle_edit';
        $user = Auth::User();
        $oView = 'catalogos.' ;
        $items = PaqueteDetalle::find($paquete_detalle_id);
        $Productos = Producto::with('medidas')->orderBy('descripcion')->get();
        foreach($Productos as $prod){
            $prod['descripcion'] = $prod->descripcion.' '.$prod->medida->desc1;
        }

        return view ($oView.$views,
            [   'items' => $items,
                'paquete_id' => $paquete_id,
                'titulo' => 'detalles paquete',
                'user' => $user,
                'Productos' => $Productos->pluck('descripcion','id'),
            ]
        );
    }

    public function editajax($paquete_id=0,$paquete_detalle_id=0)
    {
        $views  = 'paquete_detalle_edit_ajax';
        $user = Auth::User();
        $oView = 'catalogos.' ;
        $items = PaqueteDetalle::find($paquete_detalle_id);
        $Productos = Producto::with('medidas')->orderBy('descripcion')->get();
        foreach($Productos as $prod){
            $prod['descripcion'] = $prod->descripcion.' '.$prod->medida->desc1;
        }

        return view ($oView.$views,
            [   'items' => $items,
                'paquete_id' => $paquete_id,
                'titulo' => 'detalles paquete',
                'user' => $user,
                'Productos' => $Productos->pluck('descripcion','id'),
            ]
        );
    }


    public function store(Request $request)
    {

        $data = $request->all();
        $paquete_id  = $data['paquete_id'];
        $producto_id = $data['producto_id'];

        $pd = PaqueteDetalle::findOrCreatePaqueteDetalle($paquete_id,$producto_id);

        return redirect('/edit_paquete_detalle/'.$paquete_id.'/'.$pd->id);

    }

//    public function store(Request $request)
//    {
//
//        $data = $request->all();
//        $paquete_id  = $data['paquete_id'];
//        $producto_id = $data['producto_id'];
//
//        $pd = PaqueteDetalle::findOrCreatePaqueteDetalle($paquete_id,$producto_id);
//
//        return redirect('/edit_paquete_detalle/'.$paquete_id.'/'.$pd->id);
//
//    }


    public function update(Request $request, PaqueteDetalle $pd)
    {
        $data = $request->all();
        $paquete_id  = $data['paquete_id'];
        $producto_id = $data['producto_id'];
        $paquete_detalle_id = $pd->id;
        $producto_id_old = $pd->producto_id;
        $pd->updatePaqueteDetalle($paquete_id,$paquete_detalle_id,$producto_id,$producto_id_old);
        return redirect('/edit_paquete_detalle/'.$paquete_id.'/'.$paquete_detalle_id);
    }

//    public function updateajax(Request $request, PaqueteDetalle $pd)
    public function updateajax()
    {

        $paquete_detalle_id = $_GET['paquete_detalle_id'];
        $paquete_id  = $_GET['paquete_id'];
        $producto_id = $_GET['producto_id'];
        $producto_id_old = $_GET['producto_id_old'];

        $pd = PaqueteDetalle::find($paquete_detalle_id);
        try {
            $mensaje = "OK";
            $pd->updatePaqueteDetalle($paquete_id, $paquete_detalle_id, $producto_id, $producto_id_old);
        }
        catch(\Illuminate\Database\QueryException $e){
            $mensaje = "Error: ".$e->getMessage();
        }

        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);

    }


    public function destroy($id=0){

            $pd = PaqueteDetalle::findOrFail($id);
            $pd->forceDelete();

            $paq = Paquete::find($pd->paquete_id);
            $prod = Producto::find($pd->producto_id);

            $pd->productos()->detach($prod);
            $paq->productos()->detach($prod);

            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }


}