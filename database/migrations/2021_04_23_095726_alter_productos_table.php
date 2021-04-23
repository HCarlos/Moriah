<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('siifac.table_names');

        Schema::table($tableNames['productos'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('status')->default(0)->nullable();
        });

        Schema::table($tableNames['pedidos'], function (Blueprint $table) use ($tableNames) {
            $table->string('username_alu',20)->default('')->nullable();
        });

        Schema::table($tableNames['ventas'], function (Blueprint $table) use ($tableNames) {
            $table->string('username_alu',20)->default('')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableNames = config('siifac.table_names');

        Schema::table($tableNames['productos'], function (Blueprint $table) use ($tableNames) {
            $table->dropColumn('status');
        });

        Schema::table($tableNames['pedidos'], function (Blueprint $table) use ($tableNames) {
            $table->dropColumn('username_alu');
        });

        Schema::table($tableNames['ventas'], function (Blueprint $table) use ($tableNames) {
            $table->dropColumn('username_alu');
        });

    }
}
