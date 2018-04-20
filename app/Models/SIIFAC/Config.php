<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'config';

    protected $fillable = [
        'key','value','empresa_id',
        'status_config','idemp','ip','host',
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
