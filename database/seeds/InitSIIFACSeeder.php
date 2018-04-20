<?php

use App\Models\SIIFAC\Empresa;
use App\Models\SIIFAC\Familia_Producto;
use App\Models\SIIFAC\Paquete;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class InitSIIFACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $IdEmp1 = Empresa::findOrCreateEmpresa('COMERCIALIZADORA ARJI, S.A. DE C.V.','COMERCIALIZADORA ARJI, S.A. DE C.V.','AV. MEXICO #2 COL. DEL BOSQUE, VILLAHERMOSA, TABASCO CP.86160','CAR-930816-FH0');
        $IdEmp2 = Empresa::findOrCreateEmpresa('LIBROS 2006/2007', 'LIBROS 2006/2007','AVENIDA MEXICO #2','');
        $IdEmp3 = Empresa::findOrCreateEmpresa('Empresa 3', 'Empresa 3','AVENIDA MEXICO #2','');

        $IdFP1 = Familia_Producto::findOrCreateProducto(1,'KINDER',0.00,1,$IdEmp1->id);
        $IdFP2 = Familia_Producto::findOrCreateProducto(2,'PRIMARIA',0.00,1,$IdEmp1->id);
        $IdFP3 = Familia_Producto::findOrCreateProducto(3,'SECUNDARIA',0.00,1,$IdEmp1->id);
        $IdFP4 = Familia_Producto::findOrCreateProducto(4,'PREPARATORIA',0.00,1,$IdEmp1->id);
        $IdFP5 = Familia_Producto::findOrCreateProducto(5,'SERVICIOS',0.00,1,$IdEmp1->id);

        $Paq1 = Paquete::findOrCreatePraquete(1,'110615120716','PAQUETE 2° DE SECUNDARIA ESP.',0,$IdEmp1->id);

    }
}
