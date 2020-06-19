<?php

namespace App\Models\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Carbon\Carbon;
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
        if ( $pq ){
            $pq->importe = $importe;
            $pq->save();
            return $pq->importe;
        }
        return 0;

    }


    public static function createPedidoFromPlatsourceTutor($User_id,$IdPaquete,$IdEmpresa,$arrIds,$arrPrd,$arrCnt,$arrImp,$Referencia,$Observaciones,$TotalInternet)
    {
        $f = new FuncionesController();
        $user = User::find($User_id);
        $emp = Empresa::find($IdEmpresa);
        $paq = Paquete::find($IdPaquete);

        $date = Carbon::now();
        $daysToAdd = 3;
        $date = $date->addDays($daysToAdd);
        
        $ped = static::create([
            'user_id' => $User_id,
            'paquete_id' => $IdPaquete,
            'descripcion_pedido' => $paq->descripcion_paquete,
            'codigo' => $paq->codigo,
            'filename' => $paq->root,
            'filename' => $paq->filename,
            'importe' => $paq->importe,
            'fecha' => NOW(),
            'empresa_id' => $IdEmpresa,
            'idemp' => $paq->idemp,
            'fecha_vencimiento' => $date,
            'referencia' => $Referencia,
            'observaciones' => $Observaciones,
            'total_internet' => $TotalInternet,
            'ip' => $f->getIHE(1),
            'host' => $f->getIHE(1),
        ]);
        $ped->users()->attach($user);
        $ped->empresas()->attach($emp);
        PedidoDetalle::asignProductoAPedidoDetalleFromPlatsource($ped->id,$User_id,$IdPaquete,$IdEmpresa,$arrIds,$arrPrd,$arrCnt,$arrImp);
        return $ped;

    }

    public static function UpdateImporteFromPedidoDetallePlatsource($detalles){
        $paq = $detalles->first();
        $paqid = $paq->pedido_id;
        $dets = PedidoDetalle::all()->where('pedido_id',$paqid);
        $importe = 0;
        foreach ($dets as $p){
            $importe = $importe + ($p->cant * $p->pv);
        }
        $pq = static::find($paqid);
        if ( $pq ){
//            $pq->importe = $importe;
            $pq->update(['importe'=>$importe]);
            dd($pq);
            return $pq;
        }
        return 0;

    }




}
