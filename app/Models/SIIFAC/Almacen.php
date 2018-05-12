<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Almacen extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'almacenes';

    protected $fillable = [
        'clave_almacen', 'descripcion', 'responsable','tipoinv','prefijo','empresa_id',
        'status_almacen','idemp','ip','host',
    ];

    public function compras(){
        // Esta en muchas Compras
        return $this->hasMany(Compra::class);
    }

    public function movimientos(){
        // Esta en muchas Compras
        return $this->hasMany(Movimiento::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }

    public static function findOrCreateAlmacen($clave_almacen, $descripcion, $responsable, $tipoinv, $prefijo, $empresa_id){
        $obj = static::all()->where('clave_almacen', $clave_almacen)->where('descripcion', $descripcion)->first();
        if (!$obj) {
            $emp = Empresa::find($empresa_id);
            $alma =  static::create([
                'clave_almacen'=>$clave_almacen,
                'descripcion'=>$descripcion,
                'responsable'=>$responsable,
                'tipoinv'=>$tipoinv,
                'prefijo'=>$prefijo,
                'empresa_id'=>$empresa_id,
            ]);
            $alma->empresas()->attach($emp);
            return $alma;
        }
        return $obj;
    }


}
