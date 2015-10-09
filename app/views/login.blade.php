<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>
		@yield('title', 'KVC')
	</title>
	{{ HTML::style('c/bootstrap.css'); }}
	{{ HTML::style('c/bootstrap-theme.css'); }} 
	{{ HTML::style('c/mainStyles.css'); }} 
</head>
<body class="">
	
	@if(Session::has('mensaje_error'))

	@endif

	<div class="row">
		<div class="col-lg-12 hidden-sm hidden-xs">
			<br>
			<br>
			<br>
			<br>
			<br>
		</div>
	</div>
	
	<div class="row">
		
		<div class="col-sm-offset-4 col-sm-4">
				
			<center>
				
				<img src="i/kmdc.jpg" class="img-responsive">

				<h1>Iniciar sesi&oacute;n</h1>

			</center>

			@if(Session::has('mensaje_error'))
                <div class="alert alert-danger">{{ Session::get('mensaje_error') }}</div>
            @endif

            {{ 
				Form::open(
					array(
						'url' => '/login'
					)
				)
			}}

			<br>

			<div class="form-group">
		        {{ Form::label('usuario', 'Nombre de usuario') }}
		        {{ Form::text('username', Input::old('username'), array('class' => 'form-control')); }}
		    </div>

			<div class="form-group">
		        {{ Form::label('contraseña', 'Contraseña') }}
		        {{ Form::password('password', array('class' => 'form-control')); }}
		    </div>

	        {{ Form::checkbox('rememberme', true) }} Recordarme
		    
		</div>
		
	</div>

	<div class="row">
		
		<div class="col-sm-offset-4 col-sm-4 text-center">
			
			{{ Form::reset('Cancelar', array('class' => 'btn btn-danger')) }}
			{{ Form::submit('Enviar', array('class' => 'btn btn-primary')) }}
			{{ Form::close() }}

		</div>

	</div>

</body>
</html>

{{ HTML::script('j/jquery-2.1.1.js'); }}
{{ HTML::script('j/bootstrap.js'); }}
{{ HTML::script('j/mainFunctions.js'); }}