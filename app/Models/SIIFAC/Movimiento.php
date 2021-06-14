<?php

namespace App\Models\SIIFAC;

use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Classes\GeneralFunctions;
use Request;

class Movimiento extends Model{
    
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'movimientos';

    protected $fillable = [
        'id',
        'user_id', 'cliente_id', 'venta_id', 'venta_detalle_id', 'compra_id', 'producto_id','paquete_id', 'pedido_id', 'proveedor_id', 'almacen_id', 'medida_id',
        'folio', 'clave', 'codigo', 'ejercicio', 'periodo', 'fecha', 'foliofac', 'nota', 'entrada',
        'salida', 'exlocal', 'existencia', 'pu', 'cu', 'debe', 'haber', 'descto', 'importe', 'iva', 'sllocal', 'saldo',
        'tipo', 'status', 'tipoinv','empresa_id',
        'status_movimiento', 'idemp', 'ip', 'host',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function clientes()
    {
        return $this->belongsToMany(User::class);
    }

    public function cliente()
    {
        return $this->belongsTo(User::class);
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class);
    }

    public function compra()
    {
        return $this->belongsTo(Compra::class);
    }

    public function compras()
    {
        return $this->belongsToMany(Compra::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Producto::class);
    }

    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

    public function paquetes()
    {
        return $this->belongsToMany(Paquete::class);
    }

    public function pedidodetalle()
    {
        return $this->belongsTo(PedidoDetalle::class);
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function proveedores()
    {
        return $this->belongsToMany(Proveedor::class);
    }

    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }

    public function almacenes()
    {
        return $this->belongsToMany(Almacen::class);
    }

    public function medida()
    {
        return $this->belongsTo(Medida::class);
    }

