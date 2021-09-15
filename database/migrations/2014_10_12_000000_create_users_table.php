<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){


        $tableUsers     = config('ibt.table_names.users');
        $tablePersonas  = config('ibt.table_names.personas');
        $tableUbi       = config('ibt.table_names.ubicaciones');
        $tableCatalogos = config('ibt.table_names.catalogos');
        $tableRelaciones = config('ibt.table_names.relaciones');


        // clase raiz
        if (!Schema::hasTable($tableCatalogos['empresas'])) {
            Schema::create($tableCatalogos['empresas'], function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('razon_social', 250)->default('')->nullable();
                $table->string('domicilio_fiscal', 250)->default('')->nullable();
                $table->string('rfc', 15)->default('')->nullable();
                $table->string('ip', 150)->default('')->nullable();
                $table->string('host', 150)->default('')->nullable();
                $table->softDeletes();
                $table->timestamps();

            });
        }

        Schema::create($tableUsers['users'], function (Blueprint $table) use ($tableCatalogos, $tableUsers) {
            $table->increments('id');
            $table->string('username',64)->unique();
            $table->string('email',250)->default('')->nullable();
            $table->string('password',64);
            $table->string('nombre',50)->nullable();
            $table->string('ap_paterno',50)->nullable();
            $table->string('ap_materno',50)->nullable();
            $table->string('curp',18)->default('')->nullable();
            $table->string('emails',500)->default('')->nullable();
            $table->string('celulares',250)->default('')->nullable();
            $table->string('telefonos',250)->default('')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->smallInteger('genero')->default(0)->nullable();
            $table->string('root',150)->default('')->nullable();
            $table->string('filename',50)->nullable();
            $table->string('filename_png',50)->nullable();
            $table->string('filename_thumb',50)->nullable();
            $table->boolean('admin')->default(false);
            $table->string('session_id')->nullable();
            $table->unsignedSmallInteger('status_user')->default(1)->nullable();
            $table->unsignedSmallInteger('empresa_id')->default(1)->nullable();
            $table->unsignedInteger('creado_por_id')->default(1)->nullable();
            $table->unsignedInteger('user_id_anterior')->default(0)->index();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->boolean('logged')->default(false)->index();
            $table->timestamp('logged_at')->nullable()->index();
            $table->timestamp('logout_at')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('id_sistema_anterior')->default(0)->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('empresa_id')
                ->references('id')
                ->on($tableCatalogos['empresas'])
                ->onDelete('cascade');

            $table->foreign('creado_por_id')
                ->references('id')
                ->on($tableUsers['users'])
                ->onDelete('cascade');


        });

        Schema::create($tableUsers['user_adress'], function (Blueprint $table) use ($tableUsers) {
            $table->increments('id');
            $table->string('calle',250)->default('')->nullable();
            $table->string('num_ext',100)->default('')->nullable();
            $table->string('num_int',100)->default('')->nullable();
            $table->string('colonia',150)->default('')->nullable();
            $table->string('localidad',150)->default('')->nullable();
            $table->string('municipio',100)->default('')->nullable();
            $table->string('estado',100)->default('TABASCO')->nullable();
            $table->string('pais',25)->default('MÉXICO')->nullable();
            $table->string('cp',10)->default('')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on($tableUsers['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableUsers['user_extend'], function (Blueprint $table) use ($tableUsers) {
            $table->increments('id');
            $table->string('ocupacion',250)->default('')->nullable();
            $table->string('profesion',250)->default('')->nullable();
            $table->string('lugar_trabajo',250)->default('')->nullable();
            $table->string('lugar_nacimiento',250)->default('')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on($tableUsers['users'])
                ->onDelete('cascade');

        });

        Schema::create($tableUsers['user_social'], function (Blueprint $table) use ($tableUsers) {
            $table->increments('id');
            $table->string('red_social',100)->default('')->nullable();
            $table->string('username_red_social',100)->default('')->nullable();
            $table->string('alias_red_social',100)->default('')->nullable();
            $table->unsignedInteger('user_id');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on($tableUsers['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableUsers['categorias'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoria',150)->default('')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create($tableUsers['imagenes'], function (Blueprint $table)  use ($tableUsers) {
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


        Schema::create($tableRelaciones['imagen_user'], function (Blueprint $table) use ($tableUsers){
            $table->increments('id');
            $table->unsignedInteger('imagen_id')->default(0)->index();
            $table->unsignedInteger('user_id')->default(0)->index();
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['imagen_id', 'user_id']);

            $table->foreign('imagen_id')
                ->references('id')
                ->on($tableUsers['imagenes'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableUsers['users'])
                ->onDelete('cascade');

        });



        DB::statement("ALTER TABLE users ADD COLUMN searchtext TSVECTOR");
        DB::statement("UPDATE users SET searchtext = to_tsvector('spanish', coalesce(trim(ap_paterno),'') || ' ' || coalesce(trim(ap_materno),'') || ' ' || coalesce(trim(nombre),'') || ' ' || coalesce(trim(curp),'') )");
        DB::statement("CREATE INDEX searchtext_user_gin ON users USING GIN(searchtext)");
        DB::statement("CREATE TRIGGER ts_searchtext BEFORE INSERT OR UPDATE ON users FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.spanish', 'ap_paterno', 'ap_materno', 'nombre', 'curp')");





    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        $tableUsers     = config('ibt.table_names.users');
        $tableCatalogos = config('ibt.table_names.catalogos');
        $tableRelaciones = config('ibt.table_names.relaciones');

        Schema::dropIfExists($tableRelaciones['imagen_user']);
        Schema::dropIfExists($tableRelaciones['familia_familiar_user']);
        Schema::dropIfExists($tableUsers['categorias']);
        Schema::dropIfExists($tableUsers['imagenes']);
        Schema::dropIfExists($tableUsers['user_adress']);
        Schema::dropIfExists($tableUsers['user_extend']);
        Schema::dropIfExists($tableUsers['user_social']);
        Schema::dropIfExists($tableCatalogos['alumnos']);
        Schema::dropIfExists($tableCatalogos['familias']);
        Schema::dropIfExists($tableUsers['users']);

    }
}
