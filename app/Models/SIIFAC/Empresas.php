<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'conceptos';

    protected $fillable = [
        'rs','ncomer','df','rfc',
        'status_empresa','ip','host',
    ];

}
