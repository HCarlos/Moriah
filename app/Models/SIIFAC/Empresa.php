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

    public function cuentas_por_cobrar()
    {
        return $this->hasMany(Cuenta_Por_Cobrar::class);
    }

    public function familias_cliente()
    {
        return $this->hasMany(Familia_Cliente::class);
    }

    public function familias_producto()
    {
        return $this->hasMany(Familia_Producto::class);
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

    public function notas_credito()
    {
        return $this->hasMany(Nota_Credito::class);
    }

    public function nota_credito_detalles()
    {
        return $this->hasMany(Nota_Credito_Detalle::class);
    }

    public function paquetes()
    {
        return $this->hasMany(Paquete::class);
    }

    public function paquete_detalles()
    {
        return $this->hasMany(Paquete_Detalle::class);
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    public function pedido_detalles()
    {
        return $this->hasMany(Pedido_Detalle::class);
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function proveedores()
    {
        return $this->hasMany(Proveedor::class);
    }

    public static function findOrCreateEmpresa(string $rs, string $ncomer, string $df, string $rfc){
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
