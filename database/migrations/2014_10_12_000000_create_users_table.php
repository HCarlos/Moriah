<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->nullable();
            $table->string('ap_paterno')->nullable();
            $table->string('ap_materno')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('celular',50)->nullable();
            $table->string('telefono',50)->nullable();
            $table->string('filename',50)->nullable();
            $table->unsignedInteger('iduser_ps')->nullable();
            $table->string('root',150)->default('')->nullable();
            $table->boolean('admin')->default(false);
            $table->boolean('alumno')->default(false);
            $table->boolean('foraneo')->default(false);
            $table->boolean('exalumno')->default(false);
            $table->boolean('credito')->default(false);
            $table->unsignedTinyInteger('familia_cliente_id')->default(1)->nullable();
            $table->unsignedSmallInteger('status_user')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(0)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();
            $table->index('familia_cliente_id');
            $table->index('idemp');

//            $table->foreign('familia_cliente_id')
//                ->references('id')
//                ->on('familia_cliente')
//                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
