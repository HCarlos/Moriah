<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Funciones\FuncionesController;
use Request;

class Producto extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'productos';

    protected $fillable = ['id',
        'almacen_id','proveedor_id','familia_producto_id','medida_id','clave', 'codigo', 'descripcion',
        'shortdesc','saldo_costeo',
        'maximo','minimo','isiva','fecha', 'tipo', 'pv', 'porcdescto','inicia_descuento','termina_descuento',
        'moneycli','exist','cu','saldo', 'propiedades_producto', 'filename', 'root','empresa_id',
        'status_producto','idemp','ip','host','searchtext',
    ];
    protected $casts = ['isiva'=>'boolean','status_producto'];

    public function scopeSearch($query, $search){
        if (!$search || $search == "" || $search == null) return $query;
        $search = strtoupper($search);
        $filters  = $search;
        $F        = new FuncionesController();
        $tsString = $F->string_to_tsQuery( strtoupper($filters),' & ');
        return $query->whereRaw("searchtext @@ to_tsquery('spanish', ?)", [$tsString])
            ->orderByRaw("ts_rank(searchtext, to_tsquery('spanish', ?)) ASC", [$tsString]);
    }


    public function isIVA(){
        return $this->isiva;
    }

    public function tieneIVA(){
        return !$this->isiva ? 0 : 1;
    }

    public function almacenes(){
        return $this->belongsToMany(Almacen::class);
    }

    public function almacen(){
        return $this->belongsTo(Almacen::class);
    }

    public function familiaProductos(){
        return $this->belongsToMany(FamiliaProducto::class);
    }

    public function familiaProducto(){
        return $this->belongsTo(FamiliaProducto::class);
    }

    public function medidas(){
        return $this->belongsToMany(Medida::class);
    }

    public function medida(){
        return $this->belongsTo(Medida::class);
    }

    public function paqueteDetalles(){
        return $this->hasMany(PaqueteDetalle::class);
    }

    public function pedidosDetalles(){
        return $this->hasMany(PedidoDetalle::class);
    }

    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function proveedores(){
        return $this->belongsToMany(Proveedor::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedor::class);
    }

    public function IsEmptyPhoto(){
        return $this->filename == '' ? true : false;
    }

    public function getFullDescriptionAttribute(){
        return $this->attributes['descripcion']. ' - ' .$this->attributes['id'] . ' - ' .  $this->attributes['pv'];
    }

    public static function findOrCreateProducto(
        $almacen_id, $familia_producto_id, $medida_id,
        $clave, $codigo, $descripcion, $shortdesc,$maximo,$minimo,
        $isiva, $fecha, $tipo, $pv, $porcdescto,$moneycli,$exist,$cu,$saldo,
        $empresa_id,$proveedor_id=0){
        $obj = static::all()
            ->where('almacen_id', $almacen_id)
            ->where('familia_producto_id', $familia_producto_id)
            ->where('medida_id', $medida_id)
            ->where('clave', $clave)
            ->where('codigo', $codigo)
            ->where('descripcion', $descripcion)
            ->first();

        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();

        if (!$obj && $Empresa_Id > 0) {
            $alma = Almacen::find($almacen_id);
            $fp   = FamiliaProducto::find($familia_producto_id);
            $med  = Medida::find($medida_id);
            $emp = Empresa::find($Empresa_Id);
            if ( $proveedor_id == 0 ) {
                $proveedor_id = 1;
            }else{
                if ($alma->proveedor_id !== null){
                    $proveedor_id = $alma->proveedor_id;
                }else {
                    $proveedor_id = 1;
                }
            }

            $prod =  static::create([
                'almacen_id'=>$almacen_id,
                'proveedor_id'=>$proveedor_id,
                'familia_producto_id'=>$familia_producto_id,
                'medida_id'=>$medida_id,
                'clave'=>$clave,
                'codigo'=>$codigo,
                'descripcion'=>$descripcion,
                'shortdesc'=>$shortdesc,
                'maximo'=>$maximo,
                'minimo'=>$minimo,
                'isiva'=>$isiva,
                'fecha'=>$fecha,
                'tipo'=>$tipo,
                'pv'=>$pv,
                'porcdescto'=>$porcdescto,
                'moneycli'=>$moneycli,
                'exist'=>$exist,
                'cu'=>$cu,
                'saldo'=>$saldo,
                'empresa_id' => $Empresa_Id,
                'idemp' => $Empresa_Id,
                'root' => 'producto/',
            ]);

            $prod->almacenes()->attach($alma);
            $prod->familiaProductos()->attach($fp);
            $prod->medidas()->attach($med);
            $prod->empresas()->attach($emp);

            $F = new FuncionesController();
            $F->validImage($prod,'producto','producto/');

            Movimiento::inventarioInicialDesdeProducto($prod);

            return $prod;

        }
        return $obj;
    }
    public static function ActualizaPaqueteDetalles($id){
        $prod = static::select('pv')->where('id',$id)->first();
        $pqdts = PaqueteDetalle::all()->where('producto_id',$id);
        Paquete::UpdateImporteFromPaqueteDetalle($pqdts);

    }

    public static function ActualizaDatosDesdeCompras($id,$data){
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();

        $Prod         = static::find($id);
        $almacen_id   = $data['almacen_id'];
        $proveedor_id = $data['proveedor_id'];
        $compra_id    = $data['compra_id'];
        $pv           = $data['pv'];
        $cu           = $data['cu'];
        $cantidad     = $data['cantidad'];
        $existencia   = $Prod->exist + $cantidad;
        $saldo        = $Prod->saldo + ($cu * $cantidad);

        $Prod->almacen_id   = $almacen_id;
        $Prod->proveedor_id = $proveedor_id;
        $Prod->empresa_id   = $Empresa_Id;
        $Prod->idemp        = $Empresa_Id;
        $Prod->pv           = $pv;
        $Prod->cu           = $cu;
        $Prod->exist        = $existencia;
        $Prod->saldo        = $saldo;

        $Prod->save();

        $Mov = Compra::compra($compra_id,$Prod, $data);

        return $Mov;

    }

    public static function ActualizaDatosDesdeComprasDetalles($Mov,$Prod,$almacen_id,$proveedor_id,$compra_id,$pu,$cu,$entrada,$almacen_anterior_id,$producto_anterior_id,$proveedor_anterior_id, $medida_anterior_id){
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();

        $existencia   = $Prod->exist + $entrada;
        $saldo        = $Prod->saldo + ($cu * $entrada);

        $Prod->almacen_id   = $almacen_id;
        $Prod->proveedor_id = $proveedor_id;
        $Prod->empresa_id   = $Empresa_Id;
        $Prod->idemp        = $Empresa_Id;
        $Prod->pv           = $pu;
        $Prod->cu           = $cu;
        $Prod->exist        = $existencia;
        $Prod->saldo        = $saldo;

        $Prod->save();

        $Fecha      = Carbon::now();
        $user       = Auth::user();
        $cantidad   = $entrada;
        $existencia = $Prod->exist;
        $saldo      = $cu * $cantidad;

        $iva   = GeneralFunctions::getImporteIVA($Prod->tieneIVA(),$saldo);
        $total = $saldo;

        $Mov->update([
            'producto_id'      => $Prod->id,
            'empresa_id'       => $Empresa_Id,
            'proveedor_id'     => $proveedor_id,
            'almacen_id'       => $almacen_id,
            'ejercicio'        => $Fecha->year,
            'periodo'          => $Fecha->month,
            'fecha'            => $Fecha,
            'entrada'          => $entrada,
            'existencia'       => $existencia,
            'cu'               => $cu,
            'pu'               => $pu,
            'debe'             => $saldo,
            'descto'           => 0,
            'importe'          => $saldo,
            'iva'              => $iva,
            'saldo'            => $total,
            'status'           => 1,
            'idemp'            => $Empresa_Id,
            'ip'               => Request::ip(),
            'host'             => Request::getHttpHost(),
        ]);

        $Comp = Compra::find($compra_id);
        $Suma = $Mov->where('compra_id',$compra_id)->sum('saldo');
        $Comp->total = $Suma;
        $Comp->save();

        $Mov->productos()->detach($producto_anterior_id);
        $Mov->proveedores()->detach($proveedor_anterior_id);
        $Mov->almacenes()->detach($almacen_anterior_id);
        $Mov->medidas()->detach($medida_anterior_id);

        $Mov->productos()->attach($Prod->id);
        $Mov->proveedores()->attach($proveedor_id);
        $Mov->almacenes()->attach($almacen_id);
        $Mov->medidas()->attach($Prod->medida_id);

        return $Mov;

    }



}
