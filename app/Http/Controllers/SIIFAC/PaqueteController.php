<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Paquete;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\PaqueteDetalle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;

class PaqueteController extends Controller
{
    protected $tableName = 'paquetes';
    protected $itemPorPagina = 50;
    protected $otrosDatos;
    protected $Predeterminado = false;
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {

        $this->tableName = 'paquetes';
        $items = Paquete::select('id','codigo','descripcion_paquete','importe','empresa_id','filename','root','grupos_platsource')
            ->orderBy('id','desc')
            ->paginate();
        $user = Auth::User();
        $items->appends(request(['search']))->fragment('table');
        $items->links();
        return view ('catalogos.listados.paquetes_list',
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
        $views  = 'paquete_new';
        $user = Auth::User();
        $oView = 'catalogos.';
        $Empresas = Empresa::all()->sortBy('rs')->sortBy('rs')->pluck('rs', 'id');
        $timex  = Carbon::now()->format('ymdHisu');

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'paquetes',
                'user' => $user,
                'Empresas' => $Empresas,
            ]
        );

    }

    public function edit($idItem=0)
    {
        $views  = 'paquete_edit';
        $items = Paquete::findOrFail($idItem);
        $Empresas = Empresa::all()->sortBy('rs')->sortBy('rs')->pluck('rs', 'id');
        $user = Auth::User();
        $oView = 'catalogos.' ;

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'paquetes',
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
            'codigo' => "required|unique:paquetes,codigo|min:12|max:16",
            'descripcion_paquete' => "required|unique:paquetes,descripcion_paquete|max:100",
        ]);

        if ($validator->fails()) {
            return redirect('/new_paquete/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }

        $F = (new FuncionesController);

        $descripcion_paquete         = $F->toMayus($data['descripcion_paquete']);
        $data['descripcion_paquete'] = $descripcion_paquete;
        $data['empresa_id']          = $data['empresa_id'];
        $data['codigo']              = $data['codigo'];

        $data['grupos_platsource']   = $data['grupos_platsource'] ?? '';
        $data['isvisibleinternet']   = $data['isvisibleinternet'];
        $data['total_internet']      = $data['total_internet'];

        $data['user_id']             = Auth::user()->id;
        $data["idemp"]               = $F->getIHE(0);
        $data["ip"]                  = $F->getIHE(1);
        $data["host"]                = $F->getIHE(2);

        $user = User::find($data['user_id']);
        $emp  = Empresa::find($data['empresa_id']);

        $paq = Paquete::create($data);

        $paq->users()->attach($user);
        $paq->empresas()->attach($emp);

        return redirect('/new_paquete/'.$idItem);
    }

    public function update(Request $request, Paquete $paq)
    {

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'codigo' => "required|unique:paquetes,codigo,".$idItem.'|min:12|max:16',
            'descripcion_paquete' => "required|unique:paquetes,descripcion_paquete,".$idItem."|max:100",
        ]);

        if ($validator->fails()) {
            return redirect('/edit_paquete/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }
        $F = (new FuncionesController);

        $descripcion_paquete         = $F->toMayus($data['descripcion_paquete']);
        $data['descripcion_paquete'] = $descripcion_paquete;
        $data['empresa_id']          = $data['empresa_id'];
        $data['codigo']              = $data['codigo'];

        $data['grupos_platsource']   = $data['grupos_platsource'] ?? '';
        $data['isvisibleinternet']   = $data['isvisibleinternet'];
        $data['total_internet']      = $data['total_internet'];


        $data["idemp"]               = $F->getIHE(0);
        $data["ip"]                  = $F->getIHE(1);
        $data["host"]                = $F->getIHE(2);

        $user = Auth::User();
        $emp  = Empresa::find($data['empresa_id']);
        
        // dd($data);

        $paq->update($data);

        $paq->users()->detach();
        $paq->empresas()->detach();
        $paq->users()->attach($user);
        $paq->empresas()->attach($emp);

        return redirect('/edit_paquete/'.$idItem);

    }

    protected function imagen($idItem){
        $oPaq = Paquete::findOrFail($idItem);
        $user = Auth::User();

        return view ('archivos.paquete_imagen',
            [
                'idItem' => $idItem,
                'titulo' => 'Subir imagen a ficha: ',
                'item' => $oPaq,
                'user' => $user,
                'otrosDatos' => '',
            ]
        );
    }

    public function destroy($id=0){
        $mov = Movimiento::all()->where('paquete_id',$id)->first();

        if ( !$mov ){
            $paq = Paquete::findOrFail($id);
            $paq->delete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$mov->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }

    public function actualizar_precio_paquetes(){
        $Paqs = Paquete::select('id')->get();
        foreach ($Paqs as $Paq){
            Paquete::UpdateImporteFromPaquete($Paq->id);        
        }
        return Response::json(['mensaje' => 'Precios de paquetes actualizado con éxito.', 'data' => 'OK', 'status' => '200'], 200);
    }



    public function getLibrosPS($grupo_ps){

        $grupos = explode(',',$grupo_ps);
        $paqs = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet')->whereIn('grupos_platsource',$grupos)
               ->get();

        foreach($paqs as $paq){
            $pd = PaqueteDetalle::select('codigo','descripcion','cant','pv')
                  ->where('paquete_id',$paq->id)
                  ->get();
            $paq->libros = $pd;
        }       
        
        return Response::json(['mensaje' => 'OK', 'encabezado_paquete' => $paqs, 'status' => '200'], 200);

    }









}
