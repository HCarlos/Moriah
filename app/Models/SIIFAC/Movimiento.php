<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'movimientos';

    protected $fillable = [

        'user_id', 'compra_id', 'producto_id', 'pedido_id', 'proveedor_id', 'almacen_id', 'medida_id',
        'folio', 'clave', 'codigo', 'ejercicio', 'periodo', 'fecha', 'foliofac', 'nota', 'entrada',
        'salida', 'exlocal', 'existencia', 'pu', 'cu', 'debe', 'haber', 'descto', 'importe', 'iva', 'sllocal', 'saldo',
        'tipo', 'status', 'tipoinv','empresa_id',
        'status_movimiento', 'idemp', 'ip', 'host',
    ];

    public function user()
    {
        // Esta en muchos Almacenes
        return $this->belongsTo(User::class);
    }

    public function compra()
    {
        // Esta en muchos Almacenes
        return $this->belongsTo(Compra::class);
    }

    public function producto()
    {
        // Esta en muchos familia de productos
        return $this->belongsTo(Producto::class);
    }

    public function pedido()
    {
        // Esta en muchos familia de productos
        return $this->belongsTo(PedidoDetalle::class);
    }

    public function proveedor()
    {
        // Esta en muchos familia de productos
        return $this->belongsTo(Proveedor::class);
    }

    public function almacen()
    {
        // Esta en muchos Almacenes
        return $this->belongsTo(Almacen::class);
    }

    public function medida()
    {
        // Esta en muchos medidas
        return $this->belongsTo(Medida::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}