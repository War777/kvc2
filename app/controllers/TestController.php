<?

	/**
	* Controllador de Prueba
	*/
	class TestController extends BaseController
	{
		
		public function test(){

			return 'Testing';

			// $queries = array();

			// $queries['Insercion de Prueba'] = "insert into test (a, b) values ('Columna A', 10), ('Columna A', 30), ('Columna A', 20);";

			// $queries['Borrado de prueba'] = "delete from test where b = 10;";

			// $queries['Actualizacion de prueba'] = "update test set a = 'cambio de columna';";

			// $queries['Seleccion de prueba'] = "select * from test;";

			// Own::runQueries($queries);

			// $result = Own::runQuery($queries['Insercion de Prueba']);
			// Own::d($result);
			
			// $result = Own::runQuery($queries['Borrado de prueba']);
			// Own::d($result);

			// $result = Own::runQuery($queries['Actualizacion de prueba']);
			// Own::d($result);

			// $result = Own::runQuery($queries['Seleccion de prueba']);
			// Own::d($result);

			// $path = "C:/xampp/htdocs/kvc2/s/php/files/test.csv";

			// $query = "	load data local
			// 			infile '" . $path . "'
			// 			into table test 
			// 			fields terminated by ','
			// 			lines terminated by '\n'
			// 			ignore 1 lines";

			// Own::d(DB::connection()->getpdo()->exec($query));
			
			
		}
		
	}

?>