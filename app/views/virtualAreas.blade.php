@extends('layout')

@section('title')
	Areas virtuales
@stop

@section('h1')
	Areas virtuales
@stop

@section('content')

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_vir_are"
		periodExists = "false"
		requiredFile="Diccionario de areas virtuales"
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
				<td>Area</td>
				<td>Id Cedis</td>
			</thead>

		@foreach($records as $record)
			
			<tr align="center">
				<td> {{ $record['id'] }} </td>
				<td> {{ $record['idCed'] }} </td>
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