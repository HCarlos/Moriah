<?php

namespace App\Http\Controllers\Externos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\PaqueteDetalle;
use App\Models\SIIFAC\Producto;
use Illuminate\Support\Facades\Response;

class PaqueteExternoController extends Controller{


    public function getPaquetesLibrosPSAll($grupo_ps){

        $grupos = explode(',',$grupo_ps);
        $paqs = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet')->whereIn('grupos_platsource',$grupos)
               ->get();

        foreach($paqs as $paq){
            $pd = PaqueteDetalle::select('producto_id','codigo','descripcion','cant','pv')
                  ->where('paquete_id',$paq->id)
                  ->get();
            foreach($pd as $p){
                $prod = Producto::find($p->producto_id);
                $p->existencia = $prod->exist;
            }                  
            $paq->detalle_paquete = $pd;
        }       
        $arr = [
            'mensaje' => 'OK', 
            'encabezado_paquete' => $paqs, 
            'author' => '@DevCH', 
            'status' => '200'];

        // return Response::json([
        //     'mensaje' => 'OK', 
        //     'encabezado_paquete' => $paqs, 
        //     'author' => '@DevCH', 
        //     'status' => '200'], 
        //     200);
        
        return json_encode($arr);

    }

    public function getPaqueteLibro($paquete_id){

        $paq = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet')
                ->where('id',$paquete_id)
               ->get();

        return Response::json([
            'mensaje' => 'OK', 
            'encabezado_paquete' => $paq, 
            'author' => '@DevCH', 
            'status' => '200'], 
            200);

    }

    public function getPaqueteLibroDetalle($paquete_id){

        $pd = PaqueteDetalle::select('producto_id','codigo','descripcion','cant','pv')
        ->where('paquete_id',$paquete_id)
        ->get();
        foreach($pd as $p){
            $prod = Producto::find($p->producto_id);
            $p->existencia = $prod->exist;
        }                  

        return Response::json([
            'mensaje' => 'OK', 
            'detalle_paquete' => $pd, 
            'author' => '@DevCH', 
            'status' => '200'], 
            200);

    }


    

}
