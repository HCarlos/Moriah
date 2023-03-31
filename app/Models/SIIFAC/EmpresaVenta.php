<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpresaVenta extends Model{

    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'empresa_venta';

    protected $fillable = [
        'id',
        'empresa_id',
        'venta_id',
        'folio',
    ];

    protected $hidden = ['deleted_at', 'created_at', 'update_at'];

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }

    public function ventas(){
        return $this->belongsToMany(Venta::class);
    }

}
