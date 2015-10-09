<? 
	/**
	* Controlador para la autenticacion
	*/
	class AuthController extends BaseController
	{
		
		//Funcion para mostrar el formulario de login
		public function showLogin(){
			
			//Verificamos si ya esta autenticado
			if(Auth::check()){

				//Si esta autenticado lo mandamos a la raiz, el inicio
				return Redirect::to('/');
			} else {

				//Si no lo mandamos al formulario de login
				return View::make('login');

			}
		}

		//Funcion para el Post
		public function postLogin(){

			//Guardamos los datos recibidos
			$userdata = array(
				'user' => Input::get('username'),
				'password' => Input::get('password')
			);

			//Validamos los datos y mandamos como segundo parametro la opcion de recordar usuario
			if(
				Auth::attempt(
					$userdata,
					Input::get('remember-me', 0)
				)
			){
				//Si son validos nos mandara al inicio
				return Redirect::to('/');
			} else {

				//En caso de que no sean validos los datos nos mandara de nuevo al login con un mensaje de error
				return Redirect::to('/login')
										->with('mensaje_error', 'Usuario y/o contrase&ntilde;a incorrecta')
										->withInput();

			}

		}

		public function logout(){
			
			Auth::logout();

			return Redirect::to('login')
							->with('mensaje_error', 'Tu sesión ha sido cerrada');
		}
		
	}
?>