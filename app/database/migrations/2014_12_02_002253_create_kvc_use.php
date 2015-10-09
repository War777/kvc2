<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateKvcUse extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('kvc_use', function(Blueprint $table)
		{
			/*
			* Estructura de la tabla usuarios
			*/
			$table->increments('id'); 				//Id autoincrementable
			$table->string('use', 100);				//Nombre de usuario
			$table->binary('pas');					//Contraseña
			$table->string('sis', 100);				//Sistemas permitidos
			$table->text('per');					//Permisos
			$table->timestamps();			//Fecha de creacion

		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('kvc_use');
	}

}
