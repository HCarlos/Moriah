<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Session;

class Proveedor extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'proveedores';

    protected $fillable = [
        'clave_proveedor', 'nombre_proveedor', 'contacto_proveedor','domicilio_fiscal_proveedor','empresa_id',
        'status_proveedores','idemp','ip','host',
    ];

    public function compras(){
        // Esta en muchas Compras
        return $this->hasMany(Compra::class);
    }

    public function movimientos(){
        // Esta en muchas Compras
        return $this->hasMany(Movimiento::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public static function findOrCreateProveedor($clave_proveedor, $nombre_proveedor, $contacto_proveedor, $domicilio_fiscal_proveedor,$empresa_id){
        $obj = static::all()->where('nombre_proveedor', $nombre_proveedor)->first();
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();

        if (!$obj && $Empresa_Id > 0) {
            return static::create([
                'clave_proveedor'=>$clave_proveedor,
                'nombre_proveedor'=>$nombre_proveedor,
                'contacto_proveedor'=>$contacto_proveedor,
                'domicilio_fiscal_proveedor'=>$domicilio_fiscal_proveedor,
                'empresa_id'=>$Empresa_Id,
                'idemp' => $Empresa_Id,
            ]);
        }
        return $obj;
    }

}
