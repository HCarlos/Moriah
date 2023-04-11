<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RegimenesFiscales extends Model{

    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'regimenes_fiscales';

    protected $fillable = [
        'clave_regimen_fiscal','regimen_fiscal','empresa_id',
        'status_registro_fiscal','idemp','ip','host',
    ];


}
