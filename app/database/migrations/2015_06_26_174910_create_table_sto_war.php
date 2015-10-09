<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoWar extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		//Se crea la tabla de almacenes
		Schema::create('sto_war', function($table){

			$table->mediumInteger('cla');
			$table->string('des', 100);

			$table->primary('cla');

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		//Se elimina la tabla de almacenes
		Schema::drop('sto_war');

	}

}
