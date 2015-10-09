<?
	
	/**
	* 
	*/
	class UsersController extends BaseController
	{
		
		public function showProfile(){

			$myUsers = Own::queryToArray("select * from users where headUser ='" . Auth::user()->user . "';");

			$data = array(
				'user' => Auth::user()->user,
				'myUsers' => $myUsers
			);

			return View::make('profile')->with('data', $data);

		}
		
	}

?>