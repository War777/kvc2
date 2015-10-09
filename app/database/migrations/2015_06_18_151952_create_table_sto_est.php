<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoEst extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Creacion de la tabla diccionario de estandar y estiba por sku
		Schema::create('sto_est', function($table){

			$table->integer('sku');
			$table->string('skuDes', 100)->nullable();
			$table->smallInteger('estIba');
			$table->smallInteger('estAnd');

			$table->index('sku');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Destruccion de la tabla diccionario de estandar y estiba por sku
		Schema::drop('sto_est');
	}

}
