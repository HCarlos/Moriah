<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cuenta_Por_Cobrar extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'cuentas_por_cobrar';

    protected $fillable = [
        'user_id','cuenta','folio','num', 'f_vence',
        'subtotal','iva','total','intereses',
        'pagado_el','observaciones','empresa_id',
        'status_cxc','idemp','ip','host',
    ];

    public function ingresos(){
        // Contiene muchos Roles
        return $this->belongsToMany(Ingreso::class);
    }

    public function user(){
        // Esta en muchos Usuarios
        return $this->hasMany(User::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
