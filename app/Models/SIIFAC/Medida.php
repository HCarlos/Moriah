<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medida extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'medidas';

    protected $fillable = [
        'desc1','desc2','clave','empresa_id',
        'status_medida','idemp','ip','host',
    ];

    public function productos_list(){
        // Contiene muchos Roles
        return $this->hasMany(Producto::class);
    }

    public function pedidos(){
        // Contiene muchos Roles
        return $this->hasMany(Pedido::class);
    }

    public function paqueteDetalles(){
        // Contiene muchos Roles
        return $this->hasMany(PaqueteDetalle::class);
    }

    public function medidasDetalles(){
        // Contiene muchos Roles
        return $this->hasMany(PedidoDetalle::class);
    }

    public function movimientos(){
//        return $this->hasMany(Movimiento::class);
        return $this->belongsToMany(Movimiento::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }

    public static function findOrCreateMedida($desc1, $desc2, $clave, $empresa_id){
        $obj = static::all()->where('desc1', $desc1)->first();
        if (!$obj) {
            return static::create([
                'desc1'=>$desc1,
                'desc2'=>$desc2,
                'clave'=>$clave,
                'empresa_id'=>$empresa_id,
            ]);
        }
        return $obj;
    }

}
