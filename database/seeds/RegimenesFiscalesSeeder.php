<?php

use App\Models\SIIFAC\RegimenesFiscales;
use Illuminate\Database\Seeder;

class RegimenesFiscalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        RegimenesFiscales::create(['clave_regimen_fiscal'=>'000','regimen_fiscal'=>'Sin Régimen Fiscal']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'601','regimen_fiscal'=>'General de Ley Personas Morales']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'603','regimen_fiscal'=>'Personas Morales con Fines no Lucrativos']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'605','regimen_fiscal'=>'Sueldos y Salarios e Ingresos Asimilados a Salarios']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'606','regimen_fiscal'=>'Arrendamiento']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'607','regimen_fiscal'=>'Régimen de Enajenación o Adquisición de Bienes']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'608','regimen_fiscal'=>'Demás ingresos']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'610','regimen_fiscal'=>'Residentes en el Extranjero sin Establecimiento Permanente en México']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'611','regimen_fiscal'=>'Ingresos por Dividendos (socios y accionistas)']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'612','regimen_fiscal'=>'Personas Físicas con Actividades Empresariales y Profesionales']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'614','regimen_fiscal'=>'Ingresos por intereses']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'615','regimen_fiscal'=>'Régimen de los ingresos por obtención de premios']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'616','regimen_fiscal'=>'Sin obligaciones fiscales']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'620','regimen_fiscal'=>'Sociedades Cooperativas de Producción que optan por diferir sus ingresos']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'621','regimen_fiscal'=>'Incorporación Fiscal']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'622','regimen_fiscal'=>'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'623','regimen_fiscal'=>'Opcional para Grupos de Sociedades']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'624','regimen_fiscal'=>'Coordinados']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'625','regimen_fiscal'=>'Régimen de las Actividades Empresariales con ingresos a través de Plataformas Tecnológicas']);
        RegimenesFiscales::create(['clave_regimen_fiscal'=>'626','regimen_fiscal'=>'Régimen Simplificado de Confianza']);
    }
}
