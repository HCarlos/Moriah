<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Funciones\FuncionesController;

class EmpresaController extends Controller
{
    protected $tableName = '';
    protected $itemPorPagina = 50;
    protected $otrosDatos;
    protected $Predeterminado = false;
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {

        $this->tableName = 'empresas';
        $items = Empresa::select('id','rs','ncomer','rfc')
            ->orderBy('id')
            ->paginate(250);

        $items->appends(request(['search']))->fragment('table');
        $items->links();

        $user = Auth::User();

        return view ('catalogos.listados.empresas_list',
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
        $views  = 'empresa_new';
        $user = Auth::User();
        $oView = 'catalogos.' ;

        // dd($items);

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'empresas',
                'user' => $user,
            ]
        );

    }

    public function edit($idItem=0)
    {
        $views  = 'empresa_edit';
        $items = Empresa::findOrFail($idItem);
        $user = Auth::User();
        $oView = 'catalogos.' ;

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'empresas',
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
            'rs' => "required|unique:empresas,rs|max:100",
            'ncomer' => "max:150",
        ]);

        if ($validator->fails()) {
            return redirect('/edit_empresa/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }

        $F = (new FuncionesController);
        $rs = $F->toMayus($data['rs']);
        $ncomer = $F->toMayus($data['ncomer']);
        $df = $F->toMayus($data['df']);
        $rfc = $F->toMayus($data['rfc']);

        $data['rs'] = $rs;
        $data['ncomer'] = $ncomer;
        $data['df'] = $df;
        $data['rfc'] = $rfc;
        $emp = Empresa::create($data);

        return redirect('/new_empresa/'.$idItem);
    }

    public function update(Request $request, Empresa $emp)
    {

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'rs' => 'required|string|max:150|unique:empresas,rs,'.$idItem,
            'ncomer' => "max:150",
        ]);

        if ($validator->fails()) {
            return redirect('/edit_empresa/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }
        $F = (new FuncionesController);
        $rs = $F->toMayus($data['rs']);
        $ncomer = $F->toMayus($data['ncomer']);
        $df = $F->toMayus($data['df']);
        $rfc = $F->toMayus($data['rfc']);

        $data['rs'] = $rs;
        $data['ncomer'] = $ncomer;
        $data['df'] = $df;
        $data['rfc'] = $rfc;

        $emp->update($data);

        return redirect('/edit_empresa/'.$idItem);

    }

    public function destroy($id=0){
        $alma = Almacen::all()->where('empresa_id',$id)->first();

        if ( !$alma ){
            $emp = Empresa::findOrFail($id);
            $emp->delete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$alma->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }


}
