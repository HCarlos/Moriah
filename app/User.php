<?php

namespace App;

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
        'username', 'email', 'password','admin','nombre_completo',
        'filename','root','idemp','ip','host',
        'name',
    ];

    protected $hidden = ['password', 'remember_token',];
    protected $casts = ['admin'=>'boolean'];

    public function permissions() {
//        return $this->hasAnyPermission(Permission::class);
        return $this->belongsToMany(Permission::class);
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function isAdmin(){
        return $this->admin;
    }

    public function IsEmptyPhoto(){
        return $this->filename == '' ? true : false;
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MyResetPassword($token));
    }

    public static function findOrCreateUserWithRole(string $username, string $nombre_completo, string $email, string $password, int $iduser_ps, int $idemp, Role $role){
        $user = static::all()->where('username', $username)->where('email', $email)->first();
        if (!$user) {
            return static::create([
                'username'=>$username,
                'nombre_completo'=>$nombre_completo,
                'email'=>$email,
                'password' => bcrypt($password),
                'iduser_ps' => 0,
                'idemp' => $idemp,
            ])->roles()->attach($role);
        }
        return $user;
    }


}
