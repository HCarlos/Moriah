<?php

namespace App\Http\Controllers\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Compra;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    protected $tableName = 'compras';
    protected $redirectTo = '/home';
    protected $F;
    public function __construct(){
        $this->middleware('auth');
        $this->F = (new FuncionesController);
    }

    public function index()
    {
        $user = Auth::User();
        $items = Compra::all()->sortByDesc('id');

        return view ('catalogos.operaciones.compras.compras',
            [
                'tableName' => 'compras',
                'compras' => $items,
                'user' => $user,
            ]
        );


    }
}
