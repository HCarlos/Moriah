<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTotalPagadoColumnIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        // Schema::table('ingresos', function (Blueprint $table) {
        //     $table->decimal('total_pagado',10,2)->default(0)->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        // Schema::table('ingresos', function (Blueprint $table) {
        //     $table->dropColumn('total_pagado');
        // });
    }
}
