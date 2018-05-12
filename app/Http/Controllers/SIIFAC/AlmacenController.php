<?php

namespace App\Http\Controllers\SIIFAC;

use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Producto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Almacen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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

    public function __construct(){
        $this->middleware('auth');
    }

    public function index($npage = 1, $tpaginas = 0)
    {
        $page = Input::get('p');
        if ( $page ) $npage = $page;


        $this->tableName = 'almacenes';
        $items = Almacen::with('empresa')
            ->select('id','clave_almacen','descripcion','responsable','tipoinv','prefijo','empresa_id')
            ->orderBy('id','desc')
            ->forPage($npage,$this->itemPorPagina)
            ->get();

        $tpaginator = Almacen::paginate($this->itemPorPagina,['*'],'p');
        $tpaginas = $tpaginas == 0 ? $tpaginator->lastPage() : $tpaginas;
        $tpaginator->withPath("/index_almacen/$npage/$tpaginas");

        $user = Auth::User();
        return view ('catalogos.listados.almacenes_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Catálogo de ".ucwords($this->tableName),
                'user' => $user,
                'tableName'=>$this->tableName,
                'npage'=> $npage,
                'tpaginas' => $tpaginas,
            ]
        )->with("paginator" , $tpaginator);

    }

    public function new($idItem=0)
    {
        $views  = 'almacen_new';
        $user = Auth::User();
        $oView = 'catalogos.' ;
        $Empresas = Empresa::all()->sortBy('rs')->sortBy('rs')->pluck('rs', 'id');

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'almacenes',
                'user' => $user,
                'Empresas' => $Empresas,
            ]
        );

    }

    public function edit($idItem=0)
    {
        $views  = 'almacen_edit';
        $items = Almacen::findOrFail($idItem);
        $Empresas = Empresa::all()->sortBy('rs')->sortBy('rs')->pluck('rs', 'id');
        $user = Auth::User();
        $oView = 'catalogos.' ;

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'almacenes',
                'items' => $items,
                'user' => $user,
                'Empresas' => $Empresas,
            ]
        );

    }
    public function store(Request $request)
    {

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

        $emp = Empresa::find($data['empresa_id']);
        $alma = Almacen::create($data);
        $alma->empresas()->attach($emp);

        return redirect('/new_almacen/'.$idItem);
    }

    public function update(Request $request, Almacen $alma)
    {

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

        $emp = Empresa::find($data['empresa_id']);
        $alma->update($data);
        $alma->empresas()->detach();
        $alma->empresas()->attach($emp);

        return redirect('/edit_almacen/'.$idItem);

    }

    public function destroy($id=0){
        $prod = Producto::all()->where('almacen_id',$id)->first();

        if ( !$prod ){
            $alma = Almacen::findOrFail($id);
            $alma->delete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$prod->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }
}
