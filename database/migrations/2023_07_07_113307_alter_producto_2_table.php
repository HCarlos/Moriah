<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterProducto2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){

        DB::statement("ALTER DATABASE dbmoriah set default_text_search_config = 'spanish'");
        DB::statement("ALTER TABLE productos ADD COLUMN searchtext TSVECTOR");
        DB::statement("UPDATE productos SET searchtext = to_tsvector('spanish', coalesce(trim(descripcion),'') || ' ' || coalesce(trim(shortdesc),'') || ' ' || coalesce(trim(codigo),'') )");
        DB::statement("CREATE INDEX prod_searchtext_gin ON productos USING GIN(searchtext)");
        DB::statement("CREATE TRIGGER ts_searchtext_prod_1 BEFORE INSERT OR UPDATE ON productos FOR EACH ROW EXECUTE PROCEDURE tsvector_update_trigger('searchtext', 'pg_catalog.spanish', 'descripcion', 'shortdesc', 'codigo')");



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(){

        DB::statement("DROP TRIGGER IF EXISTS ts_searchtext_prod_1 ON productos");
        DB::statement("DROP INDEX IF EXISTS prod_searchtext_gin");
        DB::statement("ALTER TABLE productos DROP COLUMN IF EXISTS searchtext");


    }
}
