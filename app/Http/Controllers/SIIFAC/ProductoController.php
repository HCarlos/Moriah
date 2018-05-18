<?php

namespace App\Http\Controllers\SIIFAC;

use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\FamiliaProducto;
use App\Models\SIIFAC\Medida;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\Producto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Funciones\FuncionesController;

class ProductoController extends Controller
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

        $this->tableName = 'productos';
        $items = Producto::select('id','clave','codigo','descripcion','pv','exist','empresa_id','almacen_id','familia_producto_id','medida_id')
            ->orderBy('id','desc')
            ->forPage($npage,$this->itemPorPagina)
            ->get();
            $tpaginator = Producto::paginate($this->itemPorPagina,['*'],'p');
        //dd($npage);
        $user = Auth::User();
        $tpaginas = $tpaginas == 0 ? $tpaginator->lastPage() : $tpaginas;
        $tpaginator->withPath("/index_producto/$npage/$tpaginas");
        return view ('catalogos.listados.productos_list',
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
        $views  = 'producto_new';
        $user = Auth::User();
        $oView = 'catalogos.';
        $Empresas = Empresa::all()->sortBy('rs')->sortBy('rs')->pluck('rs', 'id');
        $Almacenes = Almacen::all()->sortBy('rs')->sortBy('rs')->pluck('descripcion', 'id');
        $FamProds = FamiliaProducto::all()->sortBy('rs')->sortBy('rs')->pluck('descripcion', 'id');
        $Medidas = Medida::all()->sortBy('rs')->sortBy('rs')->pluck('desc1', 'id');
        $timex  = Carbon::now()->format('ymdHisu');

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'productos',
                'user' => $user,
                'Empresas' => $Empresas,
                'Almacenes' => $Almacenes,
                'FamProds' => $FamProds,
                'Medidas' => $Medidas,
            ]
        );

    }

    public function edit($idItem=0)
    {
        $views  = 'producto_edit';
        $items = Producto::findOrFail($idItem);
        $Empresas = Empresa::all()->sortBy('rs')->sortBy('rs')->pluck('rs', 'id');
        $Almacenes = Almacen::all()->sortBy('rs')->sortBy('rs')->pluck('descripcion', 'id');
        $FamProds = FamiliaProducto::all()->sortBy('rs')->sortBy('rs')->pluck('descripcion', 'id');
        $Medidas = Medida::all()->sortBy('rs')->sortBy('rs')->pluck('desc1', 'id');
        $user = Auth::User();
        $oView = 'catalogos.' ;

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'productos',
                'items' => $items,
                'user' => $user,
                'Empresas' => $Empresas,
                'Almacenes' => $Almacenes,
                'FamProds' => $FamProds,
                'Medidas' => $Medidas,
            ]
        );

    }
    public function store(Request $request)
    {

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'clave' => "required|unique:productos,clave|min:1|max:10",
            'codigo' => "required|unique:productos,codigo|min:12|max:16",
            'descripcion' => "required|unique:productos,descripcion|max:100",
            'cu' => "required|numeric|regex:'\d{0,2}(\.\d{1,2})?' ",
            'exist' => "required|numeric|regex:'\d{0,2}(\.\d{1,2})?' ",
            'pv' => "required|numeric|regex:'\d{0,2}(\.\d{1,2})?' ",
        ]);

        if ($validator->fails()) {
            return redirect('/new_producto/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }

        $F = (new FuncionesController);

        $descripcion = $F->toMayus($data['descripcion']);
        $shortdesc = $F->toMayus($data['shortdesc']);
        $data['descripcion'] = $descripcion;
        $data['shortdesc']   = $shortdesc;
        $data['descripcion'] = $descripcion;
        $data['isiva']       = isset($data['isiva']) ? true : false;
        $data['saldo']       = $data['cu'] * $data['exist'];
        $data['empresa_id']  = $data['almacen_id'];
        $data["idemp"]       = $F->getIHE(0);
        $data["ip"]          = $F->getIHE(1);
        $data["host"]        = $F->getIHE(2);

        $alma = Almacen::find($data['almacen_id']);
        $fp   = FamiliaProducto::find($data['familia_producto_id']);
        $med  = Medida::find($data['medida_id']);
        $emp  = Empresa::find($data['empresa_id']);

        $prod = Producto::create($data);

        $prod->almacenes()->attach($alma);
        $prod->familiaProductos()->attach($fp);
        $prod->medidas()->attach($med);
        $prod->empresas()->attach($emp);
        $prod::ActualizaPaqueteDetalles($prod->id);

        return redirect('/new_producto/'.$idItem);
    }

    public function update(Request $request, Producto $prod)
    {

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'clave' => "required|unique:productos,clave,".$idItem.'|min:1|max:10',
            'codigo' => "required|unique:productos,codigo,".$idItem.'|min:12|max:16',
            'descripcion' => "required|unique:productos,descripcion,".$idItem."|max:100",
            'cu' => "required|numeric|regex:'\d{0,2}(\.\d{1,2})?' ",
            'exist' => "required|numeric|regex:'\d{0,2}(\.\d{1,2})?' ",
            'pv' => "required|numeric|regex:'\d{0,2}(\.\d{1,2})?' ",
        ]);

        if ($validator->fails()) {
            return redirect('/edit_producto/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }
        $F = (new FuncionesController);

        $descripcion = $F->toMayus($data['descripcion']);
        $shortdesc = $F->toMayus($data['shortdesc']);
        $data['descripcion'] = $descripcion;
        $data['shortdesc'] = $shortdesc;
        //dd($data['isiva']);
        $data['isiva']       = isset($data['isiva']) ? true : false;
        $data['saldo']       = $data['cu'] * $data['exist'];
        $data['empresa_id']  = $data['almacen_id'];
        $data["idemp"]       = $F->getIHE(0);
        $data["ip"]          = $F->getIHE(1);
        $data["host"]        = $F->getIHE(2);

        $alma = Almacen::find($data['almacen_id']);
        $fp   = FamiliaProducto::find($data['familia_producto_id']);
        $med  = Medida::find($data['medida_id']);
        $emp  = Empresa::find($data['empresa_id']);


        $prod->update($data);

        $prod->almacenes()->detach();
        $prod->familiaProductos()->detach();
        $prod->medidas()->detach();
        $prod->empresas()->detach();

        $prod->almacenes()->sync($alma);
        $prod->familiaProductos()->sync($fp);
        $prod->medidas()->sync($med);
        $prod->empresas()->sync($emp);
        $prod::ActualizaPaqueteDetalles($prod->id);

        return redirect('/edit_producto/'.$idItem);

    }

    protected function imagen($idItem){
        $oProd = Producto::findOrFail($idItem);
        $user = Auth::User();

        return view ('storage.producto_imagen',
            [
                'idItem' => $idItem,
                'titulo' => 'Subir imagen a ficha: ',
                'item' => $oProd,
                'user' => $user,
                'otrosDatos' => '',
            ]
        );
    }


    public function destroy($id=0){
        $mov = Movimiento::all()->where('producto_id',$id)->first();

        if ( !$mov ){
            $prod = Producto::findOrFail($id);
            $prod->forceDelete();
            $prod::ActualizaPaqueteDetalles($id);
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$mov->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }


}

