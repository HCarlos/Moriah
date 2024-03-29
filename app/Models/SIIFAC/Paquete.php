<?php

namespace App\Models\SIIFAC;

use App\Classes\GeneralFunctions;
use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Illuminate\Support\Facades\Session;
//use Illuminate\Support\Facades\Storage;

class Paquete extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'paquetes';

    protected $fillable = [
        'id',
        'user_id', 'codigo', 'descripcion_paquete','root','filename','importe',
        'grupos_platsource', 'isvisibleinternet', 'total_internet',
        'empresa_id', 'status_paquete','idemp','ip','host',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function detalles(){
        return $this->belongsToMany(PaqueteDetalle::class);
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

    public function movimientos(){
        return $this->belongsToMany(Movimiento::class);
    }

    public function IsEmptyPhoto(){
        return $this->filename == '' ? true : false;
    }

    public function getFullDescriptionAttribute(){
        return $this->attributes['id'] . ' - ' . $this->attributes['descripcion_paquete']. ' - ' . $this->attributes['importe'];
    }

    public function getFullDescriptionWithoutPriceAttribute(){
        return $this->attributes['id'] . ' - ' . $this->attributes['descripcion_paquete'];
    }

    public static function findOrCreatePaquete($user_id, $codigo, $descripcion_paquete, $importe, $empresa_id){
        $obj = static::all()->where('clave', $codigo)->first();
        $Empresa_Id = GeneralFunctions::Get_Empresa_Id();

        if (!$obj && $Empresa_Id > 0) {
            $user = User::find($user_id);
            $emp = Empresa::find($Empresa_Id);
            $paq =  static::create([
                'user_id'=>$user_id,
                'codigo'=>$codigo,
                'descripcion_paquete'=>$descripcion_paquete,
                'importe'=>$importe,
                'empresa_id'=>$Empresa_Id,
                'root' => 'paquete/',
            ]);
            $paq->users()->attach($user);
            $paq->empresas()->attach($emp);

            $F = new FuncionesController();
            $F->validImage($paq,'paquete','paquete/');

            return $paq;
        }
        return $obj;
    }

    public static function UpdateImporteFromPaquete($paquete_id){
        $dets = PaqueteDetalle::where('paquete_id',$paquete_id)->get();
        $importe = 0;
        foreach ($dets as $p){
            $cant = $p->cant ?? 1;
            $p->cant = $cant;
            $p->save();
            $importe += ($cant * $p->pv);
        }
        $pq = static::find($paquete_id);
        $pq->update(['importe' => $importe]);

        return $pq->importe;
    }

    public static function UpdateImporteFromPaqueteDetalle($detalles){
        
        $paq = $detalles->first();
        $paqid = $paq->paquete_id;
        $dets = PaqueteDetalle::where('paquete_id',$paqid)->get();
        $importe = 0;
        foreach ($dets as $p){
            $cant = $p->cant ?? 1;
            $p->cant = $cant;
            $p->save();
            $importe += ($p->cant * $p->pv);
        }
        $pq = static::find($paqid);
        if (!is_null($pq)){
            $pq->update(['importe'=>$importe]);
            return $pq->importe;
        }else{
            return null;        
        }

    }

}
