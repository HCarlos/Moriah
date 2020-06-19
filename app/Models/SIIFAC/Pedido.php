<?php

namespace App\Models\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Request;

class Pedido extends Model
{
    use SoftDeletes;
    
    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'pedidos';

    protected $fillable = [
        'id',
        'user_id', 'paquete_id', 'descripcion_pedido','fecha','codigo','root','filename','importe',
        'fecha_vencimiento', 'isactivo', 'referencia', 'observaciones','total_internet', 
        'empresa_id', 'status_pedido','idemp','ip','host',
    ];

    use SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function detalles(){
        return $this->belongsToMany(PedidoDetalle::class);
    }

    public function productos(){
        return $this->belongsToMany(Producto::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function empresas(){
        return $this->belongsToMany(Empresa::class);
    }

    public function IsEmptyPhoto(){
        return $this->filename == '' ? true : false;
    }

    public function getFullDescriptionAttribute(){
        return $this->attributes['id'] . ' - ' . $this->attributes['descripcion_pedido']. ' - ' . $this->attributes['importe'];
    }

    public function getFullDescriptionPedidoUserAttribute(){
        return $this->attributes['id'] . ' - ' . $this->attributes['descripcion_pedido']. ' - ' . $this->attributes['importe']. ' - ' . $this->user->FullName;
    }

    public static function findOrCreatePedido($user_id, $paquete_id, $empresa_id)
    {
        $f = new FuncionesController();
        $user = User::find($user_id);
        $emp = Empresa::find($empresa_id);
        $paq = Paquete::find($paquete_id);
        $ped = static::create([
            'user_id' => $user_id,
            'paquete_id' => $paquete_id,
            'descripcion_pedido' => $paq->descripcion_paquete,
            'codigo' => $paq->codigo,
            'filename' => $paq->root,
            'filename' => $paq->filename,
            'importe' => $paq->importe,
            'fecha' => NOW(),
            'empresa_id' => $empresa_id,
            'idemp' => $paq->idemp,
            'ip' => $f->getIHE(1),
            'host' => $f->getIHE(1),
        ]);
        $ped->users()->attach($user);
        $ped->empresas()->attach($emp);
        PedidoDetalle::asignProductoAPedidoDetalle($ped->id,$user_id,$paquete_id,$empresa_id);
        return $ped;

    }

    public static function UpdateImporteFromPedidoDetalle($detalles){
        $paq = $detalles->first();
        $paqid = $paq->paquete_id;
        $dets = PedidoDetalle::where('pedido_id',$paqid)->get();
        $importe = 0;
        foreach ($dets as $p){
            $importe += $p->pv;
        }
        $pq = static::where('id',$paqid)->first();
        $pq->importe = $importe;
        $pq->save();
        return $pq->importe;


    }


    public static function createPedidoFromPlatsource($user_id, $paquete_id, $empresa_id)
    {
        $f = new FuncionesController();
        $user = User::find($user_id);
        $emp = Empresa::find($empresa_id);
        $paq = Paquete::find($paquete_id);
        $ped = static::create([
            'user_id' => $user_id,
            'paquete_id' => $paquete_id,
            'descripcion_pedido' => $paq->descripcion_paquete,
            'codigo' => $paq->codigo,
            'filename' => $paq->root,
            'filename' => $paq->filename,
            'importe' => $paq->importe,
            'fecha' => NOW(),
            'empresa_id' => $empresa_id,
            'idemp' => $paq->idemp,
            'ip' => $f->getIHE(1),
            'host' => $f->getIHE(1),
        ]);
        $ped->users()->attach($user);
        $ped->empresas()->attach($emp);
        PedidoDetalle::asignProductoAPedidoDetalle($ped->id,$user_id,$paquete_id,$empresa_id);
        return $ped;

    }




}
