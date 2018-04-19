<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'proveedores';

    protected $fillable = [
        'clave_proveedor', 'nombre_proveedor', 'contacto_proveedor','domicilio_fiscal_proveedor',
        'status_proveedores','idemp','ip','host',
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
