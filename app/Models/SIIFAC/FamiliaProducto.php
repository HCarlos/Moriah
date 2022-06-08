<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamiliaProducto extends Model{

    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'familia_producto';

    protected $fillable = [
        'clave','descripcion','porcdescto','moneycli','empresa_id',
        'status_familia_producto','idemp','ip','host',
    ];

    public function productos(){
        return $this->hasMany(Producto::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public static function findOrCreateFamiliaProducto($clave, $descripcion, $porcdescto, $moneycli, $empresa_id){
        $obj = static::all()->where('clave', $clave)->where('descripcion', $descripcion)->first();
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();

        if (!$obj && $Empresa_Id > 0) {
            return static::create([
                'clave'=>$clave,
                'descripcion'=>$descripcion,
                'porcdescto'=>$porcdescto,
                'moneycli'=>$moneycli,
                'empresa_id'=>$Empresa_Id,
            ]);
        }
        return $obj;
    }


}
