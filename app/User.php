<?php

namespace App;

use App\Models\SIIFAC\Cuenta_Por_Cobrar;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\Paquete_;
use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\Pedido_Detalle;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\MyResetPassword;

class User extends Authenticatable
{
    use Notifiable;
//    use CanResetPassword;
    use HasRoles;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'users';

    protected $fillable = [
        'username', 'email', 'password',
        'admin','alumno','foraneo','exalumno','credito',
        'filename','root',
        'idemp','ip','host',
        'nombre','ap_paterno','ap_materno','celular','telefono',
    ];

    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['admin'=>'boolean','alumno'=>'boolean','foraneo'=>'boolean','exalumno'=>'boolean','credito'=>'credito',];

    public function permissions() {
        // Contiene muchos Permisos
        return $this->belongsToMany(Permission::class);
    }

    public function roles(){
        // Contiene muchos Roles
        return $this->belongsToMany(Role::class);
    }

    public function cuentas_por_cobrar(){
        // Contiene muchos Cuentas_por_Cobrar
        return $this->belongsToMany(Cuenta_Por_Cobrar::class);
    }

    public function ingresos(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Ingreso::class);
    }

    public function paquetes_productos(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Paquete_::class);
    }

    public function pedidos(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Pedido::class);
    }

    public function pedidos_detalles(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Pedido_Detalle::class);
    }

    public function movimientos(){
        // Contiene muchos Ingresos
        return $this->belongsToMany(Movimiento::class);
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

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    public static function findOrCreateUserWithRole(string $username, string $nombre, string $ap_paterno, string $ap_materno, string $email, string $password, int $iduser_ps, int $idemp, Role $role){
        $user = static::all()->where('username', $username)->where('email', $email)->first();
        if (!$user) {
            return static::create([
                'username'=>$username,
                'nombre'=>$nombre,
                'ap_paterno'=>$ap_paterno,
                'ap_materno'=>$ap_materno,
                'email'=>$email,
                'password' => bcrypt($password),
                'iduser_ps' => 0,
                'idemp' => $idemp,
            ])->roles()->attach($role);
        }
        return $user;
    }


}
