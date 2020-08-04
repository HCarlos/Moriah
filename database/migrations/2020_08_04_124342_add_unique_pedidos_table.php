<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniquePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        $tableNames = config('siifac.table_names');
        Schema::table($tableNames['pedidos'], function (Blueprint $table) use ($tableNames) {
            $table->unique(['user_id', 'paquete_id', 'empresa_id', 'idemp', 'referencia']);
        });        
        Schema::table($tableNames['ingresos'], function (Blueprint $table) use ($tableNames) {
            $table->unique(['user_id', 'venta_id', 'cliente_id', 'vendedor_id', 'empresa_id', 'idemp', 'f_pagado']);
        });        
        Schema::table($tableNames['ventas'], function (Blueprint $table) use ($tableNames) {
            $table->unique(['user_id', 'vendedor_id', 'paquete_id', 'pedido_id', 'empresa_id', 'idemp', 'f_pagado']);
        });        
        Schema::table($tableNames['movimientos'], function (Blueprint $table) use ($tableNames) {
            $table->unique(['user_id','cliente_id','venta_id','venta_detalle_id','compra_id','producto_id','paquete_id','pedido_id','proveedor_id','almacen_id','medida_id', 'empresa_id', 'idemp', 'clave','codigo','ejercicio', 'periodo', 'fecha']);
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){
        $tableNames = config('siifac.table_names');
        Schema::table($tableNames['pedidos'], function (Blueprint $table) use ($tableNames) {
            $table->dropUnique(['user_id_paquete_id_empresa_id_idemp_referencia']); 
        });        
        Schema::table($tableNames['ingresos'], function (Blueprint $table) use ($tableNames) {
            $table->dropUnique(['user_id_venta_id_cliente_id_vendedor_id_empresa_id_idemp_f_pagado']);
        });        
        Schema::table($tableNames['ventas'], function (Blueprint $table) use ($tableNames) {
            $table->dropUnique(['user_id_vendedor_id_paquete_id_pedido_id_empresa_id_idemp_f_pagado']);
        });        
        Schema::table($tableNames['movimientos'], function (Blueprint $table) use ($tableNames) {
            $table->dropUnique(['user_id_cliente_id_venta_id_venta_detalle_id_compra_id_producto_id_paquete_id_pedido_id_proveedor_id_almacen_id_medida_id_empresa_id_idemp_clave_codigo_ejercicio_periodo_fecha']);
        });        
    }
}
