<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoCap extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Creacion de la tabla de capacidad de almacenamiento
		Schema::create('sto_cap', function($table){

			$table->string('ubi', 10);
			$table->bigInteger('sku');
			$table->mediumInteger('batLot');
			$table->char('uniMed', 4);
			$table->smallInteger('can');
			$table->smallInteger('pal');
			$table->char('are', 6);
			$table->smallInteger('cap');
			$table->smallInteger('capFin');
			$table->smallInteger('estIba');
			$table->smallInteger('estAnd');
			$table->double('ocu', 5, 2);

			$table->index(array('ubi', 'sku', 'batLot'));

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Destruccion de la tabla de capacidad de almacenamiento
		Schema::drop('sto_cap');
	}

}