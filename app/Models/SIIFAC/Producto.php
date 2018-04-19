<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'productos';

    protected $fillable = [
        'almacen_id','familia_producto_id','medida_id','clave', 'codigo', 'descripcion', 'shortdesc',
        'maximo','minimo','isiva','fecha', 'tipo', 'pv', 'porcdescto','inicia_descuento','termina_descuento',
        'moneycli','exist','cu','saldo', 'propiedades_producto', 'filename', 'root',
        'status_producto','idemp','ip','host',
    ];
    protected $casts = ['isiva'=>'boolean',];

    public function isIVA(){
        return $this->isiva;
    }

    public function almacenes(){
        // Esta en muchos Almacenes
        return $this->hasMany(Almacen::class);
    }

    public function familia_producto(){
        // Esta en muchos familia de productos
        return $this->hasMany(Familia_Producto::class);
    }

    public function medidas(){
        // Esta en muchos medidas
        return $this->hasMany(Medida::class);
    }

    public function paquete_producto_detalles(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Paquete__Detalle::class);
    }

    public function pedidos_detalles(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Pedido_Detalle::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Movimiento::class);
    }

}
