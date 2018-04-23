<?php

namespace App\Models\SIIFAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'proveedores';

    protected $fillable = [
        'clave_proveedor', 'nombre_proveedor', 'contacto_proveedor','domicilio_fiscal_proveedor','empresa_id',
        'status_proveedores','idemp','ip','host',
    ];

    public function proveedor(){
        // Esta en muchas Compras
        return $this->belongsTo(Compra::class);
    }

    public function user(){
        // Esta en muchos Usuarios
        return $this->belongsTo(User::class);
    }

    public function detalles(){
        // Contiene muchos Ingresos
        return $this->hasMany(PedidoDetalle::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->hasMany(Movimiento::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

}
