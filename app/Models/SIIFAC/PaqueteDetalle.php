<?php

namespace App\Models\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;

class PaqueteDetalle extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'paquete_detalle';

    protected $fillable = [
        'paquete_id', 'producto_id', 'medida_id', 'codigo', 'descripcion', 'cant','pv','comp1','empresa_id',
        'status_paquete_producto_detalle','idemp','ip','host',
    ];

    public function paquete(){
        return $this->belongsTo(Paquete::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function paquetes(){
        return $this->belongsToMany(Paquete::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }

    public static function findOrCreatePaqueteDetalle($paquete_id, $producto_id){
        $obj = static::all()->where('paquete_id', $paquete_id)->where('producto_id', $producto_id)->first();
        if (!$obj) {
            $paq = Paquete::find($paquete_id);
            $prod = Producto::find($producto_id);
            $det = static::create([
                'paquete_id'=>$paquete_id,
                'producto_id'=>$producto_id,
                'codigo' => $prod->codigo,
                'medida_id' => $prod->medida_id,
                'descripcion' => $prod->descripcion,
                'cant' => $prod->cant,
                'pv' => $prod->pv,
                'cant' => $prod->cant,
                'comp1' => $prod->comp1,
                'empresa_id' => $prod->empresa_id,
                'idemp' => 1,
                'ip' => Request::ip(),
                'host' => Request::getHttpHost(),
            ]);

            $det->productos()->detach($prod);
            $paq->detalles()->detach($det);
            $paq->productos()->detach($prod);

            $det->productos()->attach($prod);
            $paq->detalles()->attach($det);
            $paq->productos()->attach($prod);
            return $det;
        }
        return $obj;
    }


    public static function updatePaqueteDetalle($paquete_id,$paquete_detalle_id,$producto_id,$producto_id_old){
        $det = static::find($paquete_detalle_id);
        if ($det) {
            $paq = Paquete::find($paquete_id);
            $prod = Producto::find($producto_id);
            $det->update([
                'paquete_id'=>$paquete_id,
                'producto_id'=>$producto_id,
                'codigo' => $prod->codigo,
                'medida_id' => $prod->medida_id,
                'descripcion' => $prod->descripcion,
                'cant' => $prod->cant,
                'pv' => $prod->pv,
                'cant' => $prod->cant,
                'comp1' => $prod->comp1,
                'empresa_id' => $prod->empresa_id,
                'idemp' => 1,
                'ip' => Request::ip(),
                'host' => Request::getHttpHost(),
            ]);
            $det->productos()->detach($producto_id_old);
            $paq->productos()->detach($producto_id_old);

            $det->productos()->attach($prod);
            $paq->productos()->attach($prod);

            return $det;

        }
        return $det;
    }







}
