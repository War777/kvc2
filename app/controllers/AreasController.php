<?

	/**
	* Controlador de ubicciones
	*/
	class AreasController extends BaseController
	{

		public function viewAreas(){

			$warehouses = DB::table('sto_war')->get();					//Obtenemos los almacenes

			$warehousesList = array();									//Los convertimos a un arreglo

			foreach ($warehouses as $warehouse) {

				$warehouseOption = array(
					'value' => $warehouse->cla,
					'text' => $warehouse->des
				);

				array_push($warehousesList, $warehouseOption);

			}

			$categories = DB::table('sto_cat')->get();					//Obtenemos las categorias

			$categoriesList = array();

			foreach ($categories as $categorie) {						//Las convertimos a un arreglo

				$categorieOption = array(
					'value' => $categorie->con,
					'text' => $categorie->cat
				);

				array_push($categoriesList, $categorieOption);

			}

			$area = array(
				'type' => 'text',
				'name' => 'are',
				'placeholder' => 'Area',
				'required' => true
			);

			$warehouses = array(
				'type' => 'select',
				'name' => 'claAlm',
				'values' => $warehousesList
			);

			$categories = array(
				'type' => 'select',
				'name' => 'cat',
				'values' => $categoriesList
			);

			$lanes = array(
				'type' => 'numeric',
				'name' => 'car',
				'placeholder' => 'Carriles',
				'required' => true
			);

			$pap = array(
				'type' => 'numeric',
				'name' => 'pap',
				'placeholder' => 'Posiciones a piso',
				'required' => true
			);


			$formData = array(
				'controller' => 'AreasController@addArea',
				'inputs' => array($area, $warehouses, $categories, $lanes, $pap)
			);

			return View::make('areas')->with('formData', $formData);

		}

		public function viewAreaCetegories(){

			$areaCategory = array(
				'type' => 'text',
				'name' => 'areCat',
				'placeholder' => 'Categoria',
				'required' => true
			);

			$itCounts = array(
				'type' => 'select',
				'name' => 'con',
				'values' => array('0'=>'No', '1' => 'Si')
			);

			$formData = array(
				'controller' => 'AreasController@addAreaCategory',
				'inputs' => array($areaCategory, $itCounts)
			);

			return View::make('areaCategories')->with('formData', $formData);

		}

		public function addAreaCategory($data){

			$cat = $data['inputs']['areCat'];
			$con = $data['inputs']['con'];

			$category = AreaCategories::firstOrCreate(['cat' => $cat]);

			$category->con = $con;
			$category->cat = $cat;

			$category->save();

			return Own::d($category);

		}

	}

?>