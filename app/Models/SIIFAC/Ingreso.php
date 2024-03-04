<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Ingreso extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web';
    protected $table = 'ingresos';

    protected $fillable = [
        'id','venta_id','user_id','cliente_id','vendedor_id','nota_credito_id','empresa_id','idemp',
        'f_vencimiento','f_pagado','metodo_pago','referencia','subtotal','iva','total',
        'status_ingreso','fecha','tipoventa',
    ];

    public static $metodos_pago =
        [
            0 => "Efectivo", 1 => "Cheque Nominativo", 2 => "Transferencia Electrónica de Fondos",
            3 => "Tarjeta de Crédito", 4 => "Monedero Electrónico", 5 => "Dinero Elctrónico",
            6 => "Vales de Despensa", 7 => "Tarjeta de Debito", 8 => "Tarjeta de Servicio",
            9 => "Otros",
        ];


    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function ventas(){
        return $this->belongsToMany(Venta::class);
    }

    public function venta(){
        return $this->belongsTo(Venta::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
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

    public function scopeAbonos($query,$venta_id) {
        return $query->where('venta_id',$venta_id)->sum('total');
    }

    public function getTipoVentaAttribute() {
        return $this->attributes['tipoventa'] == 0 ? 'Contado' : 'Crédito';
    }

    public function getTipoDeVentaAttribute() {
        return $this->attributes['tipoventa'] == 0 ? 0 : 1;
    }

    public function getMetodoPagoAttribute() {
        //return self::$metodos_pago[ $this->attributes['metodo_pago'] ];
        return GeneralFunctions::$metodos_pagos_complete[ $this->attributes['metodo_pago'] ];

    }

    public static function pagar($venta_id, $total_pagado, $metodo_pago, $referencia,$nota_credito_id){

        if ($total_pagado > 0) {

            $user = Auth::user();
            $user_id = $user->id;

            $Ven = Venta::findOrFail($venta_id);
            $Empresa_Id = GeneralFunctions::Get_Empresa_Id();

            if ( $Empresa_Id > 0){

                $Ing   =  static::create([
                    'fecha'           => now(),
                    'venta_id'        => $venta_id,
                    'user_id'         => $user_id,
                    'cliente_id'      => $Ven->user_id,
                    'vendedor_id'     => $Ven->vendedor_id,
                    'nota_credito_id' => $nota_credito_id,
                    'empresa_id'      => $Empresa_Id,
                    'f_pagado'        => now(),
                    'metodo_pago'     => $metodo_pago,
                    'referencia'      => $referencia,
                    'subtotal'        => $Ven->subtotal,
                    'iva'             => $Ven->iva,
                    'total'           => $total_pagado,
                    'tipoventa'       => $Ven->TipoDeVenta,
                ]);

                $Ing->ventas()->attach($venta_id);
                $Ing->users()->attach($user_id);
                $Ing->vendedores()->attach($Ven->vendedor_id);
                $Ing->clientes()->attach($Ven->user_id);
                $Ing->empresas()->attach($Empresa_Id);

                if ($nota_credito_id > 0) {
                    $NC = NotaCredito::find($nota_credito_id);
                    $NC->importe_utilizado = $NC->SaldoUtilizado;
                    $NC->saldo_utilizado   = $NC->Saldo;
                    $NC->save();
                }

                return $Ing;

            } else {
                return null;
            }

        }else{

            return null;

        }

    }

}
