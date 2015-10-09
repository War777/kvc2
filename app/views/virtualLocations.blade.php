@extends('layout')

@section('title')
	Ubicaciones virtuales
@stop

@section('h1')
	Ubicaciones virtuales
@stop

@section('content')

	<p>
			<b>	Ultima modificaci&oacute;n </b>
			<br>Fecha:  {{ $data['lastUpdate']['dat'] }}
			<br>Usuario: {{ $data['lastUpdate']['usu'] }} 
	</p>

	<legend>Detalle</legend>

	@if($data['records'])
	
		<table class="table table-condensed table-bordered">

			<thead class="bg-info" align="center">
				<td>Ubicacion virtual</td>
				<td>Ubicacion fis&iacute;ca</td>
			</thead>

			@foreach($data['records'] as $record)

				<tr>
					
					<td>{{ $record['virLoc'] }}</td>
					<td>{{ $record['fisLoc'] }}</td>

				</tr>

			@endforeach

		</table>

	@endif

@stop

@section('localScript')
	
@stop