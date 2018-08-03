<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'users';

    protected $fillable = [
        'id',
        'username', 'email', 'password','cuenta',
        'admin','alumno','foraneo','exalumno','credito',
        'dias_credito','limite_credito','saldo_a_favor','saldo_en_contra',
        'rfc','curp','razon_social','calle','num_ext','num_int',
        'colonia','localidad','estado','pais','cp','email1','email2',
        'cel1','cel2','tel1','tel2','lugar_nacimiento','fecha_nacimiento','genero',
        'ocupacion','lugar_trabajo',
        'root','filename','familia_cliente_id',
        'idemp','ip','host',
        'nombre','ap_paterno','ap_materno','domicilio','celular','telefono',
    ];

    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['admin'=>'boolean','alumno'=>'boolean','foraneo'=>'boolean','exalumno'=>'boolean','credito'=>'boolean',];

    public function ventas(){
        return $this->belongsToMany(Venta::class);
    }

    public function inresos(){
        return $this->belongsToMany(Ingreso::class);
    }


    public function getFullNameAttribute() {
        return $this->attributes['ap_paterno'] . ' ' . $this->attributes['ap_materno']. ' ' . $this->attributes['nombre'];
    }



}
