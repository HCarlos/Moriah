<?php

namespace App;

use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\CuentaPorCobrar;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\FamiliaCliente;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\PedidoDetalle;
use App\Models\SIIFAC\Venta;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\MyResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
//    use CanResetPassword;
    use HasRoles;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'users';

    protected $fillable = [
        'username', 'email', 'password','cuenta',
        'admin','alumno','foraneo','exalumno','credito',
        'dias_credito','limite_credito','saldo_a_favor','saldo_en_contra',
        'root','filename','familia_cliente_id',
        'idemp','ip','host',
        'nombre','ap_paterno','ap_materno','domicilio','celular','telefono',
    ];

    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['admin'=>'boolean','alumno'=>'boolean','foraneo'=>'boolean','exalumno'=>'boolean','credito'=>'credito',];

    public static function findByEmail($email){
        return static::where( compac('email') )->first();
    }

    public function permissions() {
        // Contiene muchos Permisos
        return $this->belongsToMany(Permission::class);
    }

    public function roles(){
        // Contiene muchos Roles
        return $this->belongsToMany(Role::class);
    }

    public function familiasClientes(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(FamiliaCliente::class);
    }

    public function cuentas_por_cobrar(){
        // Contiene muchos Cuentas_por_Cobrar
        return $this->hasMany(CuentaPorCobrar::class);
    }

    public function ingresos(){
        // Contiene muchos Ingresos
        return $this->hasMany(Ingreso::class);
    }

    public function paquetes_productos(){
        // Contiene muchos Ingresos
        return $this->hasMany(Paquete::class);
    }

    public function pedidos(){
        // Contiene muchos Ingresos
        return $this->hasMany(Pedido::class);
    }

    public function pedidos_detalles(){
        // Contiene muchos Ingresos
        return $this->hasMany(PedidoDetalle::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->hasMany(Movimiento::class);
    }

    public function empresas(){
        // Contiene muchos Ingresos
        return $this->hasMany(Empresa::class);
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function almacenes(){
        // Contiene muchos Ingresos
        return $this->hasMany(Almacen::class);
    }

    public function ventas(){
        // Contiene muchos Ingresos
        return $this->hasMany(Venta::class);
    }

    public function isAdmin(){
        return $this->admin;
    }

    public function isAlumno(){
        return $this->alumno;
    }

    public function isForaneo(){
        return $this->foraneo;
    }

    public function isExalumno(){
        return $this->exalumno;
    }

    public function isCredito(){
        return $this->credito;
    }

    public function IsEmptyPhoto(){
        return $this->filename == '' ? true : false;
    }

    public function scopeMyID(){
        return $this->id;
    }

    public function getFullNameAttribute() {
        return $this->attributes['ap_paterno'] . ' ' . $this->attributes['ap_materno']. ' ' . $this->attributes['nombre'];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    public static function findOrCreateUserWithRole3(
        string $cuenta, string $username, string $nombre, string $ap_paterno, string $ap_materno, string $email, string $password,
        bool $admin, bool $alumno, bool $foraneo, bool $exalumno, bool $credito, int $dias_credito, float $limite_credito,
        string $domicilio, string $celular, string $telefono,
        float $saldo_a_favor, float $saldo_en_contra, int $familia_cliente_id,
        int $iduser_ps, int $idemp, Role $role1, Role $role2, Role $role3){
        $user = static::all()->where('username', $username)->where('email', $email)->where('cuenta', $cuenta)->first();
        if (!$user) {
            if ($cuenta == ''){
                $timex  = Carbon::now()->format('ymdHisu');
                $cuenta =  substr($timex,0,16);
            }
            if ($email == ''){
                $email = $username.'@example.com';
            }
            if ($password == ''){
                $password = $username;
            }
            $user = static::create([
                'cuenta' => $cuenta,
                'username'=>$username,
                'nombre'=>$nombre,
                'ap_paterno'=>$ap_paterno,
                'ap_materno'=>$ap_materno,
                'email'=>$email,
                'password' => bcrypt($password),
                'domicilio' => $domicilio,
                'celular' => $celular,
                'telefono' => $telefono,
                'admin' => $admin,
                'alumno' => $alumno,
                'foraneo' => $foraneo,
                'exalumno' => $exalumno,
                'credito' => $credito,
                'dias_credito' => $dias_credito,
                'limite_credito' => $limite_credito,
                'saldo_a_favor' => $saldo_a_favor,
                'saldo_en_contra' => $saldo_en_contra,
                'iduser_ps' => $iduser_ps,
                'familia_cliente_id' => $familia_cliente_id,
                'idemp' => $idemp,
            ]);
            $user->roles()->attach($role1);
            $user->roles()->attach($role2);
            $user->roles()->attach($role3);
        }
        return $user;

    }


}
