<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Familia_Cliente extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'familia_cliente';

    protected $fillable = [
        'descripcion','empresa_id',
        'status_familia_cliente','idemp','ip','host',
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
