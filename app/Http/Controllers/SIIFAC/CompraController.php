<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Compra;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\QueryException;
use LogicException;

class CompraController extends Controller
{
    protected $tableName = 'compras';
    protected $redirectTo = '/home';
    protected $F;
    protected $Empresa_Id = 0;
    public function __construct(){
        $this->middleware('auth');
        $this->F = (new FuncionesController);
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
//            return redirect('openEmpresa');
        }
    }

    public function index()
    {
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $user = Auth::User();
        $items = Compra::query()
            ->where('empresa_id',$this->Empresa_Id)
            ->orderByDesc('id')
            ->get();

        return view ('catalogos.operaciones.compras.compras',
            [
                'tableName' => 'compras',
                'compras' => $items,
                'user' => $user,
            ]
        );
    }

    public function nueva_compra_ajax(){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views       = 'compra_nueva_ajax';
        $user        = Auth::User();
        $oView       = 'catalogos.operaciones.compras.';
        $Empresas    = Empresa::query()
                        ->where('id',$this->Empresa_Id)
                        ->orderBy('rs')
                        ->pluck('rs', 'id');
        $Almacenes   = Almacen::query()
                        ->where('empresa_id',$this->Empresa_Id)
                        ->orderBy('descripcion')
                        ->pluck('descripcion', 'id');
        $Proveedores = Proveedor::query()
                        ->where('empresa_id',$this->Empresa_Id)
                        ->orderBy('nombre_proveedor')
                        ->pluck('nombre_proveedor', 'id');
        return view ($oView.$views,
            [
                'Empresas'    => $Empresas,
                'Almacenes'   => $Almacenes,
                'Proveedores' => $Proveedores,
                'user'        => $user,
                'empresa_id'  => $this->Empresa_Id,
                'Url'         => '/store_compra_nueva_ajax',
            ]
        );
    }

    public function store_compra_nueva_ajax(Request $request){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data = $request->all();
        $data["folio_factura"]      = $data["folio_factura"]      ==  null ? '' : $data["folio_factura"];
        $data["nota_id"]            = $data["nota_id"]            ==  null ? '' : $data["nota_id"];
        $data["descripcion_compra"] = $data["descripcion_compra"] ==  null ? '' : $data["descripcion_compra"];

        $data['idemp']      = $this->Empresa_Id;
        $data['empresa_id'] = $this->Empresa_Id;

        $data['fecha'] = now();
        try {
            $mensaje = "OK";
            Compra::create($data);
        }
        catch(QueryException $e){
            $mensaje = "Error: ".$e->getMessage();
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function editar_compra_ajax($compra_id){
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views       = 'compra_editar_ajax';
        $user        = Auth::User();
        $oView       = 'catalogos.operaciones.compras.';
        $Compra      = Compra::find($compra_id);
        $Empresas    = Empresa::query()
                        ->where('id',$this->Empresa_Id)
                        ->orderBy('rs')
                        ->pluck('rs', 'id');
        $Almacenes   = Almacen::query()
                        ->where('empresa_id',$this->Empresa_Id)
                        ->orderBy('descripcion')
                        ->pluck('descripcion', 'id');
        $Proveedores = Proveedor::query()
                        ->where('empresa_id',$this->Empresa_Id)
                        ->orderBy('nombre_proveedor')
                        ->pluck('nombre_proveedor', 'id');
        return view ($oView.$views,
            [
                'Empresas'    => $Empresas,
                'Almacenes'   => $Almacenes,
                'Proveedores' => $Proveedores,
                'compra'      => $Compra,
                'user'        => $user,
                'empresa_id'  => $this->Empresa_Id,
                'Url'         => '/store_compra_editada_ajax',
            ]
        );
    }

    public function store_compra_editada_ajax(Request $request)
    {
        $data = $request->all();

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        try {

            $mensaje                  = "OK";
            $Comp                     = Compra::findOrFail($data['compra_id']);
            $Comp->empresa_id         = $this->Empresa_Id;
            $Comp->proveedor_id       = $data['proveedor_id'];
            $Comp->almacen_id         = $data['almacen_id'];
            $Comp->folio_factura      = isset($data['folio_factura']) ? $data['folio_factura'] : 0;
            $Comp->nota_id            = $data['nota_id'];
            $Comp->descripcion_compra = $data['descripcion_compra'];
            $Comp->save();
        }
        catch(LogicException $e){
            $mensaje = "Error: ".$e->getMessage();
        }
        return Response::json(['mensaje' => $mensaje, 'data' => 'OK', 'status' => '200'], 200);
    }

    public function destroy($id){

        $Comp = Compra::findOrFail($id);
        $Mov  = Movimiento::where('compra_id', $id);
        $Comp->forceDelete();
        $Mov->forceDelete();

        return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);

    }




}
