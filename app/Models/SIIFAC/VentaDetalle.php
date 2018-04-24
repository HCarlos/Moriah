<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VentaDetalle extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'venta_detalle';

    protected $fillable = [
        'venta_id', 'user_id', 'producto_id','paquete_id','almacen_id',
        'fecha', 'folio', 'cuenta','clave_producto','codigo',
        'descripcion', 'foliofac', 'porcdescto','cantidad','pv',
        'importe', 'descto', 'subtotal','iva','total',
        'ispagado', 'f_pagado', 'cantidad_devuelta','empresa_id',
        'status_venta_detalle','idemp','ip','host',
    ];

    public function user(){
        // Su usuario es
        return $this->belongsTo(User::class);
    }

    public function venta(){
        // Su usuario es
        return $this->belongsTo(Venta::class);
    }

    public function producto(){
        // Su usuario es
        return $this->belongsTo(Producto::class);
    }

    public function paquete(){
        // Su usuario es
        return $this->belongsTo(Paquete::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

}
