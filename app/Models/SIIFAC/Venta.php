<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'ventas';

    protected $fillable = [
        'fecha', 'clave', 'foliofac','tipoventa','cuenta',
        'isimp', 'cantidad', 'importe','descto','subtotal',
        'iva', 'total', 'ispagado','f_pagado','user_id',
        'empresa_id',
        'status_venta','idemp','ip','host',
    ];

    public function user(){
        // Su usuario es
        return $this->belongsTo(User::class);
    }

    public function ventaDetalles(){
        // Tiene muchos en detalles
        return $this->hasMany(VentaDetalle::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }    //

}
