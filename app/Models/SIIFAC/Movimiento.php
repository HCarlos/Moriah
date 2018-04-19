<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'movimientos';

    protected $fillable = [

        'user_id', 'compra_id', 'producto_id', 'pedido_id', 'proveedor_id', 'almacen_id', 'medida_id',
        'folio', 'clave', 'codigo', 'ejercicio', 'periodo', 'fecha', 'foliofac', 'nota', 'entrada',
        'salida', 'exlocal', 'existencia', 'pu', 'cu', 'debe', 'haber', 'descto', 'importe', 'iva', 'sllocal', 'saldo',
        'tipo', 'status', 'tipoinv',
        'status_movimiento', 'idemp', 'ip', 'host',
    ];

    public function users()
    {
        // Esta en muchos Almacenes
        return $this->hasMany(User::class);
    }

    public function compras()
    {
        // Esta en muchos Almacenes
        return $this->hasMany(Compra::class);
    }

    public function productos()
    {
        // Esta en muchos familia de productos
        return $this->hasMany(Producto::class);
    }

    public function pedidos()
    {
        // Esta en muchos familia de productos
        return $this->hasMany(Pedido_Detalle::class);
    }

    public function proveedores()
    {
        // Esta en muchos familia de productos
        return $this->hasMany(Proveedor::class);
    }

    public function almacenes()
    {
        // Esta en muchos Almacenes
        return $this->hasMany(Almacen::class);
    }

    public function medidas()
    {
        // Esta en muchos medidas
        return $this->hasMany(Medida::class);
    }

}