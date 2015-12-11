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
				
				<button type="button" id="openUserModal" class="btn btn-info btn-xs pull-right">
					<i class="glyphicon glyphicon-plus"></i>
				</button>

			</legend>
				
			@if(count($data['myUsers']) > 0)
				
				<table class="table table-condensed table-bordered table-hover">

					<thead align="center" class="bg-info">
						<td>Usuario</td>
						<td>E-mail</td>
						<td>Fecha de creaci&oacute;n</td>
						<td>Ultima modificaci&oacute;n</td>
						<td></td>
					</thead>

					@foreach($data['myUsers'] as $user)

						<tr>
							<td class="user"> {{ $user['user'] }}</td>
							<td class="email text-center"> {{ $user['email'] }}</td>
							<td class="text-right"> {{ $user['created'] }}</td>
							<td class="text-right"> {{ $user['updated'] }}</td>
							<td class="text-center">
								<button id="{{ $user['id'] }}" class="deleteUser btn btn-danger btn-xs">
									<i class="glyphicon glyphicon-remove"></i>
								</button>
								<button id="{{ $user['id'] }}" class="editUser btn btn-info btn-xs">
									<i class="glyphicon glyphicon-edit"></i>
								</button>
							</td>
						</tr>

					@endforeach

				</table>

			@else
				<br>
				<p class="text-center">
					Sin usuarios registrados
				</p>
			@endif

		</div>
	</div>

	{{-- Inicio del modal para el estado de carga --}}

	<div class="modal fade" id="userModal" userId="-1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
		<div class="modal-dialog" role="document">
			
			<div class="modal-content">
				
				<div class="modal-header">
					
					<h4 class="modal-title" id="myModalLabel">Agregar usuario</h4>
					
				</div>
				
				<div class="modal-body">				

					<div class="row">

						<div class="col-sm-12">

							<form action="" method="post" id="userForm" mode="0">
								
								<input type="text" id="user" class="form-control" placeholder="Usuario" required="required">
							
								<br>
								<input type="password" id="password" class="form-control" placeholder="Contrase&ntilde;a" required="required">
							
								<br>
								<input type="password" id="confirmPassword" class="form-control" placeholder="Confirmar contrase&ntilde;a" required="required">
								
								<br>
								<input type="email" id="email" class="form-control" placeholder="E-mail" required="required">

								<br>

								<p class="text-right">

									<button type="button" id="closeUserModal" class="btn btn-danger btn-xs">
										<i class="glyphicon glyphicon-remove"></i>
									</button>
									
									<button type="submit" class="btn btn-info btn-xs">
										<i class="glyphicon glyphicon-ok"></i>
									</button>

								</p>

							</form>

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

			jQuery.fn.reset = function(){

				$(this).each(function(){ this.reset(); });

			}

			$('#openUserModal').click(function(){

				$('#userModal').modal('show');
				$('#userForm').attr('mode', '1');

			});

			$('#closeUserModal').click(function(){

				$('#userForm').reset();
				$('#userForm').attr('mode', '0');

				$('#userModal').modal('hide');

			});

			$('.editUser').click(function(){

				var id = $(this).attr('id');
				var user = $(this).closest('tr').find('.user').text();
				var email = $(this).closest('tr').find('.email').text();

				$('#user').val(user).attr('disabled', true);
				$('#email').val(email);
				
				$('#userForm').attr('userId', id);
				$('#userForm').attr('mode', '2');

				$('#userModal').modal('show');

			});

			$('#userForm').submit(function(e){

				e.preventDefault();
				
				var mode = $(this).attr('mode');

				var password = $('#password').val();
				var confirmPassword = $('#confirmPassword').val();

				var route = '';
				var id = $(this).attr('userId');

				if(mode == 1){
					route = 'addUser';
				} else if(mode == 2){
					route = 'updateUser';
				}

				if(password == confirmPassword){

					var user = $('#user').val();
					var email = $('#email').val();

					$.ajax({

						'url' : route,
						'method' : 'POST',
						'dataType' : 'json',
						'data' : {
							'id' : id,
							'user' : user,
							'password' : password,
							'email' : email
						},
						beforeSend: function(){

						},
						success: function(response){

							if(response.userExists == false){

								alert(response.responseText);
								location.reload();
								
							} else {

								alert('Usuario y/o email ya existente');

							}


						},
						error: function(response){

							l(response);

						}

					});
					
				} else {

					alert('Las contrase\u00f1as no coinciden');
					$('#password').focus();

				}


			});

		});
		
	</script>
	
@stop