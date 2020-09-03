<?php

namespace App\Models\SIIFAC;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaCreditoDetalle extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'nota_credito_detalle';

    protected $fillable = [
        'id',
        'user_id', 'nota_credito_id', 'producto_id','venta_id','venta_detalle_id','fecha',
        'cuenta', 'codigo', 'descripcion_producto','cant', 'pv', 'importe','empresa_id',
        'status_nota_credito_detalle','idemp','ip','host',
    ];

    public function user(){
        // Su usuario es
        return $this->belongsTo(User::class);
    }

    public function notaCredito(){
        // Su usuario es
        return $this->belongsTo(NotaCredito::class);
    }

    public function producto(){
        // Su usuario es
        return $this->belongsTo(Producto::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }






}
