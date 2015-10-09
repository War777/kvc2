<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStoCapBatLotToFecCad extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Eliminamos la columna de lote y la cambiamos por fecha de caducidad
		Schema::table('sto_cap', function($table){
			$table->dropColumn('batLot');
			$table->integer('fecCad')->after('sku');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Regresamos la columna de lote y eliminamos fecha de caducidad
		Schema::table('sto_cap', function($table){
			$table->dropColumn('fecCad');
			$table->integer('batLot')->after('sku');
		});
	}

}
