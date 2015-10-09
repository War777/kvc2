<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Generamos una tabla de prueba
		Schema::create('test', function($table){
			$table->increments('id');
			$table->string('a');
			$table->integer('b');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Eliminamos la tabla de prueba
		Schema::drop('test');
	}

}
