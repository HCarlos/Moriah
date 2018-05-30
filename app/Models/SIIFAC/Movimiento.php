<?php

namespace App\Models\SIIFAC;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;

class Movimiento extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'movimientos';

    protected $fillable = [
        'id',
        'user_id', 'venta_id', 'venta_detalle_id', 'compra_id', 'producto_id', 'pedido_id', 'proveedor_id', 'almacen_id', 'medida_id',
        'folio', 'clave', 'codigo', 'ejercicio', 'periodo', 'fecha', 'foliofac', 'nota', 'entrada',
        'salida', 'exlocal', 'existencia', 'pu', 'cu', 'debe', 'haber', 'descto', 'importe', 'iva', 'sllocal', 'saldo',
        'tipo', 'status', 'tipoinv','empresa_id',
        'status_movimiento', 'idemp', 'ip', 'host',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class);
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function compras()
    {
        return $this->belongsToMany(Compra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

    public function paquetes()
    {
        return $this->belongsToMany(Paquete::class);
    }

    public function pedidodetalle()
    {
        return $this->belongsTo(PedidoDetalle::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function almacenes()
    {
        return $this->belongsToMany(Almacen::class);
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function medidas()
    {
        return $this->belongsToMany(Medida::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }

    public static function agregarDesdeVentaDetalle(VentaDetalle $Vd)
    {
        $Prod = Producto::findOrFail($Vd->producto_id);
        $Existencia = $Prod->exist - $Vd->cantidad;
        $Fecha = Carbon::now();
        $Mov  =  static::create([
            'user_id'          => $Vd->user_id,
            'venta_id'         => $Vd->venta_id,
            'venta_detalle_id' => $Vd->id,
            'producto_id'      => $Prod->id,
            'paquete_id'       => $Vd->paquete_id,
            'pedido_id'        => $Vd->pedido_id,
            'empresa_id'       => $Vd->empresa_id,
            'proveedor_id'     => $Prod->proveedor_id,
            'almacen_id'       => $Prod->almacen_id,
            'medida_id'        => $Prod->medida_id,
            'folio'            => $Vd->folio,
            'clave'            => $Prod->clave_producto,
            'codigo'           => $Vd->codigo,
            'ejercicio'        => $Fecha->year,
            'periodo'          => $Fecha->month,
            'fecha'            => $Fecha,
            'salida'           => $Vd->cantidad,
            'existencia'       => $Existencia,
            'pu'               => $Prod->pv,
            'haber'            => $Vd->importe,
            'descto'           =>  $Vd->descto,
            'importe'          =>  $Vd->subtotal,
            'iva'              =>  $Vd->iva,
            'saldo'            =>  $Vd->total,
            'idemp'            => 1,
            'ip'               => Request::ip(),
            'host'             => Request::getHttpHost(),
        ]);
        $Prod->exist = $Existencia;
        $Prod->save();

        $Mov->users()->attach($Vd->user_id);
        $Mov->empresas()->attach($Vd->empresa_id);
        $Mov->ventas()->attach($Vd->venta_id);
        $Mov->productos()->attach($Prod->id);
        $Mov->proveedores()->attach($Prod->proveedor_id);
        $Mov->almacenes()->attach($Vd->almacen_id);
        $Mov->medidas()->attach($Prod->medida_id);
        $Mov->paquetes()->attach($Vd->paquete_id);

    }


}