@extends('layout')

@section('title')
	Perfil
@stop

@section('h1')
	Perfil
@stop

@section('content')
	
	<div class="row">

		<div class="col-sm-12">

			<legend>
				
				Rangos actuales
				
				<button type="button" id="openRangeModal" class="btn btn-info btn-xs pull-right">
					<i class="glyphicon glyphicon-plus"></i>
				</button>

			</legend>
				
			@if(count($data['records']) > 0)
				
				<table class="table table-condensed table-bordered table-hover">

					<thead align="center" class="bg-info">
						<td>Usuario</td>
						<td>Responsable directo</td>
						<td>Limite</td>
						<td></td>
					</thead>

					@foreach($data['records'] as $record)

						<tr>
							<td class="use"> {{ $record['use'] }}</td>
							
							@if($record['res'] == 1)

								<td class="res text-center">Si</td>

							@else

								<td class="res text-center">No</td>

							@endif



							<td class="lim text-right"> {{ $record['lim'] }}</td>
							<td class="text-center">
								<button id="{{ $record['id'] }}" class="deleteUser btn btn-danger btn-xs">
									<i class="glyphicon glyphicon-remove"></i>
								</button>
								<button id="{{ $record['id'] }}" class="editRange btn btn-info btn-xs">
									<i class="glyphicon glyphicon-edit"></i>
								</button>
							</td>
						</tr>

					@endforeach

				</table>

			@else
				<br>
				<p class="text-center">
					Sin rangos registrados
				</p>
			@endif

		</div>

	</div>

	{{-- Inicio del modal para el estado de carga --}}

	<div class="modal fade" id="rangeModal" userId="-1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
		<div class="modal-dialog" role="document">
			
			<div class="modal-content">
				
				<div class="modal-header">
					
					<h4 class="modal-title" id="myModalLabel">Agregar rango</h4>
					
				</div>
				
				<div class="modal-body">				

					<div class="row">

						<div class="col-sm-12">

							<form action="" rangeId="-1" method="post" id="rangeForm" isResponsable="No" mode="0">

								<h4 id="userTitle"></h4>

								<div id="selectContainer">
							
									<select class="form-control" id="userSelect">

										@foreach($data['users'] as $user)

											<option value="{{$user['id']}}"> {{ $user['user'] }} </option>

										@endforeach
									
									</select>

								</div>
								
								<br>
								
								<input type="number" id="lim" class="form-control" placeholder="Unidades minimas" required="required">
								
								<br>

								<input type="checkbox" id="res"> Responsable directo
							
								<br>

								<p class="text-right">

									<button type="button" id="closeRangeModal" class="btn btn-danger btn-xs">
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

			$('#openRangeModal').click(function(){

				$('#userTitle').hide('fast');
				$('#selectContainer').show('fast');
				$('#rangeForm').attr('mode', '1');
				$('#rangeModal').modal('show');

			});

			$('#closeRangeModal').click(function(){

				$('#rangeForm').reset();
				$('#rangeForm').attr('mode', '0');

				$('#rangeModal').modal('hide');

			});

			$('.editRange').click(function(){

				var id = $(this).attr('id');
				var use = $(this).closest('tr').find('.use').text();
				var res = $(this).closest('tr').find('.res').text();
				var lim = $(this).closest('tr').find('.lim').text();

				$('#userTitle').text(use).show('fast');
				$('#selectContainer').hide('fast');
				
				$('#rangeForm').attr('rangeId', id);
				$('#rangeForm').attr('isResponsable', res);
				$('#rangeForm').attr('mode', '2');

				$('#rangeModal').modal('show');

			});

			$('#rangeForm').submit(function(e){

				e.preventDefault();
				
				var route = '';

				var mode = $(this).attr('mode');
				
				var id = '';
				var res = '';
				var lim = $('#lim').val();

				if(mode == 1){
					
					route = 'addRange';
					id = $('#userSelect option:selected').val();
					res = $('#res').is(':checked');

				} else if(mode == 2){

					route = 'updateRange';
					id = $(this).attr('rangeId');
					res = $('#res').is(':checked');

				}

				$.ajax({

					'url' : route,
					'method' : 'POST',
					'dataType' : 'json',
					'data' : {
						'id' : id,
						'res' : res,
						'lim' : lim
					},
					beforeSend: function(){

					},
					success: function(response){
						
						alert(response.responseText);
						location.reload();
						l(response);

					},
					error: function(response){

						l(response);

					}

				});

			});

		});
		
	</script>
	
@stop