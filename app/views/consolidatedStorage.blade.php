@extends('layout')

@section('title')

	Consolidated storage

@stop

@section('h1')
	Consolidated storage
@stop

@section('content')

	@if (count($data['records']) > 0)


		<table class="table table-bordered table-condensed">
			<thead>
				<td>Tipo</td>
				<td>Pallets</td>
				<td>Capacidad</td>
				<td>Ocupacion</td>
				<td>Disponibilidad</td>
			</thead>
			<tbody>
				<tr>
					<td>Sin Consolidar</td>
					<td> {{ $data['general']['totalPallets'] }} </td>
					<td> {{ $data['general']['totalCapacity'] }} </td>
					<td> {{ $data['general']['storageCapacity'] }} </td>
					<td> {{ 100 - $data['general']['storageCapacity'] }} </td>
				</tr>
				<tr>
					<td>Consolidando</td>
					<td> {{ $data['general']['consolidatedPallets'] }} </td>
					<td> {{ $data['general']['consolidatedCapacity'] }} </td>
					<td> {{ $data['general']['storageCapacityConsolidated'] }} </td>
					<td> {{ 100 - $data['general']['storageCapacityConsolidated'] }} </td>
				</tr>
			</tbody>
		</table>

		
		<table class="table table-bordered table-condensed table-striped table-hover">
			
			<thead id="tableHeader" align="center">
				
				<td>Cedis</td>
				<td></td>

				<td>Area</td>
				<td>Categoria</td>
				<td>Contabiliza</td>

				<td>Ubicacion</td>
				<td>Sku</td>
				<td>Lote</td>
				
				<td>Permite estiba</td>
				<td>Estiba</td>
				<td>Estandar</td>

				<td>UOM</td>
				
				<td>Cantidad</td>
				<td>Pallets</td>
				<td>PAP</td>
				<td>Capacidad Total</td>
				
				<td>SP Ocu.</td>
				<td>% Ocu.</td>
				<td>% Ocu con.</td>
				
				<td>SP Dis.</td>
				<td>% Dis.</td>
				<td>% Dis con.</td>

				<td>Ubicaciones</td>

			</thead>
		
		<?	
			$counter = 0;
		?>

		@foreach ($data['records'] as $record)
			
			<tr>
				<td> {{ $record['idCed'] }} </td>
				<td> {{ $record['ced'] }} </td>
				<td> {{ $record['are'] }} </td>
				<td> {{ $record['cat'] }} </td>
				<td> {{ $record['con'] }} </td>

				<td> {{ $record['ubi'] }} </td>
				<td> {{ $record['sku'] }} </td>
				<td> {{ $record['fecCad'] }} </td>

		@if ($record['perEst'] == 1)
			
			<td> Si </td>

		@else
			
			<td> No </td>

		@endif

				<td class="text-right"> {{ $record['estIba'] }} </td>
				<td class="text-right"> {{ $record['estAnd'] }} </td>

				<td> {{ $record['uniMed'] }}  </td>

				<td class="text-right"> {{ $record['can'] }} </td>
				<td class="text-right"> {{ $record['pal'] }} </td>
				<td class="text-right"> {{ $record['cap'] }} </td>
				<td class="text-right"> {{ $record['capFin'] }} </td>

				<td class="text-right"> {{ $record['ocuPal'] }} </td>
				<td class="text-right"> {{ $record['ocuPor'] }} %</td>
				<td class="text-right"> {{ $record['ocuConPor'] }} %</td>
				
				<td class="text-right"> {{ $record['disPal'] }} </td>
				<td class="text-right"> {{ $record['disPor'] }} %</td>
				<td class="text-right"> {{ $record['disConPor'] }} %</td>
				
				@if(count($record['conUbi']) > 0)

					<td class="text-center"> <button type="button" index="<?= $counter ?>" class="btn btn-xs btn-link consolidatedLocations">Ver</button> </td>

				@else
					
					<td class="text-center"> - </td>

				@endif

			</tr>	
			
			<?	
				$counter++;
			?>
		@endforeach

		</table>

	@else
		
		There are no records in this view
	
	@endif


	{{-- Inicio del modal para el listado de posibles ubicaciones por consolidar --}}

	<div class="modal" id="modalConsolidatedLocations" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		
		<div class="modal-dialog modal-lg" role="document">
			
			<div class="modal-content">
				
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					
					<h4 class="modal-title" id="myModalLabel">Ubicaciones por consolidar</h4>
					
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

				var records = {{ $data['jsonRecords'] }} ;

				$('.consolidatedLocations').click(function(){

					$('#modalConsolidatedLocations').find('.containerConsolidatedLocations').html('');

					var index = $(this).attr('index');

					var tableParentLocationContainer = $('<div/>').addClass('table-responsive');

					var tableParentLocation = $('<table/>').addClass('table table-bordered table-condensed');

					var header = $('#tableHeader').clone();

					var row = $(this).closest('tr').clone();

					$(row).find('tr').last().remove();

					$(tableParentLocation).append(header).append(row);

					$(tableParentLocationContainer).append(tableParentLocation);

					$('#modalConsolidatedLocations').find('.containerConsolidatedLocations').append(tableParentLocationContainer);

					var table = '<hr> <div class="table-responsive"> <table class="table table-bordered table-condensed">';
							table += '<thead align="center">';
								
								table += '<td>Cedis</td>';
								table += '<td></td>';
								table += '<td>Area</td>';
								table += '<td>Categoria</td>';
								table += '<td>Contabiliza</td>';

								table += '<td>Ubicacion</td>';
								table += '<td>Sku</td>';						
								table += '<td>Lote</td>';

								table += '<td>Permite Estiba</td>';
								table += '<td>Estiba</td>';
								table += '<td>Estandar</td>';

								table += '<td>UoM</td>';

								table += '<td>Cantidad</td>';
								table += '<td>Pallets</td>';
								table += '<td>PAP</td>';
								table += '<td>Capacidad Total</td>';

								table += '<td>SP Ocu.</td>';
								table += '<td>% Ocu.</td>';
								table += '<td>% Ocu. Con.</td>';

								table += '<td>SP Dis.</td>';
								table += '<td>% Dis.</td>';
								table += '<td>% Dis. Con.</td>';

							table += '<thead>';

					$.each(records[index].conUbi, function(position, location){

						table += '<tr>';
							table += '<td>' + location.idCed + '</td>';
							table += '<td>' + location.ced + '</td>';
							table += '<td>' + location.are + '</td>';
							table += '<td>' + location.cat + '</td>';
							table += '<td>' + location.con + '</td>';

							table += '<td>' + location.ubi + '</td>';
							table += '<td>' + location.sku + '</td>';
							table += '<td>' + location.fecCad + '</td>';

							if(location.perEst == 1){
								table += '<td>Si</td>';
							} else {
								table += '<td>No</td>';
							}

							table += '<td>' + location.estIba + '</td>';
							table += '<td>' + location.estAnd + '</td>';

							table += '<td>' + location.uniMed + '</td>';

							table += '<td>' + location.can + '</td>';
							table += '<td>' + location.pal + '</td>';
							table += '<td>' + location.cap + '</td>';
							table += '<td>' + location.capFin + '</td>';

							table += '<td class="text-right">' + location.ocuPal + '</td>';
							table += '<td class="text-right">' + location.ocuPor + '</td>';
							table += '<td class="text-right">' + location.ocuConPor + '</td>';

							table += '<td class="text-right">' + location.disPal + '</td>';
							table += '<td class="text-right">' + location.disPor + '</td>';
							table += '<td class="text-right">' + location.disConPor + '</td>';

						table += '</tr>';

					});

					table += '</table> </div>';

					$('#modalConsolidatedLocations').find('.containerConsolidatedLocations').append(table);

					$('#modalConsolidatedLocations').modal('show');

				});

				var preTable = '<table class="table table-bordered table-condensed">';

							preTable += '<thead align="center">';
								preTable += '<td>Ubicacion</td>';							
								preTable += '<td>Sku</td>';						
								preTable += '<td>Lote</td>';
								preTable += '<td>Ocu.</td>';
								preTable += '<td>Dis.</td>';
							preTable += '<thead>';

							preTable += '<tr align="center">';
								preTable += '<td>-----------</td>';							
								preTable += '<td>-----------</td>';						
								preTable += '<td>------</td>';
								preTable += '<td>-----</td>';
								preTable += '<td>-----</td>';
							preTable += '</tr>';

						preTable += '</table>';

				// $('.popoverConsolidated').on('click', function(e){

				// 	e.preventDefault();

				// 	return true;

				// });

				// $('.popoverConsolidated').on('shown.bs.popover', function(){

				// 	var popoverId = $(this).attr('aria-describedby');
				// 	var index = $(this).attr('index');

				// 	var table = '<table class="table table-bordered table-condensed">';
				// 			table += '<thead align="center">';
				// 				table += '<td>Ubicacion</td>';							
				// 				table += '<td>Sku</td>';						
				// 				table += '<td>Lote</td>';
				// 				table += '<td>Ocu.</td>';
				// 				table += '<td>Dis.</td>';
				// 			table += '<thead>';

				// 		$.each(records[index].conUbi, function(position, location){

				// 			table += '<tr>';
				// 				table += '<td>' + location.ubi + '</td>';
				// 				table += '<td>' + location.sku + '</td>';
				// 				table += '<td>' + location.fecCad + '</td>';
				// 				table += '<td class="text-right">' + location.ocu + ' %</td>';
				// 				table += '<td class="text-right">' + location.dis + ' %</td>';
				// 			table += '</tr>';

				// 		});

				// 		table += '</table>';

				// 	$('#' + popoverId).find('.popover-content').html(table);

				// });

			});

		</script>

@stop
