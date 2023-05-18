<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMovimiento2Table extends Migration{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $tableNames = config('siifac.table_names');
        Schema::table($tableNames['movimientos'], function (Blueprint $table) use ($tableNames) {
            $table->decimal('costo_promedio',10,2)->default(0.00)->nullable();
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
            $table->dropColumn('costo_promedio');
        });
    }


}
