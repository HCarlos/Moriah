<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaCredito extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'notas_credito';

    protected $fillable = [
        'user_id', 'clave', 'cuenta','folio','fecha',
        'importe', 'isprint', 'status','tipo','empresa_id',
        'status_nota_credito','idemp','ip','host',
    ];

    public function user(){
        // Su usuario es
        return $this->belongsTo(User::class);
    }

    public function notaCreditoDatalles(){
        // Tiene muchos en detalles
        return $this->hasMany(NotaCreditoDetalle::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
