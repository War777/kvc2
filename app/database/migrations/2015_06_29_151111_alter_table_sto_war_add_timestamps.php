<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStoWarAddTimestamps extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		//Agregamos las columnas de tiempo de creacion y modificacion
		Schema::table('sto_war', function($table){

			$table->timestamps();
			$table->softDeletes();

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Eliminamos las columnas de tiempo de creacion y modificacion
		Schema::table('sto_war', function($table){

			$table->dropTimestamps();
			$table->dropSoftDeletes();

		});
	}

}