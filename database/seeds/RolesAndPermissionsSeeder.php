<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $ip   = 'root_init';//$_SERVER['REMOTE_ADDR'];
        $host = 'root_init';//gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $idemp = 1;

        Permission::create(['name' => 'all']);
        Permission::create(['name' => 'editar_registro']);

        $role_admin = Role::create([
            'name' => 'administrator',
            'description' => 'administrator',
            'guard_name' => 'web',
        ]);
        $role_admin->givePermissionTo('all');

        $role_user = Role::create([
            'name' => 'user',
            'description' => 'user',
            'guard_name' => 'web',
        ]);
        $role_user->givePermissionTo('editar_registro');

        $user = new User();
        $user->nombre = 'Administrador';
        $user->username = 'Admin';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('secret');
        $user->admin = true;
        $user->idemp = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->save();
        $user->roles()->attach($role_user);
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->nombre = 'Usuario';
        $user->username = 'User';
        $user->email = 'user@example.com';
        $user->password = bcrypt('secret');
        $user->idemp = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->save();
        $user->roles()->attach($role_user);

    }

}
