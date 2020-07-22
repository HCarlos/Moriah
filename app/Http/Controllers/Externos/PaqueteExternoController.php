<?php

namespace App\Http\Controllers\Externos;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\PaqueteDetalle;
use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\PedidoDetalle;
use App\Models\SIIFAC\Producto;
use App\User;
use Composer\Package\Link;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Response;

class PaqueteExternoController extends Controller{

    protected $UrlBase = 'https://moriah.mx/print_pedido/';


    public function getPaquetesLibrosPS($grupo_ps, $iduser_ps, $username){
        $ps = User::select('id','ap_paterno','ap_materno','nombre')
            ->where('iduser_ps',$iduser_ps)
            ->whereRaw("username like ('%".trim($username)."%')")
            ->first();
        
        $paqs = Paquete::select('id','grupos_platsource')
        ->where('grupos_platsource','like','%'.$grupo_ps.'%' )
        ->get();
        $cad = "";
        foreach($paqs as $p){
            $arr = explode(',',$p->grupos_platsource);
            if (  in_array($grupo_ps,$arr) ){
                if ($cad == ""){
                    $cad .=$p->id; 
                }else{
                    $cad .=",".$p->id; 
                }
            }
        }

        $arrCad = explode(',',$cad);
        $paqs = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet','empresa_id','idemp','grupos_platsource')
        ->whereIn('id', $arrCad)
        ->get();


        foreach($paqs as $paq){


            if ( !is_null($ps) ){
                $peds = Pedido::select('id')
                ->where('paquete_id',$paq->id)
                ->where('user_id',$ps->id)
                ->where('isactivo',true)
                ->first();
    
            }else{
                $peds = null;
            }


            if ( !is_null($peds) ){
                $paq->url_pedido = $this->UrlBase.$peds->id;
            }else{
                $paq->url_pedido = "";
            }

            $paq->Usuario = is_null($ps) ? "" : $ps->FullName;
        }

        return Response::json([
            'mensaje' => 'OK', 
            'encabezado_paquete' => $paqs, 
            'author' => '@DevCH', 
            'status' => '200'], 
            200);

    }



    public function getPaquetesLibrosPSAll($grupo_ps, $iduser_ps){

        $ps = User::select('id','ap_paterno','ap_materno','nombre')->where('iduser_ps',$iduser_ps)->first();

        $paqs = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet','empresa_id','idemp','grupos_platsource')
        ->where('grupos_platsource','like','%'.$grupo_ps.'%' )
        ->get();
        $IdPaq = 0;
        foreach($paqs as $p){
            $arr = explode(',',$p->grupos_platsource);
            if (  in_array($grupo_ps,$arr) ){
                $IdPaq = $p->id;
            }
        }

        // dd($IdPaq);

        $paq = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet','empresa_id','idemp','grupos_platsource')
        ->where('id',$IdPaq )
        ->first();

        // dd($paq);

        // foreach($paqs as $paq){
            if ( !is_null($ps) ){
                $peds = Pedido::select('id')
                ->where('paquete_id',$paq->id)
                ->where('user_id',$ps->id)
                ->where('isactivo',true)
                ->first();
    
            }else{
                $peds = null;
            }


            // dd($peds);    


            if ( !is_null($peds) ){
                $paq->url_pedido = $this->UrlBase.$peds->id;
            }else{
                $paq->url_pedido = "";
            }

            $paq->Usuario = is_null($ps) ? "" : $ps->FullName;

            $pd = PaqueteDetalle::select('id','paquete_id','producto_id','codigo','descripcion','cant','pv')
                  ->where('paquete_id',$paq->id)
                  ->orderBy('id')
                  ->get();
            foreach($pd as $p){
                $prod = Producto::find($p->producto_id);
                $p->existencia = $prod->exist;
            }                  
            $paq->detalle_paquete = $pd;

        // }       
        
        return Response::json([
            'mensaje' => 'OK', 
            'encabezado_paquete' => $paq, 
            'author' => '@DevCH', 
            'status' => '200'], 
            200);

    }

    public function getPaqueteLibro($paquete_id){

        $paqs = Paquete::select('id','codigo','descripcion_paquete','importe','filename','root','isvisibleinternet','total_internet','empresa_id','idemp','grupos_platsource')
        ->where('grupos_platsource','like','%'.$grupo_ps.'%' )
        ->get();
        $IdPaq = 0;
        foreach($paqs as $p){
            $arr = explode(',',$p->grupos_platsource);
            if (  in_array($grupo_ps,$arr) ){
                $IdPaq = $p->id;
            }
        }


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
        ->orderBy('id')
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
        $Username      = intval($arr[15]);

        $arrCad = explode('|',$CadenaUsuario);
        $Username = $arrCad[10];

        $userPS = User::select('id')
        ->where('iduser_ps',$IdUser)
        ->whereRaw("username like ('%".trim($Username)."%')")
        ->first();


        if ( is_null($userPS) ){
            $User = User::createUserFromPlatsourceTutor($CadenaUsuario,$IdUser,$IdUser);
        }
        $User = $userPS;


        $ped = Pedido::createPedidoFromPlatsourceTutor($User->id,$IdPaquete,$IdEmpresa,$arrIds,$arrPrd,$arrCnt,$arrImp,$Referencia,$Observaciones,$TotalInternet);
 
        $pd = PedidoDetalle::select('id','pedido_id','producto_id','codigo','descripcion_producto','cant','pv')
        ->where('pedido_id',$ped->id)
        ->orderBy('id')
        ->get();

        return Response::json([
            'mensaje' => 'OK', 
            'url' => $this->UrlBase.$ped->id, 
            'author' => '@DevCH', 
            'status' => '200'], 
            200);


    }
    

}
