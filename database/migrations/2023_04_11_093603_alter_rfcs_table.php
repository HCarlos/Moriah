<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterRfcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        $tableNames = config('siifac.table_names');

        if ( ! Schema::hasTable( $tableNames['regimenes_fiscales'] ) ) {
            Schema::create($tableNames['regimenes_fiscales'], function (Blueprint $table) use ($tableNames) {
                $table->increments('id')->unique();
                $table->string('clave_regimen_fiscal',20)->default('000')->nullable(false)->unique();
                $table->string('regimen_fiscal',256)->default('')->nullable(false)->unique();
                $table->integer('empresa_id')->default(1)->index();
                $table->unsignedSmallInteger('status_registro_fiscal')->default(1)->nullable();
                $table->unsignedSmallInteger('idemp')->default(1)->nullable();
                $table->string('ip',150)->default('')->nullable();
                $table->string('host',150)->default('')->nullable();
                $table->softDeletes();
                $table->timestamps();

            });
        }

        Schema::table($tableNames['rfcs'], function (Blueprint $table) use ($tableNames) {
            $table->string('emails',250)->default("")->nullable();
            $table->integer('regimen_fiscal_id')->index()->nullable();

            $table->foreign('regimen_fiscal_id')
                ->references('id')
                ->on($tableNames['regimenes_fiscales'])
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableNames = config('siifac.table_names');

        if ( Schema::hasTable( $tableNames['rfcs'] )) {
            Schema::table($tableNames['rfcs'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('emails');
                $table->dropColumn('regimen_fiscal_id');
            });
        }

        Schema::dropIfExists($tableNames['regimenes_fiscales'] );


    }
}
