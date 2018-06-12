<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'compras';

    protected $fillable = [
        'almacen_id', 'proveedor_id', 'folio_factura','nota_id',
        'descripcion_compra',
        'fecha','importe','descuento','subtotal','iva',
        'credito','observaciones','status_compras','total','tipo','empresa_id',
        'idemp','ip','host',
    ];

    protected $casts = ['credito'=>'boolean',];

    public function isCredito(){
        return $this->credito;
    }

    public function almacen() {
        // Contiene muchos Permisos
        return $this->belongsTo(Almacen::class);
    }

    public function proveedor(){
        // Contiene muchos Roles
        return $this->belongsTo(Proveedor::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Movimiento::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public static function compra($compra_id,$producto_id, $cantidad){
//        $Prod  = Producto::find($producto_id);
//        $Alma  = Almacen::find($Prod->almacen_id);
        /*
        $Comp   =  static::create([
            'fecha'       => now(),
            'almacen_id'       => $Prod->almacen_id,
            'proveedor_id'       => 0,
            'folio_factura'       => '',
            'nota_id'       => '',
            'importe'=> 0,
            'descuento'=> 0,
            'subtotal'=> 0,
            'iva'=> 0,
            'total'=> 0,
            'credito' => false,
            'empresa_id'  => $Prod->empresa_id,
        ]);
        */
        $Comp = static::find($compra_id);
        //dd($Comp);
        return Movimiento::agregarCompras($Comp,$producto_id,$cantidad);

    }

}
