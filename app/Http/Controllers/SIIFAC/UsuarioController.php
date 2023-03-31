<?php

namespace App\Http\Controllers\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Requests\Users\UserAddRFCRequest;
use App\Http\Requests\Users\UserRemoveRFCRequest;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\FamiliaCliente;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Rfc;
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
//use App\Http\Requests\{CreateUserRequest, UpdateUserRequest};


class UsuarioController extends Controller
{
    protected $tableName = '';
    protected $itemPorPagina = 300;
    protected $otrosDatos;
    protected $Predeterminado = false;
    protected $redirectTo = '/home';

    public function __construct(){
        $this->middleware('auth');
    }

    public function index()
    {
        ini_set('max_execution_time', 300);
        $this->tableName = 'usuarios';
        $items = User::query()
            ->filtrar(request('search'))
            ->orderByDesc('created_at')
            ->paginate(250);

        $items->appends(request(['search']))->fragment('table');
        $items->links();

        $user = Auth::User();

        return view ('catalogos.listados.usuarios_list',
            [
                'items' => $items,
                'titulo_catalogo' => "Catálogo de ".ucwords($this->tableName),
                'user' => $user,
                'tableName'=>$this->tableName,
//                'npage'=> $npage,
//                'tpaginas' => $tpaginas,
                'npage'=> 0,
                'tpaginas' => 0,
            ]
//        )->with("paginator" , $tpaginator);
        );

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

    public function store(Request $request){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

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

        $data['ap_paterno'] = $ap_paterno;
        $data['ap_materno']   = $ap_materno;
        $data['nombre'] = $nombre;
        $data['cuenta'] = '';
        $data['celular'] = is_null($data['celular']) ? ' ' : $data['celular'];
        $data['telefono'] = is_null($data['telefono']) ? ' ' : $data['telefono'];
        $data['iduser_ps'] = is_null($data['iduser_ps']) ? ' ' : $data['iduser_ps'];

        $data["idemp"]       = $this->Empresa_Id;
        $data["ip"]          = $F->getIHE(1);
        $data["host"]        = $F->getIHE(2);

        $role1 = Role::find(3);
        $role2 = Role::find(4);
        $role3 = Role::find(5);

        //dd($data);

        //User::create($data);
        User::findOrCreateUserWithRole3(
            $data['cuenta'], $data['username'], $data['nombre'], $data['ap_paterno'], $data['ap_materno'], $data['email'],
            '',false,false,false,false,false,0,0,
            '', $data['celular'], $data['telefono'],0,0, $data['familia_cliente_id'],
            $data['iduser_ps'],$data['idemp'],$role1,$role2,$role3);

        return redirect('/new_usuario/'.$idItem);
    }

    public function update(Request $request, User $user){

        $this->Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }

        $data = $request->all();
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

        $data['ap_paterno']  = $ap_paterno;
        $data['ap_materno']  = $ap_materno;
        $data['nombre']      = $nombre;
        $data["idemp"]       = $this->Empresa_Id;
        $data["ip"]          = $F->getIHE(1);
        $data["host"]        = $F->getIHE(2);

        $user->update($data);

        return redirect('/edit_usuario/'.$idItem);

    }

    public function destroy($id=0){
        $mov = Movimiento::all()->where('user_id',$id)->first();

        if ( !$mov ){
            $user = User::findOrFail($id);
            $user->forceDelete();
            return Response::json(['mensaje' => 'Registro eliminado con éxito', 'data' => 'OK', 'status' => '200'], 200);
        }else{
            return Response::json(['mensaje' => 'No se puede eliminar el registro ['.$mov->id.']', 'data' => 'Error', 'status' => '200'], 200);
        }

    }

    public function show_rfc_usuario($user_id){
        $user = Auth::user();
        $usuario = User::findOrFail($user_id);
        $rfcs= Rfc::query()->orderBy('rfc')->get();
        $rfcs_asignados = User::query()->whereHas('rfcs',function ($q) use ($user_id){
            return $q->where('user_id',$user_id);
        })->get();

        return view ('asignaciones.add_rfc_ajax',
            [
                'user_id' => $user_id,
                'usuario' => $usuario,
                'rfcs' => $rfcs,

                'rfcs_asignados' => $rfcs_asignados,
                'titulo_catalogo' => "Registros Fiscales de ".ucwords($user->FullName()),
                'user' => $user,
                'tableName'=>$this->tableName,
            ]
        );
    }


    public function add_rfc_usuario(UserAddRFCRequest $request){
        $msg = $request->manage();
        return Response::json(['mensaje' => $msg, 'data' => 'OK', 'status' => '200'], 200);
    }


    public function show_remove_rfc_usuario($user_id){
        $user = Auth::user();

        return view ('catalogos.listados.usuarios_list',
            [
                'user_id' => $user_id,
                'rfcs' => $rfcs,
                'titulo_catalogo' => "Agregar Registros Fiscales de ".ucwords($user->FullName()),
                'user' => $user,
                'tableName'=>$this->tableName,
            ]
        );
    }

    public function remove_rfc_usuario(UserRemoveRFCRequest $request){
        $msg = $request->manage();
        return Response::json(['mensaje' => $msg, 'data' => 'OK', 'status' => '200'], 200);
    }





}



?>