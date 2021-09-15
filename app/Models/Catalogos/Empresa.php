<?php

namespace App\Models\Catalogos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model{


    use HasFactory;


    protected $guard_name = 'web';
    protected $table = 'empresas';

//    protected $fillable = [
//        'id',
//        'clave', 'nivel', 'clave_registro_nivel','nivel_oficial','nivel_fiscal','prefijo_evaluacion',
//        'numero_evaluaciones', 'fecha_actas', 'estatus',
//        'empresa_id',
//    ];


    protected $fillable = [
        'id',
        'razon_social', 'domicilio_fiscal', 'domicilio_fiscal',
    ];


}
