<?php

namespace App\Http\Controllers\User;

use App\Classes\FunctionsEloquentClass;
use App\Filters\User\UserFilterRules;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserPasswordRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;



class UserController extends Controller{




    protected $tableName = "users";
    protected $navCat = "usuarios";
    protected $msg = "";



// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //

    /**
     * UserController constructor.
     * @param string $msg
     */
    public function __construct(){
        $this->middleware('auth');
    }

    protected function index(Request $request){

        $this->lim_max_reg = config('ibt.limite_maximo_registros');
        $this->lim_min_reg = config('ibt.limite_minimo_registros');
        $this->max_reg_con = config('ibt.maximo_registros_consulta');
        $this->min_reg_con = config('ibt.minimo_registros_consulta');

        @ini_set( 'upload_max_size' , '16384M' );
        @ini_set( 'post_max_size', '16384M');
        @ini_set( 'max_execution_time', '960000' );

        $this->tableName = 'users';
        $filters = new UserFilterRules();
        $filters = $filters->filterRulesUserDB($request);

        $items = User::query()
            ->filterBySearch($filters)
            ->orderByDesc('id')
            ->paginate(250);
        $items->appends($filters)->fragment('table');

//        $ld = User::query()->whereHas('user_adress',function($q){
//            return $q->where('calle','CALLE 3');
//        })->get();
//        dd($ld->first()->user_adress->calle);

        $user = Auth::user();
        //$items =FunctionsEloquentClass::paginate($items, $this->max_reg_con);
        $items->appends($filters)->fragment('table');

        $request->session()->put('items', $items);

        //dd($items);

        return view('layouts.User.generales._users_list',[
            'items'        => $items,
            'user'         => $user,
            'tituloTabla'  => 'Listado de Usuarios',
            'newItem'      => 'newUsuario',
            'searchButton' => 'viewSearchModal',
            'excelButton'  => 'listUsuariosToXlsx',
            'editItem'     => 'editUsuario',
            'removeItem'   => 'removeUsuario',
            'listItems'    => 'listaUsuarios',

        ]);
    }


    protected function newItem(){

        $user = Auth::user();
        $roles = Role::query()->where('id','>',3)->orderBy('name') ->pluck('name','abreviatura')->toArray();
        //dd($roles);
        return view('layouts.User.generales._user_edit',[
            "item"     => null,
            "User"     => $user,
            "Roles"    => $roles,
            "titulo"   => "Nuevo registro ",
            'Route'    => 'createUsuario',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => true,
        ]);

    }

    protected function createItem(UserRequest $request) {
        //dd($request);
        $Obj = $request->manageUser();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('newUsuario')
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        $user = Auth::user();
        session(['msg' => 'value']);
        return view('layouts.User.generales._user_edit',[
            "item"     => $Obj,
            "User"     => $user,
            "titulo"   => "Editando el registro: ".$id,
            'Route'    => 'updateUsuario',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => false,
            'createItem' => 'addRoleItem',
            'removeItem' => 'removeRoleUsuario',
        ]);

    }


    protected function editItem($Id){

        $User = User::find($Id);
        $user = Auth::user();

        return view('layouts.User.generales._user_edit',[
            "item"       => $User,
            "user_id"    => $User->id,
            "User"       => $user,
            "titulo"     => "Editando el registro: ".$Id,
            'Route'      => 'updateUsuario',
            'Method'     => 'POST',
            'msg'        => $this->msg,
            'IsUpload'   => false,
            'IsNew'      => false,
            'createItem' => 'addRoleItem',
            'removeItem' => 'removeRoleUsuario',
        ]);

    }

    protected function updateItem(UserRequest $request) {
        $Obj = $request->manageUser();
        if (!is_object($Obj)) {
            $id = 0;
            return redirect('editUsuario')
                ->withErrors($Obj)
                ->withInput();
        }else{
            $id = $Obj->id;
        }
        $user = Auth::user();
        session(['msg' => 'value']);
        return view('layouts.User.generales._user_edit',[
            "item"     => $Obj,
            "User"     => $user,
            "titulo"   => "Editando el registro: ".$id,
            'Route'    => 'updateUsuario',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => false,
            'createItem' => 'addRoleItem',
            'removeItem' => 'removeRoleUsuario',
        ]);

    }

