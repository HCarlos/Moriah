<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Familia_Producto extends Model
{
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

}
