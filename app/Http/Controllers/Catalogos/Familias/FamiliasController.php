<?php

namespace App\Http\Controllers\Catalogos\Familias;

use App\Filters\Catalogo\Familia\FamiliaFilterRules;
use App\Http\Controllers\Controller;
use App\Http\Requests\Familia\FamiliaRequest;
use App\Models\Catalogos\Familia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class FamiliasController extends Controller{




    protected $tableName = "familias";
    protected $navCat = "familias";
    protected $msg = "";



// ***************** MUESTRA EL LISTADO DE USUARIOS ++++++++++++++++++++ //

    /**
     * FamiliaController constructor.
     * @param string $msg
     */
    public function __construct(){
    }

    protected function index(Request $request){

        $this->lim_max_reg = config('ibt.limite_maximo_registros');
        $this->lim_min_reg = config('ibt.limite_minimo_registros');
        $this->max_reg_con = config('ibt.maximo_registros_consulta');
        $this->min_reg_con = config('ibt.minimo_registros_consulta');

        @ini_set( 'upload_max_size' , '16384M' );
        @ini_set( 'post_max_size', '16384M');
        @ini_set( 'max_execution_time', '960000' );

        $this->tableName = 'familias';
        $filters = new FamiliaFilterRules();
        $filters = $filters->filterRulesFamilia($request);

        $items = Familia::query()
            ->filterBySearch($filters)
            ->orderByDesc('id')
            ->paginate(250);
        $items->appends($filters)->fragment('table');

        $user = Auth::user();
        //$items =FunctionsEloquentClass::paginate($items, $this->max_reg_con);
        $items->appends($filters)->fragment('table');

        $request->session()->put('items', $items);

        //dd($items);

        return view('layouts.Catalogos.Familias._familias_list',[
            'items'        => $items,
            'user'         => $user,
            'tituloTabla'  => 'Listado de Familias',
            'newItem'      => 'newFamilia',
            'searchButton' => 'viewSearchModal',
            'excelButton'  => 'listFamiliasToXlsx',
            'editItem'     => 'editFamilia',
            'removeItem'   => 'removeFamilia',
            'listItems'    => 'listaFamilias',

        ]);
    }


    protected function newItem(){

        $user = Auth::user();
        return view('layouts.Catalogos.Familias._familia_edit',[
            "item"     => null,
            "Familia"     => $user,
            "titulo"   => "Nuevo registro ",
            'Route'    => 'createFamilia',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => true,
        ]);

    }

    protected function createItem(FamiliaRequest $request) {
        //dd($request);
        $Familia = $request->manage();
        if (!isset($Familia)) {
            abort(404);
        }
        dd($Familia);
        $user = Auth::user();
        session(['msg' => 'value']);
        return view('layouts.Catalogos.Familias._familia_edit',[
            "item"     => $Familia,
            "Familia"     => $user,
            "titulo"   => "Editando el registro: ".$Familia->id,
            'Route'    => 'updateFamilia',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => false,
        ]);

    }


    protected function editItem($Id){

        $Familia = Familia::find($Id);
        $user = Auth::user();

        return view('layouts.Catalogos.Familias._familia_edit',[
            "item"     => $Familia,
            "Familia"     => $user,
            "titulo"   => "Editando el registro: ".$Id,
            'Route'    => 'updateFamilia',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => false,
        ]);

    }

    protected function updateItem(FamiliaRequest $request) {
        $Familia = $request->manage();
        if (!isset($Familia)) {
            abort(404);
        }
        $user = Auth::user();
        session(['msg' => 'value']);
        return view('layouts.Catalogos.Familias._familia_edit',[
            "item"     => $Familia,
            "Familia"     => $user,
            "titulo"   => "Editando el registro: ".$Familia->id,
            'Route'    => 'updateFamilia',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => false,
        ]);

    }

    // ***************** ELIMINA AL USUARIO VIA AJAX ++++++++++++++++++++ //
    protected function removeItem($Id = 0, $dato1 = null, $dato2 = null){
        $code = 'OK';
        $msg = "Registro Eliminado con éxito!";
        //dd($Id);
        $user = Familia::withTrashed()->findOrFail($Id);
        $user->forceDelete();

        return Response::json(['mensaje' => $msg, 'data' => $code, 'status' => '200'], 200);

    }

    //    Attach miembro de la familia
    protected function attachMemberItem(FamiliaRequest $request) {
        //dd($request);
        $Familia = $request->manage();
        if (!isset($Familia)) {
            abort(404);
        }
        dd($Familia);
        $user = Auth::user();
        session(['msg' => 'value']);
        return view('layouts.Catalogos.Familias._familia_edit',[
            "item"     => $Familia,
            "Familia"     => $user,
            "titulo"   => "Editando el registro: ".$Familia->id,
            'Route'    => 'updateFamilia',
            'Method'   => 'POST',
            'msg'      => $this->msg,
            'IsUpload' => false,
            'IsNew'    => false,
        ]);

    }



}
