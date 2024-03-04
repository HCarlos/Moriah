<?php

use App\Models\SIIFAC\NotaCredito;
use Illuminate\Database\Seeder;

class ActualizarSaldosDeNotasDeCreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $NCs = NotaCredito::all();
        foreach ($NCs as $NC){
            if ($NC->id > 0) {
                $NC->importe_utilizado = $NC->SaldoUtilizado;
                $NC->saldo_utilizado   = $NC->Saldo;
                $NC->save();
            }

        }

    }
}
