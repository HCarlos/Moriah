<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('descripcion',100)->nullable();
            $table->string('color',25)->default('#7986cb')->nullable();
            $table->string('guard_name')->default('web');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');       // For MySQL 8.0 use string('name', 125);
            $table->string('descripcion',100)->nullable();
            $table->string('color',25)->default('#ffab91')->nullable();
            $table->string('abreviatura',25)->default('none')->nullable()->unique();
            $table->string('guard_name')->default('web');
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));


        $tableUsers     = config('ibt.table_names.users');

        Schema::create($tableUsers['role_user'], function (Blueprint $table) use ($tableUsers) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('role_id');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'role_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($tableUsers['users'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableUsers['roles'])
                ->onDelete('cascade');
        });

        Schema::create($tableUsers['permission_user'], function (Blueprint $table) use ($tableUsers) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('permission_id');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['user_id', 'permission_id']);

            $table->foreign('user_id')
                ->references('id')
                ->on($tableUsers['users'])
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableUsers['permissions'])
                ->onDelete('cascade');

        });


        Schema::create($tableUsers['permission_role'], function (Blueprint $table) use ($tableUsers) {
            $table->increments('id');
            $table->integer('role_id');
            $table->integer('permission_id');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['role_id', 'permission_id']);

            $table->foreign('role_id')
                ->references('id')
                ->on($tableUsers['roles'])
                ->onDelete('cascade');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableUsers['permissions'])
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
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not found and defaults could not be merged. Please publish the package configuration before proceeding, or drop the tables manually.');
        }

        $tableUsers     = config('ibt.table_names.users');

        Schema::dropIfExists($tableUsers['role_user']);
        Schema::dropIfExists($tableUsers['permission_user']);
        Schema::dropIfExists($tableUsers['permission_role']);

        Schema::dropIfExists($tableNames['role_has_permissions']);
        Schema::dropIfExists($tableNames['model_has_roles']);
        Schema::dropIfExists($tableNames['model_has_permissions']);
        Schema::dropIfExists($tableNames['roles']);
        Schema::dropIfExists($tableNames['permissions']);
    }
}
