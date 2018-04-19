<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Familia_Cliente extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'familia_cliente';

    protected $fillable = [
        'descripcion',
        'status_familia_cliente','idemp','ip','host',
    ];
}
