<?
	
	/**
	* 
	*/
	class UsersController extends BaseController
	{
		
		public function showProfile(){

			$myUsers = Own::queryToArray("select id, user, email, created_at as 'created', updated_at as 'updated' from users where headUser ='" . Auth::user()->user . "';");

			$data = array(
				'user' => Auth::user()->user,
				'myUsers' => $myUsers
			);

			return View::make('profile')->with('data', $data);

		}

		public function addUser($id, $user, $password, $email){

			$userExists = false;

			if (
				count(
					DB::select("select user from users where user = '" . $user . "' or email = '" . $email . "';")
				) > 0
			) {

				$userExists = true;

			} else {

				$newUser = new User;
				$newUser->user = $user;
				$newUser->password = Hash::make($password);
				$newUser->email = $email;
				$newUser->headUser = Auth::user()->user;
				$newUser->save();

			}
						
			$response = array(
				'responseText' => 'Usuario agregado con exito.',
				'userExists' => $userExists,
			);

			return $response;

		}

		public function updateUser($id, $user, $password, $email){

			$user = User::find($id);
			$user->password = Hash::make($password);
			$user->email = $email;
			$user->save();

			$response = array(
				'userExists' => false, 
				'responseText' => 'Usuario actualizado con exito.'
			);

			return $response;

		}

		public function sendStorageMails(){

			$data = array(
				'user' => 'war',
				'email' => 'oscar.resendiz@kellogg.com'
			);

			echo Mail::send('storageMail', array('user' => $data['user']), function($message) use ($data){
		        $message->to($data['email'], $data['user'])->subject('Adevertencia de almacenaje');
		    });

		}
		
	}

?>