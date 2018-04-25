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

        $P0 = Permission::create(['name' => 'all']);
        $P1 = Permission::create(['name' => 'crear']);
        $P2 = Permission::create(['name' => 'editar']);
        $P3 = Permission::create(['name' => 'eliminar']);
        $P4 = Permission::create(['name' => 'consultar']);
        $P5 = Permission::create(['name' => 'imprimir']);

        $role_admin = Role::create([
            'name' => 'administrator',
            'description' => 'administrator',
            'guard_name' => 'web',
        ]);
        $role_admin->givePermissionTo($P0);

        $role_user_libros = Role::create([
            'name' => 'usuarios_libros',
            'description' => 'usuario libros',
            'guard_name' => 'web',
        ]);
        $role_user_libros->givePermissionTo($P4);

        $role_user_uniformes = Role::create([
            'name' => 'usuario_uniformes',
            'description' => 'usuario uniformes',
            'guard_name' => 'web',
        ]);
        $role_user_uniformes->givePermissionTo($P4);

        $role_user_cuadernos = Role::create([
            'name' => 'usuario_cuadernos',
            'description' => 'usuario cuadernos',
            'guard_name' => 'web',
        ]);
        $role_user_cuadernos->givePermissionTo($P4);

        $role_user_servicios = Role::create([
            'name' => 'usuario_servicios',
            'description' => 'usuario servicios',
            'guard_name' => 'web',
        ]);
        $role_user_servicios->givePermissionTo($P4);

        $role_uv_libros = Role::create([
            'name' => 'usuario_venta_libros',
            'description' => 'usuario de venta de libros',
            'guard_name' => 'web',
        ]);
        $role_uv_libros->givePermissionTo($P4);

        $role_ua_libros = Role::create([
            'name' => 'usuario_admin_venta_libros',
            'description' => 'usuario de venta de libros',
            'guard_name' => 'web',
        ]);
        $role_ua_libros->givePermissionTo($P4);

        $role_uv_uniformes = Role::create([
            'name' => 'usuario_venta_uniformes',
            'description' => 'usuario de venta de uniformes',
            'guard_name' => 'web',
        ]);
        $role_uv_uniformes->givePermissionTo($P4);

        $role_ua_uniformes = Role::create([
            'name' => 'usuario_admin_venta_uniformes',
            'description' => 'usuario de venta de uniformes',
            'guard_name' => 'web',
        ]);
        $role_ua_uniformes->givePermissionTo($P4);

        $role_uv_cuadernos = Role::create([
            'name' => 'usuario_venta_cuadernos',
            'description' => 'usuario de venta de cuadernos',
            'guard_name' => 'web',
        ]);
        $role_uv_cuadernos->givePermissionTo($P4);

        $role_ua_cuadernos = Role::create([
            'name' => 'usuario_admin_venta_cuadernos',
            'description' => 'usuario de venta de cuadernos',
            'guard_name' => 'web',
        ]);
        $role_ua_cuadernos->givePermissionTo($P4);


        $user = new User();
        $user->nombre = 'Administrador';
        $user->username = 'Admin';
        $user->email = 'admin@example.com';
        $user->cuenta = '20182404130814';
        $user->password = bcrypt('secret');
        $user->admin = true;
        $user->idemp = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->save();
        $user->roles()->attach($role_admin);
        $user->permissions()->attach($P0);

        $user = new User();
        $user->nombre = 'Usuario de los Libros';
        $user->username = 'usuario_libros';
        $user->email = 'usuario_libro@example.com';
        $user->cuenta = '20182404130901';
        $user->password = bcrypt('secret');
        $user->idemp = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->save();
        $user->roles()->attach($role_user_libros);
        $user->permissions()->attach($P4);

        $user = new User();
        $user->nombre = 'Usuario de Uniformes';
        $user->username = 'usuario_uniformes';
        $user->email = 'usuario_uniforme@example.com';
        $user->cuenta = '20182404130937';
        $user->password = bcrypt('secret');
        $user->idemp = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->save();
        $user->roles()->attach($role_user_uniformes);
        $user->permissions()->attach($P4);

        $user = new User();
        $user->nombre = 'Usuario de Cuadernos';
        $user->username = 'usuario_cuadernos';
        $user->email = 'usuario_cuaderno@example.com';
        $user->cuenta = '20182404130947';
        $user->password = bcrypt('secret');
        $user->idemp = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->save();
        $user->roles()->attach($role_user_cuadernos);
        $user->permissions()->attach($P4);


        $user = new User();
        $user->nombre = 'Usuario de Servicios';
        $user->username = 'usuario_servicios';
        $user->email = 'usuario_servicio@example.com';
        $user->cuenta = '20182404130957';
        $user->password = bcrypt('secret');
        $user->idemp = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->save();
        $user->roles()->attach($role_user_servicios);
        $user->permissions()->attach($P4);

        $user = new User();
        $user->nombre = 'Usuario Venta Servicios';
        $user->username = 'uv_libros';
        $user->email = 'uv_libro@example.com';
        $user->cuenta = '20182404130967';
        $user->password = bcrypt('secret');
        $user->idemp = $idemp;
        $user->ip = $ip;
        $user->host = $host;
        $user->save();
        $user->roles()->attach($role_uv_libros);
        $user->permissions()->attach($P4);


    }

}
