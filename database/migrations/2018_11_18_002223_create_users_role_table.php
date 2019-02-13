<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usersRole', function (Blueprint $table) {
					$table->increments('id');
					$table->integer('idUser')->unsigned()->index();
					$table->integer('idRole')->unsigned()->index();
					$table->text('notes');
					$table->foreign('idUser')
						->references('id')->on('users')
						->onDelete('cascade');
					$table->foreign('idRole')
						->references('id')->on('roles')
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
        Schema::dropIfExists('usersRole');
    }
}
