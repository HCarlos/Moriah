<?php

namespace Database\Seeders;

use App\Classes\GeneralFunctios;
use App\Models\Catalogos\Empresa;
use App\Models\User;
use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class InitializeUserRolesPermissionsBiblosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        app()['cache']->forget('spatie.permission.cache');

        $F = new GeneralFunctios();
        $ip   = 'root_init';
        $host = 'root_init';

        Empresa::query()->truncate();

        $idemp = Empresa::create([
            'razon_social' => 'Nombre Institución',
            'domicilio_fiscal' => 'concoido',
            'domicilio_fiscal' => 'rfc'
        ]);

        //dd($idemp);

        $P1 = Permission::create(['name' => 'all','guard_name' => 'web']);
        $P2 = Permission::create(['name' => 'crear','guard_name' => 'web']);
        $P3 = Permission::create(['name' => 'guardar','guard_name' => 'web']);
        $P4 = Permission::create(['name' => 'editar','guard_name' => 'web']);
        $P5 = Permission::create(['name' => 'modificar','guard_name' => 'web']);
        $P6 = Permission::create(['name' => 'eliminar','guard_name' => 'web']);
        $P7 = Permission::create(['name' => 'consultar','guard_name' => 'web']);
        $P8 = Permission::create(['name' => 'imprimir','guard_name' => 'web']);
        $P9 = Permission::create(['name' => 'asignar','guard_name' => 'web']);
        $P10 = Permission::create(['name' => 'desasignar','guard_name' => 'web']);
        $P11 = Permission::create(['name' => 'sysop','guard_name' => 'web']);

        $role_admin = Role::create([
            'name' => 'ADMIN',
            'descripcion' => 'Administrator',
            'color' => '#263238',
            'abreviatura' => 'adm',
            'guard_name' => 'web',
        ]);
        $role_admin->permissions()->attach($P1);

        $role_sysop = Role::create([
            'name' => 'SYSOP',
            'descripcion' => 'System Operator',
            'color' => '#455a64',
            'abreviatura' => 'sys',
            'guard_name' => 'web',
        ]);
        $role_sysop->permissions()->attach($P11);

        $role_invitado = Role::create([
            'name' => 'Invitado',
            'descripcion' => 'Invitado',
            'color' => '#607d8b',
            'abreviatura' => 'inv',
            'guard_name' => 'web',
        ]);
        $role_invitado->permissions()->attach($P7);

        $user = new User();
        $user->nombre = 'Administrador';
        $user->username = 'Admin';
        $user->email = 'sentauro@gmail.com';
        $user->password = bcrypt('secret');
        $user->genero = 1;
        $user->admin = true;
        $user->empresa_id = $idemp->id;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach($role_admin);
        $user->permissions()->attach($P1);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $user->user_data_social()->create();
        $F->validImage($user,'profile','profile/');

        $user = new User();
        $user->nombre = 'System Operator';
        $user->username = 'SysOp';
        $user->email = 'sysop@example.com';
        $user->password = bcrypt('sysop');
        $user->admin = false;
        $user->empresa_id = $idemp->id;
        $user->ip = $ip;
        $user->host = $host;
        $user->email_verified_at = now();
        $user->save();
        $user->roles()->attach($role_sysop);
        $user->permissions()->attach($P11);
        $user->user_adress()->create();
        $user->user_data_extend()->create();
        $user->user_data_social()->create();
        $F->validImage($user,'profile','profile/');

        Role::create(['name'=>'ALUMNO','descripcion'=>'Alumno', 'color'=>'#558b2f', 'abreviatura'=>'alu', 'guard_name'=>'web'])->permissions()->attach($P7);
        Role::create(['name'=>'PROFESOR','descripcion'=>'Profesor', 'color'=>'#dd2c00', 'abreviatura'=>'pro', 'guard_name'=>'web'])->permissions()->attach($P7);

    }
}
