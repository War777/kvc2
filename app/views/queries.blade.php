@extends('layout')

@section('title')
	Consultas
@stop

@section('h1')
	Consultas
@stop

@section('content')
	
	<div class="row">

		<div class="col-lg-12">

			<legend>
				Buscar por:
			</legend>

			<form action="queries" method="post">
				
				<input type="radio" name="queryField" value="are" checked="true"> Area
				<br>
				<input type="radio" name="queryField" value="ubi"> Ubicacion
				<br>
				<input type="radio" name="queryField" value="sku"> Sku
				<br>
				<input type="radio" name="queryField" value="lot"> Lote
				<br>
				<input type="radio" name="queryField" value="lpn"> Lpn

				<br>
				<br>

				<input type="text" name="value" class="form-control" placeholder="Busqueda" required>

				<br>

				<button type="submit" class="btn btn-info pull-right">Buscar</button>				

			</form>

		</div>
		
	</div>
	
	<br>
	
	<br>

	@if(isset($data['records']))

		@if(count($data['records']) > 0)

			<div class="row">
				
				<div class="col-lg-12">
					
					<legend>
						Resultados
					</legend>

					{{ Own::arrayToTable($data['records']) }}

				</div>

			</div>

		@else
			
			<div class="row">
				
				<div class="col-lg-12">
					
					<center>
						<h3>
							Sin resultados
						</h3>
					</center>

				</div>

			</div>		
		@endif


	@endif

@stop