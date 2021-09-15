<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasRoles;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'permissions';
    protected $fillable = ['id','name','description'];

    public static function findByName($name){
        return static::where( 'name',$name )->first();
    }
    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    public function users() {
        // Esta en muchos Roles
        return $this->belongsToMany(User::class);
    }

}
