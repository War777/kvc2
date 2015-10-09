<?

	class Event extends Eloquent{
		
		protected $table = 'sto_eve';

		protected $primaryKey = null;

		protected $fillable = array('use', 'tab', 'dat');
		
		public $incrementing = false;

	}

?>