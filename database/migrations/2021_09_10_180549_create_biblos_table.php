<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiblosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $tableUsers = config('ibt.table_names.users');
        $tablePersonas = config('ibt.table_names.personas');
        $tableUbi = config('ibt.table_names.ubicaciones');
        $tableCatalogos = config('ibt.table_names.catalogos');
        $tableRelaciones = config('ibt.table_names.relaciones');
        $tableBiblos = config('ibt.table_names.biblos');

        if (!Schema::hasTable($tableBiblos['codigo_lenguaje_paises'])) {
            Schema::create($tableBiblos['codigo_lenguaje_paises'], function (Blueprint $table) use ($tableCatalogos){
                $table->id();
                $table->string('codigo', 10)->nullable();
                $table->string('lenguaje', 150)->nullable();
                $table->char('tipo')->default('L')->nullable();
                $table->unsignedTinyInteger('empresa_id')->default(0)->nullable();
                $table->unsignedSmallInteger('status_lenguaje')->default(1)->nullable();
                $table->unsignedInteger('migration_id')->default(0)->nullable()->index();
                $table->timestamps();
                $table->index('empresa_id');

                $table->foreign('empresa_id')
                    ->references('id')
                    ->on($tableCatalogos['empresas'])
                    ->onDelete('cascade');

            });
        }

        if (!Schema::hasTable($tableBiblos['editoriales'])) {
            Schema::create($tableBiblos['editoriales'], function (Blueprint $table) use ($tableCatalogos){
                $table->id();
                $table->unsignedInteger('no')->nullable();
                $table->string('editorial',100)->unique();
                $table->string('representante',150)->nullable();
                $table->boolean('predeterminado')->default(false)->nonullable();
                $table->unsignedTinyInteger('empresa_id')->default(0)->nullable();
                $table->timestamps();
                $table->index('predeterminado');
                $table->index('empresa_id');

                $table->foreign('empresa_id')
                    ->references('id')
                    ->on($tableCatalogos['empresas'])
                    ->onDelete('cascade');

            });
        }

        if (!Schema::hasTable($tableBiblos['fichas'])) {
            Schema::create($tableBiblos['fichas'], function (Blueprint $table) use ($tableBiblos, $tableCatalogos ) {
                $table->id();
                $table->unsignedInteger('ficha_no')->nullable();
                $table->string('isbn',50);
                $table->string('etiqueta_smarth',50);
                $table->string('titulo',250);
                $table->string('autor',250);
                $table->unsignedTinyInteger('tipo_material')->nullable()->default(1);
                $table->string('clasificacion',30)->nullable();
                $table->unsignedInteger('no_coleccion')->nullable();
                $table->string('observaciones', 560)->default('')->nullable();
                $table->unsignedSmallInteger('empresa_id')->default(0)->nullable();
                $table->unsignedSmallInteger('status_ficha')->default(1)->nullable();
                $table->unsignedInteger('editorial_id')->default(2);
                $table->string('ip', 150)->default('')->nullable();
                $table->string('host', 150)->default('')->nullable();
                $table->softDeletes();
                $table->timestamps();
                $table->index('empresa_id');
                $table->index('isbn');
                $table->index('editorial_id');

                $table->foreign('editorial_id')
                    ->references('id')
                    ->on($tableBiblos['editoriales'])
                    ->onDelete('cascade');

                $table->foreign('empresa_id')
                    ->references('id')
                    ->on($tableCatalogos['empresas'])
                    ->onDelete('cascade');

            });
        }

        if (!Schema::hasTable($tableBiblos['portadas'])) {
            Schema::create($tableBiblos['portadas'], function (Blueprint $table) use ($tableUsers) {
                $table->bigIncrements('id');
                $table->string('root',250)->nullable();
                $table->string('filename',250)->nullable();
                $table->string('filename_png',250)->nullable();
                $table->string('filename_thumb',250)->default('')->nullable();
                $table->string('pie_de_foto',250)->default('')->nullable();
                $table->unsignedInteger('user_id')->default(0)->nullable();
                $table->unsignedInteger('creado_por_id')->default(0)->nullable();
                $table->unsignedSmallInteger('status_imagen')->default(1)->nullable();
                $table->string('ip',150)->default('')->nullable();
                $table->string('host',150)->default('')->nullable();
                $table->softDeletes();
                $table->timestamps();
                $table->index(['user_id']);
                $table->index(['creado_por_id']);

                $table->foreign('user_id')
                    ->references('id')
                    ->on($tableUsers['users'])
                    ->onDelete('cascade');

                $table->foreign('creado_por_id')
                    ->references('id')
                    ->on($tableUsers['users'])
                    ->onDelete('cascade');

            });

        }





        if (!Schema::hasTable($tableBiblos['editoriale_ficha'])) {
            Schema::create($tableBiblos['editoriale_ficha'], function (Blueprint $table) use ($tableBiblos){
                $table->id();
                $table->unsignedInteger('ficha_id');
                $table->unsignedInteger('editoriale_id');
                $table->softDeletes();
                $table->timestamps();
                $table->unique(['ficha_id', 'editoriale_id']);

                $table->foreign('ficha_id')
                    ->references('id')
                    ->on($tableBiblos['fichas'])
                    ->onDelete('cascade');

                $table->foreign('editoriale_id')
                    ->references('id')
                    ->on($tableBiblos['editoriales'])
                    ->onDelete('cascade');

            });

        }


        if (!Schema::hasTable($tableBiblos['ficha_portada'])) {
            Schema::create($tableBiblos['ficha_portada'], function (Blueprint $table) use ($tableBiblos){
                $table->id();
                $table->unsignedInteger('ficha_id');
                $table->unsignedInteger('portada_id');
                $table->softDeletes();
                $table->timestamps();
                $table->unique(['ficha_id', 'portada_id']);

                $table->foreign('ficha_id')
                    ->references('id')
                    ->on($tableBiblos['fichas'])
                    ->onDelete('cascade');

                $table->foreign('portada_id')
                    ->references('id')
                    ->on($tableBiblos['portadas'])
                    ->onDelete('cascade');

            });

        }






    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableUsers     = config('ibt.table_names.users');
        $tablePersonas  = config('ibt.table_names.personas');
        $tableUbi       = config('ibt.table_names.ubicaciones');
        $tableCatalogos = config('ibt.table_names.catalogos');
        $tableRelaciones = config('ibt.table_names.relaciones');
        $tableBiblos     = config('ibt.table_names.biblos');

        Schema::dropIfExists($tableBiblos['codigo_lenguaje_paises']);
        Schema::dropIfExists($tableBiblos['editoriale_ficha']);
        Schema::dropIfExists($tableBiblos['ficha_portada']);
        Schema::dropIfExists($tableBiblos['portadas']);
        Schema::dropIfExists($tableBiblos['fichas']);
        Schema::dropIfExists($tableBiblos['editoriales']);


    }
}
