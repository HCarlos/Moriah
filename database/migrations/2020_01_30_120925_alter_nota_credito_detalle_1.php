<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterNotaCreditoDetalle1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        Schema::table('nota_credito_detalle', function (Blueprint $table) {

            // $table->renameColumn('folio','venta_id');
            // $table->integer('venta_detalle_id')->default(0)->nullable();

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nota_credito_detalle', function (Blueprint $table) {
            // $table->renameColumn('venta_id','folio');
            // $table->dropColumn('venta_detalle_id');
        });
    }
}