    protected function viewSearchModal(){

        $user = Auth::user();
        $roles = Role::query()->where('id','>',3)->orderBy('name') ->pluck('name','id')->toArray();

        return view('layouts.Accesorios._searchModal',[
            "User"        => $user,
            "Roles"       => $roles,
            "TituloModal" => "Buscar dato ",
            "RouteModal"   => 'listaUsuarios',
        ]);

    }
















// ***************** EDITA LOS DATOS DEL USUARIO PARA ESCRITURA ++++++++++++++++++++ //
    protected function editProfile($Id)
    {

        $user = User::find($Id);
        return view('User.profile',
            [
                'item'     => $user,
                'User'     => $user,
                'titulo'   => 'Mi Perfil',
                'Route'    => 'updateProfile',
                'Method'   => 'POST',
                'msg'      => $this->msg,
                'ReadOnly' => true,
            ]
        );
    }

// ***************** GUARDA LOS CAMBIOS EN EL USUARIO ++++++++++++++++++++ //
    protected function updateProfile(UserRequest $request)
    {
//        dd($request);
        $request->manageUser();
        $User = Auth::user();
        session(['msg' => 'value']);
        return redirect()->route('editProfile',['Id'=>$User]);
    }

// ***************** MUESTRA LA EDICIÓMN DE FOTO ++++++++++++++++++++ //
    protected function editFotodUser()
    {
        $user = Auth::user();
        return view('User.foto', [
                'User' => $user,
                'titulo' => 'Cambiar mi password',
                'Route' => 'updateFotodUser',
                'Method' => 'POST',
                'msg' => $this->msg,
                'IsUpload' => true,
                'IsNew' => true,
            ]
        );
    }

// ***************** MUESTRA LA EDICIÓN DEL PASSWORD ++++++++++++++++++++ //
    protected function editPasswordUser()
    {

        $user = Auth::user();
        $titulo_catalogo = "";
        return view('User.password', [
                'User' => $user,
                'titulo' => 'Cambiar mi password',
                'Route' => 'updatePasswordUser',
                'Method' => 'POST',
                'msg' => $this->msg,
            ]
        );
    }

// ***************** CAMBIA EL PASSWORD ++++++++++++++++++++ //
    protected function updatePasswordUser(UserPasswordRequest $request)
    {
        $request->UserPasswordRequest();
        $User = Auth::user();
        session(['msg' => 'value']);
        return redirect()->route('editPasswordUser',['Id'=>$User]);

    }

    // ***************** Devuelve el Proximo Usuario++++++++++++++++++++ //
    protected function getUsernameNext($Abreviatura = ''){
        $data = [];
        $msg = "OK";
        //dd($Id);
        $data = User::getUsernameNext($Abreviatura);

        return Response::json(['mensaje' => $msg, 'data' => $data, 'status' => '200'], 200);

    }


    // ***************** ELIMINA AL USUARIO VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($Id = 0, $dato1 = null, $dato2 = null){
        $code = 'OK';
        $msg = "Registro Eliminado con éxito!";
        //dd($Id);
        $user = User::withTrashed()->findOrFail($Id);
        $user->forceDelete();

        return Response::json(['mensaje' => $msg, 'data' => $code, 'status' => '200'], 200);

    }


    protected function addRoleItem($User){

        $roles = Role::query()->where('id','>',3)->orderBy('name') ->pluck('name','id')->toArray();
        $User = User::find($User);

        return view('layouts.Accesorios._addRoleUser',[
            "User"        => $User,
            "Roles"       => $roles,
            "TituloModal" => "Agregar rol a ".$User->nombre,
            "RouteModal"   => 'createRoleUsuario',
            'Method' => 'POST',
            'msg' => $this->msg,
            'IsNew' => true,
        ]);

    }

    // ******************  AGREGAR ROLE A USUARIO *****************************
    protected function createRoleItem(Request $request){
        $data = json_decode( json_encode( $request->all() ) );
        $User = User::find($data->user_id);
        $User->roles()->detach( $data->role_id );
        $User->roles()->attach( $data->role_id );
        return redirect()->route('editUsuario',['Id'=>$User]);
    }

    protected function removeRoleItem($Id,$Dato1){
        if ($Dato1 > 3){
            $code = 'OK';
            $msg = "Registro Eliminado con éxito!";
            $User = User::find($Id);
            $User->roles()->detach($Dato1);
        }else{
            $code = 'Error';
            $msg = "No se puede eliminar el registro! ".$Dato1;
        }
        return Response::json(['mensaje' => $msg, 'data' => $code, 'status' => '200'], 200);
    }

}
