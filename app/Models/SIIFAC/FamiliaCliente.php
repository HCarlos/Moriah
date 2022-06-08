<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamiliaCliente extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'familia_cliente';

    protected $fillable = [
        'descripcion','empresa_id',
        'status_familia_cliente','idemp','ip','host',
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function users(){
        // Esta en muchos Usuarios
        return $this->belongsToMany(User::class);
    }

    public static function findOrCreateFamiliaCliente($descripcion, $empresa_id){
        $obj = static::all()->where('descripcion', $descripcion)->first();
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();

        if (!$obj && $Empresa_Id > 0) {
            return static::create([
                'descripcion'=>$descripcion,
                'empresa_id'=>$Empresa_Id,
            ]);
        }
        return $obj;
    }


}
