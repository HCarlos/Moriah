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

        Schema::create($tableNames['compra_almacen'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('almacen_id');
            $table->integer('compra_id');
            $table->timestamps();
            $table->index(['almacen_id', 'compra_id']);

            $table->foreign('almacen_id')
                ->references('id')
                ->on($tableNames['almacenes'])
                ->onDelete('cascade');

            $table->foreign('compra_id')
                ->references('id')
                ->on($tableNames['compras'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['compra_proveedor'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('proveedor_id');
            $table->integer('compra_id');
            $table->timestamps();
            $table->index(['proveedor_id', 'compra_id']);

            $table->foreign('proveedor_id')
                ->references('id')
                ->on($tableNames['proveedores'])
                ->onDelete('cascade');

            $table->foreign('compra_id')
                ->references('id')
                ->on($tableNames['compras'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['conceptos'], function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('isiva')->default(false);
            $table->unsignedInteger('factor')->default(1)->nullable();
            $table->string('descripcion')->default('');
            $table->decimal('importe',10,2)->default(0.00);
            $table->unsignedSmallInteger('status_concepto')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['config'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('key',25)->nullable();
            $table->string('value',100)->nullable();
            $table->unsignedSmallInteger('status_config')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['cuentas_por_cobrar'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('cuenta',16)->default('');
            $table->unsignedInteger('folio')->default(0);
            $table->unsignedInteger('num')->default(0);
            $table->date('f_vence')->nullable();
            $table->decimal('subtotal',10,2)->default(0.00);
            $table->decimal('iva',10,2)->default(0.00);
            $table->decimal('total',10,2)->default(0.00);
            $table->decimal('intereses',10,2)->default(0.00);
            $table->dateTime('pagado_el')->nullable();
            $table->string('observaciones',150)->default('');
            $table->unsignedSmallInteger('status_cxc')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('cuenta');
            $table->index('folio');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['cuenta_por_cobrar_user'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('cuenta_por_cobrar_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->index(['cuenta_por_cobrar_id', 'user_id']);

            $table->foreign('cuenta_por_cobrar_id')
                ->references('id')
                ->on($tableNames['cuentas_por_cobrar'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['empresas'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('rs',150)->default('')->nullable();
            $table->string('ncomer',100)->default('')->nullable();
            $table->string('df',200)->default('')->nullable();
            $table->string('rfc',20)->default('')->nullable();
            $table->unsignedSmallInteger('status_empresa')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['ingresos'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('cuenta_por_cobrar_id')->default(0);
            $table->string('cuenta',16)->default('');
            $table->unsignedInteger('folio')->default(0);
            $table->unsignedInteger('num')->default(0);
            $table->string('foliofac',12)->default('');
            $table->dateTime('f_pagado')->nullable();
            $table->decimal('subtotal',10,2)->default(0)->nullable();
            $table->decimal('iva',10,2)->default(0)->nullable();
            $table->decimal('total',10,2)->default(0)->nullable();
            $table->unsignedTinyInteger('tipo')->default(0);
            $table->unsignedTinyInteger('origen')->default(0);
            $table->string('banco',15)->default('');
            $table->string('cheque',15)->default('');
            $table->dateTime('fc_aplica')->nullable();
            $table->unsignedInteger('nota_credito')->default(0);
            $table->unsignedSmallInteger('status_ingreso')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('cuenta_por_cobrar_id');
            $table->index('cuenta');
            $table->index('folio');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('cuenta_por_cobrar_id')
                ->references('id')
                ->on($tableNames['cuentas_por_cobrar'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['ingreso_user'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('ingreso_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->index(['ingreso_id', 'user_id']);

            $table->foreign('ingreso_id')
                ->references('id')
                ->on($tableNames['ingresos'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['ingreso_cuenta_por_cobrar'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('ingreso_id');
            $table->integer('cuenta_por_cobrar_id');
            $table->timestamps();
            $table->index(['ingreso_id', 'cuenta_por_cobrar_id']);

            $table->foreign('ingreso_id')
                ->references('id')
                ->on($tableNames['ingresos'])
                ->onDelete('cascade');

            $table->foreign('cuenta_por_cobrar_id')
                ->references('id')
                ->on($tableNames['cuentas_por_cobrar'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['medidas'], function (Blueprint $table) {
            $table->increments('id');
            $table->string('desc1',20)->default('')->nullable();
            $table->string('desc2',20)->default('')->nullable();
            $table->unsignedInteger('clave')->default(0)->nullable();
            $table->unsignedSmallInteger('status_medida')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['familia_producto'], function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('clave')->default(0)->nullable();
            $table->string('descripcion',75)->default('');
            $table->decimal('porcdescto',10,2)->default(0.00)->nullable();
            $table->unsignedTinyInteger('moneycli')->default(0);
            $table->unsignedSmallInteger('status_familia_producto')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
        });

        Schema::create($tableNames['productos'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('almacen_id')->default(0)->nullable();
            $table->integer('familia_producto_id')->default(0)->nullable();
            $table->integer('medida_id')->default(0)->nullable();
            $table->unsignedInteger('clave')->default(0)->nullable();
            $table->string('codigo',16)->default('')->nullable();
            $table->string('descripcion',150)->default('')->nullable();
            $table->string('shortdesc',75)->default('')->nullable();
            $table->decimal('maximo',10,2)->default(0)->nullable();
            $table->decimal('minimo',10,2)->default(0)->nullable();
            $table->boolean('isiva')->default(false);
            $table->dateTime('fecha')->nullable();
            $table->string('tipo',75)->default('')->nullable();
            $table->decimal('pv',10,2)->default(0)->nullable();
            $table->decimal('porcdescto',10,2)->default(0)->nullable();
            $table->dateTime('inicia_descuento')->nullable();
            $table->dateTime('termina_descuento')->nullable();
            $table->unsignedTinyInteger('moneycli')->default(0);
            $table->decimal('exist',10,2)->default(0)->nullable();
            $table->decimal('cu',10,2)->default(0)->nullable();
            $table->decimal('saldo',10,2)->default(0)->nullable();
            $table->text('propiedades_producto')->default('');
            $table->string('filename',50)->nullable();
            $table->string('root',150)->default('')->nullable();
            $table->unsignedSmallInteger('status_producto')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();

            $table->index('almacen_id');
            $table->index('familia_producto_id');
            $table->index('medida_id');
            $table->index('clave');
            $table->index('codigo');

            $table->foreign('almacen_id')
                ->references('id')
                ->on($tableNames['almacenes'])
                ->onDelete('cascade');

            $table->foreign('familia_producto_id')
                ->references('id')
                ->on($tableNames['familia_producto'])
                ->onDelete('cascade');

            $table->foreign('medida_id')
                ->references('id')
                ->on($tableNames['medidas'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['almacen_producto'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('almacen_id');
            $table->integer('producto_id');
            $table->timestamps();
            $table->index(['almacen_id', 'producto_id']);

            $table->foreign('almacen_id')
                ->references('id')
                ->on($tableNames['almacenes'])
                ->onDelete('cascade');

            $table->foreign('producto_id')
                ->references('id')
                ->on($tableNames['productos'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['familia_producto_producto'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('almacen_id');
            $table->integer('familia_producto_id');
            $table->timestamps();
            $table->index(['almacen_id', 'familia_producto_id']);

            $table->foreign('almacen_id')
                ->references('id')
                ->on($tableNames['almacenes'])
                ->onDelete('cascade');

            $table->foreign('familia_producto_id')
                ->references('id')
                ->on($tableNames['familia_producto'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['medida_producto'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('almacen_id');
            $table->integer('medida_id');
            $table->timestamps();
            $table->index(['almacen_id', 'medida_id']);

            $table->foreign('almacen_id')
                ->references('id')
                ->on($tableNames['almacenes'])
                ->onDelete('cascade');

            $table->foreign('medida_id')
                ->references('id')
                ->on($tableNames['medidas'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['paquetes'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->nullable();
            $table->string('descripcion_paquete',150)->default('')->nullable();
            $table->unsignedSmallInteger('status_paquete')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['paquete_user'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('paquete_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->index(['paquete_id', 'user_id']);

            $table->foreign('paquete_id')
                ->references('id')
                ->on($tableNames['paquetes'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['paquete_detalle'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('paquete_id')->default(0)->nullable();
            $table->integer('producto_id')->default(0)->nullable();
            $table->integer('medida_id')->default(0)->nullable();
            $table->string('codigo',16)->default('')->nullable();
            $table->string('descripcion',150)->default('')->nullable();
            $table->decimal('cant',10,2)->default(0)->nullable();
            $table->decimal('pv',10,2)->default(0)->nullable();
            $table->decimal('comp1',10,2)->default(0)->nullable();
            $table->unsignedSmallInteger('status_paquete_detalle')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();

            $table->index('paquete_id');
            $table->index('producto_id');
            $table->index('medida_id');
            $table->index('codigo');

            $table->foreign('paquete_id')
                ->references('id')
                ->on($tableNames['paquetes'])
                ->onDelete('cascade');

            $table->foreign('producto_id')
                ->references('id')
                ->on($tableNames['productos'])
                ->onDelete('cascade');

            $table->foreign('medida_id')
                ->references('id')
                ->on($tableNames['medidas'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['paquete_detalle_paquete'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('paquete_detalle_id');
            $table->integer('paquete_id');
            $table->timestamps();
            $table->index(['paquete_detalle_id', 'paquete_id']);

            $table->foreign('paquete_detalle_id')
                ->references('id')
                ->on($tableNames['paquete_detalle'])
                ->onDelete('cascade');

            $table->foreign('paquete_id')
                ->references('id')
                ->on($tableNames['paquetes'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['paquete_detalle_producto'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('paquete_detalle_id');
            $table->integer('producto_id');
            $table->timestamps();
            $table->index(['paquete_detalle_id', 'producto_id']);

            $table->foreign('paquete_detalle_id')
                ->references('id')
                ->on($tableNames['paquete_detalle'])
                ->onDelete('cascade');

            $table->foreign('producto_id')
                ->references('id')
                ->on($tableNames['productos'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['paquete_detalle_medida'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('paquete_detalle_id');
            $table->integer('medida_id');
            $table->timestamps();
            $table->index(['paquete_detalle_id', 'medida_id']);

            $table->foreign('paquete_detalle_id')
                ->references('id')
                ->on($tableNames['paquete_detalle'])
                ->onDelete('cascade');

            $table->foreign('medida_id')
                ->references('id')
                ->on($tableNames['medidas'])
                ->onDelete('cascade');
        });



        Schema::create($tableNames['pedidos'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->nullable();
            $table->integer('paquete_id')->default(0)->nullable();
            $table->string('descripcion_pedido',150)->default('');
            $table->dateTime('fecha')->nullable();
            $table->unsignedSmallInteger('status_pedido')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('paquete_id');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('paquete_id')
                ->references('id')
                ->on($tableNames['paquetes'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['pedido_user'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('pedido_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->index(['pedido_id', 'user_id']);

            $table->foreign('pedido_id')
                ->references('id')
                ->on($tableNames['pedidos'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['pedido_paquete'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('pedido_id');
            $table->integer('paquete_id');
            $table->timestamps();
            $table->index(['pedido_id', 'paquete_id']);

            $table->foreign('pedido_id')
                ->references('id')
                ->on($tableNames['pedidos'])
                ->onDelete('cascade');

            $table->foreign('paquete_id')
                ->references('id')
                ->on($tableNames['paquetes'])
                ->onDelete('cascade');
        });



        Schema::create($tableNames['pedido_detalle'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('pedido_id')->default(0)->nullable();
            $table->integer('user_id')->default(0)->nullable();
            $table->integer('producto_id')->default(0)->nullable();
            $table->integer('medida_id')->default(0)->nullable();
            $table->string('codigo',16)->default('')->nullable();
            $table->string('descripcion_producto',150)->default('')->nullable();
            $table->decimal('cant',10,2)->default(0)->nullable();
            $table->decimal('pv',10,2)->default(0)->nullable();
            $table->decimal('comp1',10,2)->default(0)->nullable();
            $table->unsignedSmallInteger('status_pedido_detalle')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();

            $table->index('pedido_id');
            $table->index('user_id');
            $table->index('producto_id');
            $table->index('medida_id');
            $table->index('codigo');

            $table->foreign('pedido_id')
                ->references('id')
                ->on($tableNames['pedidos'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('producto_id')
                ->references('id')
                ->on($tableNames['productos'])
                ->onDelete('cascade');

            $table->foreign('medida_id')
                ->references('id')
                ->on($tableNames['medidas'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['pedido_detalle_pedido'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('pedido_id');
            $table->integer('pedido_detalle_id');
            $table->timestamps();
            $table->index(['pedido_id', 'pedido_detalle_id']);

            $table->foreign('pedido_id')
                ->references('id')
                ->on($tableNames['pedidos'])
                ->onDelete('cascade');

            $table->foreign('pedido_detalle_id')
                ->references('id')
                ->on($tableNames['pedido_detalle'])
                ->onDelete('cascade');
        });

        Schema::create($tableNames['pedido_detalle_user'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('pedido_detalle_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->index(['pedido_detalle_id', 'user_id']);

            $table->foreign('pedido_detalle_id')
                ->references('id')
                ->on($tableNames['pedido_detalle'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['pedido_detalle_producto'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('pedido_detalle_id');
            $table->integer('producto_id');
            $table->timestamps();
            $table->index(['pedido_detalle_id', 'producto_id']);

            $table->foreign('pedido_detalle_id')
                ->references('id')
                ->on($tableNames['pedido_detalle'])
                ->onDelete('cascade');

            $table->foreign('producto_id')
                ->references('id')
                ->on($tableNames['productos'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['pedido_detalle_medida'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('pedido_detalle_id');
            $table->integer('medida_id');
            $table->timestamps();
            $table->index(['pedido_detalle_id', 'medida_id']);

            $table->foreign('pedido_detalle_id')
                ->references('id')
                ->on($tableNames['pedido_detalle'])
                ->onDelete('cascade');

            $table->foreign('medida_id')
                ->references('id')
                ->on($tableNames['medidas'])
                ->onDelete('cascade');

        });


        Schema::create($tableNames['movimientos'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('compra_id')->default(0)->nullable();
            $table->integer('producto_id')->default(0)->nullable();
            $table->integer('pedido_id')->default(0)->nullable();
            $table->integer('proveedor_id')->default(0)->nullable();
            $table->integer('almacen_id')->default(0)->nullable();
            $table->integer('medida_id')->default(0)->nullable();
            $table->integer('folio')->default(0)->nullable();
            $table->unsignedInteger('clave')->default(0)->nullable();
            $table->string('codigo',13)->default('');
            $table->unsignedInteger('ejercicio')->default(0)->nullable();
            $table->unsignedInteger('periodo')->default(0)->nullable();
            $table->dateTime('fecha')->nullable();
            $table->string('foliofac',12)->default('');
            $table->string('nota',12)->default('');
            $table->decimal('entrada',10,2)->default(0.00)->nullable();
            $table->decimal('salida',10,2)->default(0.00)->nullable();
            $table->decimal('exlocal',10,2)->default(0.00)->nullable();
            $table->decimal('existencia',10,2)->default(0.00)->nullable();
            $table->decimal('pu',10,2)->default(0.00)->nullable();
            $table->decimal('cu',10,2)->default(0.00)->nullable();
            $table->decimal('debe',10,2)->default(0.00)->nullable();
            $table->decimal('haber',10,2)->default(0.00)->nullable();
            $table->decimal('descto',10,2)->default(0.00)->nullable();
            $table->decimal('importe',10,2)->default(0.00)->nullable();
            $table->decimal('iva',10,2)->default(0.00)->nullable();
            $table->decimal('sllocal',10,2)->default(0.00)->nullable();
            $table->decimal('saldo',10,2)->default(0.00)->nullable();
            $table->unsignedTinyInteger('tipo')->default(0);
            $table->unsignedTinyInteger('status')->default(0);
            $table->unsignedTinyInteger('tipoinv')->default(0);
            $table->unsignedSmallInteger('status_movimiento')->default(1)->nullable();
            $table->unsignedSmallInteger('idemp')->default(1)->nullable();
            $table->string('ip',150)->default('')->nullable();
            $table->string('host',150)->default('')->nullable();
            $table->timestamps();
            $table->index('user_id');
            $table->index('compra_id');
            $table->index('producto_id');
            $table->index('pedido_id');
            $table->index('proveedor_id');
            $table->index('almacen_id');
            $table->index('medida_id');
            $table->index('codigo');
            $table->index('folio');
            $table->index('clave');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

            $table->foreign('compra_id')
                ->references('id')
                ->on($tableNames['compras'])
                ->onDelete('cascade');

            $table->foreign('producto_id')
                ->references('id')
                ->on($tableNames['productos'])
                ->onDelete('cascade');

            $table->foreign('pedido_id')
                ->references('id')
                ->on($tableNames['pedidos'])
                ->onDelete('cascade');

            $table->foreign('proveedor_id')
                ->references('id')
                ->on($tableNames['proveedores'])
                ->onDelete('cascade');

            $table->foreign('almacen_id')
                ->references('id')
                ->on($tableNames['almacenes'])
                ->onDelete('cascade');

            $table->foreign('medida_id')
                ->references('id')
                ->on($tableNames['medidas'])
                ->onDelete('cascade');


        });

        Schema::create($tableNames['movimiento_user'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('movimiento_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->index(['movimiento_id', 'user_id']);

            $table->foreign('movimiento_id')
                ->references('id')
                ->on($tableNames['movimientos'])
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on($tableNames['users'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['movimiento_compra'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('movimiento_id');
            $table->integer('compra_id');
            $table->timestamps();
            $table->index(['movimiento_id', 'compra_id']);

            $table->foreign('movimiento_id')
                ->references('id')
                ->on($tableNames['movimientos'])
                ->onDelete('cascade');

            $table->foreign('compra_id')
                ->references('id')
                ->on($tableNames['compras'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['movimiento_producto'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('movimiento_id');
            $table->integer('producto_id');
            $table->timestamps();
            $table->index(['movimiento_id', 'producto_id']);

            $table->foreign('movimiento_id')
                ->references('id')
                ->on($tableNames['movimientos'])
                ->onDelete('cascade');

            $table->foreign('producto_id')
                ->references('id')
                ->on($tableNames['productos'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['movimiento_pedido'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('movimiento_id');
            $table->integer('pedido_id');
            $table->timestamps();
            $table->index(['movimiento_id', 'pedido_id']);

            $table->foreign('movimiento_id')
                ->references('id')
                ->on($tableNames['movimientos'])
                ->onDelete('cascade');

            $table->foreign('pedido_id')
                ->references('id')
                ->on($tableNames['pedidos'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['movimiento_proveedor'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('movimiento_id');
            $table->integer('proveedor_id');
            $table->timestamps();
            $table->index(['movimiento_id', 'proveedor_id']);

            $table->foreign('movimiento_id')
                ->references('id')
                ->on($tableNames['movimientos'])
                ->onDelete('cascade');

            $table->foreign('proveedor_id')
                ->references('id')
                ->on($tableNames['proveedores'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['movimiento_almacen'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('movimiento_id');
            $table->integer('almacen_id');
            $table->timestamps();
            $table->index(['movimiento_id', 'almacen_id']);

            $table->foreign('movimiento_id')
                ->references('id')
                ->on($tableNames['movimientos'])
                ->onDelete('cascade');

            $table->foreign('almacen_id')
                ->references('id')
                ->on($tableNames['almacenes'])
                ->onDelete('cascade');

        });

        Schema::create($tableNames['movimiento_medida'], function (Blueprint $table) use ($tableNames) {
            $table->increments('id');
            $table->integer('movimiento_id');
            $table->integer('medida_id');
            $table->timestamps();
            $table->index(['movimiento_id', 'medida_id']);

            $table->foreign('movimiento_id')
                ->references('id')
                ->on($tableNames['movimientos'])
                ->onDelete('cascade');

            $table->foreign('medida_id')
                ->references('id')
                ->on($tableNames['medidas'])
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

        Schema::dropIfExists($tableNames['compra_almacen']);
        Schema::dropIfExists($tableNames['compra_proveedor']);
        Schema::dropIfExists($tableNames['cuenta_por_cobrar_user']);
        Schema::dropIfExists($tableNames['ingreso_user']);
        Schema::dropIfExists($tableNames['ingreso_cuenta_por_cobrar']);
        Schema::dropIfExists($tableNames['almacen_producto']);
        Schema::dropIfExists($tableNames['familia_producto_producto']);
        Schema::dropIfExists($tableNames['medida_producto']);
        
        Schema::dropIfExists($tableNames['paquete_user']);
        Schema::dropIfExists($tableNames['paquete_detalle_paquete']);
        Schema::dropIfExists($tableNames['paquete_detalle_producto']);
        Schema::dropIfExists($tableNames['paquete_detalle_medida']);

        Schema::dropIfExists($tableNames['pedido_user']);
        Schema::dropIfExists($tableNames['pedido_paquete']);
        Schema::dropIfExists($tableNames['pedido_detalle_pedido']);
        Schema::dropIfExists($tableNames['pedido_detalle_user']);
        Schema::dropIfExists($tableNames['pedido_detalle_producto']);
        Schema::dropIfExists($tableNames['pedido_detalle_medida']);

        Schema::dropIfExists($tableNames['movimiento_user']);
        Schema::dropIfExists($tableNames['movimiento_compra']);
        Schema::dropIfExists($tableNames['movimiento_producto']);
        Schema::dropIfExists($tableNames['movimiento_pedido']);
        Schema::dropIfExists($tableNames['movimiento_proveedor']);
        Schema::dropIfExists($tableNames['movimiento_almacen']);
        Schema::dropIfExists($tableNames['movimiento_medida']);

        Schema::dropIfExists($tableNames['movimientos']);

        Schema::dropIfExists($tableNames['pedido_detalle']);
        Schema::dropIfExists($tableNames['pedidos']);
        Schema::dropIfExists($tableNames['paquete_detalle']);
        Schema::dropIfExists($tableNames['paquetes']);

        Schema::dropIfExists($tableNames['compras']);
        Schema::dropIfExists($tableNames['proveedores']);
        Schema::dropIfExists($tableNames['familia_cliente']);
        Schema::dropIfExists($tableNames['conceptos']);
        Schema::dropIfExists($tableNames['config']);
        Schema::dropIfExists($tableNames['empresas']);
        Schema::dropIfExists($tableNames['ingresos']);
        Schema::dropIfExists($tableNames['cuentas_por_cobrar']);
        Schema::dropIfExists($tableNames['productos']);

        Schema::dropIfExists($tableNames['familia_producto']);
        Schema::dropIfExists($tableNames['medidas']);
        Schema::dropIfExists($tableNames['almacenes']);


    }
}
