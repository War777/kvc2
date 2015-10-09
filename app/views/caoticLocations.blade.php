@extends('layout')

@section('title')
	Ubicaciones caoticas
@stop

@section('h1')
	Ubicaciones caoticas
@stop

@section('content')


	@if($data['records'])
	
		<table class="table table-condensed table-bordered">

			<thead class="bg-danger" align="center">
				<td>Area</td>
				<td>Ubicacion</td>
				<td>Capacidad</td>
				<td>Lpns</td>
			</thead>

			@foreach($data['records'] as $record)

				<tr>
					<td class="text-center">'{{ $record['idAre'] }}</td>
					<td class="text-center">
						<a href="../../caoticLocation/{{ $record['idLoc'] }}">
							'{{ $record['idLoc'] }}
						</a>
					</td>
					<td class="text-right">{{ $record['cap'] }}</td>
					<td class="text-right">{{ $record['lpn'] }}</td>

				</tr>

			@endforeach

		</table>

	@endif

@stop

@section('localScript')
	
@stop