<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTablesChangeSkuIntToBigint extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		//Cambio de sku en tabla de existencias macro de int a bigint
		$query = "ALTER TABLE sto_mac MODIFY sku bigint NOT NULL;";
		DB::connection()->getpdo()->exec($query);

		$query = "ALTER TABLE sto_est ADD sku bigint NOT NULL FIRST;";
		DB::connection()->getpdo()->exec($query);

		// Schema::table('sto_mac', function($table){

		// 	$table->dropColumn('sku');

		// });

		// Schema::table('sto_mac', function($table){

		// 	$table->bigInteger('sku')->after('can');

		// });

		// //Cambio de sku en tabla de estandares de int a bigint
		// Schema::table('sto_est', function($table){

		// 	$table->dropColumn('sku');

		// });

		// Schema::table('sto_est', function($table){

		// 	$table->bigInteger('sku')->after('can');
			
		// });

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//Reversion de sku en tabla de existencias macro de bigint a int
		$query = "ALTER TABLE sto_mac MODIFY sku int NOT NULL;";
		DB::connection()->getpdo()->exec($query);


		// Schema::table('sto_mac', function($table){

		// 	$table->dropColumn('sku');

		// });

		// Schema::table('sto_mac', function($table){

		// 	$table->integer('sku')->after('can');

		// });

		// //Reversion de sku en tabla de estandares y estibas de bigint a int
		// Schema::table('sto_est', function($table){

		// 	$table->dropColumn('sku');

		// });

		// Schema::table('sto_est', function($table){

		// 	$table->integer('sku')->after('can');

		// });
	}

}