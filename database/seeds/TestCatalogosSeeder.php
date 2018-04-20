<?php

use App\Models\SIIFAC\Almacen;
use App\Models\SIIFAC\Concepto;
use Illuminate\Database\Seeder;

class TestCatalogosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Almacen::class,10)->create();
        factory(Concepto::class,10)->create();
    }
}
