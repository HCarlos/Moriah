<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendedor extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'users';

    protected $fillable = [
        'id',
        'username', 'email', 'password','cuenta',
        'admin','alumno','foraneo','exalumno','credito',
        'dias_credito','limite_credito','saldo_a_favor','saldo_en_contra',
        'root','filename','familia_cliente_id',
        'idemp','ip','host',
        'nombre','ap_paterno','ap_materno','domicilio','celular','telefono',
    ];

    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['admin'=>'boolean','alumno'=>'boolean','foraneo'=>'boolean','exalumno'=>'boolean','credito'=>'credito',];

    public function ventas(){
        return $this->belongsToMany(Venta::class);
    }

}
