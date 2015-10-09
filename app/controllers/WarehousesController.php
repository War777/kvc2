<?

	/**
	* Controlador de almacenes
	*/
	class WarehousesController extends BaseController
	{
		
		/*
		*	Funcion para agregar un nuevo almacen 
		*	@parametro 	array 		atributes 	Atributos del almacen
		* 	@returns 	Warehouse 	almacen		Almacen agregado
		*/
		public function addWarehouse($data){

			$cla = $data['inputs']['cla'];

			$user = Warehouse::firstOrCreate(['cla' => $cla]);

			$user->des = $data['inputs']['des'];

			$user->save();

			return $user;

		}

		public function viewWarehouses(){

			//Definimos el arreglo de inputs
			$cla = array(
				'type' => 'text',
				'name' => 'cla',
				'placeholder' => 'Clave',
				'required' => true
			);

			$des = array(
				'type' => 'text',
				'name' => 'des',
				'placeholder' => 'Descripcion',
				'required' => true
			);

			$formData = array(
				'controller' => 'WarehousesController@addWarehouse',
				'inputs' => array($cla, $des)
			);

			//Creamos la vista pasando el arreglo de inputs
			return View::make('warehouses')->with('formData', $formData);

		}
		
	}

?>