@extends('layout')

@section('title')
	Ubicacion caotica
@stop

@section('h1')
	Ubicacion caotica
@stop

@section('content')

	<h3>Id: {{ $data['id'] }} </h3>

	<legend>Detalle</legend>

	@if($data['records'])
	
		<table class="table table-condensed table-bordered">

			<thead class="bg-danger" align="center">
				<td>Cedis</td>
				<td>Area</td>
				<td>Categoria</td>
				<td>Lpn</td>
				<td>Sku</td>
				<td>Lote</td>
				<td>Cantidad</td>
				<td>¿Es virtual?</td>
			</thead>

			@foreach($data['records'] as $record)

				<tr>
					<td>{{ $record['ced'] }}</td>
					<td>{{ $record['are'] }}</td>
					<td>{{ $record['cat'] }}</td>

					<td>{{ $record['lpn'] }}</td>
					<td>{{ $record['sku'] }}</td>
					<td>{{ str_pad($record['lot'], 4, '0', STR_PAD_LEFT) }} </td>
					<td>{{ $record['can'] }}</td>

					@if($record['vir'] == 1)

						<td>Si</td>

					@else
						
						<td>No</td>

					@endif
					

				</tr>

			@endforeach

		</table>

	@endif

@stop

@section('localScript')
	
@stop