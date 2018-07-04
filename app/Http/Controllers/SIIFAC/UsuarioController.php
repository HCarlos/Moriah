<?php

namespace App\Http\Controllers\SIIFAC;

use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\FamiliaCliente;
use App\Models\SIIFAC\Movimiento;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Funciones\FuncionesController;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    protected $tableName = '';
    protected $itemPorPagina = 100;
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

        $this->tableName = 'usuarios';
        $items = User::with('roles')
            ->select('id','username','ap_paterno','ap_materno','nombre','email','cuenta')
            ->orderBy('id','desc')
            ->forPage($npage,$this->itemPorPagina)
            ->get();
        $tpaginator = User::paginate($this->itemPorPagina,['*'],'p');
        //dd($items);
        $user = Auth::User();
        $tpaginas = $tpaginas == 0 ? $tpaginator->lastPage() : $tpaginas;
        $tpaginator->withPath("/index_usuario/$npage/$tpaginas");

        return view ('catalogos.listados.usuarios_list',
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
        $views  = 'usuario_new';
        $user = Auth::User();
        $oView = 'catalogos.';
        $Familia_Cliente = FamiliaCliente::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $timex  = Carbon::now()->format('ymdHisu');

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'users',
                'user' => $user,
                'FamClis' => $Familia_Cliente,
            ]
        );

    }

    public function edit($idItem=0)
    {
        $views  = 'usuario_edit';
        $items = User::findOrFail($idItem);
//        dd($items);
        $Familia_Cliente = FamiliaCliente::all()->sortBy('descripcion')->pluck('descripcion', 'id');
        $user = Auth::User();
        $oView = 'catalogos.' ;

        return view ($oView.$views,
            [
                'idItem' => $idItem,
                'titulo' => 'users',
                'items' => $items,
                'user' => $user,
                'FamClis' => $Familia_Cliente,
            ]
        );

    }
    public function store(Request $request)
    {

        $data = $request->all();
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'username' => "required|unique:users,username",
            'email' => "required|email|unique:users,email",
        ]);

        if ($validator->fails()) {
            return redirect('/new_usuario/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }

        $F = (new FuncionesController);

        $ap_paterno = $F->toMayus($data['ap_paterno']);
        $ap_materno = $F->toMayus($data['ap_materno']);
        $nombre = $F->toMayus($data['nombre']);
        $domicilio = $F->toMayus($data['domicilio']);

        $data['ap_paterno'] = $ap_paterno;
        $data['ap_materno']   = $ap_materno;
        $data['nombre'] = $nombre;
        $data['domicilio'] = $domicilio;
        $data['cuenta'] = '';
        $data['celular'] = is_null($data['celular']) ? ' ' : $data['celular'];
        $data['telefono'] = is_null($data['telefono']) ? ' ' : $data['telefono'];
        $data['iduser_ps'] = is_null($data['iduser_ps']) ? ' ' : $data['iduser_ps'];

        $data["idemp"]       = $F->getIHE(0);
        $data["ip"]          = $F->getIHE(1);
        $data["host"]        = $F->getIHE(2);

        $role1 = Role::find(2);
        $role2 = Role::find(3);
        $role3 = Role::find(4);

        //dd($data);

        //User::create($data);
        User::findOrCreateUserWithRole3(
            $data['cuenta'], $data['username'], $data['nombre'], $data['ap_paterno'], $data['ap_materno'], $data['email'],
            '',false,false,false,false,false,0,0,
            $data['domicilio'], $data['celular'], $data['telefono'],0,0, $data['familia_cliente_id'],
            $data['iduser_ps'],$data['idemp'],$role1,$role2,$role3);

        return redirect('/new_usuario/'.$idItem);
    }

    public function update(Request $request, User $user)
    {

        $data = $request->all();
//        dd($data);
        $idItem     = $data['idItem'];

        $validator = Validator::make($data, [
            'username' => "required|unique:users,username,".$idItem,
            'email' => "required|unique:users,email,".$idItem,
            'cuenta' => "required|unique:users,cuenta,".$idItem.'|min:12|max:16',
        ]);

        if ($validator->fails()) {
            return redirect('/edit_usuario/'.$idItem)
                ->withErrors($validator)
                ->withInput();
        }
        $F = (new FuncionesController);

        $ap_paterno = $F->toMayus($data['ap_paterno']);
        $ap_materno = $F->toMayus($data['ap_materno']);
        $nombre     = $F->toMayus($data['nombre']);
        $domicilio  = $F->toMayus($data['domicilio']);

        $data['ap_paterno'] = $ap_paterno;
        $data['ap_materno']   = $ap_materno;
        $data['nombre'] = $nombre;
        $data['domicilio'] = $domicilio;
        $data["idemp"]       = $F->getIHE(0);
        $data["ip"]          = $F->getIHE(1);
        $data["host"]        = $F->getIHE(2);

        $user->update($data);

        return redirect('/edit_usuario/'.$idItem);

    }

    public function destroy($id=0){
        $mov = Movimiento::all()->where('user_id',$id)->first();

        if ( !$mov ){
            $user = User::findOrFail($id);
            $user->delete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$mov->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }
}



?>