<?

	/**
	* Modelo para las categorias de area
	*/

	class AreaCategories extends Eloquent
	{
		
		use SoftDeletingTrait;

		protected $table = 'sto_cat';

		protected $date = ['deleted_at'];

		protected $fillable = array('des', 'con');
		
	}

?>