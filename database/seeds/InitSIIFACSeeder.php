<?php

use App\Models\SIIFAC\Empresa;
use Illuminate\Database\Seeder;

class InitSIIFACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Empresa::findOrCreateEmpresa('COMERCIALIZADORA ARJI, S.A. DE C.V.','COMERCIALIZADORA ARJI, S.A. DE C.V.','AV. MEXICO #2 COL. DEL BOSQUE, VILLAHERMOSA, TABASCO CP.86160','CAR-930816-FH0');
        Empresa::findOrCreateEmpresa('LIBROS 2006/2007', 'LIBROS 2006/2007','AVENIDA MEXICO #2','');
    }
}
