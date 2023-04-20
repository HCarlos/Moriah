<?php

use App\Models\SIIFAC\Movimiento;
use App\Models\SIIFAC\NotaCreditoDetalle;
use App\Models\SIIFAC\VentaDetalle;
use Illuminate\Database\Seeder;

class LlenarPrecioCostoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $VDs = VentaDetalle::query()->get();
        foreach ($VDs as $vd){
            $pc = Movimiento::query()->where('venta_detalle_id',$vd->id)->first();
            if ($pc){
                VentaDetalle::where('id',$vd->id)->update(['pc'=>$pc->cu]);
            }
        }

        $NCDs = NotaCreditoDetalle::query()->get();
        foreach ($NCDs as $nc){
            $pc = Movimiento::query()->where('venta_detalle_id',$nc->venta_detalle_id)->first();
            if ($pc){
                NotaCreditoDetalle::where('id',$nc->id)->update(['pc'=>$pc->cu]);
            }
        }

    }
}
