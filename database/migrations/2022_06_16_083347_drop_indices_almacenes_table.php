<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIndicesAlmacenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $tableNames = config('siifac.table_names');

        Schema::table($tableNames['almacenes'], function (Blueprint $table) use ($tableNames) {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('almacenes');

            if (array_key_exists("almacenes_clave_almacen_unique", $indexesFound))
                $table->dropUnique('almacenes_clave_almacen_unique');

            if (array_key_exists("almacenes_descripcion_unique", $indexesFound))
                $table->dropUnique('almacenes_descripcion_unique');

            if (array_key_exists("almacenes_prefijo_unique", $indexesFound))
                $table->dropUnique('almacenes_prefijo_unique');


            if (array_key_exists("almacenes_clave_almacen_empresa_id_unique", $indexesFound))
                $table->dropUnique('almacenes_clave_almacen_empresa_id_unique');

            if (array_key_exists("almacenes_descripcion_empresa_id_unique", $indexesFound))
                $table->dropUnique('almacenes_descripcion_empresa_id_unique');

            if (array_key_exists("almacenes_prefijo_empresa_id_unique", $indexesFound))
                $table->dropUnique('almacenes_prefijo_empresa_id_unique');


            $table->unique(['clave_almacen', 'empresa_id']);
            $table->unique(['descripcion', 'empresa_id']);
            $table->unique(['prefijo', 'empresa_id']);


        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        //
    }
}
