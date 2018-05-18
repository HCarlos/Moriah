<?php

namespace App\Http\Controllers\Funciones;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FuncionesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //
    public function toMayus($str=""){
        return strtr(strtoupper($str), "áéíóúñ", "ÁÉÍÓÚÑ");
    }

    public function showFile($root="/archivos/",$archivo=""){
        $public_path = public_path();
        $url = $public_path."/archivos/".$root.$archivo;
        if (Storage::exists($archivo))
        {
            return response()->download($url);
        }
        abort(404);
    }

    public function string_to_tsQuery(String $string, String $type){
        $str = explode(' ',$string);
        //dd($str);
        $string = '';
        $i = 1;
        foreach ($str as $value){
            if ( strlen($value) >= 4 ){
                $vector = '';
                if ($string!=''){
                    $vector = $type;
                }
                $string = $string.$vector.$value;
            }
            ++$i;
        }
        return $string;
    }
    // get IP, Host or IdEmp
    public function getIHE($type=0){
        switch ($type){
            case 0:
                return 1;
                beark;
            case 1:
                return $_SERVER['REMOTE_ADDR'];
                beark;
            case 2:
                return gethostbyaddr($_SERVER['REMOTE_ADDR']);
                beark;
        }
    }

}
