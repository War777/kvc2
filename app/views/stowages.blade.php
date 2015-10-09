@extends('layout')

@section('title')
	Estandares y estibas
@stop

@section('h1')
	Estandares y estibas
@stop

@section('content')

	@if($data['missingRecords'])
		
		<legend>Estibas y skus faltantes</legend>

		<form action="#" class="ajaxDictionaryForm" table="sto_est" controller="DictionaryController@addDictionaryRecords">

			<table class="table table-condensed table-bordered">

				<thead class="bg-info" align="center">
					<td>Sku</td>
					<td>Descripci&oacute;n</td>
					<td>Estiba</td>
					<td>Estandar</td>
				</thead>
				
				<tbody>

					@foreach($data['missingRecords'] as $missingRecord)
						
						<tr>
							
							<td>
								<input type="hidden" name="sku" value="{{ $missingRecord['sku'] }}">
								{{ $missingRecord['sku'] }}
							</td>

							<td>
								<input type="text" name="skuDes" class="form-control input-sm" required>
							</td>

							<td>
								<input type="text" name="estIba" class="form-control input-sm number" required>
							</td>
							
							<td>
								<input type="text" name="estAnd" class="form-control input-sm number" required>
							</td>

						</tr>

					@endforeach

				</tbody>

			</table>

			<div class="col-lg-12 text-right">
				
				<input type="reset" value="Cancelar" class="btn btn-danger">

				<input type="submit" value="Agregar" class="ajaxForm btn btn-primary">

			</div>
			

		</form>		

	@endif
	
	<legend>
		
		Diccionario actual 

	</legend>

	@if($data['records'])
	
		<table class="table table-condensed table-bordered">

			<thead class="bg-info" align="center">
				<td>Sku</td>
				<td>Descripci&oacute;n</td>
				<td>Estiba</td>
				<td>Estandar</td>
			</thead>

			@foreach($data['records'] as $record)

				<tr>
					<td>{{ $record['sku'] }}</td>
					<td>{{ $record['skuDes'] }}</td>
					<td>{{ $record['estIba'] }}</td>
					<td>{{ $record['estAnd'] }}</td>
				</tr>

			@endforeach

		</table>

	@endif

@stop

@section('localScript')
	
@stop