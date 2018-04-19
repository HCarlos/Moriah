<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'compras';

    protected $fillable = [
        'almacen_id', 'proveedor_id', 'folio_factura','nota_id',
        'fecha','importe','descuento','subtotal','iva',
        'credito','observaciones','status_compras','total','tipo',
        'idemp','ip','host',
    ];

    protected $casts = ['credito'=>'boolean',];

    public function isCredito(){
        return $this->credito;
    }

    public function almacenes() {
        // Contiene muchos Permisos
        return $this->hasMany(Almacen::class);
    }

    public function proveedores(){
        // Contiene muchos Roles
        return $this->hasMany(Proveedor::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Movimiento::class);
    }


}
