<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Producto;
use App\Models\SIIFAC\Proveedor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class ProveedorController extends Controller
{
    protected $tableName = '';
    protected $itemPorPagina = 50;
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {

        $this->tableName = 'proveedores';
        $items = Proveedor::select(['id','clave_proveedor', 'nombre_proveedor', 'contacto_proveedor','domicilio_fiscal_proveedor'])
            ->orderBy('id')
            ->paginate();

        $items->appends(request(['search']))->fragment('table');
        $items->links();

        $user = Auth::User();

        return view ('catalogos.listados.proveedores_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Catálogo de ".ucwords($this->tableName),
                'user' => $user,
                'tableName'=>$this->tableName,
            ]
        );

    }

    public function new($idItem=0)
    {
        $views  = 'proveedor_new';
        $user = Auth::User();
        $oView = 'catalogos.' ;

        // dd($items);

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'proveedores',
                'user' => $user,
            ]
        );

    }

    public function edit($idItem=0)
    {
        $views  = 'proveedor_edit';
        $items = Proveedor::findOrFail($idItem);
        $user = Auth::User();
        $oView = 'catalogos.' ;

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'proveedores',
                'items' => $items,
                'user' => $user,
            ]
        );

    }
    public function store(Request $request)
    {

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'nombre_proveedor' => "required|unique:proveedores,nombre_proveedor|max:100",
            'contacto_proveedor' => "max:150",
        ]);

        if ($validator->fails()) {
            return redirect('/edit_proveedor/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }

        $F = (new FuncionesController);
        $rs = $F->toMayus($data['nombre_proveedor']);
        $ncomer = $F->toMayus($data['contacto_proveedor']);
        $df = $F->toMayus($data['domicilio_fiscal_proveedor']);
        $rfc = $F->toMayus($data['clave_proveedor']);

        $data['nombre_proveedor'] = $rs;
        $data['contacto_proveedor'] = $ncomer;
        $data['domicilio_fiscal_proveedor'] = $df;
        $data['clave_proveedor'] = $rfc;
        $data['empresa_id'] = 1;
        $emp = Proveedor::create($data);

        return redirect('/new_proveedor/'.$idItem);
    }

    public function update(Request $request, Proveedor $emp)
    {

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'nombre_proveedor' => 'required|string|max:150|unique:proveedores,nombre_proveedor,'.$idItem,
            'contacto_proveedor' => "max:150",
        ]);

        if ($validator->fails()) {
            return redirect('/edit_proveedor/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }
        $F = (new FuncionesController);
        $rs = $F->toMayus($data['nombre_proveedor']);
        $ncomer = $F->toMayus($data['contacto_proveedor']);
        $df = $F->toMayus($data['domicilio_fiscal_proveedor']);
        $rfc = $F->toMayus($data['clave_proveedor']);

        $data['nombre_proveedor'] = $rs;
        $data['contacto_proveedor'] = $ncomer;
        $data['domicilio_fiscal_proveedor'] = $df;
        $data['clave_proveedor'] = $rfc;

        $emp->update($data);

        return redirect('/edit_proveedor/'.$idItem);

    }

    public function destroy($id=0){
        $alma = Producto::all()->where('proveedor_id',$id)->first();

        if ( !$alma ){
            $emp = Proveedor::findOrFail($id);
            $emp->delete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$alma->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }

}
