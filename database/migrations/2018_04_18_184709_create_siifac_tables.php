<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSiifacTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       $tableNames = config('siifac.table_names');

        Schema::create($tableNames['familia_cliente'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('descripcion')->default('');
            $table->unsignedSmallInteger('status_familia_cliente')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
        });


        Schema::create($tableNames['almacenes'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->unsignedInteger('clave_almacen')->default(0);
            $table->string('descripcion')->default('');
            $table->string('responsable')->default('');
            $table->unsignedTinyInteger('tipoinv')->default(0);
            $table->char('prefijo',3)->default('GEN');
            $table->unsignedSmallInteger('status_almacen')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
            $table->unsignedInteger('familia_cliente_id')->default(0);

            $table->index('familia_cliente_id');

            $table->foreign('familia_cliente_id')
                ->references('id')
                ->on($tableNames['familia_cliente'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['proveedores'], function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clave_proveedor')->default(0);
            $table->string('nombre_proveedor',150);
            $table->string('contacto_proveedor')->defaul('');
            $table->string('domicilio_fiscal_proveedor')->default('');
            $table->unsignedSmallInteger('status_proveedores')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['compras'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->unsignedInteger('almacen_id')->default(0);
            $table->unsignedInteger('proveedor_id')->default(0);
            $table->string('folio_factura',15)->default('');
            $table->string('nota_id',15)->default('');
            $table->date('fecha')->nullable();
            $table->decimal('importe',10,2)->default(0.00);
            $table->decimal('descuento',10,2)->default(0.00);
            $table->decimal('subtotal',10,2)->default(0.00);
            $table->decimal('iva',10,2)->default(0.00);
            $table->decimal('total',10,2)->default(0.00);
            $table->unsignedTinyInteger('tipo')->default(0);
            $table->boolean('credito')->default(false);
            $table->string('observaciones')->nullable();
            $table->unsignedSmallInteger('status_compras')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();

            $table->index('almacen_id');
            $table->index('proveedor_id');

            $table->foreign('almacen_id')
                ->references('id')
                ->on($tableNames['almacenes'])
                ->onDelete('cascade');

            $table->foreign('proveedor_id')
                ->references('id')
                ->on($tableNames['proveedores'])
                ->onDelete('cascade');

        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('siifac.table_names');

        Schema::dropIfExists($tableNames['compras']);
        Schema::dropIfExists($tableNames['proveedores']);
        Schema::dropIfExists($tableNames['almacenes']);
        Schema::dropIfExists($tableNames['familia_cliente']);

    }
}
