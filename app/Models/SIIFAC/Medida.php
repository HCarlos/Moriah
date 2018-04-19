<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Medida extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'medidas';

    protected $fillable = [
        'desc1','desc2','clave',
        'status_medida','idemp','ip','host',
    ];

    public function productos(){
        // Contiene muchos Roles
        return $this->belongsToMany(Producto::class);
    }

    public function pedidos(){
        // Contiene muchos Roles
        return $this->belongsToMany(Pedido::class);
    }

    public function paquete_producto_detalles(){
        // Contiene muchos Roles
        return $this->belongsToMany(Paquete__Detalle::class);
    }

    public function medidas_detalles(){
        // Contiene muchos Roles
        return $this->belongsToMany(Pedido_Detalle::class);
    }

    public function movimientos(){
        // Esta en muchas Compras
        return $this->belongsToMany(Movimiento::class);
    }


}
