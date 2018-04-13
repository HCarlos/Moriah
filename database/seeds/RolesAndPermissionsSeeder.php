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
        $user->name = 'Administrador';
        $user->username = 'Admin';
        $user->email = 'admin@example.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_user);
        $user->roles()->attach($role_admin);

        $user = new User();
        $user->name = 'Usuario';
        $user->username = 'User';
        $user->email = 'user@example.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($role_user);

    }

}
