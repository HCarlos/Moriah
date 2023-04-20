<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaCredito extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'notas_credito';

    protected $fillable = [
        'user_id', 'clave', 'cuenta','venta_id','fecha',
        'importe', 'isprint', 'status','tipo','empresa_id',
        'consecutivo',
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


    public function Venta(){
        return $this->belongsTo(Venta::class,'venta_id');
    }

    public function ventas(){
        return $this->hasMany(Venta::class,'ventas_id');
    }

    public function Ingresos(){
        return $this->hasMany(Ingreso::class,'nota_credito_id');
    }

    public function vendedor(){
        return $this->belongsTo(Vendedor::class,'user_id');
    }

    public function vendedores(){
        return $this->belongsToMany(Vendedor::class);
    }


    public static function totalNotaCreditoFromDetalle($id){
        $NS = static::find($id);
        $items = NotaCreditoDetalle::all()->where('nota_credito_id',$id);
        $total = 0;
        foreach ($items as $ncd){
            $total += $ncd->importe;
        }
        $NS->importe = $total;
        $NS->save();
        return $NS;
    }

    public static function getTotalNotaCreditoFromIngresos($id){
        $items = Ingreso::all()->where('nota_credito_id',$id);
        $total = 0;
        foreach ($items as $ing){
            $total += $ing->total;
        }
        return $total;
    }

    public function getSaldoAttribute(){
        return $this->importe - static::getTotalNotaCreditoFromIngresos($this->id);
    }

    public function getSaldoUtilizadoAttribute(){
        return static::getTotalNotaCreditoFromIngresos($this->id);
    }

    public static function totalNotaCreditoPorPrecio($nota_credito_id,$tipo_reporte,$tipo_campo){
        $items = NotaCreditoDetalle::all()->where('nota_credito_id',$nota_credito_id);

        $subtotal_pv = 0;
        $iva_pv = 0;
        $total_pv = 0;

        $subtotal_pc = 0;
        $iva_pc = 0;
        $total_pc = 0;

        foreach ($items as $ncd){
            $total_pv += $ncd->importe;
            $iva_pv += GeneralFunctions::getImporteIVA(1,$total_pv);
            $subtotal_pv   += $total_pv - $iva_pv;

            $total__pc = $ncd->cant * $ncd->pc;
            $iva__pc = GeneralFunctions::getImporteIVA(1,$total__pc);
            $subtotal__pc = $total__pc - $iva__pc;

            $subtotal_pc += $subtotal__pc;
            $iva_pc      += $iva__pc;
            $total_pc    += $total__pc;
        }

        if ( $tipo_reporte == 3 ){
            switch ($tipo_campo){
                case 0:
                    return $subtotal_pv;
                    break;
                case 1:
                    return $iva_pv;
                    break;
                case 2:
                    return $total_pv;
                    break;
            }
        }else{
            switch ($tipo_campo){
                case 0:
                    return $subtotal_pc;
                    break;
                case 1:
                    return $iva_pc;
                    break;
                case 2:
                    return $total_pc;
                    break;
            }
        }

        return 0;

    }




    public static function getFolio($empresa_id) {
        $NC = static::all()->where('empresa_id',$empresa_id)->sortByDesc('id')->first();
        return (int) $NC->consecutivo;
    }

}
