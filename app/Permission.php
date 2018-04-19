<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User;

class Permission extends Model
{
    use HasRoles;
    use HasPermissions;

    protected $guard_name = 'web'; // or whatever guard you want to use
    protected $table = 'permissions';

    public function roles() {
        // Esta en muchos Roles
        return $this->hasMany(Role::class);
    }

    public function users() {
        // Esta en muchos Roles
        return $this->hasMany(User::class);
    }

}
