<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsPaquetesPedidos extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('paquetes', function (Blueprint $table) {
            $table->string('grupos_platsource',150)->default('')->after('root');
            $table->smallInteger('isvisibleinternet')->default(1)->after('grupos_platsource');
            $table->float('total_internet')->default(0)->after('isvisibleinternet');
        });

        Schema::table('pedidos', function (Blueprint $table) {
            $table->dateTime('fecha_vencimiento')->default(null)->after('empresa_id');
            $table->smallInteger('isactivo')->default(1)->after('fecha_vencimiento');
            $table->string('referencia',100)->default('')->after('isactivo');
            $table->string('observaciones',250)->default('')->after('referencia');
            $table->float('total_internet')->default(0)->after('observaciones');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::table('paquetes', function (Blueprint $table) {
            $table->dropColumn('grupos_platsource');
            $table->dropColumn('isvisibleinternet');
        });
 
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('fecha_vencimiento');
            $table->dropColumn('isactivo');
            $table->dropColumn('referencia');
            $table->dropColumn('observaciones');
        });
        

    }
}
