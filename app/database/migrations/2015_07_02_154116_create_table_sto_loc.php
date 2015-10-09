<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableStoLoc extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{	

		//Recreacion de la tabla de ubicaciones
		Schema::create('sto_loc', function($table){

			$table->increments('id');		//Id
			$table->string('are', 20);		//Area
			$table->boolean('con');			//Contabiliza
			$table->string('des', 100);		//Descripcion
			$table->smallInteger('car');	//Carriles
			$table->smallInteger('pap');	//Posiciones a piso
			$table->string('claAlm', 20);	//Clave del almacen
			$table->timeStamps();
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
		//Eliminacion de la tabla de ubicaciones
		Schema::drop('sto_loc');
	}

}
