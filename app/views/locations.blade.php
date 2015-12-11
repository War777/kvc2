@extends('layout')

@section('title')
	Ubicaciones
@stop

@section('h1')
	Ubicaciones
@stop

@section('content')

	<button
		type="button"
		class="activarModal btn btn-info btn-xs"
		table="sto_loc"
		periodExists = "false"
		requiredFile="Diccionario de ubicaciones"
		post=""
	>
		<i class="glyphicon glyphicon-refresh"></i>
		Actualizar
	</button>

	<br>
	<br>

	@if(count($records) > 1)
		
		<table class="table table-hover table-bordered table-condensed" tableName="sto_loc">

			<thead class="bg-info" align="center">
				<td>
					Ubicacion
				</td>
				<td>
					Area
				</td>
				<td>
					Capacidad
				</td>
				<td>
					¿Permite estiba?
				</td>

				<!-- <td>
					Tareas
				</td> -->

			</thead>

		@foreach($records as $record)
			
			<tr align="center" isEditing='false'>
				
				<form action="fakeUrl">
					
					<input type="hidden" name="pk" value="">

					<td pk='id'>
						
						<input type="hidden" name="pk" value="">
						
						@if(Own::startsWith($record['id'], '0') || Own::startsWith($record['id'], '1'))
							
							{{ "'" . $record['id'] }}

						@else

							{{ $record['id'] }}

						@endif


					</td>
					<td field='idAre' ft='sto_are' fk='id' fd='id'>
						
						@if(Own::startsWith($record['idAre'], '0') || Own::startsWith($record['idAre'], '1'))
							
							{{ "'" . $record['idAre'] }}
							
						@else

							{{ $record['idAre'] }}

						@endif
						
					</td>
					<td field='cap'> 
						{{ $record['cap'] }} 
					</td>

					@if($record['perEst'] == 1)

						<td field='perEst' boolean='true'> 
							Si
						</td>

					@else

						<td field='perEst' boolean='true'>
							No
						</td>

					@endif

					<!-- <td editRemove>
						<button type="button" class="btn btn-danger btn-xs remove">
							<i class="glyphicon glyphicon-remove"></i>
						</button>
						<button type="button" class="btn btn-info btn-xs edit">
							<i class="glyphicon glyphicon-edit"></i>
						</button>
						<button type="button" class="btn btn-success btn-xs disabled cancelEdit">
							<i class="glyphicon glyphicon-floppy-remove"></i>
						</button>
						<button type="button" class="btn btn-primary btn-xs disabled saveEdit">
							<i class="glyphicon glyphicon-floppy-saved"></i>
						</button>
					</td> -->

				</form>

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

@section('localScript')
	
	<script>

		$(document).ready(function(){

			$.fn.hasAttr = function(name){

				return this.attr(name) !== undefined;

			}

			$('.edit').click(function(){

				toggleEditing();

				var row = $(this).closest('tr');

				$(row).attr('isEditing', 'true');

				$.each($(row).children(), function(index, column){
					
					if($(column).hasAttr('pk')){
						
						$(column).find('input').val($(column).text().trim(''));

					} else if($(column).hasAttr('fk')){

						var originalValue = $(column).text();
						$(column).attr('originalValue', originalValue);

						var field = $(column).attr('field');
						var ft = $(column).attr('ft');
						var fk = $(column).attr('fk');
						var fd = $(column).attr('fd');

						getForeignSelect(ft, fk, fd, column);

					} else if ($(column).hasAttr('boolean')) {

						var originalValue = $(column).text();
						$(column).attr('originalValue', originalValue);

						var field = $(column).attr('field');

						var select = '<select> <option value="1">Si</option> <option value="0">No</option> </select>';

						$(column).html(select);

					} else if ($(column).hasAttr('editRemove')) {



					} else {

						var originalValue = $(column).text();
						$(column).attr('originalValue', originalValue);

						var field = $(column).attr('field');
						var value = $(column).text();

						var input = '<input type="text" name="' + field + '" value="' + value.trim('') + '">';

						$(column).html(input);

					}

				});

			});

			$('.cancelEdit').click(function(){
				
				toggleEditing();

				$('tr[isEditing="true"]').each(function(){
					$.each($(this).children(), function(index, column){
						$(column).text($(column).attr('originalValue'));
						$(column).find('input');
						$(column).find('select');
					})
				});

			});

			$('.saveEdit').click(function(){

				var tableName = $(this).closest('tableName');
				var form = $(this).closest('form');
				var row = $(this).closest('tr');

				if($(row).attr('isEditing') == 'false'){
					return false;
				}

				var inputs = [];

				$.each($(row).children('td'), function(index, column){
					
					if($(column).hasAttr('pk')){
						
						inputs.push(
							{	
								'type' : 'pk',
								'field' : $(column).attr('pk'),
								'value' : $(column).find('input').val().trim('')
							}
						);

					} else if($(column).hasAttr('fk')){

						inputs.push(
							{	
								'type' : 'field',
								'field' : $(column).attr('field'),
								'value' : $(column).find('select').val()
							}
						);

					} else if ($(column).hasAttr('boolean')) {

						inputs.push(
							{	
								'type' : 'field',
								'field' : $(column).attr('field'),
								'value' : $(column).find('select').val()
							}
						);

					} else if ($(column).hasAttr('editRemove')) {



					} else {

						inputs.push(
							{	
								'type' : 'field',
								'field' : $(column).attr('field'),
								'value' : $(column).find('input').val()
							}
						);
					}

				});

				l(inputs);

				$.ajax({
					'url': 'updateDictionary',
					'method' : 'POST',
					'dataType' : 'json',
					'data' : {
						'tableName' : tableName,
						'inputs' : inputs

					}, 
					beforeSend: function(){

					}, success: function(response){

						l(response);

					}, error: function(response){

						l(response);

					}
				});

			});

			//Funcion para extraer una lista con los elementos desde la base de datos
			function getForeignSelect(ft, fk, fd, column){

				$.ajax({
					'url': 'getForeignSelect',
					'method' : 'POST',
					'dataType' : 'json',
					'data' : {
						'ft' : ft,
						'fk' : fk,
						'fd' : fd						
					},

					success: function(records){

						var select = '<select>';

						$.each(records, function(index, record){

							select += '<option value="' + record.fk + '">' + record.fd + '</option>';

						});

						select += '</select>';

						$(column).html(select);

					}

				});

			}

			function toggleEditing(){

				$('.btn').each(function(){
					$(this).toggleClass('disabled');
				});

			}

		});
		
	</script>

@stop