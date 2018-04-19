<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Paquete__Detalle extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'paquetes_producto_detalle';

    protected $fillable = [
        'paquete_id', 'producto_id', 'medida_id', 'codigo', 'descripcion', 'cant','pv','comp1',
        'status_paquete_producto_detalle','idemp','ip','host',
    ];

    public function paquetes_productos(){
        // Esta en muchos Usuarios
        return $this->hasMany(Paquete_::class);
    }

    public function productos(){
        // Esta en muchos Usuarios
        return $this->hasMany(Producto::class);
    }

    public function medidas(){
        // Esta en muchos Usuarios
        return $this->hasMany(Medida::class);
    }


}
