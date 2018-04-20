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

    public function productos(){
        // Contiene muchos Roles
        return $this->hasMany(Producto::class);
    }

    public function pedidos(){
        // Contiene muchos Roles
        return $this->hasMany(Pedido::class);
    }

    public function paquete_detalles(){
        // Contiene muchos Roles
        return $this->hasMany(Paquete__Detalle::class);
    }

    public function medidas_detalles(){
        // Contiene muchos Roles
        return $this->hasMany(Pedido_Detalle::class);
    }

    public function movimientos(){
        // Esta en muchas Compras
        return $this->hasMany(Movimiento::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }


}
