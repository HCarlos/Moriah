<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterNotaCredito2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('siifac.table_names');

        if ( Schema::hasTable( $tableNames['notas_credito'] ) ) {
            Schema::table($tableNames['notas_credito'], function (Blueprint $table) use ($tableNames) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $indexesFound = $sm->listTableIndexes('notas_credito');

                if (array_key_exists("notas_credito_consecutivo_index", $indexesFound))
                    $table->dropIndex('notas_credito_consecutivo_index');

                if (array_key_exists("notas_credito_venta_id_index", $indexesFound))
                    $table->dropIndex('notas_credito_venta_id_index');

                if (array_key_exists("notas_credito_venta_id_foreign", $indexesFound))
                    $table->dropForeign('notas_credito_venta_id_foreign');

                $table->integer('consecutivo')->nullable()->default(0)->index();
                $table->index('venta_id');

                $table->foreign('venta_id')
                    ->references('id')
                    ->on($tableNames['ventas'])
                    ->onDelete('cascade');
            });

        }

        if ( Schema::hasTable( $tableNames['nota_credito_detalle'] ) ) {
            Schema::table($tableNames['nota_credito_detalle'], function (Blueprint $table) use ($tableNames) {
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $indexesFound = $sm->listTableIndexes('nota_credito_detalle');

                if (array_key_exists("nota_credito_detalle_venta_id_index", $indexesFound))
                    $table->dropIndex('nota_credito_detalle_venta_id_index');

                if (array_key_exists("nota_credito_detalle_venta_id_foreign", $indexesFound))
                    $table->dropForeign('nota_credito_detalle_venta_id_foreign');

                $table->index('venta_id');

                $table->foreign('venta_id')
                    ->references('id')
                    ->on($tableNames['ventas'])
                    ->onDelete('cascade');

                if (array_key_exists("nota_credito_detalle_venta_detalle_id_index", $indexesFound))
                    $table->dropIndex('nota_credito_detalle_venta_detalle_id_index');

                if (array_key_exists("nota_credito_detalle_venta_detalle_id_foreign", $indexesFound))
                    $table->dropForeign('nota_credito_detalle_venta_detalle_id_foreign');

                $table->index('venta_detalle_id');

                $table->foreign('venta_detalle_id')
                    ->references('id')
                    ->on($tableNames['venta_detalles'])
                    ->onDelete('cascade');




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
                $table->dropIndex('notas_credito_consecutivo_index');
                $table->dropIndex('notas_credito_venta_id_index');
                $table->dropForeign('notas_credito_venta_id_foreign');
                $table->dropColumn('consecutivo');
            });
        }

        if ( Schema::hasTable( $tableNames['nota_credito_detalle'] ) ) {
            Schema::table($tableNames['nota_credito_detalle'], function (Blueprint $table) use ($tableNames) {
                $table->dropIndex('nota_credito_detalle_venta_detalle_id_index');
                $table->dropForeign('nota_credito_detalle_venta_detalle_id_foreign');
                $table->dropIndex('nota_credito_detalle_venta_id_index');
                $table->dropForeign('nota_credito_detalle_venta_id_foreign');
            });
        }




    }

}
