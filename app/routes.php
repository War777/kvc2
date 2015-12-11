<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

//Formulario de login
Route::get('login', 'AuthController@showLogin');
// Route::get('login', 'TestController@test');

//Validacion de los datos de inicio de sesion
Route::post('login', 'AuthController@postLogin');

Route::group(
	array(
		'before' => 'auth'
	),
	function(){

		/*
		* Rutas relacionadas al portal en general
		*/

			//Perfil
				Route::get('profile', 'UsersController@showProfile');
			//======

			//Agregar usuario
				Route::post('addUser', function(){

					if(Request::ajax()){

						$inputs = Input::get('data');

						return json_encode(
							Own::runStringController(
								'UsersController@addUser', 
								$parameters = array(
									$id = Input::get('id'),
									$user = Input::get('user'),
									$password = Input::get('password'),
									$email = Input::get('email')
								)
							)
						);

					}
					

				});

			//======

			//Agregar usuario
			Route::post('updateUser', function(){

				if(Request::ajax()){

					return json_encode(
						Own::runStringController(
							'UsersController@updateUser', 
							$parameters = array(
								$id = Input::get('id'),
								$user = Input::get('user'),
								$password = Input::get('password'),
								$email = Input::get('email')
							)
						)
					);

				}
				

			});

			//======

			//Agregar un query personalizado

			Route::get('customQueries', function(){

				$records = Own::queryToArray('select * from sto_que;');

				$data = array(
					'records' => $records
				);

				return View::make('customQueries')->with('data', $data);

			});

			//======

			Route::post('customQueries', function(){

				$description = Input::get('description');
				$query = Input::get('query');

				$test = 1;

				$message = '';

				if(

					Own::contains($query, 'delete', false) ||
					Own::contains($query, 'update', false) ||
					Own::contains($query, 'drop', false) ||
					Own::contains($query, 'create', false)

				){

					$test = 0;
					$message = 'Instruccion no permitida';

				} else {

					try {
					    
						$response = Own::queryToArray($query);

						DB::table('sto_que')->insert(
							array(
								'des' => $description,
								'que' => $query
							)
 						);

 						$message = 'Query agregado con exito';

					} catch (Exception $e) {
					    
					    $test = 0;
						$message = 'Formato de query no valido';

					}

				}

				$records = Own::queryToArray('select * from sto_que;');

				$data = array(
					'test' => $test,
					'message' => $message,
					'records' => $records,
					'description' => $description,
					'query' => $query
				);

				return View::make('customQueries')->with('data', $data);

			});



		/*
		* ==========================================================================
		*/

		//Ruta para el cierre de sesion
		Route::get('logout', 'AuthController@logOut');

		//Ruta default
		Route::get('/', 'StorageController@generalStorage');

		//Ruta a la seccion de inicio
		// Route::get('home', function(){
		// 	return View::make('start');
		// });
		Route::get('home', 'StorageController@generalStorage');

		//Ruta para acceder a la edicion de layouts de almacenaje
		Route::get('editLayout', function(){
			return View::make('editLayout');
		});

		Route::get('locations', 'StorageController@locations');

		Route::get('areas', 'StorageController@areas');

		Route::get('virtualAreas', 'StorageController@virtualAreas');

		Route::get('virtualLocations', 'DictionaryController@showVirtualLocations');

		Route::get('categories', 'DictionaryController@showCategories');

		Route::get('missingLocations', 'DictionaryController@showMissingLocations');


		/*
		* Rutas relacionadas a la actualizacion de repositorios
		*/

			// Almacenaje

				//Repositorio de existencias
				Route::get('stock', 'RepositoriesController@showStock');
				
				//Repositorio de existencias en materia prima
				Route::get('stockMp', 'RepositoriesController@showStockMp');

				//Mostrar los rangos de email
				Route::get('emailRanges', 'SettingsController@showEmailRanges');

				//Agregar un rango de email
				Route::post('addRange', function(){

					if(Request::ajax()){

						return json_encode(
							Own::runStringController(
								'SettingsController@addRange', 
								$parameters = array(
									$id = Input::get('id'),
									$res = Input::get('res'),
									$lim = Input::get('lim')
								)
							)
						);

					}
					

				});

				//Actualizar un rango de email
				Route::post('updateRange', function(){

					if(Request::ajax()){

						return json_encode(
							Own::runStringController(
								'SettingsController@updateRange', 
								$parameters = array(
									$id = Input::get('id'),
									$res = Input::get('res'),
									$lim = Input::get('lim')
								)
							)
						);

					}
					

				});

			// ==========

			//Obtener el combo de la base de datos

			Route::post('getForeignSelect', function(){

				if(Request::ajax()){

					return json_encode(
						Own::runStringController(
							'DictionaryController@getForeignSelect', 
							$parameters = array(
								$ft = Input::get('ft'),
								$fk = Input::get('fk'),
								$fd = Input::get('fd')
							)
						)
					);

				}
				
			});

			//==========

			//Actualizar un diccionario
			Route::post('updateDictionary', function(){

				if(Request::ajax()){

					return json_encode(
						Own::runStringController(
							'DictionaryController@updateDictionary', 
							$parameters = array(
								'tableName' => Input::get('tableName'),
								'inputs' => Input::get('inputs')
							)
						)
					);

				}
				
			});
			//==========


		/*
		* ==========================================================================
		*/

		// Ruta para la adicion de datos a traves del jFileUploader
		Route::post('loadCsv', function(){

			if(Request::ajax()){	//Varificamos que sea una llamada ajax

				$table = Input::get('table');
				
				$file = Input::get('file');

				$periodExists = Input::get('periodExists');

				$result = Own::loadCsvToDb($table, $file, $periodExists);

				if(Input::get('post') != ''){

					$controllerData = explode('@', Input::get('post'));
					
					$app = app();

					$controller = $app->make($controllerData[0]);

					$controller->callAction($controllerData[1], $parameters = array());

				}

				$response = array(
					'responseText' => '<b>Registros agregados:</b> ' . number_format($result['insertedRows'], 0)
				);

				return json_encode($response);

			}

		});

		//Ruta para correr la capacidad de almacenaje
		Route::post('runAjaxController', function(){
				
			if(Request::ajax()){

				$controller = Input::get('controller');

				$result = Own::runStringController($controller, $parameters = array());

				$response = array(
					'responseText' => $result['responseText']
				);

				// Own::d($response);

				return json_encode($response);
				// return $response;

			}

		});

		//Ruta para la vista del porcentaje de ocupacion en el almacen
		Route::get('generalStorage', 'StorageController@generalStorage');

		Route::get('stowages', 'DictionaryController@showStowages');

		Route::get('caoticStowages', 'StorageController@caoticStowages');	

		Route::get('consolidateLpnStorage', 'StorageController@consolidateLpnStorage');

		Route::get('runStorageCapacity', 'StorageController@runStorageCapacity');

		Route::get('sendMails', 'StorageController@sendEmails');

		Route::get('queries', function(){

			return View::make('queries');

		});

		Route::post('queries', function(){

			$queryField = Input::get('queryField');

			$value = Input::get('value');

			$query = "select  idCed, ced, are, idCat, cat, con, ubi, lpn, sku, uniMed, can, cap, perEst, estIba, caoLoc, lot, matPri, vir from sto_cap where " . $queryField . " = '" . $value . "';";

			$records = Own::queryToArray($query);

			$data = array(
				'query' => $query,
				'records' => $records
			);

			return View::make('queries')->with('data', $data);

		});


		//Ruta para la vista del data grid
		Route::get('dataGrid', function(){

			return View::make('dataGrid');

		});

		//Ruta para la vista de almacenes
		Route::get('warehouses', 'WarehousesController@viewWarehouses');

		Route::get('areaCategories', 'AreasController@viewAreaCetegories');

		//Ruta para procesar una forma ajax
		Route::post('ajaxForm', function(){
			
			if(Request::ajax()){

				$data = Input::get('data');

				$controller = $data['controller'];
				$inputs = $data['inputs'];
				
				$response = Own::runStringController($controller, ['inputs' => $inputs]);

				return $response;

			}

		});

		//Ruta para procesar una forma ajax
		Route::post('ajaxDictionaryForm', function(){
			
			if(Request::ajax()){

				$data = Input::get('data');

				$table = $data['table'];
				$controller = $data['controller'];
				$records = $data['records'];
				
				$response = Own::runStringController($controller, ['table' => $table, 'records' => $records]);

				return $response;

			}

		});

		Route::get('totalCapacity/{idCed}/{idCat}', function($idCed, $idCat){

			return Own::runStringController('StorageController@totalCapacity', $parameters = array('idCed' => $idCed, 'idCat' => $idCat));

		});

		Route::get('emptyLocations/{idCed}/{idCat}/{pre}', function($idCed, $idCat, $pre){

			return Own::runStringController('StorageController@emptyLocations', $parameters = array('idCed' => $idCed, 'idCat' => $idCat, 'pre' => $pre));

		});

		Route::get('consolidableLocations/{idCed}/{idCat}/{pre}', function($idCed, $idCat, $pre){

			return Own::runStringController('StorageController@consolidableLocations', $parameters = array('idCed' => $idCed, 'idCat' => $idCat, 'pre' => $pre));

		});

		Route::get('caoticLocations/{idCed}/{idCat}', function($idCed, $idCat){

			return Own::runStringController('StorageController@caoticLocations', $parameters = array('idCed' => $idCed, 'idCat' => $idCat));

		});

		Route::get('caoticLocation/{id}', function($id){

			return Own::runStringController('StorageController@caoticLocation', $parameters = array('id' => $id));

		});

		Route::get('movedLpns/{idCed}/{idCat}', function($idCed, $idCat){

			return Own::runStringController('StorageController@movedLpns', $parameters = array('idCed' => $idCed, 'idCat' => $idCat));

		});

		Route::get('tasks/{idCed}/{idCat}', function($idCed, $idCat){
			return Own::runStringController('StorageController@showTasks', $parameters = array('idCed' => $idCed, 'idCat' => $idCat));
		});	



		// Route::get('getGridData', function(){

		// 	Own::getGridData('');

		// });

	}
);

//Ruta para el layout
Route::get('layout', function(){
	return View::make('layout');
});