<?php

namespace App\Models\SIIFAC;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido_Detalle extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'pedido_detalle';


    protected $fillable = [
        'pedido_id', 'user_id', 'producto_id', 'medida_id', 'codigo',
        'descripcion_producto','cant','pv','comp1','empresa_id',
        'status_pedido_detalle','idemp','ip','host',
    ];

    public function user(){
        // Esta en muchos Usuarios
        return $this->belongsTo(User::class);
    }

    public function pedido(){
        // Esta en muchos Usuarios
        return $this->belongsTo(Pedido::class);
    }

    public function producto(){
        // Esta en muchos Usuarios
        return $this->belongsTo(Producto::class);
    }

    public function medida(){
        // Esta en muchos Usuarios
        return $this->belongsTo(Medida::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
