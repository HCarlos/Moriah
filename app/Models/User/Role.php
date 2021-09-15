<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasPermissions;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'roles';
    protected $fillable = ['id','name','descripcion','abreviatura','color'];

    public static function findByName($name){
        return static::where( 'name',$name )->first();
    }

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public static function findOrCreateRoleMasive(string $name, string $descripcion, Permission $permission_id){
        $role = static::all()->where('name', $name)->first();
        if (!$role) {
            $role = static::create([
                'name'=>$name,
                'descripcion'=>$descripcion,
                'color' => '#000000',
                'abreviatura' => '',
                'guard_name'=>'web',
            ]);
            $role->permissions()->attach($permission_id);
        }
        return $role;

    }


}
