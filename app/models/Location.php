<?

	/**
	* Clase para el manejo de la consolidacion por ubicacion
	*/

	class Locations extends Eloquent
	{

		use softDeletingTrait;

		protected $table = 'sto_loc';

		protected $date = ['deleted_at'];

		protected $fillable = array('are', 'des', 'con', 'car', 'pap');

	}

?>