    public function medidas()
    {
        return $this->belongsToMany(Medida::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }

    // public function getStatusAttribute() {
    //     $mp = "";
    //     switch ($this->attributes['status']){
    //         case 0:
    //             $mp = "INICIO";
    //             break;
    //         case 1:
    //             $mp = "COMPRA";
    //             break;
    //         case 2:
    //             $mp = "VENTA";
    //             break;
    //         default:
    //             $mp = "Indefinido";
    //             break;
    //     }
    //     return $mp;
    // }

    public function getStatusAttribute() {
        $mp = "";
        switch ($this->attributes['status']){
            case 0:
                $mp = "INICIO";
                break;
            case 1:
                $mp = "COMPRA";
                break;
            case 2:
                $mp = "VENTA";
                break;
            case 11:
                $mp = "ENTRADA NC";
                break;
            case 12:
                $mp = "SALIDA NC";
                break;
            case 200:
                $mp = "FALTANTE";
                break;
            case 300:
                $mp = "MERMA";
                break;
            case 400:
                $mp = "DEV S/COMPRA";
                break;
            case 500:
                $mp = "SOBRANTE";
                break;
            case 600:
                $mp = "DEV P/PROV";
                break;
            default:
                $mp = "Indefinido";
                break;
        }

        return GeneralFunctions::getTiposMovto( $this->attributes['status'] ); // $mp;

    }


    public static function quitarDesdeNotaCreditoDetalle($NCd)
    {
        $Venta = Venta::findOrFail($NCd->venta_id);
        $Vd = VentaDetalle::find($NCd->venta_detalle_id);
        $Prod = Producto::findOrFail($Vd->producto_id);
        $cu         = $Prod->cu;
        $cantidad   = $NCd->cant;
        $Existencia = $Prod->exist - $NCd->cant;
        $saldo      = $cu * $cantidad;

        $Fecha = Carbon::now();

        $user = Auth::User();

        $Mov  =  static::create([
            'user_id'          => $Venta->vendedor_id,
            'cliente_id'       => $NCd->user_id,
            'venta_id'         => $Vd->venta_id,
            'venta_detalle_id' => $Vd->id,
            'producto_id'      => $Prod->id,
            'paquete_id'       => $Vd->paquete_id,
            'pedido_id'        => $Vd->pedido_id,
            'empresa_id'       => $Vd->empresa_id,
            'proveedor_id'     => $Prod->proveedor_id,
            'almacen_id'       => $Prod->almacen_id,
            'medida_id'        => $Prod->medida_id,
            'folio'            => $Vd->folio,
            'clave'            => $Vd->clave_producto,
            'codigo'           => $Vd->codigo,
            'ejercicio'        => $Fecha->year,
            'periodo'          => $Fecha->month,
            'fecha'            => $Fecha,
            'salida'           => $NCd->cant,
            'existencia'       => $Existencia,
            'cu'               => $Prod->cu,
            'pu'               => $NCd->pv,
            'haber'            => $NCd->importe,
            'descto'           =>  $Vd->descto,
            'importe'          =>  $Vd->subtotal,
            'iva'              =>  $Vd->iva,
            'saldo'            =>  $Vd->total,
            'status'           => 12,
            'idemp'            => 1,
            'ip'               => Request::ip(),
            'host'             => Request::getHttpHost(),
        ]);
        $Prod->exist = $Existencia;
        $Prod->saldo = $saldo;
        $Prod->save();

        $Mov->users()->attach($Venta->vendedor_id);
        $Mov->clientes()->attach($Vd->user_id);
        $Mov->empresas()->attach($Vd->empresa_id);
//        $Mov->ventas()->attach($Vd->venta_id);
        $Mov->productos()->attach($Prod->id);
        $Mov->proveedores()->attach($Prod->proveedor_id);
        $Mov->almacenes()->attach($Vd->almacen_id);
        $Mov->medidas()->attach($Prod->medida_id);

        return $Mov;

    }
    

    public static function agregarDesdeVentaDetalle($Vd)
    {
        $Prod = Producto::findOrFail($Vd->producto_id);
        $Venta = Venta::findOrFail($Vd->venta_id);
        $Existencia = $Prod->exist - $Vd->cantidad;
        $Fecha = Carbon::now();
        $user = Auth::User();
        $Mov  =  static::create([
            'user_id'          => $Venta->vendedor_id,
            'cliente_id'       => $Vd->user_id,
            'venta_id'         => $Vd->venta_id,
            'venta_detalle_id' => $Vd->id,
            'producto_id'      => $Prod->id,
            'paquete_id'       => $Vd->paquete_id,
            'pedido_id'        => $Vd->pedido_id,
            'empresa_id'       => $Vd->empresa_id,
            'proveedor_id'     => $Prod->proveedor_id,
            'almacen_id'       => $Prod->almacen_id,
            'medida_id'        => $Prod->medida_id,
            'folio'            => $Vd->folio,
            'clave'            => $Vd->clave_producto,
            'codigo'           => $Vd->codigo,
            'ejercicio'        => $Fecha->year,
            'periodo'          => $Fecha->month,
            'fecha'            => $Fecha,
            'salida'           => $Vd->cantidad,
            'existencia'       => $Existencia,
            'cu'               => $Prod->cu,
            'pu'               => $Prod->pv,
            'haber'            => $Vd->importe,
            'descto'           =>  $Vd->descto,
            'importe'          =>  $Vd->subtotal,
            'iva'              =>  $Vd->iva,
            'saldo'            =>  $Vd->total,
            'status'           => 2,
            'idemp'            => 1,
            'ip'               => Request::ip(),
            'host'             => Request::getHttpHost(),
        ]);
        $Prod->exist = $Existencia;
        $Prod->save();

        $Mov->users()->attach($Venta->vendedor_id);
        $Mov->clientes()->attach($Vd->user_id);
        $Mov->empresas()->attach($Vd->empresa_id);
//        $Mov->ventas()->attach($Vd->venta_id);
        $Mov->productos()->attach($Prod->id);
        $Mov->proveedores()->attach($Prod->proveedor_id);
        $Mov->almacenes()->attach($Vd->almacen_id);
        $Mov->medidas()->attach($Prod->medida_id);

        return $Mov;

    }


    public static function agregarDesdeNotaCreditoDetalle($NCd)
    {

        $Venta = Venta::findOrFail($NCd->venta_id);
        $Vd    = VentaDetalle::findOrFail($NCd->venta_detalle_id);
        $Prod = Producto::findOrFail($NCd->producto_id);
        $Fecha = Carbon::now();
        $user = Auth::User();
//        dd("Entro");
        $cu         = $Prod->cu;
        $cantidad   = $NCd->cant;
        $existencia = $Prod->exist + $NCd->cant;
        $saldo      = $cu * $cantidad;

        $iva   = $Prod->isIVA() ? $saldo * 0.160000 : 0;
//        $total = $saldo + $iva;
        $total = $saldo;

        $Mov  =  static::create([
            'user_id'          => $Venta->vendedor_id,
            'cliente_id'       => $Vd->user_id,
            'venta_id'         => $Vd->venta_id,
            'venta_detalle_id' => $Vd->id,
            'producto_id'      => $Prod->id,
            'paquete_id'       => $Vd->paquete_id,
            'pedido_id'        => $Vd->pedido_id,
            'compra_id'        => 0,
            'empresa_id'       => $Vd->empresa_id,
            'proveedor_id'     => $Prod->proveedor_id,
            'almacen_id'       => $Prod->almacen_id,
            'medida_id'        => $Prod->medida_id,
            'clave'            => $Prod->clave,
            'codigo'           => $Prod->codigo,
            'folio'            => $Prod->folio,
            'foliofac'         => 0,
            'nota'             => 0,
            'ejercicio'        => $Fecha->year,
            'periodo'          => $Fecha->month,
            'fecha'            => $Fecha,
            'entrada'          => $cantidad,
            'existencia'       => $existencia,
            'cu'               => $Prod->cu,
            'pu'               => $NCd->pv,
            'debe'             => $saldo,
            'descto'           => 0,
            'importe'          => $saldo,
            'iva'              => $iva,
            'saldo'            => $total,
            'status'           => 11,
            'idemp'            => 1,
            'ip'               => Request::ip(),
            'host'             => Request::getHttpHost(),
        ]);
        $Prod->exist = $existencia;
        $Prod->saldo = $saldo;
        $Prod->save();

        $Mov->users()->attach($NCd->user_id);
        $Mov->empresas()->attach($NCd->empresa_id);
        $Mov->productos()->attach($Prod->id);
        $Mov->proveedores()->attach($Prod->proveedor_id);
        $Mov->almacenes()->attach($Prod->almacen_id);
        $Mov->medidas()->attach($Prod->medida_id);

        return $Mov;

    }



    public static function agregarDesdeCompraDetalle($Comp, $Prod, $data)
    {
        $Fecha      = Carbon::now();
        $user       = Auth::user();
        $cu         = $data['cu'];
        $cantidad   = $data['cantidad'];
        $existencia = $Prod->exist;
        $saldo      = $cu * $cantidad;

        $iva   = $Prod->isIVA() ? $saldo * 0.160000 : 0;
        $total = $saldo + $iva;

        $Mov  =  static::create([
            'user_id'          => $user->id,
            'cliente_id'       => 1,
            'compra_id'        => $Comp->id,
            'producto_id'      => $Prod->id,
            'empresa_id'       => $Comp->empresa_id,
            'proveedor_id'     => $Comp->proveedor_id,
            'almacen_id'       => $Comp->almacen_id,
            'medida_id'        => $Prod->medida_id,
            'clave'            => $Prod->clave,
            'codigo'           => $Prod->codigo,
            'folio'            => $Prod->folio,
            'foliofac'         => $Comp->folio_factura,
            'nota'             => $Comp->nota_id,
            'ejercicio'        => $Fecha->year,
            'periodo'          => $Fecha->month,
            'fecha'            => $Fecha,
            'entrada'          => $cantidad,
            'existencia'       => $existencia,
            'cu'               => $Prod->cu,
            'pu'               => $Prod->pv,
            'debe'             => $saldo,
            'descto'           => 0,
            'importe'          => $saldo,
            'iva'              => $iva,
            'saldo'            => $total,
            'status'           => 1,
            'idemp'            => 1,
            'ip'               => Request::ip(),
            'host'             => Request::getHttpHost(),
        ]);

        $Suma = $Mov->where('compra_id',$Comp->id)->sum('saldo');
        $Comp->total = $Suma;
        $Comp->save();

        $Mov->users()->attach($Comp->user_id);
        $Mov->empresas()->attach($Comp->empresa_id);
        $Mov->productos()->attach($Prod->id);
        $Mov->proveedores()->attach($Comp->proveedor_id);
        $Mov->almacenes()->attach($Comp->almacen_id);
        $Mov->medidas()->attach($Prod->medida_id);

        return $Mov;

    }

    public static function inventarioInicialDesdeProducto($Prod)
    {
        $Fecha      = Carbon::now();
        $user       = Auth::user();
        $cu         = $Prod->cu;
        $cantidad   = $Prod->exist;
        $existencia = $Prod->exist;
        $saldo      = $cu * $cantidad;

        $iva   = $Prod->isIVA() ? $saldo * 0.160000 : 0;
        $total = $saldo + $iva;

        $Mov  =  static::create([
            'user_id'          => 1,
            'cliente_id'       => 1,
            'compra_id'        => 0,
            'venta_id'         => 0,
            'producto_id'      => $Prod->id,
            'empresa_id'       => $Prod->empresa_id,
            'proveedor_id'     => $Prod->proveedor_id,
            'almacen_id'       => $Prod->almacen_id,
            'medida_id'        => $Prod->medida_id,
            'clave'            => $Prod->clave,
            'codigo'           => $Prod->codigo,
            'folio'            => $Prod->folio,
            'foliofac'         => 'Inicio',
            'nota'             => 'Inicio',
            'ejercicio'        => $Fecha->year,
            'periodo'          => $Fecha->month,
            'fecha'            => $Fecha,
            'entrada'          => $cantidad,
            'existencia'       => $existencia,
            'cu'               => $Prod->cu,
            'pu'               => $Prod->pv,
            'debe'             => $saldo,
            'descto'           => 0,
            'importe'          => $saldo,
            'iva'              => $iva,
            'saldo'            => $total,
            'status'           => 0,
            'idemp'            => 1,
            'ip'               => Request::ip(),
            'host'             => Request::getHttpHost(),
        ]);

        $Mov->users()->attach(1);
        $Mov->empresas()->attach($Prod->empresa_id);
        $Mov->productos()->attach($Prod->id);
        $Mov->proveedores()->attach($Prod->proveedor_id);
        $Mov->almacenes()->attach($Prod->almacen_id);
        $Mov->medidas()->attach($Prod->medida_id);

        return $Mov;

    }

    public static function actualizaExistenciasYSaldo($Prod){
        $MovInit = static::query()
        ->where('producto_id',$Prod->id)
        ->first();
        //dd($MovInit);
        try{
            if (!is_null($MovInit)){
                $Movs = static::query()
                ->where('producto_id',$Prod->id)
                ->where('status','>=',0)
                ->orderBy('id','asc')
                ->get();
                //dd($Movs);
//                $exist = floatval($MovInit->existencia) <= 0 ? 0 :  floatval($MovInit->existencia);
//                $saldo = floatval($MovInit->saldo) <= 0 ? 0 : floatval($MovInit->saldo) ;
                $exist = 0;
                $saldo = 0;
                foreach ($Movs as $mov){
                    $exist0 = $mov->entrada - $mov->salida;
                    $saldo0 = $mov->debe - $mov->haber;
                    $mov->existencia  = $exist + $exist0;
                    $mov->saldo       = $saldo + $saldo0;
                    $mov->save();
                    $exist           += $exist0;
                    $saldo           += $saldo0;
                }
                $Prod->exist = $exist;
                $Prod->saldo = $saldo;
                $Prod->save();
            }

        }catch(Exception $e){
            Log::alert($MovInit.' => '.$e->getMessage());
            return null;
        }
    }
}