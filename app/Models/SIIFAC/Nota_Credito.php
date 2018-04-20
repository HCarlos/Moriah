<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota_Credito extends Model
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

    public function datalles(){
        // Tiene muchos en detalles
        return $this->hasMany(Nota_Credito_Detalle::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
