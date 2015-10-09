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

		/*
		* ==========================================================================
		*/

		//Ruta para el cierre de sesion
		Route::get('logout', 'AuthController@logOut');

		//Ruta default
		Route::get('/', function(){
			return View::make('start');
		});

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


		/*
		* Rutas relacionadas a la actualizacion de repositorios
		*/

			// Almacenaje

				//Repositorio de existencias
				Route::get('stock', 'RepositoriesController@showStock');
				
				//Repositorio de existencias en materia prima
				Route::get('stockMp', 'RepositoriesController@showStockMp');

			// ==========


		/*
		* ==========================================================================
		*/

		// Ruta para la adicion de datos a traves del jFileUploader
		Route::post('loadCsv', function(){

			if(Request::ajax()){	//Varificamos que sea una llamada ajax

				$table = Input::get('table');
				
				$file = Input::get('file');

				$periodExists = Input::get('periodExists');

				$response = Own::loadCsvToDb($table, $file, $periodExists);

				if(Input::get('post') != ''){

					$controllerData = explode('@', Input::get('post'));
					
					$app = app();

					$controller = $app->make($controllerData[0]);

					return $controller->callAction($controllerData[1], $parameters = array());

				}

				Own::d($response);

			}

		});

		//Ruta para correr la capacidad de almacenaje
		Route::post('runAjaxController', function(){
				
			if(Request::ajax()){

				$controller = Input::get('controller');

				$response = Own::runStringController($controller, $parameters = array());

				return json_encode($response);

			}

		});

		//Ruta para la vista del porcentaje de ocupacion en el almacen
		Route::get('generalStorage', 'StorageController@generalStorage');

		Route::get('stowages', 'DictionaryController@showStowages');

		Route::get('caoticStowages', 'StorageController@caoticStowages');	

		Route::get('consolidateLpnStorage', 'StorageController@consolidateLpnStorage');

		Route::get('runStorageCapacity', 'StorageController@runStorageCapacity');

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