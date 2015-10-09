@extends('layout')

@section('title')
	Ubicaciones
@stop

@section('h1')
	Ubicaciones
@stop

@section('content')

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_loc"
		periodExists = "false"
		requiredFile="Diccionario de ubicaciones"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Actualizar
	</button>

	<br>
	<br>

	@if(count($records) > 1)
		
		<table class="table table-hover table-bordered table-condensed">

			<thead class="bg-info" align="center">
				<td>
					Area
				</td>
				<td>
					Ubicacion
				</td>
				<td>
					Capacidad
				</td>
				<td>
					¿Permite estiba?
				</td>

			</thead>

		@foreach($records as $record)
			
			<tr align="center">

				<td>
					'{{ $record['idAre'] }} 
				</td>
				<td>
					'{{ $record['id'] }}
					<button type="button">
						x
					</button>
				</td>
				<td> 
					{{ $record['cap'] }} 
				</td>

				@if($record['perEst'] == 1)

					<td> 
						Si
					</td>

				@else

					<td>
						No
					</td>

				@endif
				
			</tr>

		@endforeach

		</table>
	
	@else
		
		<center>

			<p class="bg-danger">
				Diccionario vacio
			</p>

		</center>

	@endif

@stop

@section('localscript')
	
	<script>

		$(document).ready(function(){



		});
		
	</script>

@stop