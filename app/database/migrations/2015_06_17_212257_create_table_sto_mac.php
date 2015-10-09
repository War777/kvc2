<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoMac extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Generamos la tabla que contendra al archivo de existencias en macro
		Schema::create('sto_mac', function($table){

			$table->smallInteger('can');
			$table->integer('sku');
			$table->string('skuDes', 100);
			$table->char('est', 4);
			$table->tinyInteger('alm');
			$table->string('ubi', 10);
			$table->string('are', 50);
			$table->mediumInteger('batLot');
			$table->mediumInteger('fecCad');
			$table->string('ori', 50);
			$table->smallInteger('var');
			$table->char('uniMed', 4);
			$table->mediumInteger('idEnt');
			$table->string('lpn', 50);
			$table->string('con', 10);
			$table->string('tip', 10);
			$table->smallInteger('cla2');
			$table->smallInteger('cla3');
			$table->string('acoRec', 10);
			$table->string('surEmb', 10);
			$table->string('surPic', 10);

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Eliminacion de la tabla del archivo de existencias en macro
		Schema::drop('sto_mac');
	}

}
