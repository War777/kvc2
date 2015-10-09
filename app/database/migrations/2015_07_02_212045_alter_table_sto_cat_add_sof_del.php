<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStoCatAddSofDel extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//Se agregan las columnas para las fechas de creacion, modificacion y eliminacion
		Schema::table('sto_cat', function($table){

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
		//Se eliminan las columnas de creacion, modificacion y eliminacion
		$table->dropTimestamps();
		$table->dropSoftDeletes();
	}

}
