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
        'idciclo_ps', 'ciclo','idgrado_ps','grado',
        'idgrupo_ps', 'grupo','idalumno_ps','alumno',
        'idtutor_ps', 'turor','idfamilia_ps','familia',
        'alu_ap_paterno', 'alu_ap_materno','alu_nombre',
    ];

    protected $casts = ['isactivo'=>'boolean',];
    protected $appends = ['nombre_completo_alumno' => ''];

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

    public function getNombreCompletoAlumnoAttribute(){
        return $this->attributes['alu_ap_paterno'] . ' - ' . $this->attributes['alu_ap_materno']. ' - ' . $this->attributes['alu_nombre'];
    }

    public function getFullDescriptionAttribute(){
        if (is_null($this->attributes['id'])){
            return "Pedido";
        }
        return 'pedido'; //$this->attributes['id'] . ' - ' . $this->attributes['descripcion_pedido']. ' - ' . $this->attributes['importe'];
    }

    public function getFullDescriptionPedidoUserAttribute(){
        if (is_null($this->attributes['id'])){
            return "Pedido";
        }
        return $this->attributes['id'] . ' - ' . $this->attributes['descripcion_pedido']. ' - ' . $this->attributes['importe']. ' - ' . $this->user->FullName;
    }

    public static function findOrCreatePedido($user_id, $paquete_id, $empresa_id,$referencia,$observaciones)
    {
        $f = new FuncionesController();
        $user = User::find($user_id);
        $emp = Empresa::find($empresa_id);
        $paq = Paquete::find($paquete_id);
        $date = Carbon::now();
        $daysToAdd = 3;
        $date = $date->addDays($daysToAdd);
        $daysToAdd = 3;
        $date = $date->addDays($daysToAdd);

        $ped = static::create([
            'user_id' => $user_id,
            'paquete_id' => $paquete_id,
            'descripcion_pedido' => $paq->descripcion_paquete,
            'codigo' => $paq->codigo,
            'filename' => $paq->root,
            'filename' => $paq->filename,
            'importe' => $paq->importe,
            'fecha' => NOW(),
            'referencia' => $referencia,
            'observaciones' => $observaciones,
            'empresa_id' => $empresa_id,
            'fecha_vencimiento' => $date,
            'idemp' => $paq->idemp,
            'ip' => $f->getIHE(1),
            'host' => $f->getIHE(1),
        ]);
        $ped->users()->attach($user);
        $ped->empresas()->attach($emp);
        PedidoDetalle::asignProductoAPedidoDetalle($ped->id,$user_id,$paquete_id,$empresa_id);
        return $ped;

    }

    public static function UpdateImporteFromPedidoDetalle($pedido_id){
        $dets = PedidoDetalle::where('pedido_id',$pedido_id)->get();
        $importe = 0;
        foreach ($dets as $p){
            $importe += ($p->cant * $p->pv);
        }
        $pq = static::find($pedido_id);
        if ( !is_null($pq) ){
            $pq->importe = $importe;
            $pq->save();
            return $pq->importe;
        }
        return 0;

    }


    public static function createPedidoFromPlatsourceTutor($User_id,$IdPaquete,$IdEmpresa,$arrIds,$arrPrd,$arrCnt,$arrImp,$Referencia,$Observaciones,$TotalInternet,$CadenaUsuario)
    {
        $f = new FuncionesController();
        $user = User::find($User_id);
        $emp = Empresa::find($IdEmpresa);
        $paq = Paquete::find($IdPaquete);

        $date = Carbon::now();
        $daysToAdd = 3;
        $date = $date->addDays($daysToAdd);

        /*
        CadenaUsuario =
            item . data + '|' +0
            item.idgrupo+'|'+1
            item.idfamilia+'|'+2
            item.idalumno+'|'+3
            item.ap_paterno_tutor+'|'+4
            item.ap_materno_tutor+'|'+5
            item.nombre__tutor+'|'+6
            item.cel1_tutor+'|'+7
            item.tel1_tutor+'|'+8
            item.email_tutor1+'|'+9
            item.username_tutor+'|'+10
            item.idcliclo+'|'+11
            item.ciclo+'|'+12
            item.grupo+'|'+13
            item.nombre+'|'+14
            item.ap_paterno+'|'+15
            item.ap_materno+'|'+16
            item.grado+'|'+17
            item.idciclo+'|'+18
            item.familia+'|'+19
*/
        $Alu = explode('|',$CadenaUsuario);


        $ped = static::create([
            'user_id'           => $User_id,
            'paquete_id'        => $IdPaquete,
            'descripcion_pedido' => $paq->descripcion_paquete,
            'codigo'            => $paq->codigo,
            'filename'          => $paq->root,
            'filename'          => $paq->filename,
            'importe'           => $paq->importe,
            'fecha'             => NOW(),
            'empresa_id'        => $IdEmpresa,
            'idemp'             => $paq->idemp,
            'fecha_vencimiento' => $date,
            'referencia'        => $Referencia,
            'observaciones'     => $Observaciones,
            'total_internet'    => $TotalInternet,

            'idciclo_ps'        => $Alu[11],
            'ciclo'             => $Alu[12],
            'idgrado_ps'        => 0,
            'grado'             => $Alu[17],
            'idgrupo_ps'        => $Alu[1],
            'grupo'             => $Alu[13],
            'idalumno_ps'       => $Alu[3],
            'alumno'            => $Alu[16],
            'idtutor_ps'        => $Alu[18],
            'turor'             => $Alu[10],
            'idfamilia_ps'      => $Alu[2],
            'familia'           => $Alu[19],
            'alu_ap_paterno'    => $Alu[14],
            'alu_ap_materno'    => $Alu[15],
            'alu_nombre'        => $Alu[16],

            'ip'                => $f->getIHE(1),
            'host'              => $f->getIHE(1),
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
//            dd($pq);
            return $pq;
        }
        return 0;

    }




}
