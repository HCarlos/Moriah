<?php

namespace App\Http\Controllers\Catalogos\Profesores;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class ProfesorController extends Controller{


    protected $tableName = "users";
    protected $navCat = "users";
    protected $max_reg_con = 0;
    protected $min_reg_con = 0;
    protected $lim_max_reg = 0;
    protected $lim_min_reg = 0;

// ***************** MUESTRA EL LISTADO DE Personas ++++++++++++++++++++ //
    protected function index(Request $request){

        $this->lim_max_reg = config('ibt.limite_maximo_registros');
        $this->lim_min_reg = config('ibt.limite_minimo_registros');
        $this->max_reg_con = config('ibt.maximo_registros_consulta');
        $this->min_reg_con = config('ibt.minimo_registros_consulta');

        @ini_set( 'upload_max_size' , '16384M' );
        @ini_set( 'post_max_size', '16384M');
        @ini_set( 'max_execution_time', '960000' );

        $this->tableName = 'users';

        $items = User::query()->whereHas('roles', function ($query) {
            return $query->whereIn('name', ['PROFESOR']);
        })->get();

//        $items = User::query()->whereHas('roles', function ($query) {
//            return $query->whereIn('name', ['PADRE FAMILIA','MADRE FAMILIA','FAMILIAR']);
//        })->get();

//        $items = User::query()->get()->take(250);

//        $items = User::query()->get();

        $user = Auth::user();

        $request->session()->put('items', $items);

        return view('layouts.Catalogos.Profesores._profesores_list',[
            "items"       => $items,
            "user"        => $user,
            "tituloTabla" => "Listado de Profesores",
            "editItem"    => "editProfesor",
            "removeItem"  => "removeProfesor",
        ]);
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


}
