<?php

namespace App\Http\Controllers\Externos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\PaqueteDetalle;
use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\Producto;
use App\User;
use Composer\Package\Link;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Response;

class PaqueteExternoController extends Controller{


    public function getPaquetesLibrosPSAll($grupo_ps){

        $paqs = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet','empresa_id','idemp')->where('grupos_platsource','like','%'.$grupo_ps.'%' )
               ->get();

        foreach($paqs as $paq){
            $pd = PaqueteDetalle::select('id','paquete_id','producto_id','codigo','descripcion','cant','pv')
                  ->where('paquete_id',$paq->id)
                  ->get();
            foreach($pd as $p){
                $prod = Producto::find($p->producto_id);
                $p->existencia = $prod->exist;
            }                  
            $paq->detalle_paquete = $pd;
        }       
        
        return Response::json([
            'mensaje' => 'OK', 
            'encabezado_paquete' => $paqs, 
            'author' => '@DevCH', 
            'status' => '200'], 
            200);

    }

    public function getPaqueteLibro($paquete_id){

        $paq = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet','empresa_id','idemp')
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

        $pd = PaqueteDetalle::select('id','paquete_id','producto_id','codigo','descripcion','cant','pv')
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

    public function savePedido($Data){

        $arr = explode('¬',$Data);

        $IdFamilia     = intval($arr[0]);
        $IdAlumno      = intval($arr[1]);
        $IdGrupo       = intval($arr[2]);
        $IdUser        = intval($arr[3]);

        $arrIds        = explode('|',$arr[4]);
        $arrPrd        = explode('|',$arr[5]);
        $arrCnt        = explode('|',$arr[6]);
        $arrImp        = explode('|',$arr[7]);
        $Referencia    = $arr[8];
        $Observaciones = $arr[9];
        $CadenaUsuario = $arr[10];
        $TotalInternet = floatval($arr[11]);
        $IdPaquete     = intval($arr[12]);
        $IdEmpresa     = intval($arr[13]);
        $IdEmp         = intval($arr[14]);

        $userPS = User::select('id')->where('iduser_ps',$IdUser)->first();
        if ( !$userPS ){
            $User = User::createUserFromPlatsourceTutor($CadenaUsuario,$IdUser);
        }else{
            $User = $userPS;
        }

        $ped = Pedido::createPedidoFromPlatsourceTutor($User->id,$IdPaquete,$IdEmpresa,$arrIds,$arrPrd,$arrCnt,$arrImp,$Referencia,$Observaciones,$TotalInternet);
 
        return Response::json([
            'mensaje' => 'OK', 
            'data' => $Data, 
            'author' => '@DevCH', 
            'status' => '200'], 
            200);

    }
    

}
