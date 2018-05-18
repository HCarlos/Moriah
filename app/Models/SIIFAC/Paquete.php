<?php

namespace App\Models\SIIFAC;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Paquete extends Model
{
    use SoftDeletes;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'paquetes';

    protected $fillable = [
        'user_id', 'codigo', 'descripcion_paquete','root','filename','empresa_id',
        'status_paquete','idemp','ip','host',
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

    public function IsEmptyPhoto(){
        return $this->filename == '' ? true : false;
    }


    public static function findOrCreatePaquete($user_id, $codigo, $descripcion_paquete, $importe, $empresa_id){
        $obj = static::all()->where('clave', $descripcion_paquete)->first();
        if (!$obj) {
            $user = User::find($user_id);
            $emp = Empresa::find($empresa_id);
            $paq =  static::create([
                'user_id'=>$user_id,
                'codigo'=>$codigo,
                'descripcion_paquete'=>$descripcion_paquete,
                'importe'=>$importe,
                'empresa_id'=>$empresa_id,
            ]);
            $paq->users()->attach($user);
            $paq->empresas()->attach($emp);
            return $paq;
        }
        return $obj;
    }

    public static function UpdateImporteFromPaqueteDetalle($paquete_id){
        $pd = PaqueteDetalle::where('paquete_id',$paquete_id)->get();
        $importe = 0;
        foreach ($pd as $p){
            $importe += $p->pv;
        }
        $pq = static::where('id',$paquete_id)->first();
        $pq->importe = $importe;
        $pq->save();
        return $pq->importe;
    }

}
