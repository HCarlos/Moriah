<?php

namespace App\Http\Controllers\Externos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\PaqueteDetalle;
use Illuminate\Support\Facades\Response;

class PaqueteExternoController extends Controller{


    public function getLibrosPS($grupo_ps){

        $grupos = explode(',',$grupo_ps);
        $paqs = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet')->whereIn('grupos_platsource',$grupos)
               ->get();

        foreach($paqs as $paq){
            $pd = PaqueteDetalle::select('codigo','descripcion','cant','pv')
                  ->where('paquete_id',$paq->id)
                  ->get();
            $paq->detalle_paquete = $pd;
        }       
        
        return Response::json([
            'mensaje' => 'OK', 
            'encabezado_paquete' => $paqs, 
            'author' => '@DevCH', 
            'status' => '200'], 
            200);

    }


    

}
