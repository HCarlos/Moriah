<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Ramsey\Uuid\Type\Integer;

class Venta extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'ventas';

    protected $fillable = [
        'id',
        'fecha', 'clave', 'foliofac','tipoventa','cuenta',
        'isimp', 'cantidad', 'importe','descto','subtotal',
        'iva', 'total', 'ispagado','f_pagado','user_id',
        'metodo_pago','referencia','total_pagado',
        'empresa_id','paquete_id','pedido_id','vendedor_id',
        'status_venta','idemp','ip','host',
        'idciclo_ps', 'ciclo','idgrado_ps','grado',
        'idgrupo_ps', 'grupo','idalumno_ps','alumno',
        'idtutor_ps', 'turor','idfamilia_ps','familia',
        'alu_ap_paterno', 'alu_ap_materno','alu_nombre',
        'username_alu',
    ];

    protected $casts = ['isimp'=>'boolean','ispagado'=>'boolean','iscredito'=>'boolean','iscontado'=>'boolean',];

    public static $metodos_pago =
        [
            0 => "Efectivo", 1 => "Cheque Nominativo", 2 => "Transferencia Electrónica de Fondos",
            3 => "Tarjeta de Crédito", 4 => "Monedero Electrónico", 5 => "Nota de Crédito",
            6 => "Vales de Despensa", 7 => "Tarjeta de Debito", 8 => "Tarjeta de Servicio",
            9 => "Otros",
        ];
    protected $appends = ['nombre_completo_alumno' => ''];

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

    public function getNombreCompletoAlumnoAttribute(){
        return $this->attributes['alu_ap_paterno'] . ' ' . $this->attributes['alu_ap_materno']. ' ' . $this->attributes['alu_nombre'];
    }

    public function getFechaVentaAttribute() {
        $F = new FuncionesController();
        return $F->fechaEspanolComplete($this->attributes['fecha'],true);
    }

    public function getAbonosAttribute() {
        return Ingreso::where('venta_id',$this->attributes['id'])->sum('total');
    }

    public function scopeBuscarClientePorNombreCompleto($query,$dato,$user) {
        $dato = strtoupper($dato);
        return
            $this::whereHas('users', function ($q) use($dato, $user) {
                $q->where(DB::raw("CONCAT(ap_paterno,' ',ap_materno,' ',nombre)") , "similar to" , "%".$dato."%");
            })
            ->where(function ($q) use($user) {
                if (!$user->hasRole('administrator|sysop'))
                    $q->where('vendedor_id', $user->id);
            })
            ->get();
    }

    public function scopeBuscarProductoPorNombre($query,$dato,$user) {
        $dato = strtoupper($dato);
        return
            $this::whereHas('ventaDetalles', function ($q) use($dato, $user) {
                $q->where('descripcion', "similar to" , "%".$dato."%");
            })
            ->where(function ($q) use($user) {
                if (!$user->hasRole('administrator|sysop'))
                    $q->where('vendedor_id', $user->id);
            })
            ->distinct()
            ->get();
    }

    public function scopeBuscarProductoPorCodigo($query,$dato,$user) {
        $dato = strtoupper($dato);
        return
            $this::whereHas('ventaDetalles', function ($q) use($dato, $user) {
                $q->where('codigo', "similar to" , "%".$dato."%");
            })
            ->where(function ($q) use($user) {
                if (!$user->hasRole('administrator|sysop'))
                    $q->where('vendedor_id', $user->id);
            })
            ->distinct()
            ->get();
    }

    public function getMetodoPagoAttribute() {
        //return self::$metodos_pago[ $this->attributes['metodo_pago'] ];
        return GeneralFunctions::$metodos_pagos_complete[ $this->attributes['metodo_pago'] ];

    }

    public static function venderPaquete($vendedor_id, $paquete_id, $tipoventa, $user_id, $cantidad){
        $paq   = Paquete::find($paquete_id);
        $timex = Carbon::now()->format('ymdHisu');
        $timex = substr($timex,0,16);
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($Empresa_Id > 0) {

            $Ven = static::create([
                'fecha' => now(),
                'clave' => $paq->clave,
                'tipoventa' => $tipoventa,
                'cuenta' => $timex,
                'cantidad' => $cantidad,
                'total' => $paq->importe,
                'empresa_id' => $Empresa_Id,
                'paquete_id' => $paquete_id,
                'pedido_id' => 0,
                'user_id' => $user_id,
                'vendedor_id' => $vendedor_id,
                'idemp' => $Empresa_Id,
            ]);

            $FolioEmpresa = static::getFolio($Empresa_Id, $Ven->id);
            $Ven->empresas()->attach($Empresa_Id,['folio'=>$FolioEmpresa + 1]);
            $Ven->paquetes()->attach($paquete_id);
            $Ven->users()->attach($user_id);
            $Ven->vendedores()->attach($vendedor_id);

            $pd = VentaDetalle::venderPaqueteDetalles($Ven->id, $paquete_id, $cantidad);

            return $pd;
        } else {
            return null;
        }

    }

    public static function venderPedido($vendedor_id, $pedido_id, $tipoventa, $user_id, $cantidad){
        $Ped   = Pedido::find($pedido_id);
        $timex = Carbon::now()->format('ymdHisu');
        $timex = substr($timex,0,16);
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($Empresa_Id > 0) {

            $Ven = static::create([
                'fecha' => now(),
                'clave' => $Ped->clave,
                'tipoventa' => $tipoventa,
                'cuenta' => $timex,
                'cantidad' => $cantidad,
                'total' => $Ped->importe,
                'empresa_id' => $Empresa_Id,
                'paquete_id' => 0,
                'pedido_id' => $pedido_id,
                'user_id' => $user_id,
                'vendedor_id' => $vendedor_id,

                'idciclo_ps' => $Ped->idciclo_ps,
                'ciclo' => $Ped->ciclo,
                'idgrado_ps' => $Ped->idgrado_ps,
                'grado' => $Ped->grado,
                'idgrupo_ps' => $Ped->idgrupo_ps,
                'grupo' => $Ped->grupo,
                'idalumno_ps' => $Ped->idalumno_ps,
                'alumno' => $Ped->alumno,
                'idtutor_ps' => $Ped->idtutor_ps,
                'turor' => $Ped->turor,
                'idfamilia_ps' => $Ped->idfamilia_ps,
                'familia' => $Ped->familia,
                'alu_ap_paterno' => $Ped->alu_ap_paterno,
                'alu_ap_materno' => $Ped->alu_ap_materno,
                'alu_nombre' => $Ped->alu_nombre,
                'username_alu' => $Ped->username_alu,
                'idemp' => $Empresa_Id,


            ]);

            $FolioEmpresa = static::getFolio($Empresa_Id, $Ven->id);
            $Ven->empresas()->attach($Empresa_Id,['folio'=>$FolioEmpresa + 1]);
            $Ven->pedidos()->attach($pedido_id);
            $Ven->users()->attach($user_id);
            $Ven->vendedores()->attach($vendedor_id);

            $pd = VentaDetalle::venderPedidoDetalles($Ven->id, $pedido_id, $cantidad);

            return $pd;

        } else {
           return null;
        }
    }

    public static function venderNormal($vendedor_id, $producto_id, $tipoventa, $user_id, $cantidad){
        $Prod  = Producto::find($producto_id);
        $timex = Carbon::now()->format('ymdHisu');
        $timex = substr($timex,0,16);
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();
        if ($Empresa_Id > 0) {
            $Ven = static::create([
                'fecha' => now(),
                'clave' => $Prod->clave,
                'tipoventa' => $tipoventa,
                'cuenta' => $timex,
                'cantidad' => $cantidad,
                'total' => $Prod->pv,
                'empresa_id' => $Empresa_Id,
                'paquete_id' => 0,
                'pedido_id' => 0,
                'user_id' => $user_id,
                'vendedor_id' => $vendedor_id,
                'idemp' => $Empresa_Id,

            ]);
            $FolioEmpresa = static::getFolio($Empresa_Id, $Ven->id);
            $Ven->empresas()->attach($Empresa_Id,['folio'=>$FolioEmpresa + 1]);
            $Ven->users()->attach($user_id);
            $Ven->vendedores()->attach($vendedor_id);

            $pd = VentaDetalle::venderNormalDetalles($Ven, $producto_id, $cantidad);

            return $pd;
        } else {
            return null;
        }

    }

    public static function pagarVenta($venta_id, $total_a_pagar, $total_pagado, $metodo_pago, $referencia){
        $Ven = static::findOrFail($venta_id);
        $Ven->total_pagado = $total_pagado;
        $Ven->metodo_pago = $metodo_pago;
        $Ven->referencia = $referencia;
        if ($total_pagado >= $total_a_pagar){
            $Ven->f_pagado = now();
            $Ven->ispagado = true;
            $Ven->isimp = true;
            $Ven->status_venta = 2;
            if ( $Ven->pedido_id > 0 ){
                $Ped = Pedido::find($Ven->pedido_id);
                $Ped->isactivo = false;
                $Ped->status_pedido = 2;
                $Ped->save();
            }
        }
        $Ven->save();
        $IdNC = intval($metodo_pago) == 5 ? intval($referencia) : 0;
        Ingreso::pagar($venta_id,$total_pagado,$metodo_pago,$referencia,$IdNC);
        return $Ven;

    }

    public static function anularVenta($venta_id, $total_a_pagar, $total_pagado, $metodo_pago, $referencia){
        $Ven = static::findOrFail($venta_id);
        $Ven->total_pagado = 0;
        $Ven->total = 0;
        $Ven->metodo_pago = $metodo_pago;
        $Ven->referencia = $referencia;
        $Ven->f_pagado = now();
        $Ven->ispagado = true;
        $Ven->isimp = true;
        $Ven->status_venta = 2;
        $Ven->save();
        $Movs = Movimiento::all()->where('venta_id', $venta_id);
        foreach ($Movs as $Mov) {
            $Mov->status = $metodo_pago;
            $Mov->save();
        }
        $nc = $metodo_pago == 5 ? $referencia : 0;
        Ingreso::pagar($venta_id, $total_a_pagar, $total_pagado, $metodo_pago, $referencia, $nc);
        return $Ven;
    }

    public function getTotalAbonosAttribute($id=0){
        return static::getTotalAbonosIngresos($this->id);
    }

    public static function getTotalAbonosIngresos($id=0){
        return Ingreso::where('venta_id', $id)->sum('total');
    }

    public function CanCreateNotaCredito(){
        return self::ICanCreateNotaCredito($this->id);
    }

    public static function ICanCreateNotaCredito($Id){
        $keys =  array_keys(GeneralFunctions::$metodos_pago);
        $Ings =  Ingreso::where('venta_id',$Id)
            ->whereIn('metodo_pago',$keys)
            ->get();
        return $Ings->count() > 0;
    }

    public static function getFolio($empresa_id):int{
        $emp = EmpresaVenta::all()->where('empresa_id',$empresa_id)->last();
        return (int)$emp->folio;
    }


}
