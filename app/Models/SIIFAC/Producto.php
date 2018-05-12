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
        return $this->belongsToMany(Almacen::class);
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

    public function familiaProductos(){
        return $this->belongsToMany(FamiliaProducto::class);
    }

    public function familiaProducto(){
        return $this->belongsTo(FamiliaProducto::class);
    }

    public function medidas(){
        return $this->belongsToMany(Medida::class);
    }

    public function medida(){
        return $this->belongsTo(Medida::class);
    }

    public function paqueteDetalles(){
        return $this->hasMany(PaqueteDetalle::class);
    }

    public function pedidosDetalles(){
        return $this->hasMany(PedidoDetalle::class);
    }

    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
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
            $alma = Almacen::find($almacen_id);
            $fp   = FamiliaProducto::find($familia_producto_id);
            $med  = Medida::find($medida_id);
            $emp = Empresa::find($empresa_id);

            $prod =  static::create([
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

            $prod->almacenes()->attach($alma);
            $prod->familiaProductos()->attach($fp);
            $prod->medidas()->attach($med);
            $prod->empresas()->attach($emp);

            return $prod;
        }
        return $obj;
    }

}
