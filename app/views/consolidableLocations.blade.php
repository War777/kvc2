@extends('layout')

@section('title')
	Ubicaciones por consolidar
@stop

@section('h1')
	Ubicaciones por consolidar
@stop

@section('content')

	@if($data['records'])
	
		<table class="table table-condensed table-bordered">

			<thead class="bg-info" align="center">
				<td>Area</td>
				<td>Ubicacion</td>
				<td>Sku</td>
				<td>Lote</td>
				<td>Estiba</td>
				<td>Lpns</td>
				<td>Paps</td>
				<td>Capacidad</td>
				<td>¿Consolida?</td>
				<td>Suma a Pallets</td>
			</thead>

			@foreach($data['records'] as $record)

				<tr>
					<td class="text-center">'{{ $record['idAre'] }}</td>
					<td class="text-center">'{{ $record['idLoc'] }}</td>
					<td class="text-center">{{ $record['sku'] }}</td>
					<td class="text-right">{{ str_pad($record['lot'], 4, '0', STR_PAD_LEFT)  }}</td>
					<td class="text-right">{{ $record['estIba'] }}</td>
					<td class="text-right">{{ $record['lpn'] }}</td>
					<td class="text-right">{{ $record['pap'] }}</td>
					<td class="text-right">{{ $record['cap'] }}</td>
					
					@if($record['con'] == 1)

						<td class="text-center"> Si </td>

					@else

						<td class="text-center"> No </td>

					@endif
					
					@if(($record['sum'] - $record['cap']) > 5)
						
						<td class="text-right bg-danger">{{ $record['sum'] }}</td>

					@else
						
						<td class="text-right">{{ $record['sum'] }}</td>

					@endif
					

				</tr>

			@endforeach

		</table>

	@endif

@stop

@section('localScript')
	
@stop