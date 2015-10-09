<?

	class Warehouse extends Eloquent{
		
		use SoftDeletingTrait;

		protected $table = 'sto_war';

		protected $date = ['deleted_at'];

		protected $fillable = array('cla', 'des');
		
		public $incrementing = false;

		public $primaryKey = 'cla';


	}

?>