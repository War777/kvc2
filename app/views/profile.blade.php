@extends('layout')

@section('title')
	Perfil
@stop

@section('h1')
	Perfil
@stop

@section('content')
	
	<div class="row">
		<div class="col-sm-12 text-center">
			
			<img src="i/user.png" class="img-circle">

			<h3> {{ $data['user'] }} </h3>

		</div>

	</div>
	
	<div class="row">
		<div class="col-sm-12">
			<legend>
				Mis usuarios
				
				<button type="button" id="addUser" class="btn btn-xs pull-right">
					click me
				</button>

			</legend>

			<div class="row">
				
				

			</div>

				
			@if(count($data['myUsers']) > 0)
			
			@else
				<br>
				<p class="text-center">
					Sin usuarios registrados
				</p>
			@endif

		</div>
	</div>

	{{-- Inicio del modal para el estado de carga --}}

	<div class="modal fade" id="userModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
		<div class="modal-dialog" role="document">
			
			<div class="modal-content">
				
				<div class="modal-header">
					
					<h4 class="modal-title" id="myModalLabel">Agregar usuario</h4>
					
				</div>
				
				<div class="modal-body">				

					<div class="row">

						<div class="col-sm-12">
							
							<input type="text" class="form-control" placeholder="Usuario" required="required">
						
							<br>
							<input type="password" class="form-control" placeholder="Contrase&ntilde;a" required="required">
						
							<br>
							<input type="password" class="form-control" placeholder="Confirmar contrase&ntilde;a" required="required">
							
							<br>
							<input type="email" class="form-control" placeholder="E-mail" required="required">

							<br>
							
							<p class="text-right">

								<button type="button">
									<i class="glyphicon glyphicon-remove"></i>
								</button>
								
								<button type="button">
									<i class="glyphicon glyphicon-ok"></i>
								</button>

								
							</p>

						</div>
						
					</div>


				</div>

			</div>

		</div>

	</div>

	{{-- Fin del modal para el estado de carga --}}
@stop

@section('localScript')
	
	<script>

		$(document).ready(function(){

			$('#addUser').click(function(){

				$('#userModal').modal('show');

			});

		});
		
	</script>
	
@stop