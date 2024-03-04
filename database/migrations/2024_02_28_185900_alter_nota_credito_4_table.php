<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNotaCredito4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

            $tableNames = config('siifac.table_names');

            if (Schema::hasTable($tableNames['notas_credito'])) {
                Schema::table($tableNames['notas_credito'], function (Blueprint $table) use ($tableNames) {
                    $table->float('importe_utilizado')->default(0.00);
                    $table->float('saldo_utilizado')->default(0.00);
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

            if ( Schema::hasTable( $tableNames['notas_credito'] ) ) {
                Schema::table($tableNames['notas_credito'], function (Blueprint $table) use ($tableNames) {
                    $table->dropColumn('importe_utilizado');
                    $table->dropColumn('saldo_utilizado');
                });
            }

    }
}
