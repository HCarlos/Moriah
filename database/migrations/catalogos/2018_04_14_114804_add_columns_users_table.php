<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nombre_completo',150)->nullable();
            $table->string('twitter',50)->nullable();
            $table->string('facebook',50)->nullable();
            $table->string('instagram',50)->nullable();
            $table->string('filename',50)->nullable();
            $table->unsignedInteger('iduser_ps')->nullable();
            $table->string('root',150)->default('')->nullable();
            $table->boolean('admin')->default(false);
            $table->unsignedSmallInteger('status_user')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(0)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nombre_completo');
            $table->dropColumn('twitter');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('filename');
            $table->dropColumn('iduser_ps');
            $table->dropColumn('root');
            $table->dropColumn('admin');
            $table->dropColumn('status_user');
            $table->dropColumn('idemp');
            $table->dropColumn('ip');
            $table->dropColumn('host');
        });
    }
}
