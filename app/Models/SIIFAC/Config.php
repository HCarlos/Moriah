<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'config';

    protected $fillable = [
        'key','value',
        'status_config','idemp','ip','host',
    ];
}
