<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNotaCredito3Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){


        $tableNames = config('siifac.table_names');

        if ( Schema::hasTable( $tableNames['nota_credito_detalle'] ) ) {
            Schema::table($tableNames['nota_credito_detalle'], function (Blueprint $table) use ($tableNames) {
                $table->float('pc')->default(0.00);
            });
        }

        if ( Schema::hasTable( $tableNames['venta_detalles'] ) ) {
            Schema::table($tableNames['venta_detalles'], function (Blueprint $table) use ($tableNames) {
                $table->float('pc')->default(0.00);
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableNames = config('siifac.table_names');

        if ( Schema::hasTable( $tableNames['nota_credito_detalle'] ) ) {
            Schema::table($tableNames['nota_credito_detalle'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('pc');
            });
        }

        if ( Schema::hasTable( $tableNames['venta_detalles'] ) ) {
            Schema::table($tableNames['venta_detalles'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('pc');
            });
        }

    }
}
