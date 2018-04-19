<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'almacenes';

    protected $fillable = [
        'clave_almacen', 'descripcion', 'responsable','tipoinv','prefijo',
        'status_almacen','idemp','ip','host',
    ];

    public function compras(){
        // Esta en muchas Compras
        return $this->belongsToMany(Compra::class);
    }

    public function movimientos(){
        // Esta en muchas Compras
        return $this->belongsToMany(Movimiento::class);
    }

}
