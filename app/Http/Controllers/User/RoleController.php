<?php

namespace App\Http\Controllers\User;

use App\Filters\User\UserFilterRules;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RoleRequest;
use App\Http\Requests\User\UserPasswordRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Models\User\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class RoleController extends Controller{




    protected $tableName = "roles";
    protected $navCat = "roles";
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

        $this->tableName = 'roles';
        $filters = new UserFilterRules();
        $filters = $filters->filterRulesUserDB($request);

        $items = Role::query()
            ->orderByDesc('id')
            ->paginate(250);
        $items->appends($filters)->fragment('table');

        $user = Auth::user();
        //$items =FunctionsEloquentClass::paginate($items, $this->max_reg_con);
        $items->appends($filters)->fragment('table');

        $request->session()->put('items', $items);

        //dd($items);

        return view('layouts.User.roles._roles_list',[
            'items'        => $items,
            'user'         => $user,
            'tituloTabla'  => 'Listado de Roles',
            'newItem'      => 'newRole',
            'editItem'     => 'editRole',
            'removeItem'   => 'removeRole',

        ]);
    }


    protected function newItem(){

        $user = Auth::user();
        return view('layouts.User.roles._role_edit',[
            "item"     => null,
            "User"     => $user,
            "titulo"   => "Nuevo registro ",
            'Route'    => 'createRole',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => true,
        ]);

    }

    protected function createItem(RoleRequest $request) {
        //dd($request);
        $request['name'] = strtoupper(trim($request['name'] ));
        $Role = $request->manageUser();
        if (!is_object($Role)) {
            $id = 0;
            return redirect('newRole')
                ->withErrors($Role)
                ->withInput();
        }else{
            $id = $Role->id;
        }
        $user = Auth::user();
        session(['msg' => 'value']);
        return view('layouts.User.roles._role_edit',[
            "item"     => $Role,
            "User"     => $user,
            "titulo"   => "Editando el registro: ".$id,
            'Route'    => 'updateRole',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => false,
            'createItem' => 'addRoleItem',
            'removeItem' => 'removeRole',
        ]);

    }


    protected function editItem($Id){

        $Role = Role::find($Id);
        $user = Auth::user();

        return view('layouts.User.roles._role_edit',[
            "item"       => $Role,
            "user_id"    => $user->id,
            "User"       => $user,
            "titulo"     => "Editando el registro: ".$Id,
            'Route'      => 'updateRole',
            'Method'     => 'POST',
            'msg'        => $this->msg,
            'IsUpload'   => false,
            'IsNew'      => false,
            'createItem' => 'addRoleItem',
            'removeItem' => 'removeRole',
        ]);

    }

    protected function updateItem(RoleRequest $request) {
        $Role = $request->manageUser();
        if (!is_object($Role)) {
            $id = 0;
            return redirect('newRole')
                ->withErrors($Role)
                ->withInput();
        }else{
            $id = $Role->id;
        }
        $user = Auth::user();
        session(['msg' => 'value']);
        return view('layouts.User.roles._role_edit',[
            "item"     => $Role,
            "User"     => $user,
            "titulo"   => "Editando el registro: ".$Role->id,
            'Route'    => 'updateRole',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => false,
        ]);

    }


    // ***************** ELIMINA AL USUARIO VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($Id = 0){
        $code = 'OK';
        $msg = "Registro Eliminado con éxito!";
        //dd($Id);
        $user = Role::withTrashed()->findOrFail($Id);
        $user->forceDelete();

        return Response::json(['mensaje' => $msg, 'data' => $code, 'status' => '200'], 200);

    }





}
