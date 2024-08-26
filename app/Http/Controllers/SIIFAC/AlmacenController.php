<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Almacen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Funciones\FuncionesController;

class AlmacenController extends Controller
{
    protected $tableName = '';
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

    public function index(){
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $this->tableName = 'almacenes';
        $items = Almacen::with('empresa')
            ->select('id','clave_almacen','descripcion','responsable','tipoinv','prefijo','empresa_id')
            ->where('empresa_id',  $this->Empresa_Id)
            ->orderBy('id','desc')
            ->paginate(250);

        $items->appends(request(['search']))->fragment('table');
        $items->links();

        $user = Auth::User();
        return view ('catalogos.listados.almacenes_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Catálogo de ".ucwords($this->tableName),
                'user' => $user,
                'tableName'=>$this->tableName,
            ]
        );

    }

    public function new($idItem=0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views          = 'almacen_new';
        $user           = Auth::User();
        $oView          = 'catalogos.' ;
//        $Empresas       = Empresa::all()->sortBy('rs')->sortBy('rs')->pluck('rs', 'id');
        $Proveedores    = Proveedor::query()
                            ->orderBy('nombre_proveedor')
                            ->pluck('nombre_proveedor', 'id');

        return view ($oView.$views,
            [
                'idItem'      => $idItem,
                'titulo'      => 'almacenes',
                'user'        => $user,
                'Proveedores' => $Proveedores,
                'empresa_id'  => $this->Empresa_Id,
            ]
        );

    }

    public function edit($idItem=0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $views       = 'almacen_edit';
        $items       = Almacen::findOrFail($idItem);
        $Proveedores = Proveedor::query()
                        ->orderBy('nombre_proveedor')
                        ->pluck('nombre_proveedor', 'id');
        $user        = Auth::User();
        $oView       = 'catalogos.' ;

        return view ($oView.$views,
            [
                'idItem'      => $idItem,
                'titulo'      => 'almacenes',
                'items'       => $items,
                'user'        => $user,
                'Proveedores' => $Proveedores,
                'empresa_id'  => $this->Empresa_Id,
            ]
        );

    }
    public function store(Request $request){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'clave_almacen' => "required|unique:almacenes,clave_almacen",
            'descripcion' => "required|unique:almacenes,descripcion|max:100",
            'prefijo' => "required|unique:almacenes,prefijo|max:100",
            'responsable' => "max:150",
        ]);

        if ($validator->fails()) {
            return redirect('/new_almacen/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }


        $F = (new FuncionesController);

        $descripcion = $F->toMayus($data['descripcion']);
        $responsable = $F->toMayus($data['responsable']);

        $data['descripcion'] = $descripcion;
        $data['responsable'] = $responsable;
        $data['idemp']       = $this->Empresa_Id;
        $data['empresa_id']  = $this->Empresa_Id;


        $emp = Empresa::find( $this->Empresa_Id );
        $alma = Almacen::create($data);
        $alma->empresas()->attach($emp);

        return redirect('/new_almacen/'.$idItem);
    }

    public function update(Request $request, Almacen $alma)
    {
        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'clave_almacen' => 'required|numeric|unique:almacenes,clave_almacen,'.$idItem,
            'descripcion' => 'required|string|max:150|unique:almacenes,descripcion,'.$idItem,
            'prefijo' => 'required|string|max:150|unique:almacenes,prefijo,'.$idItem,
            'responsable' => "max:150",
        ]);

        if ($validator->fails()) {
            return redirect('/edit_almacen/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }
        $F = (new FuncionesController);

        $descripcion = $F->toMayus($data['descripcion']);
        $responsable = $F->toMayus($data['responsable']);

        $data['descripcion'] = $descripcion;
        $data['responsable'] = $responsable;
        $data['idemp']       = $this->Empresa_Id;

        $emp = Empresa::find( $this->Empresa_Id );
        $alma->update($data);
        $alma->empresas()->detach($emp);
        $alma->empresas()->attach($emp);

        return redirect('/edit_almacen/'.$idItem);

    }

    public function destroy($id=0){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $prod = Producto::query()
                ->where('almacen_id',$id)
                ->first();

        if ( !$prod ){
            $alma = Almacen::findOrFail($id);
            $emp = Empresa::find( $alma->empresa_id );
            $alma->empresas()->detach($emp);
            $alma->forceDelete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$prod->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }
}
