<?php

namespace Database\Seeders;

use App\Models\Catalogos\Alumno;
use App\Models\Catalogos\Ciclo;
use App\Models\Catalogos\Empresa;
use App\Models\Catalogos\Familia;
use App\Models\Catalogos\Grado;
use App\Models\Catalogos\Nivel;
use App\Models\Catalogos\Parentesco;
use App\Models\Catalogos\Subciclo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class InitializeCatalogosBiblosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {

     // Obtenemos el primer Usuario que debe ser el que se crea primero al generar el Seedor UserRolesPermisos
     $creado_por_id = User::find(1)->id;

     //Obtenemos los Roles
     $RoleAlumnoId = Role::select('id')->where('name','ALUMNO')->first()->id;
     $RoleProfesorId = Role::select('id')->where('name','PROFESOR')->first()->id;


    // Se inicializa el número de la empresa wue se estará utilizando
    $empresa_id = 1;
    $Emp = Empresa::find($empresa_id);

    // Se crea el ciclo


    }
}
