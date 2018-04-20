<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'productos';

    protected $fillable = [
        'almacen_id','familia_producto_id','medida_id','clave', 'codigo', 'descripcion', 'shortdesc',
        'maximo','minimo','isiva','fecha', 'tipo', 'pv', 'porcdescto','inicia_descuento','termina_descuento',
        'moneycli','exist','cu','saldo', 'propiedades_producto', 'filename', 'root','empresa_id',
        'status_producto','idemp','ip','host',
    ];
    protected $casts = ['isiva'=>'boolean',];

    public function isIVA(){
        return $this->isiva;
    }

    public function almacenes(){
        // Esta en muchos Almacenes
        return $this->hasMany(Almacen::class);
    }

    public function familia_producto(){
        // Esta en muchos familia de productos
        return $this->belongsTo(Familia_Producto::class);
    }

    public function medida(){
        // Esta en muchos medidas
        return $this->belongsTo(Medida::class);
    }

    public function paquete_detalles(){
        // Contiene muchos Ingresos
        return $this->hasMany(Paquete__Detalle::class);
    }

    public function pedidos_detalles(){
        // Contiene muchos Ingresos
        return $this->hasMany(Pedido_Detalle::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->hasMany(Movimiento::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
