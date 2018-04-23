<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'empresas';

    protected $fillable = [
        'rs','ncomer','df','rfc',
        'status_empresa','ip','host',
    ];

    public function almacenes()
    {
        return $this->hasMany(Almacen::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    public function conceptos()
    {
        return $this->hasMany(Concepto::class);
    }

    public function configs()
    {
        return $this->hasMany(Config::class);
    }

    public function cuentasPorCobrar()
    {
        return $this->hasMany(CuentaPorCobrar::class);
    }

    public function familiasCliente()
    {
        return $this->hasMany(FamiliaCliente::class);
    }

    public function familiasProducto()
    {
        return $this->hasMany(FamiliaProducto::class);
    }

    public function ingresos()
    {
        return $this->hasMany(Ingreso::class);
    }

    public function medidas()
    {
        return $this->hasMany(Medida::class);
    }

    public function movimientos()
    {
        return $this->hasMany(Movimiento::class);
    }

    public function notasCredito()
    {
        return $this->hasMany(NotaCredito::class);
    }

    public function notaCreditoDetalles()
    {
        return $this->hasMany(NotaCreditoDetalle::class);
    }

    public function paquetes()
    {
        return $this->hasMany(Paquete::class);
    }

    public function paqueteDetalles()
    {
        return $this->hasMany(PaqueteDetalle::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function pedidoDetalles()
    {
        return $this->hasMany(PedidoDetalle::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class);
    }

    public static function findOrCreateEmpresa($rs, $ncomer, $df, $rfc){
        $emresa = static::all()->where('rs', $rs)->where('ncomer', $ncomer)->first();
        if (!$emresa) {
            return static::create([
                'rs'=>$rs,
                'ncomer'=>$ncomer,
                'df'=>$df,
                'rfc'=>$rfc,
            ]);
        }
        return $emresa;
    }


}
