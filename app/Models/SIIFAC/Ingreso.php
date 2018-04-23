<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ingreso extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'ingresos';

    protected $fillable = [
        'user_id','cuenta','folio','num', 'cuenta_por_cobrar_id', 'foliofac', 'f_pagado',
        'subtotal','iva','total','tipo', 'origen', 'banco', 'cheque','fc_aplica','nota_credito','empresa_id',
        'status_ingreso','idemp','ip','host',
    ];

    public function user(){
        // Esta en muchos Usuarios
        return $this->belongsTo(User::class);
    }

    public function cuentasPorCobrar(){
        // Esta en muchos Usuarios
        return $this->belongsToMany(CuentaPorCobrar::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
