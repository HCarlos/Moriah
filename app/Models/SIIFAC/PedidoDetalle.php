<?php

namespace App\Models\SIIFAC;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
            static::findOrCreatePedidoDetalle($pedido_id,$p->id,$user_id,$empresa_id,0);
        }
        return $pqd;
    }

    public static function findOrCreatePedidoDetalle($pedido_id,$paquete_detalle_id,$user_id,$empresa_id,$producto_id){
        if ($paquete_detalle_id > 0) {
            $p = PaqueteDetalle::find($paquete_detalle_id);
            $producto_id = $p->producto_id;
        }else{
            $p = Producto::find($producto_id);
            $producto_id = $p->id;
        }
        $pd = PedidoDetalle::create([
            'pedido_id' => $pedido_id,
            'user_id' => $user_id,
            'producto_id' => $producto_id,
            'medida_id' => $p->medida_id,
            'codigo' => $p->codigo,
            'descripcion_producto' => $p->descripcion,
            'cant' => $p->cant,
            'pv' => $p->pv,
            'comp1' => $p->comp1,
            'empresa_id' => $empresa_id,
            'idemp' => 1,
            'ip' => Request::ip(),
            'host' => Request::getHttpHost(),
        ]);
        $ped = Pedido::find($pedido_id);
        $prod = Producto::find($producto_id);

        $pd->productos()->detach($prod);
        $ped->detalles()->detach($pd);
        $ped->productos()->detach($prod);

        $pd->productos()->attach($prod);
        $ped->detalles()->attach($pd);
        $ped->productos()->attach($prod);

    return $pd;

    }

}
