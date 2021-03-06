<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Concepto extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'conceptos';

    protected $fillable = [
        'isiva','factor','descripcion','importe','empresa_id',
        'status_concepto','idemp','ip','host',
    ];

    protected $casts = ['isiva'=>'boolean',];

    public function isIVA(){
        return $this->isiva;
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public static function findOrCreateConcepto($isiva, $factor, $descripcion, $importe, $empresa_id){
        $obj = static::all()->where('descripcion', $descripcion)->first();
        if (!$obj) {
            return static::create([
                'isiva'=>$isiva,
                'descripcion'=>$descripcion,
                'factor'=>$factor,
                'importe'=>$importe,
                'empresa_id'=>$empresa_id,
            ]);
        }
        return $obj;
    }


}
