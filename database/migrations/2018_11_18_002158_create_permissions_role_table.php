<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissionsRole', function (Blueprint $table) {
						$table->integer('idRole')->unsigned()->index();
						$table->integer('idPermission')->unsigned()->index();
						$table->text('notes');
						$table->foreign('idRole')
							->references('id')->on('roles')
							->onDelete('cascade');
						$table->foreign('idPermission')
							->references('id')->on('permissions')
							->onDelete('cascade');
						$table->primary(['idRole', 'idPermission']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissionsRole');
    }
}
