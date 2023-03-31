<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEmperesaVentaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $tableNames = config('siifac.table_names');
        Schema::table($tableNames['empresa_venta'], function (Blueprint $table) use ($tableNames) {
            $table->integer('folio',)->default(0)->index()->nullable();
        });



        if ( ! Schema::hasTable( $tableNames['rfcs'] ) ) {
            Schema::create($tableNames['rfcs'], function (Blueprint $table) use ($tableNames) {
                $table->increments('id')->unique();
                $table->string('rfc',20)->default('')->nullable(false)->unique();
                $table->string('razon_social',255)->default('');
                $table->string('razon_social_cfdi_40',255)->default('');
                $table->string('calle',255)->default('');
                $table->string('num_ext',25)->default('');
                $table->string('num_int',25)->default('');
                $table->string('colonia',255)->default('');
                $table->string('localidad',255)->default('');
                $table->string('municipio',50)->default('');
                $table->string('estado',50)->default('');
                $table->string('pais',25)->default('');
                $table->string('cp',10)->default('')->index();
                $table->boolean('is_extrangero')->default(false);
                $table->boolean('activo')->default(true);
                $table->string('observaciones',255)->default('');
                $table->integer('empresa_id')->default(0);
                $table->unsignedSmallInteger('idemp')->default(0)->nullable();
                $table->string('ip',150)->default('')->nullable();
                $table->string('host',150)->default('')->nullable();
                $table->softDeletes();
                $table->timestamps();

                $table->foreign('empresa_id')
                    ->references('id')
                    ->on($tableNames['empresas'])
                    ->onDelete('cascade');


            });
        }

        if ( ! Schema::hasTable( $tableNames['rfc_user'] ) ) {
            Schema::create($tableNames['rfc_user'], function (Blueprint $table) use ($tableNames) {
                $table->increments('id');
                $table->integer('rfc_id')->index();
                $table->integer('user_id')->index();
                $table->softDeletes();
                $table->timestamps();
            $table->unique(['rfc_id', 'user_id']);

                $table->foreign('rfc_id')
                    ->references('id')
                    ->on($tableNames['rfcs'])
                    ->onDelete('cascade');

                $table->foreign('user_id')
                    ->references('id')
                    ->on($tableNames['users'])
                    ->onDelete('cascade');
            });

        }

        if ( ! Schema::hasTable( $tableNames['email_user'] ) ) {
            Schema::create($tableNames['email_user'], function (Blueprint $table) use ($tableNames) {
                $table->increments('id');
                $table->string('email', 255)->default('')->index();
                $table->smallInteger('categoria')->default(0)->index()->comment("0=General, 1=Facturas, 2=Boletines, 3=Ofertas, 4=Otros1, 5=Otros2, 6=Otros3");
                $table->integer('user_id')->index();
                $table->softDeletes();
                $table->timestamps();
                $table->unique(['email', 'categoria', 'user_id']);

                $table->foreign('user_id')
                    ->references('id')
                    ->on($tableNames['users'])
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

        if ( Schema::hasTable( $tableNames['empresa_venta'] )) {
            Schema::table($tableNames['empresa_venta'], function (Blueprint $table) use ($tableNames) {
                $table->dropColumn('folio');
            });
        }

        Schema::dropIfExists($tableNames['rfc_user'] );
        Schema::dropIfExists($tableNames['email_user'] );
        Schema::dropIfExists($tableNames['rfcs'] );

    }
}
