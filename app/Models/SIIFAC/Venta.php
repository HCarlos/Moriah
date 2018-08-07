<?php

namespace App\Models\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Venta extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'ventas';

    protected $fillable = [
        'fecha', 'clave', 'foliofac','tipoventa','cuenta',
        'isimp', 'cantidad', 'importe','descto','subtotal',
        'iva', 'total', 'ispagado','f_pagado','user_id',
        'metodo_pago','referencia','total_pagado',
        'empresa_id','paquete_id','pedido_id','vendedor_id',
        'status_venta','idemp','ip','host',
    ];

    protected $casts = ['isimp'=>'boolean','ispagado'=>'boolean','iscredito'=>'boolean','iscontado'=>'boolean',];

    public static $metodos_pago =
        [
            0 => "Efectivo", 1 => "Cheque Nominativo", 2 => "Transferencia Electrónica de Fondos",
            3 => "Tarjeta de Crédito", 4 => "Monedero Electrónico", 5 => "Dinero Elctrónico",
            6 => "Vales de Despensa", 7 => "Tarjeta de Debito", 8 => "Tarjeta de Servicio",
            9 => "Otros",
        ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function ventaDetalles(){
        return $this->hasMany(VentaDetalle::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }

    public function paquete(){
        return $this->belongsTo(Paquete::class);
    }

    public function paquetes(){
        return $this->belongsToMany(Paquete::class);
    }

    public function pedido(){
        return $this->belongsTo(Pedido::class);
    }

    public function vendedor(){
        return $this->belongsTo(Vendedor::class,'vendedor_id');
    }

    public function vendedores(){
        return $this->belongsToMany(Vendedor::class);
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class);
    }

    public function movimientos(){
        return $this->belongsToMany(Movimiento::class);
    }

    public function isImpreso(){
        return $this->isimp;
    }

    public function isPagado(){
        return $this->ispagado;
    }

    public function getTipoVentaAttribute() {
        return $this->attributes['tipoventa'] == 0 ? 'Contado' : 'Crédito';
    }

    public function getTipoDeVentaAttribute() {
        return $this->attributes['tipoventa'] == 0 ? 0 : 1;
    }

    public function isCredito(){
        return $this->tipoventa == 1 ? true : false;
    }

    public function isContado(){
        return $this->tipoventa == 0 ? true : false;
    }

    public function getFechaVentaAttribute() {
        $F = new FuncionesController();
        return $F->fechaEspanolComplete($this->attributes['fecha'],true);
    }

    public function scopeBuscarClientePorNombreCompleto($query,$dato) {
        $dato = strtoupper($dato);
        return
            $this::whereHas('users', function ($q) use($dato) {
                $q->where(DB::raw("CONCAT(ap_paterno,' ',ap_materno,' ',nombre)") , "similar to" , "%".$dato."%");
            })->get();
    }

    public function scopeBuscarProductoPorNombre($query,$dato) {
        $dato = strtoupper($dato);
        return
            $this::whereHas('ventaDetalles', function ($q) use($dato) {
                $q->where('descripcion', "similar to" , "%".$dato."%");
            })
                ->distinct()
                ->get();
    }

    public function scopeBuscarProductoPorCodigo($query,$dato) {
        $dato = strtoupper($dato);
        return
            $this::whereHas('ventaDetalles', function ($q) use($dato) {
                $q->where('codigo', "similar to" , "%".$dato."%");
            })
            ->distinct()
            ->get();
    }

    public function getMetodoPagoAttribute() {
        return self::$metodos_pago[ $this->attributes['metodo_pago'] ];
    }

    public static function venderPaquete($vendedor_id, $paquete_id, $tipoventa, $user_id, $cantidad){
        $paq   = Paquete::find($paquete_id);
        $timex = Carbon::now()->format('ymdHisu');
        $timex = substr($timex,0,16);
        $Ven  =  static::create([
            'fecha'       => now(),
            'clave'       => $paq->clave,
            'tipoventa'   => $tipoventa,
            'cuenta'      => $timex,
            'cantidad'    => $cantidad,
            'total'       => $paq->importe,
            'empresa_id'  => $paq->empresa_id,
            'paquete_id'  => $paquete_id,
            'pedido_id'   => 0,
            'user_id'     => $user_id,
            'vendedor_id' => $vendedor_id,
        ]);

        $Ven->empresas()->attach($paq->empresa_id);
        $Ven->paquetes()->attach($paquete_id);
        $Ven->users()->attach($user_id);
        $Ven->vendedores()->attach($vendedor_id);

        $pd = VentaDetalle::venderPaqueteDetalles($Ven->id, $paquete_id,$cantidad);

        return $pd;

    }

    public static function venderPedido($vendedor_id, $pedido_id, $tipoventa, $user_id, $cantidad){
        $paq   = Pedido::find($pedido_id);
        $timex = Carbon::now()->format('ymdHisu');
        $timex = substr($timex,0,16);

        $Ven  =  static::create([
            'fecha'       => now(),
            'clave'       => $paq->clave,
            'tipoventa'   => $tipoventa,
            'cuenta'      => $timex,
            'cantidad'    => $cantidad,
            'total'       => $paq->importe,
            'empresa_id'  => $paq->empresa_id,
            'paquete_id'  => 0,
            'pedido_id'   => $pedido_id,
            'user_id'     => $user_id,
            'vendedor_id' => $vendedor_id,
        ]);

        $Ven->empresas()->attach($paq->empresa_id);
        $Ven->pedidos()->attach($pedido_id);
        $Ven->users()->attach($user_id);
        $Ven->vendedores()->attach($vendedor_id);

        $pd = VentaDetalle::venderPedidoDetalles($Ven->id, $pedido_id,$cantidad);

        return $pd;

    }

    public static function venderNormal($vendedor_id, $producto_id, $tipoventa, $user_id, $cantidad){
        $Prod  = Producto::find($producto_id);
        $timex = Carbon::now()->format('ymdHisu');
        $timex = substr($timex,0,16);
        $Ven   =  static::create([
            'fecha'       => now(),
            'clave'       => $Prod->clave,
            'tipoventa'   => $tipoventa,
            'cuenta'      => $timex,
            'cantidad'    => $cantidad,
            'total'       => $Prod->pv,
            'empresa_id'  => $Prod->empresa_id,
            'paquete_id'  => 0,
            'pedido_id'   => 0,
            'user_id'     => $user_id,
            'vendedor_id' => $vendedor_id,
        ]);

        $Ven->empresas()->attach($Prod->empresa_id);
        $Ven->users()->attach($user_id);
        $Ven->vendedores()->attach($vendedor_id);

        $pd = VentaDetalle::venderNormalDetalles($Ven, $producto_id,$cantidad);

        return $pd;

    }

    public static function pagarVenta($venta_id, $total_a_pagar, $total_pagado, $metodo_pago, $referencia)
    {
        $Ven = static::findOrFail($venta_id);
        $Ven->total_pagado = $total_pagado;
        $Ven->metodo_pago = $metodo_pago;
        $Ven->referencia = $referencia;
        if ($total_pagado >= $total_a_pagar){
            $Ven->f_pagado = now();
            $Ven->ispagado = true;
            $Ven->isimp = true;
            $Ven->status_venta = 2;
        }
        $Ven->save();

        Ingreso::pagar($venta_id,$total_pagado,$metodo_pago,$referencia,0);

        return $Ven;

    }


}
