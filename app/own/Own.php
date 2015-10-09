<?

	/**
	* Funciones propias, por ello el nombre Own
	*/
	class Own 
	{

		//Funcion para verificar si el servidor es local (desarrollo) o en produccion.
		public static function isLocal(){
			
			$isLocal = false;	//Bandera que indica el tipo de servidor

			if(Own::contains(Request::server('HTTP_HOST'), "local", false) == true){
				$isLocal = true;	
			}

			return $isLocal;

		}

		//Funcion que convierte un array a una tabla bootstrap
		public static function arrayToTable($array){

			if($array){

				$table = "";

				$tableHeaders = "<thead class='bg-info'>";

				$tableBody = "";

				$firstRow = true;

				//Recorremos los registros
				foreach ($array as $row) {

					$tableBody .= "<tr>";
					//Recorremos las columnas
					foreach ($row as $header => $value) {	

						$cellClasses = "";

						if(Own::contains($header, "#", false) == true){	//Es numerico
							
							$decimals = substr_count($header, "#");
							$cellClasses = " text-right";
							$value = number_format($value, ($decimals-1));
							$header = str_replace("#", "", $header);

						} else if(Own::contains($header, "\$", false) == true){	//Es moneda
							
							$decimals = substr_count($header, "\$");
							$cellClasses = " text-right";
							$value = number_format($value, ($decimals-1));

							$value = "<div class='pull-left'>$</div><div class='pull-right'>" . $value . "</div>"; //Agregamos el formato de moneda

							$header = str_replace("\$", "", $header);

						} else if(Own::contains($header, "%", false) == true){ //Es tiempo

							$decimals = substr_count($header, "%");
							$cellClasses = " text-right";
							$header = str_replace("%", "", $header);

						}

						if($firstRow == true){

							$tableHeaders.= "<td class='text-center'>" . ucfirst($header) . "</td>";

						}

						$tableBody .= "<td class='" . $cellClasses . "'>" . $value . "</td>";
						
					}

					$tableBody .= "</tr>";

					$firstRow = false;
					
				}

				$tableHeaders .= "</thead>";

				$table = "<div class='table-responsive'>"
							. "<table class='table table-bordered table-hover table-condensed'>" 
								. $tableHeaders
								. $tableBody 
							. "</table>"
						. "</div>";

				return $table;

			} else {

				return "Sin Datos";

			}

		}

		//Funcion para correr una serie de queries dados por un array
		public static function runQueries($queries){

			$results = array();

			foreach ($queries as $description => $query) {
				$result = Own::runQuery($description, $query);
				array_push($results, $result);
			}

			return $results;

		}

		//Funcion para ejecutar un simple query
		public static function runQuery($description, $query){

			$result = array();				//Arreglo informativo

			$start = Own::getCurrentTime();	//Hora de inicio

			// $rows = DB::statement($query);
			$rows = DB::affectingStatement($query);	//Registros afectados
			
			$finish = Own::getCurrentTime();	//Hora de termino

			//Agregamos la informacion
			$result['Descripcion'] = $description;	
			$result['#Filas'] = $rows;
			$result['%Tiempo'] = Own::getRunTime($start, $finish);
			$result['Query'] = $query;
			
			return $result;

		}

		//Funcion para obtener la hora actual
		public static function getCurrentTime(){
			$time = Date('h') . ":" . Date('i') . ":" . Date('s');
			return $time;
		}


		/*
		* Funcion para tener un tiempo de ejecucion dados dos
		* tiempos creados por la funcion getCurrentTime
		*/
		public static function getRunTime($start, $finish){

			//Construimos el tiempo transcurrido
			$interval = strtotime($finish) - strtotime($start);

			$minutes = floor( ($interval - (0 * 3600)) / 60 );
			$seconds = $interval - ( 0 * 3600 ) - ( $minutes * 60 );

			if($minutes < 10){
				$minutes = "0" . $minutes;
			}
			if($seconds < 10){
				$seconds = "0" . $seconds;
			}

			$time = $minutes . "m" . ":" . $seconds . "s";

			return $time;

		}

		//Funcion que evalua si un string contiene otro string
		public static function contains($where, $find, $caseSensitive){

			$flag = false;

			if($caseSensitive == true){

				if(strpos($where, $find) !== false){

					$flag = true;

				}

			} else {

				if(stripos($where, $find) !== false){

					$flag = true;

				}

			}

			return $flag;

		}

		//Funcion para mandar un echo mas simple con una linea de separacion
		public static function e($message){

			echo "<hr>" . $message;

		}

		//Funcion para hacer un var_dump con formato html
		public static function d($object){

			echo "<hr> <pre> " . print_r($object, true) . " </pre>";

		}

		//Funcion que inserta los registros de un archivo *.cvs a la base de datos
		public static function loadCsvToDb($table, $file, $periodExists){

			$isLocal = Own::isLocal();				//Verificamos el tipo de servidor

			$path = "/var/www/kvm/uploadedFiles/php/files/";	//Ruta del directorio de archivos
			
			if($isLocal){							//Si el servidor es local cambiamos la ruta

				$path = "C:/xampp/htdocs/kvm/uploadedFiles/php/files/";

			}

			$response = array();

			$deleteQuery = "TRUNCATE " . $table . ";";
		
			DB::connection()->getpdo()->exec($deleteQuery);

			$query = "load data local
					infile '" . $path . $file . "'
					into table " . $table . "
					fields terminated by ','
					lines terminated by '\n'
					ignore 1 lines";

			$response['insertedRows'] = DB::connection()->getpdo()->exec($query);
			// $affectedRows = DB::connection()->getpdo()->exec($query);

			Own::logEvent($table);

			return $response;
			
		}

		//Funcion para extraer los datos del grid
		public static function getGridData($query){

			$query = "SELECT * from sto_mac limit 10;";

			$records = DB::select($query);

			if(count($records) > 0){

				Own::d($records);

				// $columns = array();
				// $items = array();

				// $firstRecord = true;

				// foreach ($records as $record) {
					
				// 	foreach ($record as $field => $value) {

				// 		if($firstRecord == true){

				// 			array_push($columns, $field);

				// 		}

				// 		$record[$field] = utf8_encode($record[$field]);

				// 	}

				// 	array_push($items, $record);

				// 	$firstRecord = false;

				// }

				// $response = array(
				// 	'columns' => $columns,
				// 	'items' => $items
				// );

			} else {

				echo "No data";

			}

		}

		/*
		* Funcion para correr el metodo de un controlador
		* Recibe los siguiente parametros
		* array() Parametros
		* String Controlador@metodo
		* 
		* Devuelve un array con la informacion de retroalimentacion
		*/

		public static function runStringController($controllerString, $parameters){

			$controllerData = explode('@', $controllerString);
					
			$app = app();

			$controller = $app->make($controllerData[0]);

			return $controller->callAction($controllerData[1], $parameters);

		}

		/*
		*
		*/

		public static function arrayToModelForm($formData){

			$form = '<div class="input-group-sm">';

			$form .= Form::open(
				array(
					'url' => 'ajaxForm',
					'controller' => $formData['controller']
				)
			);

			foreach ($formData['inputs'] as $input) {
				
				switch($input['type']){

					case 'text':
						
						$attributes = array(
							'id' => $input['name'],
							'placeholder' => $input['placeholder'],
							'class' => 'form-control',
						);

						if($input['required'] == true){

							$attributes['required'] = 'required';

						}	
						
						$form .= Form::text(
							$input['name'],
							null, 
							$attributes
						);

					break;

					case 'select': 

						$form .= '<select>';

							foreach ($input['values'] as $option) {
								$form .= '<option value="' . $option['value'] . '">';
									$form .= $option['text'];
								$form .= '</option>';
							}
						
						$form .= '</select>';

						$form .= '<br /><br />';

					break;

					case 'numeric':

						$attributes = array(
							'id' => $input['name'],
							'placeholder' => $input['placeholder'],
							'class' => 'form-control numeric',
						);

						if($input['required'] == true){

							$attributes['required'] = 'required';

						}	
						
						$form .= Form::text(
							$input['name'],
							null, 
							$attributes
						);

					break;

				}

			}
			
			$form .= '<div class="row">';

				$form .= '<div class="col-sm-12 text-right">';

					$form .= Form::reset('Reset', array('class' => 'btn btn-primary btn-xs'));

					$form .= ' ';

					$form .= Form::button('Add', array('class' => 'ajaxForm btn btn-primary btn-xs'));

				$form .= '</div>';

			$form .= '</div>';
			
			
			$form .= '';


			$form .= Form::close();

			$form .= "</div>";

			return $form;

		}

		/*
		* Funcion que convierte un conjunto registros de clase estandar a un arreglo asociativo
		* @param [stdClass] stdRecords
		* @return Array records
		*/
		public static function stdRecordsToArray($stdRecords){

			$records = array();							//Declaramos el arreglo

			foreach ($stdRecords as $stdRecord) {		//Recorremos los registros
				
				$record = get_object_vars($stdRecord);	//Transformamos el registro de clase estandar a un arreglo asociativo

				array_push($records, $record);			//Agregamos el registro a la coleccion

			}

			return $records;							//Devolvemos la coleccion

		}

		/*
		* Funcion que devuelve un arreglo con datos dada una consulta en formato MySql
		* @param String $query
		* @return Array $records
		*/

		public static function queryToArray($query){

			$records = Own::stdRecordsToArray(
				DB::select($query)
			);

			return $records;

		}

		/*
		* ================================================
		* Fin de la funcion queryToArray();
		* ================================================
		*/

		/*
		* Funcion que devuelve un dato unico desde la base dado un query
		* @param String query
		* @return String data
		*/

		public static function queryToData($query){

			$data = "";

			$records = Own::stdRecordsToArray(
				DB::select($query)
			);
			
			foreach ($records as $record) {

				foreach ($record as $value) {

					$data = $value;
					
					break;

				}
				
				break;
			
			}

		}

		/*
		* Funcion que registra la modificacion de una tabla
		* @param String table
		*/

		public static function logEvent($table){

			$records = array();

			$record = array(
				'usu' => Auth::user()->user,
				'tab' => $table,
				'dat' => date('Y-m-d H:i:s')
			);

			array_push($records, $record);

			DB::table('kvm_eve')->insert($records);

		}

		public static function queryToSingleArray($query){

			$records = Own::queryToArray($query);

			$data = array();

			foreach ($records as $record) {
				
				foreach ($record as $index => $value) {
					
					$data[$index] = $value;

				}

				break;

			}

			return $data;

		}

	}

?>