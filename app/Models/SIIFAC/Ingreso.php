<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'ingresos';

    protected $fillable = [
        'user_id','cuenta','folio','num', 'cuenta_por_cobrar_id', 'foliofac', 'f_pagado',
        'subtotal','iva','total','tipo', 'origen', 'banco', 'cheque','fc_aplica','nota_credito',
        'status_ingreso','idemp','ip','host',
    ];

    public function users(){
        // Esta en muchos Usuarios
        return $this->hasMany(User::class);
    }

    public function cuentas_por_cobrar(){
        // Esta en muchos Usuarios
        return $this->hasMany(Cuenta_Por_Cobrar::class);
    }

}
