<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStoLocAddTimestampsSoftDeletes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Adicion de las columnas de fechas de creacion, modificacion y borrado
		Schema::table('sto_loc', function($table){

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
		//
		Schema::table('sto_loc', function($table){

			$table->dropTimestamps();
			$table->dropSoftDeletes();

		});
	}

}
