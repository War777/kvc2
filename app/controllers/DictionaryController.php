<?

	/**
	* 
	*/
	class DictionaryController extends BaseController
	{
		
		/*
		* Funcion que muestra el diccionario de estibas y estandares
		*/

		public function showStowages(){

			$queries = array();

			$queries['Depuracion de estibas faltantes'] = "drop table if exists sto_est_fal;";

			$queries['Creacion de tabla temporal de estibas faltantes'] = "create temporary table sto_est_fal
				select distinct(sku) as 'sku', 0 as 'added'
				from sto_cap
				where estIba = 0
				or estIba is null;";

			$queries['Verificacion de estibas ya agregadas'] = "update sto_est_fal
				inner join sto_est
				on sto_est_fal.sku = sto_est.sku
				set sto_est_fal.added = 1;";

			Own::runQueries($queries);

			$table = 'sto_est';

			$records = Own::queryToArray('select * from ' . $table);

			$missingRecords = Own::queryToArray(
				'select * from sto_est_fal where added = 0;'
			);

			$data = array(
				'table' => $table,
				'records' => $records,
				'missingRecords' => $missingRecords
			);

			return View::make('stowages')->with('data', $data);

		}

		/*
		* ===========================================
		* Fin de la funcion showStowages()
		* ===========================================
		*/

		/*
		* Funcion que agrega las estibas faltantes al diccionario de estandares y estibas
		*/

		public function addDictionaryRecords($table, $records){

			$status = 0; 

			if(count($records) > 0){

				$status = DB::table($table)->insert($records);

			}

			return $status;

		}

		/*
		* ===========================================
		* Fin de la funcion addDictionaryRecords()
		* ===========================================
		*/

		/*
		* Funcion que muestra las ubicaciones virtuales
		* @return View virtualLocations, vista con las ubicaciones virtuales
		*/

		public function showVirtualLocations(){

			$records = Own::queryToArray('select * from sto_vir_loc;');
			$lastUpdate = Own::queryToSingleArray(
				"SELECT usu, dat
				FROM kvm_eve
				WHERE tab = 'sto_vir_loc'
				ORDER BY dat DESC
				LIMIT 1;"
			);

			$data = array(
				'lastUpdate' => $lastUpdate,
				'records' => $records

			);

			return View::make('virtualLocations')->with('data', $data);

		}	


	}

?>