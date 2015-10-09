<?
	
	/**
	* Agregamos el primer usuario a la tabla
	*/

	class KvcUseSeeder extends Seeder
	{
		
		public function run(){

			User::create(
				array(
					'user' => 'war',
					'password' => Hash::make('war')
				)
			);

		}
	}

?>