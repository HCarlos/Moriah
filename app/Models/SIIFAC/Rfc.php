<?php

namespace App\Models\SIIFAC;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rfc extends Model{

    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'rfcs';

    protected $fillable = ['id',
        'rfc', 'razon_social', 'razon_social_cfdi_40',
        'calle', 'num_ext', 'num_int','colonia','localidad','municipio','estado','pais','cp',
        'emails', 'registro_fiscal_id',
        'observaciones','empresa_id',
        'idemp','ip','host',
    ];

    protected $casts = ['is_extrangero'=>'boolean','activo'=>'boolean',];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }


}
