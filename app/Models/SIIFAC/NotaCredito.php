<?php

namespace App\Models\SIIFAC;

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



}
