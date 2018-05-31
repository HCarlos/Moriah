<?php

namespace App\Models\SIIFAC;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;

class VentaDetalle extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'venta_detalles';

    protected $fillable = [
        'id',
        'venta_id', 'user_id', 'producto_id','paquete_id','pedido_id','almacen_id','empresa_id',
        'fecha', 'folio', 'cuenta','clave_producto','codigo',
        'descripcion', 'foliofac', 'porcdescto','cantidad','pv',
        'importe', 'descto', 'subtotal','iva','total',
        'ispagado', 'f_pagado', 'cantidad_devuelta','cantidad','pv',
        'status_venta_detalles','idemp','ip','host',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function ventas(){
        return $this->belongsToMany(Venta::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }

    public function paquete(){
        return $this->belongsTo(Paquete::class);
    }

    public function paquetes(){
        return $this->belongsToMany(Paquete::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

    public function almacenes(){
        return $this->belongsToMany(Almacen::class);
    }

    public function ventaDetalles(){
        return $this->hasMany(VentaDetalle::class);
    }

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class);
    }

    public static function venderPaqueteDetalles($venta_id, $paquete_id,$cantidad){
        $ven = Venta::find($venta_id);
        $peq  = PaqueteDetalle::where('paquete_id',$paquete_id)->get();
        foreach ($peq as $pd){
            $prod = Producto::find($pd->producto_id);
            $importe  = $prod->pv * $cantidad;
            $descto   = $prod->descto;
            $subtotal = $importe - $descto;
            $iva      = $prod->isIVA() ? $subtotal * 0.160000 : 0;
            $total    = $subtotal + $iva;
            $vd = static::create([
                'venta_id'       => $ven->id,
                'user_id'        => $ven->user_id,
                'paquete_id'     => $ven->paquete_id,
                'producto_id'    => $pd->producto_id,
                'empresa_id'     => $ven->empresa_id,
                'almacen_id'     => $prod->almacen_id,
                'fecha'          => now(),
                'cuenta'         => $ven->cuenta,
                'clave_producto' => $prod->clave_producto,
                'descripcion'    => $prod->descripcion,
                'codigo'         => $prod->codigo,
                'porcdescto'     => $prod->porcdescto,
                'cantidad'       => $cantidad,
                'pv'             => $prod->pv,
                'importe'        => $importe,
                'subtotal'       => $subtotal,
                'iva'            => $iva,
                'total'          => $total,
                'idemp'          => 1,
                'ip'             => Request::ip(),
                'host'           => Request::getHttpHost(),
            ]);

            $vd->users()->attach($ven->user_id);
            $vd->paquetes()->attach($ven->paquete_id);
            $vd->productos()->attach($pd->producto_id);
            $vd->empresas()->attach($ven->empresa_id);
            $vd->almacenes()->attach($prod->almacen_id);
            Movimiento::agregarDesdeVentaDetalle($vd);
        }

        return static::totalVenta($venta_id);

    }

    public static function venderPedidoDetalles($venta_id, $pedido_id,$cantidad){
        $ven = Venta::find($venta_id);
        $peq  = PedidoDetalle::where('pedido_id',$pedido_id)->get();
        foreach ($peq as $pd){
            $prod = Producto::find($pd->producto_id);
            $importe  = $prod->pv * $cantidad;
            $descto   = $prod->descto;
            $subtotal = $importe - $descto;
            $iva      = $prod->isIVA() ? $subtotal * 0.160000 : 0;
            $total    = $subtotal + $iva;
            $vd = static::create([
                'venta_id'       => $ven->id,
                'user_id'        => $ven->user_id,
                'pedido_id'     => $ven->pedido_id,
                'producto_id'    => $pd->producto_id,
                'empresa_id'     => $ven->empresa_id,
                'almacen_id'     => $prod->almacen_id,
                'fecha'          => now(),
                'cuenta'         => $ven->cuenta,
                'clave_producto' => $prod->clave_producto,
                'descripcion'    => $prod->descripcion,
                'codigo'         => $prod->codigo,
                'porcdescto'     => $prod->porcdescto,
                'cantidad'       => $cantidad,
                'pv'             => $prod->pv,
                'importe'        => $importe,
                'subtotal'       => $subtotal,
                'iva'            => $iva,
                'total'          => $total,
                'idemp'          => 1,
                'ip'             => Request::ip(),
                'host'           => Request::getHttpHost(),
            ]);

            $vd->users()->attach($ven->user_id);
            $vd->pedidos()->attach($ven->pedido_id);
            $vd->productos()->attach($pd->producto_id);
            $vd->empresas()->attach($ven->empresa_id);
            $vd->almacenes()->attach($prod->almacen_id);
            Movimiento::agregarDesdeVentaDetalle($vd);
        }

        return static::totalVenta($venta_id);

    }



    public static function totalVenta($venta_id)
    {
        $vendet  = VentaDetalle::where('venta_id',$venta_id)->get();
        $sImorte = $sDescto = $sSubtotal = $sIva = $sTotal = 0;
        foreach ($vendet as $vd) {
            $sImorte   += $vd->importe;
            $sDescto   += $vd->descto;
            $sSubtotal += $vd->subtotal;
            $sIva      += $vd->iva;
            $sTotal    += $vd->total;

        }
        $ven = Venta::find($venta_id);
        $ven->importe  = $sImorte;
        $ven->descto   = $sDescto;
        $ven->subtotal = $sSubtotal;
        $ven->iva      = $sIva;
        $ven->total    = $sTotal;
        $ven->save();

        return $venta_id;

    }



}
