<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStoCapAddDis extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Agregamos las columnas de disponibilidad
		Schema::table('sto_cap', function($table){

			$table->double('dis', 5, 2)->after('ocu');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Eliminamos la columna de disponibilidad
		Schema::table('sto_cap', function($table){

			$table->dropColumn('dis');

		});

	}

}
