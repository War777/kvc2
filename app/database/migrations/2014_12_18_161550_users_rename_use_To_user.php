<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UsersRenameUseToUser extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Renombramos la columna user
		Schema::table('users', function($table){
			$table->dropColumn('use');
			$table->string('user')->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Devolvemos la columna a su nombre original
		Schema::table('users', function($table){
			$table->dropColumn('user');
			$table->string('use')->after('id');
		});
	}

}
