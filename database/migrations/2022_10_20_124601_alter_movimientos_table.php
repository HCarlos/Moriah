<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $tableNames = config('siifac.table_names');
        Schema::table($tableNames['movimientos'], function (Blueprint $table) use ($tableNames) {
            $table->decimal('debe_costeo',10,2)->default(0.00)->nullable();
            $table->decimal('haber_costeo',10,2)->default(0.00)->nullable();
            $table->decimal('saldo_costeo',10,2)->default(0.00)->nullable();

        });
        Schema::table($tableNames['productos'], function (Blueprint $table) use ($tableNames) {
            $table->decimal('saldo_costeo',10,2)->default(0.00)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $tableNames = config('siifac.table_names');
        Schema::table($tableNames['movimientos'], function (Blueprint $table) use ($tableNames) {
            $table->dropColumn('debe_costeo');
            $table->dropColumn('haber_costeo');
            $table->dropColumn('saldo_costeo');
        });
        Schema::table($tableNames['productos'], function (Blueprint $table) use ($tableNames) {
            $table->dropColumn('saldo_costeo');
        });
    }
}
