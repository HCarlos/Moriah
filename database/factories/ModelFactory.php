<?php

use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Concepto;
use App\Models\SIIFAC\Empresa;
use Faker\Generator as Faker;
/*
$factory->defineAs(dixard\User::class, 'admin', function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt('123'),
        'user_type' => 3,
        'remember_token' => str_random(10),
    ];
});
*/
$factory->define(Almacen::class, function (Faker $faker) {
    return [
        'clave_almacen' => $faker->randomNumber(),
        'descripcion' => $faker->text(25),
        'responsable' => $faker->text(25),
        'tipoinv' => $faker->randomElement([0,1,2]),
        'prefijo' => $faker->randomElement(['GEN','NGE','PRO']),
        'empresa_id' =>$faker->randomElement([1,2]),
    ];
});

$factory->define(Concepto::class, function (Faker $faker) {
    return [
        'isiva' => $faker->randomElement([true,false]),
        'factor' => $faker->randomNumber(),
        'descripcion' => $faker->text(25),
        'importe' => $faker->randomFloat(),
        'empresa_id' =>$faker->randomElement([1,2]),
    ];
});
