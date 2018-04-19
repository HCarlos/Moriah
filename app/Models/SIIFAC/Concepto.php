<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;

class Concepto extends Model
{
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'conceptos';

    protected $fillable = [
        'isiva','factor','descripcion','importe',
        'status_concepto','idemp','ip','host',
    ];

    protected $casts = ['isiva'=>'boolean',];

    public function isIVA(){
        return $this->isiva;
    }

}
