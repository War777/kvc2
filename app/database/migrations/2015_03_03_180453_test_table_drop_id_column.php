<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TestTableDropIdColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Eliminamos la columna id
		Schema::table('test', function($table){
			$table->dropColumn('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Regeneramos la columna de id
		Schema::table('test', function($table){
			$table->increments('id');
		});
	}

}
