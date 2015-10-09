@extends('layout')

@section('title')
	Existencias en almacenes
@stop

@section('h1')
	Existencias en almacenes
@stop

@section('content')

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_mac"
		periodExists = "false"
		requiredFile="Archivo de existencias"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Actualizar
	</button>

	<br>
	<br>

	@if(count($data['records']) > 0)
		
		{{ Own::arrayToTable($data['records']) }}

	@else

		<center>
			<p>
				Sin registros
			</p>
		</center> 

	@endif

@stop

@section('localscript')

@stop