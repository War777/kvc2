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

			var warehouses = {{ $data['jsonWarehouses'] }} ;
			
			l(warehouses);
			
			$.each(categories, function(i, categorie){

				var categoriesContainer = $('#categoriesContainer');

				var categorieTitle = $('<h2/>').text(categorie.cat);

				$(categoriesContainer).append(categorieTitle);

				$(categoriesContainer).append('<legend>Datos generales</legend>');

				var generalTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var header = '<thead class="bg-info" align="center">'
								+ ' <td>Capacidad</td>'
								+ ' <td>Actual</td>'
								+ ' <td>Optimizada</td>'
								// + ' <td>Carriles vacios</td>'
								// + ' <td>Unidades</td>'
				     		// + ' <td>Pre O Paps</td> <td>Pre O Cap</td> <td> Pre C Paps </td> <td> Pre C Cap </td> </thead>  '
				;
				var generalTableBody = '<tr align="right"> '
							+ '<td> Ocupacion </td>'
							+ '<td>' + categorie.preOccupancyPercentage + ' </td>'
							+ '<td>' + categorie.postOccupancyPercentage + '</td>'	
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> Disponibilidad </td>'
							+ '<td>' + categorie.preAvailabilityPercentage + ' </td>'
							+ '<td>' + categorie.postAvailabilityPercentage + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> O P </td>'
							+ '<td>' + categorie.preOccupancyPaps + ' </td>'
							+ '<td>' + categorie.postOccupancyPaps + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> O C </td>'
							+ '<td>' + categorie.preOccupancyCapacity + ' </td>'
							+ '<td>' + categorie.postOccupancyCapacity + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> Consolidacion </td>'
							+ '<td>' + categorie.preConsolidationPercentage + ' </td>'
							+ '<td>' + categorie.postConsolidationPercentage + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> C P </td>'
							+ '<td>' + categorie.preConsolidationPaps + ' </td>'
							+ '<td>' + categorie.postConsolidationPaps + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> C C </td>'
							+ '<td>' + categorie.preConsolidationCapacity + ' </td>'
							+ '<td>' + categorie.postConsolidationCapacity + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> Carriles Vacios </td>'
							+ '<td> <a href="#" class="seePreEmptyLocations" categoryIndex="' + i + '"> ' + categorie.preEmptyLocationsCounter + ' </td>'
							+ '<td> <a href="#" class="seePostEmptyLocations" categoryIndex="' + i + '"> ' + categorie.postEmptyLocationsCounter + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> Lpns </td>'
							+ '<td>' + categorie.generalOriginalLpnsCounter + ' </td>'
							+ '<td>' + categorie.generalFinalLpnsCounter + ' </td>'
						+ '</tr>'


						+ '<tr align="right"> '
							+ '<td> Pallets </td>'
							+ '<td>' + categorie.preAvailablePallets + ' </td>'
							+ '<td>' + categorie.postAvailablePallets + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> Unidades </td>'
							+ '<td>' + categorie.preAvailableUnits + ' </td>'
							+ '<td>' + categorie.postAvailableUnits + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> Ubicaciones caoticas </td>'
							+ '<td colspan="2"> <a href="caoticLocations/' + categorie.id + '" target="_blank">' + categorie.caoticLocations.length + ' </td>'
						+ '</tr>'

						+ '<tr align="right"> '
							+ '<td> C C </td>'
							+ '<td>' + categorie.preConsolidationCapacity + ' </td>'
							+ '<td>' + categorie.postConsolidationCapacity + ' </td>'
						+ '</tr>'

						;

						// + '<tr align="right"> '
						// 	+ '<td> Consolidando </td>'
						// 	+ '<td>' + categorie.postConsolidationPercentage + ' </td>'
						// 	+ '<td>' + categorie.postConsolidationPercentage + ' </td>'
						// + '</tr>';

				$(generalTable).append(header).append(generalTableBody);

				$(categoriesContainer).append(generalTable);

				// $(categoriesContainer).append('<legend>Ubicaciones consolidadas</legend>');

				var consolidatedTableContainer = $('<div/>').css({'height':'500px', 'overflow-y':'scroll', 'margin-bottom': '20px'});

				var consolidatedTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var header = '';

				header += '<thead align="center" class="bg-info">';
					header += '<td>Ubicacion</td>';
					header += '<td>Sku</td>';
					header += '<td>Lote</td>';
					header += '<td>Lpns iniciales</td>';
					header += '<td>Lps Finales</td>';
					header += '<td>Pallets a piso</td>';
					header += '<td>Capacidad total</td>';
					// header += '<td>Ocupacion</td>';
					// header += '<td>Disponibilidad</td>';
				header += '</thead>';

				$(header).appendTo(consolidatedTable);

				$.each(categorie.consolidatedLocations, function(j, location){

					var row = '<tr>';

						row += '<td>' + location.location + '</td>';
						row += '<td>' + location.sku + '</td>';
						row += '<td>' + location.fecCad + '</td>';
						row += '<td>' + location.originalLpnsCounter + '</td>';
						row += '<td>' + location.finalLpnsCounter + '</td>';
						row += '<td>' + location.capacity + '</td>';
						row += '<td>' + location.totalCapacity + '</td>';
						// row += '<td class="text-right">' + location.percentageOccupancy.toFixed(2) * 100 + ' %</td>';
						// row += '<td class="text-right">' + location.percentageAvailability.toFixed(2) * 100 + ' %</td>';

					row += '</tr>';

					$(row).appendTo(consolidatedTable);

				});


				$(consolidatedTableContainer).append(consolidatedTable);

				// $(categoriesContainer).append(consolidatedTableContainer);
				
				$(categoriesContainer).append('<legend>Ubicaciones vacias</legend>');

				var emptyTableContainer = $('<div/>').css({'height':'300px', 'overflow-y':'scroll', 'margin-bottom': '20px'});

				var emptyTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var emptyHeader = '<thead align="center" class="bg-info">';
					emptyHeader += '<td>Ubicacion</td>';
					emptyHeader += '<td>Pallets</td>';
					emptyHeader += '<td>Consolidacion</td>';					
				emptyHeader += '</thead>';

				$(emptyTable).append(emptyHeader);

				$.each(categorie.postEmptyLocations, function(j, location){
					
					var row = '<tr>';
						row += '<td>' + location.location + '</td>';
						row += '<td>' + location.finalLpnsCounter + '</td>';

						if(location.to.length > 0){
							
							row += '<td class="text-center"><button categorieIndex="' + i + '" emptyLocationIndex="' + j + '" class="btn btn-link btn-xs seeEmptyLocation"> <i class="glyphicon glyphicon-zoom-in"></i> </button></td>';

						} else {

							row += '<td></td>';

						}
						

					row += '</tr>';

					$(row).appendTo(emptyTable);

				});

				// $(emptyTableContainer).append(emptyTable);

				// $(categoriesContainer).append(emptyTableContainer);

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
						row += '<td class="text-center">' + toLocation.location + '</td><td class="text-right">' + toLocation.movedLpns + '</td>';
					row += '</tr>';

					$(toTable).append(row);

				});

				$('#modalConsolidatedLocations').find('.containerConsolidatedLocations').html(toTable);

				$('#modalConsolidatedLocations').modal('show');

			});

			$('.seePreEmptyLocations').click(function(){

				var categoryIndex = $(this).attr('categoryIndex');

				var category = categories[categoryIndex];

				var emptyLocationsTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var emptyHeader = '<thead>'
								+ '<td>Ubicacion</td>'
								+ '<td>Capacidad</td>'
								+ '<td>Cedis</td>'
							+'</thead>';

				$(emptyHeader).appendTo(emptyLocationsTable);			

				$.each(category.preEmptyLocations, function(index, preEmptyLocation){

					var row = '<tr>'
								+ '<td>' + preEmptyLocation.id + '</td>'
								+ '<td>' + preEmptyLocation.cap + '</td>'
								+ '<td>' + preEmptyLocation.idCed + '</td>'
					 		+ '</tr>';

					$(row).appendTo(emptyLocationsTable);

				});

				$('#modalConsolidatedLocations').find('.modal-title').html('Ubicaciones vacias');

				$('#modalConsolidatedLocations').find('.containerConsolidatedLocations').html(emptyLocationsTable);

				$('#modalConsolidatedLocations').modal('show');

			});

			$('.seePostEmptyLocations').click(function(){

				var categoryIndex = $(this).attr('categoryIndex');

				var category = categories[categoryIndex];

				var emptyLocationsTable = $('<table/>').addClass('table table-condensed table-bordered table-hover table-striped');

				var emptyHeader = '<thead>'
								+ '<td>Ubicacion</td>'
								+ '<td>Capacidad</td>'
							+'</thead>';

				$(emptyHeader).appendTo(emptyLocationsTable);			

				$.each(category.postEmptyLocations, function(index, postEmptyLocation){

					var row = '<tr>'
								+ '<td>' + postEmptyLocation.location + '</td>'
								+ '<td>' + postEmptyLocation.capacity + '</td>'
					 		+ '</tr>';

					$(row).appendTo(emptyLocationsTable);

				});

				$('#modalConsolidatedLocations').find('.modal-title').html('Ubicaciones vacias');

				$('#modalConsolidatedLocations').find('.containerConsolidatedLocations').html(emptyLocationsTable);

				$('#modalConsolidatedLocations').modal('show');

			});
			
		});

	</script>


@stop