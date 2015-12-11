<?

	/**
	* 
	*/
	class RepositoriesController extends BaseController
	{
		
		public function showStock(){

			$records = Own::queryToArray(
				"SELECT can as 'Cantidad',
				    sku as 'Sku',
				    skuDes as 'Descripcion',
				    est as 'Estatus',
				    alm as 'Almacen',
				    ubi as 'Ubicacion',
				    are as 'Area',
				    batLot as 'Batch (Lote)',
				    fecCad as 'F. caducidad',
				    ori as 'Origen',
				    var as 'Variante',
				    uniMed as 'U. medida',
				    idEnt as 'Id entrada',
				    lpn as 'Lpn',
				    con as 'Contenedor',
				    tip as 'Tipo',
				    cla2 as 'Calsificacion 2',
				    cla3 as 'Clasificacion 3',
				    acoRec as 'Acomodo recibido',
				    surEmb as 'Surtir embarque',
				    surPic as 'Surtir picking'
				FROM sto_mac
				LIMIT 20;"
			);

			$lastUpdate = Own::queryToSingleArray(
				"SELECT usu, dat
				FROM kvm_eve
				WHERE tab = 'sto_vir_loc'
				ORDER BY dat DESC
				LIMIT 1;"
			);

			$data = array(
				'records' => $records
			);

			return View::make('stock')->with('data', $data);

		}

		public function showStockMp(){

			$records = Own::queryToArray(
				"SELECT can as 'Cantidad',
				    sku as 'Sku',
				    skuDes as 'Descripcion',
				    est as 'Estatus',
				    alm as 'Almacen',
				    ubi as 'Ubicacion',
				    are as 'Area',
				    batLot as 'Batch (Lote)',
				    fecCad as 'F. caducidad',
				    ori as 'Origen',
				    var as 'Variante',
				    uniMed as 'U. medida',
				    idEnt as 'Id entrada',
				    lpn as 'Lpn',
				    con as 'Contenedor',
				    tip as 'Tipo',
				    cla2 as 'Calsificacion 2',
				    cla3 as 'Clasificacion 3',
				    acoRec as 'Acomodo recibido',
				    surEmb as 'Surtir embarque',
				    surPic as 'Surtir picking'
				FROM sto_mat
				LIMIT 20;"
			);

			$data = array(
				'records' => $records
			);

			return View::make('stockMp')->with('data', $data);

		}
		
	}

?>