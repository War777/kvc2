@extends('layout')

@section('title')
	Categorias
@stop

@section('h1')
	Categorias
@stop

@section('content')
	
	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_cat"
		periodExists = "false"
		requiredFile="Diccionario de categorias"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Actualizar
	</button>

	<br>
	<br>

	@if(count($data['records']) > 1)
		
		<table class="table table-hover table-bordered table-condensed">
			<thead class="bg-info" align="center">
				<td>Id</td>
				<td>Categoria</td>
				<td>¿Contabiliza para proceso?</td>
			</thead>

		@foreach($data['records'] as $record)
			
			<tr align="center">
				<td> {{ $record['id'] }} </td>
				<td> {{ $record['cat'] }} </td>

				@if($record['con'] == 1)

					<td> Si </td>

				@else
					
					<td> No </td>

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