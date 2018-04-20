<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paquete extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'paquetes';

    protected $fillable = [
        'user_id', 'descripcion_paquete','empresa_id',
        'status_paquete','idemp','ip','host',
    ];

    public function user(){
        // Esta en muchos Usuarios
        return $this->belongsTo(User::class);
    }

    public function detalles(){
        // Contiene muchos Roles
        return $this->hasMany(Paquete__Detalle::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public static function findOrCreatePraquete($user_id, $codigo, $descripcion_paquete, $importe, $empresa_id){
        $obj = static::all()->where('clave', $descripcion_paquete)->first();
        if (!$obj) {
            return static::create([
                'user_id'=>$user_id,
                'codigo'=>$codigo,
                'descripcion_paquete'=>$descripcion_paquete,
                'importe'=>$importe,
                'empresa_id'=>$empresa_id,
            ]);
        }
        return $obj;
    }


}
