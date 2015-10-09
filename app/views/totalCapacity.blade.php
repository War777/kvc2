@extends('layout')

@section('title')
	Capacidad total
@stop

@section('h1')
	Capacidad total
@stop

@section('content')

	@if(count($records) > 1)
		
		<table class="table table-hover table-bordered table-condensed">
			<thead class="bg-info" align="center">
				<td>Area</td>
				<td>Ubicacion</td>
				<td>Capacidad</td>
				<td>¿Vacia?</td>
			</thead>

		@foreach($records as $record)
			
			<tr align="center">
				<td>'{{ $record['idAre'] }} </td>
				<td>'{{ $record['idLoc'] }} </td>
				<td> {{ $record['cap'] }} </td>

			<?
				switch ($record['emp']) {
					case 1:
							echo '<td>Vacia</td>';
						break;

					case 2:
							echo '<td>Consolidable</td>';
						break;

					case 3:
							echo '<td>Virtual</td>';
						break;

					case 4:
							echo '<td>Caotica</td>';
						break;

					default:
							echo '<td>No definida</td>';
						break;
				}
			?>


				
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