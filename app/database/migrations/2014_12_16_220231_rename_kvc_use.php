<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameKvcUse extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Renombramos la tabla
		Schema::rename('kvc_use', 'users');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Volvemos la tabla a su nombre original en caso de rollback
		Schema::rename('users', 'kvc_use');
	}

}
