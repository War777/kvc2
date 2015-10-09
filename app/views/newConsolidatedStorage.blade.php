@extends('layout')

@section('title')
	New consolidated storage
@stop

@section('h1')
	Almacenaje consolidado
@stop

@section('content')

	<div id="categoriesContainer">

	</div>

	{{-- Inicio del modal para el listado de posibles ubicaciones por consolidar --}}

	<div class="modal" id="modalConsolidatedLocations" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
		<div class="modal-dialog modal-lg" role="document">
			
			<div class="modal-content">
				
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					
					<h4 class="modal-title" id="myModalLabel">Movimientos</h4>
					
				</div>
				
				<div class="modal-body">

					<div class="row">
						
						<div id="containerConsolidatedLocations" class="col-sm-12 containerConsolidatedLocations">
							
							{{-- Contenedor de retro alimentacion del controlador ajax --}}

						</div>

					</div>				

					<div class="row">

						<div class="col-sm-12 text-right">

							<button type="button" class="btn btn-success" data-dismiss="modal">
								<i class="glyphicon glyphicon-ok"></i>
								Ok
							</button>
							
						</div>
						
					</div>


				</div>

			</div>

		</div>

	</div>

	{{-- Fin del modal para el listado de posibles ubicaciones por consolidar --}}

@stop

@section('localScript')

	<script>

		$(document).ready(function(){

			var categories = {{ $data['jsonCategories'] }} ;
			
			l(categories);
			
			$.each(categories, function(i, categorie){

				var categoriesContainer = $('#categoriesContainer');

				var categorieTitle = $('<h2/>').text(categorie.cat);

				$(categoriesContainer).append(categorieTitle);

				$(categoriesContainer).append('<legend>Datos generales</legend>');

				var generalTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var header = '<thead class="bg-info" align="center"> <td>Pallets</td> <td>Capacidad</td> <td>Ocupacion</td> <td>Carriles vacios</td> </thead>';
				var row = '<tr align="right"> <td>' + categorie.consolidatedPallets + ' </td>'
							+' <td>' + categorie.consolidatedCapacity + '</td>'
							+' <td>' + categorie.consolidatedStorage.toFixed(2) + ' %</td>'
							+' <td>' + categorie.emptyLocationsCounter + '</td>';

				$(generalTable).append(header).append(row);

				$(categoriesContainer).append(generalTable);

				$(categoriesContainer).append('<legend>Ubicaciones consolidadas</legend>');

				var consolidatedTableContainer = $('<div/>').css({'height':'500px', 'overflow-y':'scroll', 'margin-bottom': '20px'});

				var consolidatedTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var header = '';

				header += '<thead align="center" class="bg-info">';
					header += '<td>Ubicacion</td>';
					header += '<td>Sku</td>';
					header += '<td>Lote</td>';
					header += '<td>SP iniciales</td>';
					header += '<td>SP Finales</td>';
					header += '<td>Pallets a piso</td>';
					header += '<td>Capacidad total</td>';
					header += '<td>Ocupacion</td>';
					header += '<td>Disponibilidad</td>';
				header += '</thead>';

				$(header).appendTo(consolidatedTable);

				$.each(categorie.consolidatedLocations, function(j, location){

					var row = '<tr>';

						row += '<td>' + location.location + '</td>';
						row += '<td>' + location.sku + '</td>';
						row += '<td>' + location.fecCad + '</td>';
						row += '<td>' + location.originalPallets + '</td>';
						row += '<td>' + location.finalPallets + '</td>';
						row += '<td>' + location.capacity + '</td>';
						row += '<td>' + location.totalCapacity + '</td>';
						row += '<td class="text-right">' + location.percentageOccupancy.toFixed(2) * 100 + ' %</td>';
						row += '<td class="text-right">' + location.percentageAvailability.toFixed(2) * 100 + ' %</td>';

					row += '</tr>';

					$(row).appendTo(consolidatedTable);

				});


				$(consolidatedTableContainer).append(consolidatedTable);

				$(categoriesContainer).append(consolidatedTableContainer);
				
				$(categoriesContainer).append('<legend>Ubicaciones vacias</legend>');

				var emptyTableContainer = $('<div/>').css({'height':'300px', 'overflow-y':'scroll', 'margin-bottom': '20px'});

				var emptyTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var emptyHeader = '<thead align="center" class="bg-info">';
					emptyHeader += '<td>Ubicacion</td>';
					emptyHeader += '<td>Pallets</td>';
					emptyHeader += '<td>Consolidacion</td>';					
				emptyHeader += '</thead>';

				$(emptyTable).append(emptyHeader);

				$.each(categorie.emptyLocations, function(j, location){
					
					var row = '<tr>';
						row += '<td>' + location.location + '</td>';
						row += '<td>' + location.finalPallets + '</td>';

						if(location.to.length > 0){
							
							row += '<td class="text-center"><button categorieIndex="' + i + '" emptyLocationIndex="' + j + '" class="btn btn-link btn-xs seeEmptyLocation"> <i class="glyphicon glyphicon-zoom-in"></i> </button></td>';

						} else {

							row += '<td></td>';

						}
						

					row += '</tr>';

					$(row).appendTo(emptyTable);

				});

				$(emptyTableContainer).append(emptyTable);

				$(categoriesContainer).append(emptyTableContainer);

			});

			$('.seeEmptyLocation').click(function(){

				var categoryIndex = $(this).attr('categorieIndex');
				var emptyLocationIndex = $(this).attr('emptyLocationIndex');

				var to = categories[categoryIndex].emptyLocations[emptyLocationIndex].to;

				$('#modalConsolidatedLocations').find('.containerConsolidatedLocations').html('');

				var toTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var toHeader = '<thead align="center" class="bg-info"> <td>Ubicacion</td> <td>Pallets</td> </thead>';

				$(toTable).append(toHeader);

				$.each(to, function(i, toLocation){
					
					var row = '<tr>';
						row += '<td class="text-center">' + toLocation.location + '</td><td class="text-right">' + toLocation.pallets + '</td>';
					row += '</tr>';

					$(toTable).append(row);

				});

				$('#modalConsolidatedLocations').find('.containerConsolidatedLocations').html(toTable);

				$('#modalConsolidatedLocations').modal('show');

				// if(){

				// }

				l(to);

			});
			
		});

	</script>


@stop