@extends('layout')

@section('title')
	Ubicaciones disponibles
@stop

@section('h1')
	Ubicaciones disponibles
@stop

@section('content')
	
	@if($data['records'])

		<table class="table table-condensed table-bordered table-hover">

			<thead class="bg-info">
				<td>Area</td>
				<td>Ubicacion</td>
				<td>Capacidad</td>
			</thead>
			
			@foreach($data['records'] as $record)

				<tr>
					<td>'{{ $record['idAre'] }} </td>
					<td>'{{ $record['idLoc'] }} </td>
					<td> {{ $record['cap'] }} </td>
				</tr>

			@endforeach

		</table>

	@endif

	
	
@stop

@section('localScript')
	
	

@stop