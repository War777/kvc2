<?

	/**
	* 
	*/
	class SettingsController extends BaseController
	{
		
		public function showEmailRanges(){

			$records = Own::queryToArray(
				"select 
					sto_ema.id as id, 
					users.user as 'use',
					sto_ema.res as res,
					sto_ema.lim as lim
					from sto_ema
					inner join users
					on sto_ema.id = users.id;"
			);

			$users = Own::queryToArray("select id, user from users where id not in (select id from sto_ema);");

			$data = array(
				'records' => $records,
				'users' => $users
			);

			return View::make('emailRanges')->with('data', $data);

		}

		public function addRange($id, $res, $lim){

			$responsable = 0;

			if($res == true) {

				$responsable = 1;

			}

			$record = array(
				'id' => $id,
				'res' => $responsable,
				'lim' => $lim
			);

			$records = array();

			array_push($records, $record);

			DB::table('sto_ema')->insert($records);

			return array(
				'responseText' => 'Rango agregado con exito.',
				'res' => $res
			);

		}

		public function updateRange($id, $res, $lim){

			$affectedRows = DB::affectingStatement(
				"update sto_ema
				set res = " . $res . ",
					lim = " . $lim . "
				where id = " . $id . ";"
			);

			return array(
				'responseText' => 'Rango actualizado con exito.',
				'id' => $id,
				'res' => $res,
				'lim' => $lim,
				'affected' => $affectedRows

			);

		}			

	}

?>