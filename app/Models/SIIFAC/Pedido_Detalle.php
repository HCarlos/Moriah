<?php

namespace App\Models\SIIFAC;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Pedido_Detalle extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'pedidos_detalles';


    protected $fillable = [
        'pedido_id', 'user_id', 'producto_id', 'medida_id', 'codigo', 'descripcion_producto','cant','pv','comp1',
        'status_pedido_detalle','idemp','ip','host',
    ];

    public function users(){
        // Esta en muchos Usuarios
        return $this->hasMany(User::class);
    }

    public function pedidos(){
        // Esta en muchos Usuarios
        return $this->hasMany(Pedido::class);
    }

    public function productos(){
        // Esta en muchos Usuarios
        return $this->hasMany(Producto::class);
    }

    public function medidas(){
        // Esta en muchos Usuarios
        return $this->hasMany(Medida::class);
    }}
