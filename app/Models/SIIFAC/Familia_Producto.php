<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Familia_Producto extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'familia_producto';

    protected $fillable = [
        'clave','descripcion','porcdescto','moneycli',
        'status_familia_producto','idemp','ip','host',
    ];
}
