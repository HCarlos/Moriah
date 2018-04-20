<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nota_Credito_Detalle extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'nota_credito_detalle';

    protected $fillable = [
        'user_id', 'nota_credito_id', 'producto_id','folio','fecha',
        'cuenta', 'codigo', 'descripcion_producto','cant', 'pv', 'importe','empresa_id',
        'status_nota_credito_detalle','idemp','ip','host',
    ];

    public function user(){
        // Su usuario es
        return $this->belongsTo(User::class);
    }

    public function nota_credito(){
        // Su usuario es
        return $this->belongsTo(Nota_Credito::class);
    }

    public function producto(){
        // Su usuario es
        return $this->belongsTo(Producto::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }


}
