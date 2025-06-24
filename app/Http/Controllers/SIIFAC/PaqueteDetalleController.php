<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Models\SIIFAC\PaqueteDetalle;
use App\Models\SIIFAC\Producto;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Paquete;
use Exception;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use LogicException;


class PaqueteDetalleController extends Controller
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

        $this->tableName = 'paquete_detalles';
        $paq = Paquete::find($id);
        $items = PaqueteDetalle::select('id','paquete_id', 'producto_id', 'medida_id', 'codigo', 'descripcion', 'cant','pv','comp1','empresa_id')
            ->where('empresa_id',$this->Empresa_Id)
            ->where('paquete_id',$id)
            ->orderBy('id','desc')
            ->paginate();
        $user = Auth::User();
        $items->appends(request(['search']))->fragment('table');
        $items->links();
        return view ('catalogos.listados.paquete_detalles_list',
            [
                'idItem' => $id,
                'items' => $items,
                'titulo_catalogo' => "Elementos de ".$paq->descripcion_paquete,
                'user' => $user,
                'tableName'=>$this->tableName,
            ]
        );

    }

    public function new_ajax($paquete_id=0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views  = 'paquete_detalle_new_ajax';
        $user = Auth::User();
        $oView = 'catalogos.';

//        $Productos = Producto::select('descripcion','pv','id')
//            ->where('empresa_id',$this->Empresa_Id)
//            ->orderBy('descripcion')
//            ->pluck('FullDescription','id');

        $Productos = Producto::select('descripcion','pv','id')
            ->where('empresa_id',$this->Empresa_Id)
            ->orderBy('descripcion')
            ->get() // Obtener la colección completa de modelos
            ->pluck('full_description','id'); // Usar el nombre del accesor en snake_case


        return view ($oView.$views,
            [
                'paquete_id' => $paquete_id,
                'titulo' => 'detalles paquete',
                'user' => $user,
                'Productos' => $Productos,
                'Url' => '/store_paquete_detalle_ajax',
            ]
        );
    }

    public function edit_ajax($paquete_id=0,$paquete_detalle_id=0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views  = 'paquete_detalle_edit_ajax';
        $user = Auth::User();
        $oView = 'catalogos.' ;
        $items = PaqueteDetalle::find($paquete_detalle_id);
//        $Productos = Producto::query()->select(['descripcion','pv','id'])
//            ->where('empresa_id',$this->Empresa_Id)
//            ->orderBy('descripcion')
//            ->pluck('full_description','id');

        $Productos = Producto::select('descripcion','pv','id')
            ->where('empresa_id',$this->Empresa_Id)
            ->orderBy('descripcion')
            ->get() // Obtener la colección completa de modelos
            ->pluck('full_description','id'); // Usar el nombre del accesor en snake_case

        return view ($oView.$views,
            [   'items' => $items,
                'paquete_id' => $paquete_id,
                'titulo' => 'detalles paquete',
                'user' => $user,
                'Productos' => $Productos,
                'Url' => '/update_paquete_detalle_ajax',
            ]
        );
    }


    public function store_ajax(Request $request){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data        = $request->all();
        $paquete_id  = $data['paquete_id'];
        $producto_id = $data['producto_id'];
        $cantidad    = $data['cant'];

//        dd($paquete_id.', '.$producto_id);

        try {
            $mensaje = "OK";
            PaqueteDetalle::findOrCreatePaqueteDetalle($paquete_id,$producto_id,$cantidad);
            $dets = PaqueteDetalle::all()
                ->where('empresa_id',$this->Empresa_Id)
                ->where('paquete_id',$paquete_id);
            Paquete::UpdateImporteFromPaqueteDetalle($dets);
        }
        catch(LogicException $e){
            $mensaje = "Error: ".$e->getMessage();
        }

        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function update_ajax(Request $request){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data               = $request->all();
        $paquete_detalle_id = $data['paquete_detalle_id'];
        $paquete_id         = $data['paquete_id'];
        $producto_id        = $data['producto_id'];
        $producto_id_old    = $data['producto_id_old'];
        $cantidad           = $data['cant'];

        $pd = PaqueteDetalle::find($paquete_detalle_id);
        try {
            $mensaje = "OK";
            $pd->updatePaqueteDetalle($paquete_id, $paquete_detalle_id, $producto_id, $producto_id_old,$cantidad);
            $dets = PaqueteDetalle::all()
                ->where('empresa_id',$this->Empresa_Id)
                ->where('paquete_id',$paquete_id);
            Paquete::UpdateImporteFromPaqueteDetalle($dets);

        }
        catch(QueryException $e){
            $mensaje = "Error: ".$e->getMessage();
        }

        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);

    }

    public function destroy($id=0){
        try{

            $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
            if ($this->Empresa_Id <= 0){
                return redirect('openEmpresa');
            }

            $pd = PaqueteDetalle::findOrFail($id);
            $pd->forceDelete();

            $prod = Producto::find($pd->producto_id);
            $paq = Paquete::find($pd->paquete_id);
            $dets = PaqueteDetalle::all()
                ->where('empresa_id',$this->Empresa_Id)
                ->where('paquete_id',$pd->paquete_id);
            $paq::UpdateImporteFromPaqueteDetalle($dets);

            $pd->productos()->detach($prod);
            $paq->productos()->detach($prod);

            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

        }catch(Exception $e){
            return Response::json(['mensaje' => 'Ocurrió un error: '.$e->getMessage(), 'data' => 'OK', 'status' => '200'], 200);

        }

    }

}