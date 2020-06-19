<?php

namespace App\Models\SIIFAC;

use App\Http\Controllers\Funciones\FuncionesController;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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

    public static function findOrCreatePaquete($user_id, $codigo, $descripcion_paquete, $importe, $empresa_id){
        $obj = static::all()->where('clave', $codigo)->first();
        if (!$obj) {
            $user = User::find($user_id);
            $emp = Empresa::find($empresa_id);
            $paq =  static::create([
                'user_id'=>$user_id,
                'codigo'=>$codigo,
                'descripcion_paquete'=>$descripcion_paquete,
                'importe'=>$importe,
                'empresa_id'=>$empresa_id,
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

    public static function UpdateImporteFromPaqueteDetalle($detalles){
        $paq = $detalles->first();
        $paqid = $paq->paquete_id;
        $dets = PaqueteDetalle::where('paquete_id',$paqid)->get();
        $importe = 0;
        foreach ($dets as $p){
            $importe += $p->pv;
        }
        $pq = static::where('id',$paqid)->first();
//        $pq->importe = $importe;
        $pq->update(['importe'=>$importe]);
        return $pq->importe;
    }

}
