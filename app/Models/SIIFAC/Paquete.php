<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Paquete_ extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'paquetes_producto';

    protected $fillable = [
        'user_id', 'descripcion_paquete',
        'status_paquete','idemp','ip','host',
    ];

    public function users(){
        // Esta en muchos Usuarios
        return $this->hasMany(User::class);
    }

    public function detalles(){
        // Contiene muchos Roles
        return $this->belongsToMany(Paquete__Detalle::class);
    }


}
