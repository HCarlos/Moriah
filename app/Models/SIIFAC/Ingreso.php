<?php

namespace App\Models\SIIFAC;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Ingreso extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'ingresos';

    protected $fillable = [
        'id','user_id','cliente_id','vendedor_id','nota_credito_id','empresa_id','idemp',
        'f_vencimiento','f_pagado','metodo_pago','referencia','subtotal','iva','total',
        'status_ingreso','fecha',
    ];

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

//    public function empresas(){
//        return $this->belongsToMany(Empresa::class);
//    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function clientes(){
        return $this->belongsToMany(Cliente::class);
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function vendedores(){
        return $this->belongsToMany(Vendedor::class);
    }

    public function vendedor(){
        return $this->belongsTo(Vendedor::class);
    }

    public static function pagar($venta_id, $total_pagado, $metodo_pago, $referencia,$nota_credito_id=0)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $Ven = Venta::findOrFail($venta_id);

        $Ing   =  static::create([
            'fecha'           => now(),
            'user_id'         => $user_id,
            'cliente_id'      => $Ven->user_id,
            'vendedor_id'     => $Ven->vendedor_id,
            'nota_credito_id' => $nota_credito_id,
            'empresa_id'      => $Ven->empresa_id,
            'f_pagado'        => now(),
            'metodo_pago'     => $metodo_pago,
            'referencia'      => $referencia,
            'subtotal'        => $Ven->subtotal,
            'iva'             => $Ven->iva,
            'total'           => $total_pagado,
            'tipoventa'       => $Ven->tipoventa,
        ]);

//        $Ing->empresas()->attach($Ven->empresa_id);
        $Ing->users()->attach($user_id);
        $Ing->vendedores()->attach($Ven->vendedor_id);
        $Ing->clientes()->attach($Ven->user_id);

        return $Ing;

    }


}
