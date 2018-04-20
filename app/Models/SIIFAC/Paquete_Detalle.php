<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paquete_Detalle extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'paquete_detalle';

    protected $fillable = [
        'paquete_id', 'producto_id', 'medida_id', 'codigo', 'descripcion', 'cant','pv','comp1','empresa_id',
        'status_paquete_producto_detalle','idemp','ip','host',
    ];

    public function paquete(){
        // Esta en muchos Usuarios
        return $this->belongsTo(Paquete_::class);
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
