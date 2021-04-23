<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('siifac.table_names');

        Schema::table($tableNames['ventas'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('idciclo_ps')->default(0)->nullable();
            $table->string('ciclo',20)->default('')->nullable();
            $table->unsignedInteger('idgrado_ps')->default(0)->nullable();
            $table->string('grado',20)->default('')->nullable();
            $table->unsignedInteger('idgrupo_ps')->default(0)->nullable();
            $table->string('grupo',20)->default('')->nullable();
            $table->unsignedInteger('idalumno_ps')->default(0)->nullable();
            $table->string('alumno',20)->default('')->nullable();
            $table->unsignedInteger('idtutor_ps')->default(0)->nullable();
            $table->string('turor',20)->default('')->nullable();
            $table->unsignedInteger('idfamilia_ps')->default(0)->nullable();
            $table->string('familia',20)->default('')->nullable();
            $table->string('alu_ap_paterno',100)->default('')->nullable();
            $table->string('alu_ap_materno',100)->default('')->nullable();
            $table->string('alu_nombre',100)->default('')->nullable();
        });

        Schema::table($tableNames['pedidos'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedInteger('idciclo_ps')->default(0)->nullable();
            $table->string('ciclo',20)->default('')->nullable();
            $table->unsignedInteger('idgrado_ps')->default(0)->nullable();
            $table->string('grado',20)->default('')->nullable();
            $table->unsignedInteger('idgrupo_ps')->default(0)->nullable();
            $table->string('grupo',20)->default('')->nullable();
            $table->unsignedInteger('idalumno_ps')->default(0)->nullable();
            $table->string('alumno',20)->default('')->nullable();
            $table->unsignedInteger('idtutor_ps')->default(0)->nullable();
            $table->string('turor',20)->default('')->nullable();
            $table->unsignedInteger('idfamilia_ps')->default(0)->nullable();
            $table->string('familia',20)->default('')->nullable();
            $table->string('alu_ap_paterno',100)->default('')->nullable();
            $table->string('alu_ap_materno',100)->default('')->nullable();
            $table->string('alu_nombre',100)->default('')->nullable();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableNames = config('siifac.table_names');

        Schema::table($tableNames['ventas'], function (Blueprint $table) use ($tableNames) {
            $table->dropColumn('idciclo_ps');
            $table->dropColumn('ciclo');
            $table->dropColumn('idgrado_ps');
            $table->dropColumn('grado');
            $table->dropColumn('idgrupo_ps');
            $table->dropColumn('grupo');
            $table->dropColumn('idalumno_ps');
            $table->dropColumn('alumno');
            $table->dropColumn('idtutor_ps');
            $table->dropColumn('turor');
            $table->dropColumn('idfamilia_ps');
            $table->dropColumn('familia');
            $table->dropColumn('alu_ap_paterno');
            $table->dropColumn('alu_ap_materno');
            $table->dropColumn('alu_nombre');
        });

        Schema::table($tableNames['pedidos'], function (Blueprint $table) use ($tableNames) {
            $table->dropColumn('idciclo_ps');
            $table->dropColumn('ciclo');
            $table->dropColumn('idgrado_ps');
            $table->dropColumn('grado');
            $table->dropColumn('idgrupo_ps');
            $table->dropColumn('grupo');
            $table->dropColumn('idalumno_ps');
            $table->dropColumn('alumno');
            $table->dropColumn('idtutor_ps');
            $table->dropColumn('turor');
            $table->dropColumn('idfamilia_ps');
            $table->dropColumn('familia');
            $table->dropColumn('alu_ap_paterno');
            $table->dropColumn('alu_ap_materno');
            $table->dropColumn('alu_nombre');
        });


    }
}
