@extends('layout')

@section('title')
	KVM
@stop

@section('h1')
	Bienvenido
@stop

@section('content')
	
	<!-- <br>
	<br>

	<h1>Inicio</h1> -->

	<? 
		
		// $request = Request::create('testRoute', 'GET');

		// echo Route::dispatch($request)->getContent();

	?>

	<button type="button" class="btn btn-primary runAjaxController" controller="StorageController@runStorageCapacity">
		<i class="glyphicon glyphicon-play"></i>
		Ejecutar capacidad de almacenaje
	</button>
	
	<hr>

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_war"
		periodExists = "false"
		requiredFile="Almacenes"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Almacenes
	</button>
		
	<hr>
	
	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_cat"
		periodExists = "false"
		requiredFile="Categorias"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Categorias
	</button>

	<hr>	

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_are"
		periodExists = "false"
		requiredFile="Areas"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Areas
	</button>
	

	<hr>	
			
	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_loc"
		periodExists = "false"
		requiredFile="Ubicaciones"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Ubicaciones
	</button>
	
	<hr>

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_est"
		periodExists = "false"
		requiredFile="Estandar y estiba"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Estandares y Estibas
	</button>

	<hr>

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_mac"
		periodExists = "false"
		requiredFile="Macro"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Existencias Macro
	</button>
	
	<hr>
	
	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_mat"
		periodExists = "false"
		requiredFile="Macro"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Existencias Materia Prima
	</button>
	
	<hr>

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_cap"
		periodExists = "false"
		requiredFile="Macro"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Cap
	</button>

	<hr>

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_vir_loc"
		periodExists = "false"
		requiredFile="Macro"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Virtual locations
	</button>

@stop