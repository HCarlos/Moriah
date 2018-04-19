<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'proveedores';

    protected $fillable = [
        'clave_proveedor', 'nombre_proveedor', 'contacto_proveedor','domicilio_fiscal_proveedor',
        'status_proveedores','idemp','ip','host',
    ];

    public function proveedores(){
        // Esta en muchas Compras
        return $this->hasMany(Compra::class);
    }

    public function users(){
        // Esta en muchos Usuarios
        return $this->hasMany(User::class);
    }

    public function detalles(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Pedido_Detalle::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Movimiento::class);
    }

}
