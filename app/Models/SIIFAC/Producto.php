<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'productos';

    protected $fillable = [
        'almacen_id','familia_producto_id','medida_id','clave', 'codigo', 'descripcion', 'shortdesc',
        'maximo','minimo','isiva','fecha', 'tipo', 'pv', 'porcdescto','inicia_descuento','termina_descuento',
        'moneycli','exist','cu','saldo', 'propiedades_producto', 'filename', 'root','empresa_id',
        'status_producto','idemp','ip','host',
    ];
    protected $casts = ['isiva'=>'boolean',];

    public function isIVA(){
        return $this->isiva;
    }

    public function almacenes(){
        return $this->hasMany(Almacen::class);
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

    public function familiaProducto(){
        // Esta en muchos familia de productos
        return $this->belongsTo(FamiliaProducto::class);
    }

    public function medida(){
        // Esta en muchos medidas
        return $this->belongsTo(Medida::class);
    }

    public function paqueteDetalles(){
        // Contiene muchos Ingresos
        return $this->hasMany(PaqueteDetalle::class);
    }

    public function pedidosDetalles(){
        // Contiene muchos Ingresos
        return $this->hasMany(PedidoDetalle::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->hasMany(Movimiento::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public static function findOrCreateProducto(
        $almacen_id, $familia_producto_id, $medida_id,
        $clave, $codigo, $descripcion, $shortdesc,$maximo,$minimo,
        $isiva, $fecha, $tipo, $pv, $porcdescto,$moneycli,$exist,$cu,$saldo,
        $empresa_id){
        $obj = static::all()
            ->where('almacen_id', $almacen_id)
            ->where('familia_producto_id', $familia_producto_id)
            ->where('medida_id', $medida_id)
            ->where('clave', $clave)
            ->where('codigo', $codigo)
            ->where('descripcion', $descripcion)
            ->first();
        if (!$obj) {
            return static::create([
                'almacen_id'=>$almacen_id,
                'familia_producto_id'=>$familia_producto_id,
                'medida_id'=>$medida_id,
                'clave'=>$clave,
                'codigo'=>$codigo,
                'descripcion'=>$descripcion,
                'shortdesc'=>$shortdesc,
                'maximo'=>$maximo,
                'minimo'=>$minimo,
                'isiva'=>$isiva,
                'fecha'=>$fecha,
                'tipo'=>$tipo,
                'pv'=>$pv,
                'porcdescto'=>$porcdescto,
                'moneycli'=>$moneycli,
                'exist'=>$exist,
                'cu'=>$cu,
                'saldo'=>$saldo,
                'empresa_id'=>$empresa_id,
            ]);
        }
        return $obj;
    }

}
