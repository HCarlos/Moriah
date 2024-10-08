<?php

namespace App;

use App\Http\Controllers\Funciones\FuncionesController;
use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\CuentaPorCobrar;
use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\FamiliaCliente;
use App\Models\SIIFAC\Ingreso;
use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\NotaCredito;
use App\Models\SIIFAC\Paquete;
use App\Models\SIIFAC\Pedido;
use App\Models\SIIFAC\PedidoDetalle;
use App\Models\SIIFAC\Rfc;
use App\Models\SIIFAC\Venta;
use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PhpOffice\PhpSpreadsheet\Shared\Date;
//use Silber\Bouncer\Database\HasRolesAndAbilities;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\MyResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Illuminate\Auth\Passwords\CanResetPassword;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
//    use HasRolesAndAbilities;
    use HasRoles;
    use CanResetPassword;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'users';

    protected $fillable = [
        'id',
        'username', 'email', 'password','cuenta',
        'admin','alumno','foraneo','exalumno','credito',
        'dias_credito','limite_credito','saldo_a_favor','saldo_en_contra',
        'rfc','curp','razon_social','calle','num_ext','num_int',
        'colonia','localidad','estado','pais','cp','email1','email2',
        'cel1','cel2','tel1','tel2','lugar_nacimiento','fecha_nacimiento','genero',
        'ocupacion','lugar_trabajo',
        'root','filename','familia_cliente_id', 'iduser_ps', 
        'idemp','ip','host',
        'nombre','ap_paterno','ap_materno','celular','telefono',
    ];

    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['admin'=>'boolean','alumno'=>'boolean','foraneo'=>'boolean','exalumno'=>'boolean','credito'=>'boolean',];

    public static function findByEmail($email){
        return static::where('email', trim($email) )->first();
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function familiasClientes(){
        return $this->belongsToMany(FamiliaCliente::class);
    }

    public function cuentas_por_cobrar(){
        return $this->hasMany(CuentaPorCobrar::class);
    }

    public function ingresos(){
        return $this->hasMany(Ingreso::class);
    }

    public function paquetes_productos(){
        return $this->hasMany(Paquete::class);
    }

    public function pedidos(){
        return $this->hasMany(Pedido::class);
    }

    public function pedidos_detalles(){
        return $this->hasMany(PedidoDetalle::class);
    }

    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }

    public function empresas(){
        return $this->hasMany(Empresa::class);
    }
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function almacenes(){
        return $this->hasMany(Almacen::class);
    }

    public function ventas(){
        return $this->belongsToMany(Venta::class);
    }

    public function Notas_Credito(){
        return $this->hasMany(NotaCredito::class, 'user_id','id');
    }

    public function rfcs(){
        return $this->belongsToMany(Rfc::class, 'rfc_user','user_id','rfc_id');
    }
    public function emails(){
        return $this->hasMany( 'email_user','user_id','id');
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
        return "{$this->ap_paterno} {$this->ap_materno} {$this->nombre}";
    }

//    public function getFullNameCFDI40Attribute() {
//        return "{$this->nombre} {$this->ap_paterno} {$this->ap_materno}";
//    }

    public function getNombreCompletoCFDI40Attribute() {
        return "{$this->nombre} {$this->ap_paterno} {$this->ap_materno}";
    }

    public function sendPasswordResetNotification($token){
        $this->notify(new MyResetPassword($token));
    }

    public function scopeFiltrar($query, $search)
    {
        if (empty ($search)) {
            return;
        }
        $search = strtoupper($search);
        $query->whereRaw("CONCAT(ap_paterno,' ',ap_materno,' ',nombre) like ?", "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%")
            ->orWhere('cuenta', 'like', "%{$search}%")
            ->orWhere('username', 'like', "%{$search}%")
            ->orWhere('id', 'like', "%{$search}%");
//            ->orWhereHas('team', function ($query) use ($search) {
//                $query->where('name', 'like', "%{$search}%");
//            });
    }


    public static function createUserFromPlatsourceTutor($Data, $iduser_ps, $IdUser){

        $F = (new FuncionesController);

        $data = explode('|',$Data);
        
        $ap_paterno = $F->toMayus($data[4]);
        $ap_materno = $F->toMayus($data[5]);
        $nombre = $F->toMayus($data[6]);

        $arrEmail = explode(',',$data[9]);
        $timestamp = Carbon::now()->timestamp;
    
        $d['ap_paterno'] = $ap_paterno;
        $d['ap_materno']   = $ap_materno;
        $d['nombre'] = $nombre;
        $d['username'] = $data[10];
        $d['email'] = $timestamp."@example.com";
        $d['cuenta'] = '';
        $d['celular'] = is_null($data[7]) ? ' ' : $data[7];
        $d['telefono'] = is_null($data[8]) ? ' ' : $data[8];
        $d['iduser_ps'] = is_null($iduser_ps) ? $IdUser : $iduser_ps;
    
        $d["idemp"]       = $F->getIHE(0);
        $d["ip"]          = $F->getIHE(1);
        $d["host"]        = $F->getIHE(2);
        $d["familia_cliente_id"] = 5; //Profesores
    
        $role1 = Role::find(3);
        $role2 = Role::find(4);
        $role3 = Role::find(5);
    
        //dd($data);
    
        //User::create($data);
        $user = User::findOrCreateUserWithRole3(
            $d['cuenta'], $d['username'], $d['nombre'], $d['ap_paterno'], $d['ap_materno'], $d['email'],
            '',false,false,false,false,false,0,0,
            '', $d['celular'], $d['telefono'],0,0, $d['familia_cliente_id'],
            $d['iduser_ps'],$d['idemp'],$role1,$role2,$role3);
    
        return $user;
    }
    


    public static function findOrCreateUserWithRole3(
        string $cuenta, string $username, string $nombre, string $ap_paterno, string $ap_materno, string $email, string $password,
        bool $admin, bool $alumno, bool $foraneo, bool $exalumno, bool $credito, int $dias_credito, float $limite_credito,
        string $domicilio, string $celular, string $telefono,
        float $saldo_a_favor, float $saldo_en_contra, int $familia_cliente_id,
        int $iduser_ps, int $idemp, Role $role1, Role $role2, Role $role3,
        string $calle='', string $num_ext='', string $num_int='', string $colonia='', string $localidad='', string $estado='', string $pais='', string $cp='', string $curp='', string $rfc='', string $razon_social='',
        string $lugar_nacimiento='', Date $fecha_nacimiento=null, int $genero=null,
        string $ocupacion=''){
        $user = static::query()
            ->where('username', $username)
            ->where('email', $email)
            ->where('cuenta', $cuenta)
            ->first();
        // $user = static::all()->where('username','=', trim($username))->first();

        if (is_null($user)) {
            
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
                'rfc' => $rfc,
                'curp' => $curp,
                'razon_social' => $razon_social,
                'calle' => $calle,
                'num_ext' => $num_ext,
                'num_int' => $num_int,
                'colonia' => $colonia,
                'localidad' => $localidad,
                'estado' => $estado,
                'pais' => $pais,
                'cp' => $cp,
                'lugar_nacimiento' => $lugar_nacimiento,
                'fecha_nacimiento' => $fecha_nacimiento,
                'genero' => $genero,
                'ocupacion'=> $ocupacion,
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
            $F = new FuncionesController();
            $F->validImage($user,'profile','profile/');

        }
        return $user;

    }


}
