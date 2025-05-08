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
        $this->Empresa_Id = (int)Session::get('Empresa_Id');
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
    }


    public function index(){
        $this->Empresa_Id = (int)Session::get('Empresa_Id');
        if ($this->Empresa_Id <= 0){
            return redirect('openEmpresa');
        }
        return view('/home');
    }

    public function openViewEmpresa(){
        $Emp = Empresa::query()->get();
        $this->initEmpresa();
        return view('open_empresa',[
            'Empresa' => $Emp,
        ]);
    }

    public function setEmpresa(Request $request){
        $data = $request->all('Empresa_Id');
        $Emp = Empresa::where('id',$data['Empresa_Id'])->first();
        if ( (int)$data['Empresa_Id'] > 0 ){
            session([
                'Empresa_Id' => (int)$Emp->id,
                'RS' => $Emp->rs,
            ]);
            dd($Emp);
            return redirect('/home');
        }else{
            dd("error");
            return redirect('openEmpresa');
        }
        //return view('open_empresa');
    }

    public function initEmpresa(){
            session([
                'Empresa_Id' => 0,
                'RS' => '',
            ]);
        return true;
    }

}
