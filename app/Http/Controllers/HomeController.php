<?php

namespace App\Http\Controllers;

use App\Models\SIIFAC\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
     protected $Empresa_Id = 0;

    public function __construct()
    {
        $this->middleware('auth');
        $this->Empresa_Id = intval(Session::get('Empresa_Id'));
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
    }


    public function index(){
        $this->Empresa_Id = intval(Session::get('Empresa_Id'));
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
        return view('/home');
    }

    public function openViewEmpresa(){
        $Emp = Empresa::all();
        return view('open_empresa',[
            'Empresa' => $Emp,
        ]);
    }

    public function setEmpresa(Request $request){
        $data = $request->all('Empresa_Id');
        $Emp = Empresa::where('id',$data['Empresa_Id'])->first();
        if ( intval($data['Empresa_Id']) > 0 ){
            session([
                'Empresa_Id' => intval($Emp->id),
                'RS' => $Emp->rs,
            ]);
            return redirect('/home');
        }else{
            return redirect('openEmpresa');
        }
        //return view('open_empresa');
    }

}
