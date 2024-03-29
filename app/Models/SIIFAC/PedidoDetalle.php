<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;
use Request;

class PedidoDetalle extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'pedido_detalles';


    protected $fillable = [
        'id','pedido_id', 'user_id', 'producto_id', 'medida_id', 'codigo',
        'descripcion_producto','cant','pv','comp1','empresa_id',
        'status_pedido_detalle','idemp','ip','host',
    ];

    public function user(){
        // Esta en muchos Usuarios
        return $this->belongsTo(User::class);
    }

    public function pedido(){
        // Esta en muchos Usuarios
        return $this->belongsTo(Pedido::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function medida(){
        return $this->belongsTo(Medida::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }


    public static function asignProductoAPedidoDetalle($pedido_id, $user_id, $paquete_id, $empresa_id){
        $pqd = PaqueteDetalle::where('paquete_id',$paquete_id)->get();
        foreach ($pqd as $p){
            $peds = static::findOrCreatePedidoDetalle($pedido_id,$p->id,$user_id,$empresa_id,0,1);
        }
        if ( !is_null($peds) ){
            Pedido::UpdateImporteFromPedidoDetalle($peds->pedido_id);
        }
        return $pqd;
    }


    public static function asignProductoAPedidoDetalleFromPlatsource($pedido_id, $user_id, $paquete_id, $empresa_id,$arrIds,$arrPrd,$arrCnt,$arrImp){
        $f = new FuncionesController();
        $_Ids = $arrIds;
        $_Prd = $arrPrd;
        $_Cnt = $arrCnt;
        $_Imp = $arrImp;
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        foreach($_Ids as $i => $valor){
            $p = Producto::find( intval($_Prd[$i]) );
            if ( $p && $Empresa_Id > 0 ){
                $pd = PedidoDetalle::create([
                    'pedido_id' => $pedido_id,
                    'user_id' => $user_id,
                    'producto_id' => $p->id,
                    'medida_id' => $p->medida_id,
                    'codigo' => $p->codigo,
                    'descripcion_producto' => $p->descripcion,
                    'cant' => intval($_Cnt[$i]),
                    'pv' => $p->pv,
                    'comp1' => $p->comp1,
                    'empresa_id' => $Empresa_Id,
                    'idemp' => $Empresa_Id,
                    'ip' => $f->getIHE(1),
                    'host' => $f->getIHE(1),
                ]);
                $ped = Pedido::find($pedido_id);
                $prod = Producto::find( intval($_Prd[$i]) );
        
                $pd->productos()->detach($prod);
                $ped->detalles()->detach($pd);
                $ped->productos()->detach($prod);
        
                $pd->productos()->attach($prod);
                $ped->detalles()->attach($pd);
                $ped->productos()->attach($prod);
    
            }
            
        }
        $pd = static::all()->where('pedido_id',$pedido_id);
        Pedido::UpdateImporteFromPedidoDetallePlatsource($pd);
        return $pd;
    }

    
    public static function findOrCreatePedidoDetalle($pedido_id,$paquete_detalle_id,$user_id,$empresa_id,$producto_id,$cantidad){
        $comp = 0;
        if ($paquete_detalle_id > 0) {
            $p = PaqueteDetalle::find($paquete_detalle_id);
            $producto_id = $p->producto_id;
            $comp = $p->comp1;
        }else{
            $p = Producto::find($producto_id);
            $producto_id = $p->id;
        }
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ( $Empresa_Id > 0) {
            $pd = PedidoDetalle::create([
                'pedido_id' => $pedido_id,
                'user_id' => $user_id,
                'producto_id' => $producto_id,
                'medida_id' => $p->medida_id,
                'codigo' => $p->codigo,
                'descripcion_producto' => $p->descripcion,
                'cant' => $cantidad,
                'pv' => $p->pv,
                'comp1' => $comp,
                'empresa_id' => $Empresa_Id,
                'idemp' => $Empresa_Id,
                'ip' => Request::ip(),
                'host' => Request::getHttpHost(),
            ]);
//            dd($pd);
            $ped = Pedido::find($pedido_id);
            $prod = Producto::find($producto_id);

            $pd->productos()->detach($prod);
            $ped->detalles()->detach($pd);
            $ped->productos()->detach($prod);


            $pd->productos()->attach($prod);
            $ped->detalles()->attach($pd);
            $ped->productos()->attach($prod);

            return $pd;

        }else{
            return null;
        }

    }


    public static function updatePedidoDetalleFromProducto(Producto $prod){
        $f = new FuncionesController();
        $dets = static::all()->where('producto_id',$prod->id);

        foreach ($dets as $det){

            $pd = PedidoDetalle::create([
                'producto_id' => $prod->id,
                'medida_id' => $prod->medida_id,
                'codigo' => $prod->codigo,
                'descripcion_producto' => $prod->descripcion,
                'pv' => $prod->pv,
                'comp1' => $prod->comp1,
                'empresa_id' => $prod->empresa_id,
                'idemp' => $prod->idemp,
                'ip' => $f->getIHE(1),
                'host' => $f->getIHE(2),
            ]);

            Paquete::UpdateImporteFromPaqueteDetalle($dets);

            return $pd;

        }
        return $dets;
    }





}
