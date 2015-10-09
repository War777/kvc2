<?

	/**
	* Controllador de proceso de almacenaje
	*/
	class StorageController extends BaseController
	{
		
		public function runStorageCapacity(){

			$start = Own::getCurrentTime();

			$truncateQueries = array(
				'Truncado de tabla de ubicaciones caoticas' => 'truncate table sto_cao;',
				'Truncado de tabla de ubicaciones consolidadas' => 'truncate table sto_con;',
				'Truncado de tabla de ubicaciones vacias' => 'truncate table sto_emp;',
				'Truncado de tabla de ubicaciones filtradas' => 'truncate table sto_fil_loc;',
				'Truncado de tabla de ubicaciones de origen' => 'truncate table sto_fro;',
				'Truncado de tabla de ubicaciones de destino' => 'truncate table sto_to;'
			);

			Own::runQueries($truncateQueries);

			$queries = array();

			$queries['Depuracion de tabla temporal'] = "DROP table if exists sto_cap_tem;";

			$queries['Creacion de tabla de capacidad de almacenaje temporal'] = "CREATE temporary table sto_cap_tem(
								
				idCed smallint(4),
				ced varchar(100),

				are char(6), 		#	

				idCat smallint(4),
				
				cat varchar(50),	#
				
				con tinyint(1),

				ubi	varchar(10),
				lpn bigint(20),
				
				sku	bigint,
				
				fecCad	mediumint(9),
				
				uniMed	char(4),
				
				can	smallint(6),

				pal smallint(3),

				cap tinyint(2),
				capFin tinyint(4),
				
				perEst tinyint(1),

				estIba tinyint(2),
				
				estAnd smallint(4),

				ocuPal	tinyint(4),
				disPal	tinyint(4),

				ocuPor	double(5, 2),
				disPor	double(5, 2),

				caoLoc tinyint(1),

				lot mediumint(4),

				matPri tinyint(1),

				vir tinyint(1),								
				
				key exi(ubi, sku, fecCad)

			);";

			$queries['Agrupacion de existencias en macro a tabla temporal'] = "INSERT into sto_cap_tem(
				select

					0, '', '', 0, '', 0, 
					
					ubi, lpn, sku, fecCad, uniMed, sum(can),
					
					0, 0, 0, 0, 0, 0, 0, 0, 0.0, 0.0, 0, 0, 0, 0

				from sto_mac

				group by ubi, lpn, sku, fecCad, uniMed

			);";
			
			$queries['Actualizacion de estandar y estiba en tabla temporal'] = "UPDATE sto_cap_tem
				inner join sto_est
				on sto_cap_tem.sku = sto_est.sku
				set sto_cap_tem.estIba = sto_est.estIba,
					sto_cap_tem.estAnd = sto_est.estAnd;";

			$queries['Actualizacion de capacidades y bandera de estiba por ubicacion en tabla temporal'] = "UPDATE sto_cap_tem
				inner join sto_loc
				on sto_cap_tem.ubi = sto_loc.id
				set sto_cap_tem.cap = sto_loc.cap,
					sto_cap_tem.perEst = sto_loc.perEst;";

			$queries['Adicion de area de ubicacion en tabla temporal'] = "UPDATE sto_cap_tem
				SET are = substring_index(ubi, '-', 1);";

			$queries['Actualizacion de datos de area (cedis y categoria) en tabla temporal'] = "UPDATE sto_cap_tem
				inner join sto_are
				on sto_cap_tem.are = sto_are.id
				set sto_cap_tem.idCed = sto_are.idCed,
					sto_cap_tem.idCat = sto_are.idCat;";

			$queries['Actualizacion de ubicaciones virtuales en tabla temporal'] = "update sto_cap_tem
				inner join sto_vir_are
				on sto_cap_tem.are = sto_vir_are.id
				set sto_cap_tem.vir = 1
				and sto_cap_tem.idCed = sto_vir_are.idCed;";

			$queries['Depuracion de tabla de capacidad de ubicaciones virtuales'] = "drop table if exists sto_vir_cap;";

			$queries['Creacion de tabla temproal de capacidad de ubicaciones virtuales'] = "create temporary table sto_vir_cap
				select sto_vir_loc.virLoc as 'virLoc', sto_vir_loc.fisLoc as 'fisLoc', sto_loc.cap as 'cap'
				from sto_vir_loc
				inner join sto_loc
				on sto_vir_loc.fisLoc = sto_loc.id;
			;";

			$queries['Actualizacion de capacidad de ubicaciones virtuales'] = "update sto_cap_tem
				inner join sto_vir_cap
				on sto_cap_tem.ubi = sto_vir_cap.virLoc
				set sto_cap_tem.cap = sto_vir_cap.cap
			;";

			$queries['Actualizacion de datos de cedis en tabla temporal'] = "UPDATE sto_cap_tem
				inner join sto_war
				on sto_cap_tem.idCed = sto_war.id
				set sto_cap_tem.ced = sto_war.ced;";

			$queries['Actualizacion de datos de categoria en tabla temporal'] = "UPDATE sto_cap_tem
				inner join sto_cat
				on sto_cap_tem.idCat = sto_cat.id
				set sto_cap_tem.cat = sto_cat.cat,
					sto_cap_tem.con = sto_cat.con;";

			$queries['Actualizacion de lote mes-año'] = "UPDATE sto_cap_tem
				set lot = 
				    concat(
						extract(month from date_add('1900-01-01', interval fecCad - 2 day)),
						substr(extract(year from date_add('1900-01-01', interval fecCad - 2 day)), 3, 2) 
				    );";

			$queries['Depuracion de tabla de pre ubicaciones caoticas'] = "drop table if exists sto_pre_cao_loc;";

			$queries['Pre agrupacion de ubicaciones caoticas'] = "create temporary table sto_pre_cao_loc
					select idCed, idCat, are, ubi, sku, lot, cap, count(lpn) as 'lpns'
					from sto_cap_tem
					where con = 1
					group by idCed, idCat, are, ubi, sku, lot;";

			$queries['Depuracion de tabla de ubicaciones caoticas'] = "drop table if exists sto_cao_loc;";

			$queries['Agrupamiento de ubicaciones caoticas'] = "create temporary table sto_cao_loc
					(index ubi(ubi))
					select idCed, idCat, are, ubi, cap, sum(lpns) as 'lpns'
					from sto_pre_cao_loc
					group by idCed, idCat, are, ubi
					having count(ubi) > 1;";

			$queries['Depuracion de tabla de ubicaciones en MP'] = "drop table if exists sto_mat_loc;";

			$queries['Creacion de tabla de ubicaciones en MP'] = "create temporary table sto_mat_loc
				select distinct(ubi) as 'ubi'
				from sto_mat
			";

			$queries['Exclusion de ubicaciones caoticas en MP'] = "delete from sto_cao_loc
				where ubi in (
					select ubi
					from sto_mat_loc
				);
			";

			$queries['Pre ajuste de ubicaciones no caoticas'] = "update sto_cap_tem
				set caoLoc = 0
				where con = 1;";

			$queries['Actualizacion de ubicaciones caoticas en tabla de almacenaje'] = "update sto_cap_tem
				inner join sto_cao_loc
				on sto_cap_tem.ubi = sto_cao_loc.ubi
				set sto_cap_tem.caoLoc = 1;";

			$queries['Preparacion de tabla de ubicaciones caoticas'] = "delete from sto_cao;";

			$queries['Almacenamiento de ubicaciones caoticas'] = "insert into sto_cao(

				select idCed, idCat, are, ubi, cap, sum(lpns)
				from sto_cao_loc
				group by idCed, idCat, are, ubi

			);";

			$queries['Praparado de repositorio'] = "truncate sto_cap;";

			$queries['Consolidado de tabla temporal a repositorio de capacidad de almacenaje'] = "INSERT into sto_cap(
								select * from sto_cap_tem
							);";

			$this->consolidateLpnStorage();
			
			$results = Own::runQueries($queries);

			$finish = Own::getCurrentTime();

			$runTime = Own::getRunTime($start, $finish);

			$response = array(
				'responseText' => '¡Hecho!<br>Tiempo de respuesta: ' . $runTime
			);

			return  $response;
			
		}

		public function getStorageData(&$warehouse){

			$query = "SELECT *
					FROM sto_cap
					WHERE idCed = " . $warehouse['idCed']  . "
					AND con = 1
					AND caoLoc = 0
					AND matPri = 0";

			$data = DB::select($query);

			return $data;

		}

		public function consolidateLpnStorage(){

			//Se crean los cedis existentes
			$warehouses = $this->getWarehouses();

			foreach ($warehouses as &$warehouse) {
				
				//Obtenemos las categorias del cedis
				$warehouse['categories'] = $this->getCategories($warehouse);


				/*
				* Generamos las posiciones a piso usadas por cada ubicacion
				*/

				foreach ($warehouse['categories'] as &$category) {

					$this->setCategoryPrePaps($category);

				}

				/*
				* =========================================================
				*/

				//Ordenamos por numero de LPNS que contiene cada ubicacion
				foreach ($warehouse['categories'] as &$category) {
					
					$this->sortLocationsByLpns($category);

				}

				/*
				* ========================================================
				*/

				/*
				* Generamos las ubicaciones vacias para cada categoria
				*/

				foreach ($warehouse['categories'] as &$category) {

					$this->setCategoryPreEmptyData($category);

				}

				/*
				* ==================================================================================================
				*/

				/*
				* Generamos los datos de consolidacion y ocupacion antes de la consolidacion
				*/

				foreach ($warehouse['categories'] as &$category) {

					$this->setCategoryPreData($category);

				}

				/*
				* ==========================================================================
				*/

				//Realizamos la consolidacion por LPN de menores hacia los mayores
				foreach ($warehouse['categories'] as &$category) {

					$this->consolidateCategory($category);

				}

				/*
				* Generamos las posiciones a piso usadas por cada ubicacion despues de la consolidacion
				*/

				foreach ($warehouse['categories'] as &$category) {

					$this->setCategoryPostPaps($category);

				}

				/*
				* =========================================================
				*/

				/*
				* Generamos las ubicaciones consolidadas asi como las ubicaciones vacias
				*/

				foreach ($warehouse['categories'] as &$category) {

					$this->divideCategoryLocations($category);

				}

				/*
				* ==========================================================================
				*/

			}

			return true;

			/*
			* Pasamos los datos a la vista correspondiente
			*/

		}

		public function setCategoryPreEmptyData(&$category){

			$category['preEmptyLocations'] = array();
			
			$queries = array();

			$queries['Depuracion de tabla temporal de ubicaciones'] = "delete from sto_fil_loc
				where idCed = " . $category['idCed'] . "
				and idCat = " . $category['id'] . ";";

			$queries['Creacion de tabla con ubicaciones filtradas por categoria'] = "insert into sto_fil_loc 
				(
					SELECT " . $category['idCed'] . ", " . $category['id'] . ", sto_loc.idAre, sto_loc.id, sto_loc.cap, 1 as 'emp'
					FROM sto_loc
					inner join sto_are
					on sto_loc.idAre = sto_are.id
					and sto_are.idCed = " . $category['idCed'] . "
					and sto_are.idCat = " . $category['id'] . "
				);
			";

			$queries['Depuracion de ubicaciones fisicas usadas como virtuales para evitar duplicados'] = "delete from sto_fil_loc
				where idLoc in (
					select distinct(fisLoc)
					from sto_vir_loc
				);";

			$queries['Actualizacion de ubicaciones consolidables en capacidad total'] = "
				update sto_fil_loc
				inner join sto_con
				on sto_fil_loc.idLoc = sto_con.idLoc
				and sto_fil_loc.idCed = " . $category['idCed'] . "
				and sto_fil_loc.idCat = " . $category['id'] . "
				and sto_con.pre = 1
				set sto_fil_loc.emp = 2;";
			
			$queries['Adicion de ubicaciones virtuales a la capacidad total'] = "insert into sto_fil_loc 
				(
					SELECT " . $category['idCed'] . ", " . $category['id'] . ", are, ubi, cap, 3
					FROM sto_cap
					WHERE idCed = " . $category['idCed'] . "
                    AND idCat = " . $category['id'] . "
					AND vir = 1
					GROUP by ubi
				);";

			$queries['Actualizacion de ubicaciones caoticas en capacidad total'] = "
				update sto_fil_loc
				inner join sto_cao
				on sto_fil_loc.idLoc = sto_cao.idLoc
				and sto_fil_loc.idCed = " . $category['idCed'] . "
				and sto_fil_loc.idCat = " . $category['id'] . "
				set sto_fil_loc.emp = 4;
			";

			$queries['Depuracion de tabla de ubicaciones en MP'] = "drop table if exists sto_mat_loc;";

			$queries['Creacion de tabla de ubicaciones en MP'] = "create temporary table sto_mat_loc
				select distinct(ubi) as 'ubi'
				from sto_mat
			";

			$queries['Exclusion de ubicaciones en MP'] = "delete from sto_fil_loc
				where idLoc in (
					select ubi
					from sto_mat_loc
				);
			";

			$queries['Actualizacion de ubicaciones de materia prima en existencias'] = "update sto_cap
				inner join sto_mat_loc
				on sto_cap.ubi = sto_mat_loc.ubi
				and sto_cap.idCed = " . $category['idCed'] . "
				and sto_cap.idCat = " . $category['id'] . "
				set sto_cap.matPri = 1;";

			// $queries['a'] = "drop table if exists sto_cap_loc;";

			// $queries['b'] = "create temporary table sto_cap_loc
			// 				select ubi
			// 				from sto_cap
			// 				where idCed = " . $category['idCed'] . "
			// 				and idCat = " . $category['id'] . "
			// 				group by ubi;";

			// $queries['c'] = "update sto_fil_loc
			// 				inner join sto_cap_loc
			// 				on sto_fil_loc.idLoc = sto_cap_loc.ubi
			// 				set emp = 0;";
				
			$queries['Depuracion de tabla de ubicaciones vacias en pre consolidacion'] = "delete from sto_emp 
				where idCed = " . $category['idCed'] . "
				and idCat = " . $category['id'] . "
				and pre = 1;";

			$queries['d'] = "insert into sto_emp(
								select " . $category['idCed'] . ", " . $category['id'] . ", idAre, idLoc, cap, 1
								from sto_fil_loc
								where idCed = " . $category['idCed'] . "
								and idCat = " . $category['id'] . "
								and emp = 1
							)";			
			
			Own::runQueries($queries);

		}


		/*
		* Funcion que genera las categorias de almacenaje
		* @return Array categories
		*/

		private function getCategories($warehouse){

			//Obtenemos los registros en bruto
			$stdRecords = $this->getStorageData($warehouse);

			$records = Own::stdRecordsToArray($stdRecords);

			$grossCategories = Own::stdRecordsToArray(DB::select('select idCat as "id", cat from sto_cap where idCed = ' . $warehouse['idCed'] . ' and con = 1 group by idCat, cat;'));

			$categories = array();

			foreach ($grossCategories as $category) {

				$category['idCed'] = $warehouse['idCed'];

				$category['pivots'] = array();

				foreach ($records as $record) {

					if($record['idCat'] == $category['id'] && $record['idCed'] == $category['idCed'] && $record['caoLoc'] == 0){

						$pivotExists = false;

						foreach ($category['pivots'] as &$pivot) {
							
							if(
								$record['sku'] == $pivot['sku']
								&& $record['lot'] == $pivot['fecCad']
							){

								$pivotExists = true;

								$locationExists = false;

								foreach ($pivot['locations'] as &$location) {

									// Own::d($location);

									if($record['ubi'] == $location['location']){

										$locationExists = true;



										array_push($location['lpns'], ['lpn' => $record['lpn'], 'quantity' => $record['can']]);
										$location['originalLpnsCounter']++;
										$location['finalLpnsCounter']++;
										$location['availability']--;
										// Own::d($location);

										break;

									}
									
								}

								if($locationExists == false){

									$newLocation = array(
										'idCedis' => $record['idCed'],
										'idCategory' => $record['idCat'],
										'area' => $record['are'],
										'location' => $record['ubi'],
										'capacity' => $record['cap'],
										'stowage' => $record['estIba'],
										'totalCapacity' => ($record['cap'] * $record['estIba']),
										'availability' => ($record['cap'] * $record['estIba']) - 1,

										'originalLpnsCounter' => 1,
										'finalLpnsCounter' => 1,

										'isCaotic' => $record['caoLoc'],

										'lpns' => array(

											['lpn' => $record['lpn'], 'quantity' => $record['can']]

										),

										'to' => array(),
										'from' => array()

									);

									// Own::d($newLocation);

									array_push($pivot['locations'], $newLocation);

								}

								break;

							}

						}

						if($pivotExists == false){

							$newPivot = array(

								'sku' => $record['sku'],
								'fecCad' => $record['lot'],
								'idCat' => $record['idCat'],
								'locations' => array(

									array(
										'idCedis' => $record['idCed'],
										'idCategory' => $record['idCat'],
										'area' => $record['are'],
										'location' => $record['ubi'],
										'capacity' => $record['cap'],
										'stowage' => $record['estIba'],
										'totalCapacity' => ($record['cap'] * $record['estIba']),
										'availability' => ($record['cap'] * $record['estIba']) - 1,

										'originalLpnsCounter' => 1,
										'finalLpnsCounter' => 1,

										'isCaotic' => $record['caoLoc'],

										'lpns' => array(

											['lpn' => $record['lpn'], 'quantity' => $record['can']]

										),

										'to' => array(),
										'from' => array()

									)
									
								),


							);

							// Own::d($newPivot);

							array_push($category['pivots'], $newPivot);	

						}


					}

				}

				array_push($categories, $category);

			}

			return $categories;

		}

		/*
		* ====================================================
		* Fin de la funcion getCategories();
		* ====================================================
		*/

		/*
		* Funcion que genera las posiciones a piso originales por categoria y a su vez contabiliza los Lpns
		* @param Array category
		*/

		private function setCategoryPrePaps(&$category){

			$category['generalOriginalLpnsCounter'] = 0;
				
			foreach ($category['pivots'] as &$pivot) {

				foreach ($pivot['locations'] as &$location) {

					if($location['stowage'] == 0){

						// echo "<h1>" . $pivot['sku'] . "</h1>";

						$location['originalPapsUsed'] = 0;

						$category['generalOriginalLpnsCounter'] += $location['originalLpnsCounter'];

					} else {
						
						$category['generalOriginalLpnsCounter'] += $location['originalLpnsCounter'];

						$location['originalPapsUsed'] = ceil(($location['originalLpnsCounter'] / $location['stowage']));

					}


				}

			}

		}

		/*
		* ====================================================
		* Fin de la funcion setCategoryPrePaps();
		* ====================================================
		*/

		/*
		* Funcion que ordena las ubicaciones de los pivotes por numero de Lpns
		* @param Array category
		*/

		private function sortLocationsByLpns(&$category){

			foreach ($category['pivots'] as &$pivot) {

				$locationsCounter = count($pivot['locations']);

				for ($i=0; $i < $locationsCounter - 1; $i++) { 
					
					for ($j= $i + 1; $j < $locationsCounter; $j++) { 
						
						if($pivot['locations'][$i]['originalLpnsCounter'] < $pivot['locations'][$j]['originalLpnsCounter']){

							$tempLocation = $pivot['locations'][$i];
							$pivot['locations'][$i] = $pivot['locations'][$j];
							$pivot['locations'][$j] = $tempLocation;

						}

					}

				}
				
			}

		}

		/*
		* ====================================================
		* Fin de la funcion sortLocationsByLpns();
		* ====================================================
		*/

		/*
		* Funcion que genera los datos de consolidacion y ocupacion antes de la optimizacion
		* @param Array category
		*/

		private function setCategoryPreData(&$category){

			$consolidableLocations = array();

			foreach ($category['pivots'] as &$pivot) {

				if(count($pivot['locations']) >= 2){

					foreach ($pivot['locations'] as &$location) {

						$sum = $location['originalPapsUsed'];

						// if($location['originalPapsUsed'] > $location['capacity']){ //Se evalua si los pallets a piso superan la capacidad para sumar la capacidad en si
						

						// 	$sum = $location['capacity'];

						// }

						$consolidableLocations[$location['location']] = [

							'idCedis' => $location['idCedis'],
							'id' => $category['id'],
							'area' => $location['area'],
							'location' => $location['location'], 
							'sku' => $pivot['sku'],
							'fecCad' => $pivot['fecCad'],
							'stowage' => $location['stowage'],
							'preLpns' => $location['originalLpnsCounter'],
							'originalPapsUsed' => $location['originalPapsUsed'],
							'capacity' => $location['capacity'],
							'consolidate' => 1,
							'sum' => $sum

						];

					}
					

				} else if(count($pivot['locations']) == 1){

					foreach ($pivot['locations'] as &$location) {					

						$consolidableLocations[$location['location']] = [

							'idCedis' => $location['idCedis'],
							'id' => $category['id'],
							'area' => $location['area'],
							'location' => $location['location'],
							'sku' => $pivot['sku'],
							'fecCad' => $pivot['fecCad'],
							'stowage' => $location['stowage'],
							'preLpns' => $location['originalLpnsCounter'],
							'originalPapsUsed' => $location['originalPapsUsed'],
							'capacity' => $location['capacity'],
							'consolidate' => 0,
							'sum' => $location['capacity']

						];

					}

				}

			}

			$category['consolidableLocations'] = $consolidableLocations;

			$this->saveConsolidableLocations($category);

		}

		/*
		* ====================================================
		* Fin de la funcion setCategoryPreData();
		* ====================================================
		*/

		/*
		* Funcion que realiza la consolidacion por Lpns desde las ubicaciones con mayor ocupacion hacia los menores
		* @param Array category
		*/

		private function consolidateCategory(&$category){

			foreach ($category['pivots'] as &$pivot) {

				$locationsCounter = count($pivot['locations']);

				for ($i=0; $i < $locationsCounter; $i++) { 
					
					for ($j= $locationsCounter - 1; $j > $i ; $j--) { 

						if(
							$pivot['locations'][$i]['availability'] > 0 
							&& $pivot['locations'][$j]['finalLpnsCounter'] > 0
							){

							$moveableLpns = min($pivot['locations'][$i]['availability'], $pivot['locations'][$j]['finalLpnsCounter']);

							$pivot['locations'][$i]['finalLpnsCounter'] += $moveableLpns;
							$pivot['locations'][$i]['availability'] -= $moveableLpns;

							$pivot['locations'][$j]['finalLpnsCounter'] -= $moveableLpns;
							$pivot['locations'][$j]['availability'] += $moveableLpns;

							$fromPallets = array(
								'idCed' => $category['idCed'],
								'idCat' => $category['id'],
								'idLoc' => $pivot['locations'][$i]['location'],
								'idFroLoc' => $pivot['locations'][$j]['location'],
								'lpn' => $moveableLpns
							);

							$toPallets = array(
								'idCed' => $category['idCed'],
								'idCat' => $category['id'],
								'idLoc' => $pivot['locations'][$j]['location'],
								'idToLoc' => $pivot['locations'][$i]['location'],
								'lpn' => $moveableLpns
							);

							array_push($pivot['locations'][$i]['from'], $fromPallets);
							array_push($pivot['locations'][$j]['to'], $toPallets);

							// if($pivot['locations'][$i]['location'] == '15-05'){

							// 	Own::d($pivot['locations'][$i]);
							// 	Own::d($pivot['locations'][$j]);

							// }

						}
						
					}

				}

			}

		}

		/*
		* ====================================================
		* Fin de la funcion consolidateCategory();
		* ====================================================
		*/

		/*
		* Funcion que genera las posiciones a piso usadas despues de la consolidacion y contabiliza los Lpns finales como comprobacion
		* @param Array category
		*/

		private function setCategoryPostPaps(&$category){

			$category['generalFinalLpnsCounter'] = 0;

			foreach ($category['pivots'] as &$pivot) {

				foreach ($pivot['locations'] as &$location) {

					$category['generalFinalLpnsCounter'] += $location['finalLpnsCounter'];

					if($location['stowage'] > 0){

						$location['finalPapsUsed'] = ceil(($location['finalLpnsCounter'] / $location['stowage']));
						
					} else {

						$location['finalPapsUsed'] = 0;
						
					}
					
				}

			}

		}

		/*
		* ====================================================
		* Fin de la funcion setCategoryPostPaps();
		* ====================================================
		*/

		/*
		* Funcion que separa las ubicaciones vacias asi como las consolidadas
		* @param Array category
		*/

		private function divideCategoryLocations(&$category){

			$category['consolidatedLocations'] = array();
			$category['postEmptyLocations'] = array();

			$category['postAvailablePallets'] = 0;

			foreach ($category['pivots'] as &$pivot) {

				foreach ($pivot['locations'] as $location) {

					$location['sku'] = $pivot['sku'];
					$location['fecCad'] = $pivot['fecCad'];

					if($location['finalPapsUsed'] <= 0){

						$emptyLocationFound = false;
						
						foreach ($category['postEmptyLocations'] as &$emptyLocation) {
							
							if($emptyLocation['location'] == $location['location']){

								foreach ($location['from'] as $from) {

									array_push($emptyLocation['from'], $from);

								}

								foreach ($location['to'] as $to) {

									array_push($emptyLocation['to'], $to);

								}

								$emptyLocationFound = true;

								break;

							}	

						}

						if($emptyLocationFound == false){
							
							$category['postAvailablePallets'] += $location['capacity'];

							array_push($category['postEmptyLocations'], $location);

						}

					} else {

						array_push($category['consolidatedLocations'], $location);

					}

				}

			}

			foreach ($category['preEmptyLocations'] as $preEmpLocation) {

				$postEmptyLocation = array(
					'idCedis' => $preEmpLocation['idCed'],
					'idCategory' => $preEmpLocation['idCat'],
					'area' => $preEmpLocation['idAre'],
					'location' => $preEmpLocation['id'],
					'capacity' => $preEmpLocation['cap'],
					'from' => array(),
					'to' => array()
				);

				$category['postAvailablePallets'] += $postEmptyLocation['capacity'];

				array_push($category['postEmptyLocations'], $postEmptyLocation);
			}

			$this->savePostEmptyLocations($category);
			$this->saveConsolidatedLocations($category);

			// $category['postEmptyLocationsCounter'] = count($category['postEmptyLocations']);
			// $category['postAvailableUnits'] = ceil($category['postAvailablePallets'] / 28);

		}

		/*
		* ====================================================
		* Fin de la funcion divideCategoryLocations();
		* ====================================================
		*/


		/*
		* Funcion que muestra las ubicaciones caoticas segun la categoria dada
		* @oaram int idCat, numero de categoria
		* @return View emptyLocations, vista de ubicaciones caoticas
		*/
		public function emptyLocations($idCed, $idCat, $pre){

			//Obtenemos los registros de ubicaciones caoticas de acuerdo a la categoria

			if($pre == 1){
				$queryCaoticLocations = "select idAre, idLoc, cap from sto_emp where idCed = " . $idCed . " and idCat = " . $idCat . " and pre = " . $pre . ";";
			} else if($pre == 0){
				$queryCaoticLocations = "select idAre, idLoc, cap from sto_emp where idCed = " . $idCed . " and idCat = " . $idCat . ";";
			}
			
			$records = Own::stdRecordsToArray(DB::select($queryCaoticLocations));

			$data = array(
				'records' => $records
			);

			return View::make('emptyLocations')->with('data', $data);

		}

		/*
		* ====================================================
		* Fin de la funcion seeCaoticLocations();
		* ====================================================
		*/

		/*
		* Funcion que almacena las ubicaciones consolidables
		* @param Array consolidableLocations, arreglo de ubicaciones consolidables
		*/

		public function saveConsolidableLocations($category){

			//Eliminamos los registros de esta categoria que se almacenaron en la pre consolidacion
			DB::table('sto_con')->where('idCed', '=', $category['idCed'])->where('idCat', '=', $category['id'])->where('pre', '=', 1)->delete();

			$records = array();

			foreach ($category['consolidableLocations'] as $consolidableLocation) {
				
				$record = array(
					
					'idCed' => $consolidableLocation['idCedis'],
					'idCat' => $consolidableLocation['id'],
					'idAre' => $consolidableLocation['area'],
					'idLoc' => $consolidableLocation['location'],
					'sku' => $consolidableLocation['sku'],
					'lot' => $consolidableLocation['fecCad'],
					'estIba' => $consolidableLocation['stowage'],
					'lpn' => $consolidableLocation['preLpns'],
					'pap' => $consolidableLocation['originalPapsUsed'],
					'cap' => $consolidableLocation['capacity'],
					'con' => $consolidableLocation['consolidate'],
					'sum' => $consolidableLocation['sum'],
					'pre' => 1

				);

				array_push($records, $record);

			}
			
			if(count($records) > 0){
			
				DB::table('sto_con')->insert($records);

			}

			//Actualizacion de las ubicaciones consolidables en la tabla de ubicaciones filtradas
			// $queries = array();

			// $queries[''] = "";

		}

		/*
		* ====================================================
		* Fin de la funcion saveConsolidableLocations();
		* ====================================================
		*/

		public function saveConsolidatedLocations(&$category){

			//Eliminamos los registros de esta categoria que se almacenaron en la post consolidacion
			DB::table('sto_con')->where('idCed', '=', $category['idCed'])->where('idCat', '=', $category['id'])->where('pre', '=', 0)->delete();

			DB::table('sto_fro')->where('idCed', '=', $category['idCed'])->where('idCat', '=', $category['id'])->delete();

			$records = array();

			$fromRecords = array();

			$toRecords = array();

			foreach ($category['consolidatedLocations'] as $consolidatedLocation) {
				
				$record = array(

					'idCed' => $consolidatedLocation['idCedis'],
					'idCat' => $consolidatedLocation['idCategory'],
					'idAre' => $consolidatedLocation['area'],
					'idLoc' => $consolidatedLocation['location'],
					'sku' => $consolidatedLocation['sku'],
					'lot' => $consolidatedLocation['fecCad'],
					'estIba' => $consolidatedLocation['stowage'],
					'lpn' => $consolidatedLocation['finalLpnsCounter'],
					'pap' => $consolidatedLocation['finalPapsUsed'],
					'cap' => $consolidatedLocation['capacity'],
					'con' => 0,
					'sum' => $consolidatedLocation['finalPapsUsed'],
					'pre' => 0

				);

				array_push($records, $record);

				if(count($consolidatedLocation['from']) > 0){

					foreach ($consolidatedLocation['from'] as $from) {
						
						array_push($fromRecords, $from);

					}

				}

				if(count($consolidatedLocation['to']) > 0){

					foreach ($consolidatedLocation['to'] as $to) {

						array_push($toRecords, $to);

					}

				}

			}

			if(count($records) > 0){
				
				DB::table('sto_con')->insert($records);

			}

			if(count($fromRecords) > 0){

				DB::table('sto_fro')->insert($fromRecords);

			}

			if(count($toRecords) > 0){

				// DB::table('sto_to')->insert($toRecords);

			}

		}

		/*
		* Funcion que almacena las ubicaciones consolidadas
		* @param Array consolidatedLocations, arreglo de ubicaciones consolidadas
		*/

		/*
		* ====================================================
		* Fin de la funcion saveConsolidatedLocations();
		* ====================================================
		*/

		/*
		* Funcion que almacena las ubicaciones vacias despues de la consolidacion
		* NOTA: Hay que tomar en cuenta que la la primer parte son aquellas que se encontraron como vacias desde
		* el principio del proceso, la segunda parte de estas ubicaciones son las que se liberan despues de la consolidacion.
		* @param Array category, categoria que dentro contiene las ubicaciones vacias despues de la consolidacion
		*/

		public function savePostEmptyLocations(&$category){
			//
			DB::table('sto_to')->where('idCed', '=', $category['idCed'])->where('idCat', '=', $category['id'])->delete();

			//Limpiamos las ubicaciones vacias en esta categoria y con el indice 'pre' en falso
			DB::table('sto_emp')->where('idCed', '=', $category['idCed'])->where('idCat', '=', $category['id'])->where('pre', '=', 0)->delete();

			//Construimos el arreglo de ubicaciones vacias con el formato de la tabla
			$records = array();

			// Own::d($category['postEmptyLocations']);

			$toRecords = array();

			foreach ($category['postEmptyLocations'] as $postEmptyLocation) {
				
				$record = array(

					'idCed' => $postEmptyLocation['idCedis'],
					'idCat' => $postEmptyLocation['idCategory'],
					'idAre' => $postEmptyLocation['area'],
					'idLoc' => $postEmptyLocation['location'],
					'cap' => $postEmptyLocation['capacity'],
					'pre' => 0

				);

				array_push($records, $record);

				if(count($postEmptyLocation['to']) > 0){

					foreach ($postEmptyLocation['to'] as $to) {
						
						array_push($toRecords, $to);
						
					}

				}

			}

			//Si el arreglo contiene informacion se almacena en la tabla
			if(count($records) > 0){
				
				DB::table('sto_emp')->insert($records);

			}

			if(count($toRecords) > 0){
				
				DB::table('sto_to')->insert($toRecords);

			}
		}

		/*
		* ====================================================
		* Fin de la funcion savePostEmptyLocations();
		* ====================================================
		*/

		/*
		* Funcion que genera y muestra la capacidad de almacenaje general
		* 
		*/
		public function generalStorage(){

			//Seleccionamos los cedis para los checkboxes
			$warehouses = Own::stdRecordsToArray(DB::select('select idCed, ced from sto_cap where con = 1 group by idCed, ced;'));

			foreach ($warehouses as &$warehouse) {

				$warehouse['categories'] = Own::stdRecordsToArray(
					DB::select('select idCat, cat from sto_cap where idCed = ' . $warehouse['idCed'] . ' and con = 1 group by idCat, cat;')
				);
				
				foreach ($warehouse['categories'] as &$category) {
					
					//Obtenemos la capacidad de las ubicaciones caoticas
					$category['lpnsCounter'] = DB::table('sto_cap')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('matPri', '=', 0)
															->count('lpn');


					$category['caoticCapacity'] = DB::table('sto_cao')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->sum('cap');

					$category['prePaps'] = DB::table('sto_con')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('pre', '=', 1)
															->sum('sum');

					$category['preConsolidationPaps'] = DB::table('sto_con')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('pre', '=', 1)
															->sum('pap');

					$category['postConsolidationPaps'] = DB::table('sto_con')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('pre', '=', 0)
															->sum('pap');

					$category['postPaps'] = DB::table('sto_con')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('pre', '=', 0)
															->sum('pap');

					$category['preCapacity'] = DB::table('sto_con')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('pre', '=', 1)
															->sum('cap');

					$category['postCapacity'] = DB::table('sto_con')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('pre', '=', 0)
															->sum('cap');

					$category['preEmptyLocations'] = DB::table('sto_emp')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('pre', '=', 1)
															->count();

					$category['postEmptyLocations'] = DB::table('sto_emp')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->count();

					$category['preEmptyPaps'] = DB::table('sto_emp')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->where('pre', '=', 1)
															->sum('cap');

					$category['postEmptyPaps'] = DB::table('sto_emp')
															->where('idCed', '=', $warehouse['idCed'])
															->where('idCat', '=', $category['idCat'])
															->sum('cap');

					$category['preCapacities'] = Own::queryToArray(
						"select

							emp,

							case emp
							when 1 then 'Disponible'
							when 2 then 'Consolidables'
							when 3 then 'Virtuales'
							when 4 then 'Caoticas'
							end as 'ocu',

							sum(cap) as 'cap'

						from sto_fil_loc
						where idCed = " . $warehouse['idCed'] . "
						and idCat = " . $category['idCat'] . "
						group by emp;"
					);



					$category['totalCapacity'] = Own::stdRecordsToArray(
						DB::select('SELECT sum(cap) as "totalCapacity"
							FROM sto_fil_loc
							WHERE idCed = ' . $warehouse['idCed'] . ' 
							and idCat = ' . $category['idCat'] . ';'
						)
					);
				}

			}

			$data = array(
				'warehouses' => $warehouses
			);

			//Generamos la vista
			return View::make('generalStorage')->with('data', $data);

		}

		/*
		* ====================================================
		* Fin de la funcion generalStorage();
		* ====================================================
		*/

		/*
		* Funcion que genera los cedis existentes en la base de almacenaje
		* @return Array warehouses, arreglo con los numeros de cedis
		*/

		private function getWarehouses(){

			$warehouses = Own::stdRecordsToArray(DB::select('select idCed, ced from sto_cap where con = 1 group by idCed;'));

			return $warehouses;

		}

		/*
		* ====================================================
		* Fin de la funcion getWarehouses();
		* ====================================================
		*/

		public function movedLpns($idCed, $idCat){



		}

		/*
		* Funcion que muestra los skus de aquellas ubicaciones en las que la existencia supera la capacidad a piso
		* @return View caoticStowages, vista con los posibles skus con estiba incorrecta
		*/

		public function caoticStowages(){

			$caoticStowages = Own::stdRecordsToArray(
				DB::select('select sku, estIba from sto_con where pre = 1 and pap > cap group by sku, estIba;')
			);

			return View::make('caoticStowages')->with('caoticStowages', $caoticStowages);

		}

		/*
		* ====================================================
		* Fin de la funcion caoticStowages();
		* ====================================================
		*/

		/*
		* Funcion que muestra el comportamiento de la consolidacion
		* @param int $idCed, id del cedis
		* @param int $idCat, id de la categoria
		* @param int $pre, bandera que indica si es antes o despues de la optimizacion
		* @return View consolidableLocations, vista con el comportamiento de las consolidaciones
		*/

		public function consolidableLocations($idCed, $idCat, $pre){

			$records = Own::stdRecordsToArray(
				DB::select(
					"SELECT idAre, idLoc, sku, lot, estIba, lpn, pap, cap, con, sum
					FROM sto_con
					WHERE idCed = $idCed
					AND idCat = $idCat
					AND pre = $pre;"
				)
			);

			$data = array(
				'idCed' => $idCed,
				'idCat' => $idCat,
				'pre' => $pre,
				'records' => $records
			);

			return View::make('consolidableLocations')->with('data', $data);

		}

		/*
		* ====================================================
		* Fin de la funcion consolidableLocations();
		* ====================================================
		*/

		/*
		* Funcion que muestra las ubicaciones caoticas
		* @param int $idCed, id del cedis
		* @param int $idCat, id de la categoria
		* @return View caoticLocations, vista con con las ubicaciones caoticas
		*/

		public function caoticLocations($idCed, $idCat){

			$records = Own::queryToArray(
				"SELECT idAre, idLoc, cap, lpn 
				FROM sto_cao
				WHERE idCed = $idCed
				AND idCat = $idCat;
				"
			);

			$data = array(
				'records' => $records
			);

			return View::make('caoticLocations')->with('data', $data);

		}

		/*
		* ====================================================
		* Fin de la funcion caoticLocations();
		* ====================================================
		*/

		/*
		* Funcion que muestra a detalle una ubicacion caotica
		* @param int $id, id de la ubicacion
		* @return View caoticLocation, vista con con el detalle de la ubicacion
		*/

		public function caoticLocation($id){

			$query = "select ced, are, cat, con, lpn, sku, fecCad, uniMed, can, lot, matPri, vir
				from sto_cap where ubi = '" . $id . "';";

			$records = Own::queryToArray(
				$query
			);

			$data = array(
				'id' => $id,
				'records' => $records
			);

			return View::make('caoticLocation')->with('data', $data);

		}

		/*
		* ====================================================
		* Fin de la funcion caoticLocation();
		* ====================================================
		*/

		/*
		* Funcion que muestra las areas virtuales
		* @return View virtualAreas, vista con con las areas virtuales
		*/

		public function virtualAreas(){

			$records = Own::queryToArray('select id, idCed from sto_vir_are;');

			return View::make('virtualAreas')->with('records', $records);

		}

		/*
		* ====================================================
		* Fin de la funcion virtualAreas();
		* ====================================================
		*/

		/*
		* Funcion que muestra las ubicaciones
		* @return View locations, vista con con las ubicaciones
		*/

		public function locations(){

			$records = Own::queryToArray('select id, idAre, cap, perEst from sto_loc;');

			return View::make('locations')->with('records', $records);

		}

		/*
		* ====================================================
		* Fin de la funcion locations();
		* ====================================================
		*/

		/*
		* Funcion que muestra las ubicaciones
		* @return View locations, vista con con las ubicaciones
		*/

		public function areas(){

			$records = Own::queryToArray('select id, idCed, idCat from sto_are;');

			return View::make('areas')->with('records', $records);

		}

		/*
		* ====================================================
		* Fin de la funcion locations();
		* ====================================================
		*/

		/*
		* Funcion que muestra las ubicaciones
		* @return View locations, vista con con las ubicaciones
		*/

		public function totalCapacity($idCet, $idCat){

			$records = Own::queryToArray('select idAre, idLoc, cap, emp from sto_fil_loc where idCed = ' . $idCet . ' and idCat = ' . $idCat . ';');

			return View::make('totalCapacity')->with('records', $records);

		}

		/*
		* ====================================================
		* Fin de la funcion locations();
		* ====================================================
		*/

		public function showTasks($idCed, $idCat){

			$query = "select idLoc, idFroLoc, lpn
					from sto_fro
					where idCed = " . $idCed . "
					and idCat = " . $idCat . "
					order by idLoc, lpn;";

			$fromRecords = Own::queryToArray($query);

			$query = "select idLoc, idToLoc, lpn
					from sto_to
					where idCed = " . $idCed . "
					and idCat = " . $idCat . "
					order by idLoc, lpn;";

			$toRecords = Own::queryToArray($query);

			$data = array(
				'toRecords' => $toRecords,
				'fromRecords' => $fromRecords
			);

			return View::make('tasks')->with('data', $data);

		}

	}

?>